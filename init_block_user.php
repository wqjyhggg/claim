<?php
//$servername = "aurora1.cluster-coadisrdeyad.us-east-1.rds.amazonaws.com";
//$username = "admin";
//$password = "Aurora1JF221119";
//$dbname1 = "jfweb";
//$dbname2 = "jfweb";
$servername = "localhost";
$username = "root";
$password = "n92sw1198";
$dbname1 = "jfinsurance";
$dbname2 = "jf_claim_management";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname1);
$connc = new mysqli($servername, $username, $password, $dbname2);
// Check connection
if ($conn->connect_error || $connc->connect_error) {
    die("Connection failed:[" . $conn->connect_error . "][" . $connc->connect_error . "]");
}

$sql = "SELECT * FROM  `plan` WHERE `claim_flag`>0 ORDER BY claim_flag DESC, plan_id DESC";
echo $sql."\n";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    $plan_id = $row["plan_id"];
    $policy = $row["policy"];
    $sql1 = "SELECT * FROM  `customer` WHERE `plan_id`=".$plan_id;
    echo $sql1."\n";
    $result1 = $conn->query($sql1);
    if ($result1->num_rows > 0) {
      // output data of each row
      while($row1 = $result1->fetch_assoc()) {
        $firstname = strtolower($row1["firstname"]);
        $lastname = strtolower($row1["lastname"]);
        $birthday = $row1["birthday"];
        
        $sql2 = "SELECT * FROM block_list WHERE firstname='".$firstname."' AND lastname='".$lastname."' AND birthday='".$birthday."'";
        $result2 = $connc->query($sql2);
        if ($row2 = $result2->fetch_assoc()) {
          continue;
        }

        $claim_amount = 0;
        $case_amount = 0;

        $sql2 = "SELECT SUM(e.amount_claimed) as amount FROM claim c JOIN expenses_claimed e ON (c.id=e.claim_id) WHERE LOWER(c.insured_first_name)='".$firstname."' AND LOWER(c.insured_last_name)='".$lastname."' AND c.dob='".$birthday."'";
        $result2 = $connc->query($sql2);
        if ($row2 = $result2->fetch_assoc()) {
          $claim_amount = $row2["amount"];
        }

        $sql2 = "SELECT SUM(reserve_amount) as amount FROM `case` WHERE LOWER(insured_firstname)='".$firstname."' AND LOWER(insured_lastname)='".$lastname."' AND dob='".$birthday."' AND claim_no=''";
        $result2 = $connc->query($sql2);
        if ($row2 = $result2->fetch_assoc()) {
          $case_amount = $row2["amount"];
        }

        if (($claim_amount > 2500) || ($case_amount > 2500)) {
          $sql3 = "INSERT INTO block_list (status, firstname, lastname, birthday, policies, notes) VALUES (2,'".$firstname."','".$lastname."','".$birthday."','".$policy.";','".json_encode([date("Ymd:His")=>"From Existed Block Policy"])."')";
          $connc->query($sql3);
        } else if (($claim_amount > 0) || ($case_amount > 0)) {
          $sql3 = "INSERT INTO block_list (status, firstname, lastname, birthday, policies, notes) VALUES (1,'".$firstname."','".$lastname."','".$birthday."','".$policy.";','".json_encode([date("Ymd:His")=>"From Existed Block Policy"])."')";
          $connc->query($sql3);
        }
      }
    }
  }
}
$conn->close();
$connc->close();