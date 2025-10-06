<html>
   <body>
    <div>
      <table>
        <tr>
          <td>Claimant/Insured's Name</td>
          <td><?php echo $claim["insured_first_name"] . " " . $claim["insured_last_name"]; ?></td>
        </tr>
        <tr>
          <td>Date of Birth/Age/Sex</td>
          <td><?php echo $claim["dob"] . "/" . (intval(substr($claim["apply_date"], 0, 4)) - intval(substr($claim["dob"], 0, 4))) . "/" . ucfirst($claim["gender"]); ?></td>
        </tr>
        <tr>
          <td>Claim Number</td>
          <td><?php echo $claim["claim_no"]; ?></td>
        </tr>
        <tr>
          <td>Other Claims (related or unrelated)</td>
          <td>No</td>
        </tr>
        <tr>
          <td>Policy Number</td>
          <td><?php echo $claim["policy_no"]; ?></td>
        </tr>
        <tr>
          <td>Product</td>
          <td><?php echo $product_name; ?></td>
        </tr>
        <tr>
          <td>Plan Type</td>
          <td>Individual</td>
        </tr>
        <tr>
          <td>Date of Application/Issue (if applicable) </td>
          <td><?php echo $claim["apply_date"]; ?></td>
        </tr>
        <tr>
          <td>Coverage Period</td>
          <td><?php echo $claim["effective_date"] . " to " . $claim["expiry_date"]; ?></td>
        </tr>
        <tr>
          <td>Travel Dates</td>
          <td><?php echo $claim["arrival_date"]; ?></td>
        </tr>
        <tr>
          <td>Travel Destination</td>
          <td><?php echo $claim["city"] . " " . $claim["province"]; ?></td>
        </tr>
        <tr>
          <td>Date of Loss</td>
          <td><?php echo $claim["date_symptoms"]; ?></td>
        </tr>
        <tr>
          <td>Cause for Claim/Diagnosis</td>
          <td><?php echo $claim["medical_description"]; ?></td>
        </tr>
        <tr>
          <td>Reserve Amount</td>
          <td><?php echo $claim["reserve_amount"]; ?></td>
        </tr>
        <tr>
          <td>Pre-existing Condition Period</td>
          <td><?php echo ($plan["stable_condition"] == 1)?"Including":(($plan["stable_condition"] == 2)?"Excludes":"&nbsp;") ; ?></td>
        </tr>
      </table>
    </div>
	</body>
</html>