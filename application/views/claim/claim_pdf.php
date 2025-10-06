<html>
   <body>
    <table>
      <tr>
        <td><p>Claimant/Insured's Name</p></td>
        <td><p><?php echo $claim["insured_first_name"] . " " . $claim["insured_last_name"]; ?></p></td>
      </tr>
      <tr>
        <td><p>Date of Birth/Age/Sex</p></td>
        <td><p><?php echo $claim["dob"] . "/" . (intval(substr($claim["apply_date"], 0, 4)) - intval(substr($claim["dob"], 0, 4))) . "/" . ucfirst($claim["gender"]); ?></p></td>
      </tr>
      <tr>
        <td><p>Claim Number</p></td>
        <td><p><?php echo $claim["claim_no"]; ?></p></td>
      </tr>
      <tr>
        <td><p>Other Claims (related or unrelated)</p></td>
        <td><p>No</p></td>
      </tr>
      <tr>
        <td><p>Policy Number</p></td>
        <td><p><?php echo $claim["policy_no"]; ?></p></td>
      </tr>
      <tr>
        <td><p>Product</p></td>
        <td><p><?php echo $product_name; ?></p></td>
      </tr>
      <tr>
        <td><p>Plan Type</p></td>
        <td><p>Individual</p></td>
      </tr>
      <tr>
        <td><p>Date of Application/Issue (if applicable) </p></td>
        <td><p><?php echo $claim["apply_date"]; ?></p></td>
      </tr>
      <tr>
        <td><p>Coverage Period</p></td>
        <td><p><?php echo $claim["effective_date"] . " to " . $claim["expiry_date"]; ?></p></td>
      </tr>
      <tr>
        <td><p>Travel Dates</p></td>
        <td><p><?php echo $claim["arrival_date"]; ?></p></td>
      </tr>
      <tr>
        <td><p>Travel Destination</p></td>
        <td><p><?php echo $claim["city"] . " " . $claim["province"]; ?></p></td>
      </tr>
      <tr>
        <td><p>Date of Loss</p></td>
        <td><p><?php echo $claim["date_symptoms"]; ?></p></td>
      </tr>
      <tr>
        <td><p>Cause for Claim/Diagnosis</p></td>
        <td><p><?php echo $claim["medical_description"]; ?></p></td>
      </tr>
      <tr>
        <td><p>Reserve Amount</p></td>
        <td><p><?php echo $claim["reserve_amount"]; ?></p></td>
      </tr>
      <tr>
        <td><p>Pre-existing Condition Period</p></td>
        <td><p><?php echo ($plan["stable_condition"] == 1)?"Including":(($plan["stable_condition"] == 2)?"Excludes":"&nbsp;") ; ?></p></td>
      </tr>
    </table>
	</body>
</html>