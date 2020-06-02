<style>
h3 {
border-bottom: 1px solid #000;
}
</style>
<div>
    <h1 style="text-align:center; width:100%">Eclaim - <?php echo empty($eclaim['eclaim_no']) ? "ID#".$eclaim['id'] : $eclaim['eclaim_no']; ?></h1>
</div>
<h3>Claimant Information</h3>
<div><b>Insured First Name: </b><?php echo $eclaim["insured_first_name"]; ?></div>
<div><b>Insured Last Name: </b><?php echo $eclaim["insured_last_name"]; ?></div>
<div><b>Gender: </b><?php echo ucfirst($eclaim["gender"]); ?></div>
<div><b>ID : </b><?php echo $policy["student_id"]; ?></div>
<div><b>Date of Birth: </b><?php echo $eclaim["dob"]; ?></div>
<div><b>Policy#: </b><?php echo $eclaim["policy_no"]; ?></div>
<div><b>School Name: </b><?php echo $eclaim["school_name"]; ?></div>
<div><b>Group ID: </b><?php echo $eclaim["group_id"]; ?></div>
<div><b>Enroll Date: </b><?php echo $policy["apply_date"]; ?></div>
<div><b>Arrival Date in Canada: </b><?php echo $eclaim["arrival_date"]; ?></div>
<div><b>Full Name of Guardian if applicable: </b><?php echo $eclaim["guardian_name"]; ?></div>
<div><b>Guardian Phone#: </b><?php echo $eclaim["guardian_phone"]; ?></div>
<br />
<h3>Address in Canada</h3>
<div><b>Street Address: </b><?php echo $eclaim["street_address"]; ?></div>
<div><b>City/Town: </b><?php echo $eclaim["city"]; ?></div>
<div><b>Province: </b><?php echo $eclaim["province"]; ?></div>
<div><b>Telephone: </b><?php echo $eclaim["telephone"]; ?></div>
<div><b>Email: </b><?php echo $eclaim["email"]; ?></div>
<div><b>PostCode: </b><?php echo $eclaim["post_code"]; ?></div>
<div><b>Date of Arrival in Canada: </b><?php echo $eclaim["arrival_date_canada"]; ?></div>
<div><b>Cellular: </b><?php echo $eclaim["cellular"]; ?></div>
<br />
<h3>Contact Information</h3>
<div><b>First Name: </b><?php echo $eclaim["contact_first_name"]; ?></div>
<div><b>Last Name: </b><?php echo $eclaim["contact_last_name"]; ?></div>
<div><b>Email: </b><?php echo $eclaim["contact_email"]; ?></div>
<div><b>Phone: </b><?php echo $eclaim["contact_phone"]; ?></div>
<br />
<h3>Name and Address of Family Physician in Country of Origin</h3>
<div><b>Name: </b><?php echo $eclaim["physician_name"]; ?></div>
<div><b>Clinic Name or Address: </b><?php $eclaim["clinic_name"]; ?></div>
<div><b>Street Address: </b><?php echo $eclaim["physician_street_address"]; ?></div>
<div><b>City/Town: </b><?php echo $eclaim["physician_city"]; ?></div>
<div><b>Country: </b><?php foreach ($country as $key => $val) { if (($key == $eclaim['country']) || ($val == $eclaim['country'])) { echo $val; break; } } ?></div>
<div><b>Postal Code: </b><?php echo $eclaim["physician_post_code"]; ?></div>
<div><b>Telephone: </b><?php echo $eclaim["physician_telephone"]; ?></div>
<div><b>Alt Telephone: </b><?php echo $eclaim["physician_alt_telephone"]; ?></div>
<br />
<h3>Name and Address of Family Physician in Canada</h3>
<div><b>Name: </b><?php echo $eclaim["physician_name_canada"]; ?></div>
<div><b>Clinic Name or Address: </b><?php echo $eclaim["clinic_name_canada"]; ?></div>
<div><b>Street Address: </b><?php echo $eclaim["physician_street_address_canada"]; ?></div>
<div><b>City/Town: </b><?php echo $eclaim["physician_city_canada"]; ?></div>
<div><b>Postal Code: </b><?php echo $eclaim["physician_post_code_canada"]; ?></div>
<div><b>Telephone: </b><?php echo $eclaim["physician_telephone_canada"]; ?></div>
<div><b>Alt Telephone: </b><?php echo $eclaim["physician_alt_telephone_canada"]; ?></div>
<br />
<h3>Other Insurance Coverage</h3>
<div><b>Do you have other insurance coverage including Canadian government health insurance? </b><?php echo ($eclaim["other_insurance_coverage"] == 'Y') ? "Yes" : "No"; ?></div>
<div><b>Do you, your spouse or your parents/guardians have any other medical or travel insurance coverage? </b><?php echo ($eclaim["travel_insurance_coverage_guardians"] == 'Y') ? "Yes" : "No"; ?></div>
<div><b>If yes, provide details of other insurance company coverage below.</b></div>
<div><b>Full Name: </b><?php echo $eclaim["full_name"]; ?></div>
<div><b>Employer Name: </b><?php echo $eclaim["employee_name"]; ?></div>
<div><b>Street Address: </b><?php echo $eclaim["employee_street_address"]; ?></div>
<div><b>City/Town: </b><?php echo $eclaim["city_town"]; ?></div>
<div><b>Postal Code: </b><?php echo $eclaim["employee_post_code"]; ?></div>
<div><b>Country: </b><?php foreach ($country as $key => $val) { if (($key == $eclaim['country2']) || ($val == $eclaim['country2'])) { echo $val; break; } } ?></div>
<div><b>Telephone: </b><?php echo $eclaim["employee_telephone"]; ?></div>
<br />
<h3>Medical Information</h3>
<div><b>Diagnosis: </b><?php echo $eclaim["diagnosis"]; ?></div>
<div><b>Brief description of your sickness or injury: </b><?php echo $eclaim["medical_description"]; ?></div>
<div><b>Date symptoms or injury first appeared: </b><?php echo $eclaim["date_symptoms"]; ?></div>
<div><b>Date you first saw physician for this condition: </b><?php echo $eclaim["date_first_physician"]; ?></div>
<div><b>Have you ever been treated for this or a similar condition before? </b><?php echo ($eclaim["treatment_before"] == 'Y') ? "Yes" : "No"; ?></div>
<div><b>If you answered “yes”, provide all dates of treatment and list all medications taken before the effective date of the current policy: </b></div>
<div><b>Date: </b><?php echo empty($eclaim["medication_date_1"]) ? "__________" : $eclaim["medication_date_1"]; ?> &nbsp; &nbsp; <b>Medication: </b><?php echo $eclaim["medication_1"]; ?></div>
<div><b>Date: </b><?php echo empty($eclaim["medication_date_2"]) ? "__________" : $eclaim["medication_date_2"]; ?> &nbsp; &nbsp; <b>Medication: </b><?php echo $eclaim["medication_2"]; ?></div>
<div><b>Date: </b><?php echo empty($eclaim["medication_date_3"]) ? "__________" : $eclaim["medication_date_3"]; ?> &nbsp; &nbsp; <b>Medication: </b><?php echo $eclaim["medication_3"]; ?></div>
<br />
<h3>Payee Information</h3>
<div><b>Payment Type: </b><?php echo $eclaim["payees_payment_type"]; ?></div>
<div><b>Payee Name: </b><?php echo $eclaim["payees_payee_name"]; ?> : <?php echo ($eclaim["payees_payment_type"] == 'cheque') ? $eclaim["payees_address"]." ".$eclaim["payees_city"]."; ".$eclaim["payees_province"]." ".$eclaim["payees_country"]." ".$eclaim["payees_postcode"] : $eclaim["payees_email"]; ?>
<br />
<h3>Expenses Claimed</h3>
<?php
$expenses_claimed_service_descriptions = json_decode($eclaim["expenses_claimed_service_description"], TRUE);
$expenses_claimed_provider_names = json_decode($eclaim["expenses_claimed_provider_name"], TRUE);
$expenses_claimed_referencing_physicians = json_decode($eclaim["expenses_claimed_referencing_physician"], TRUE);
$expenses_claimed_date_of_services = json_decode($eclaim["expenses_claimed_date_of_service"], TRUE);
$expenses_claimed_amount_client_paid_orgs = json_decode($eclaim["expenses_claimed_amount_client_paid_org"], TRUE);
$expenses_claimed_amount_claimed_orgs = json_decode($eclaim["expenses_claimed_amount_claimed_org"], TRUE);
$expenses_claimed_other_reimbursed_amounts = json_decode($eclaim["expenses_claimed_other_reimbursed_amount"], TRUE);
if ($expenses_claimed_service_descriptions && is_array($expenses_claimed_service_descriptions)) {
    foreach ( $expenses_claimed_service_descriptions as $key => $value ) { ?>
<div><b>Description of Services: </b><?php echo $expenses_claimed_service_descriptions[$key]; ?></div>
<div><b>Date of Service: </b><?php echo $expenses_claimed_service_descriptions[$key]; ?></div>
<div><b>Amount Client Paid: </b><?php echo $expenses_claimed_amount_client_paid_orgs[$key]; ?></div>
<div><b>Amount Claimed: </b><?php echo $expenses_claimed_amount_client_paid_orgs[$key]; ?></div>
<div><b>Amount reimbursed / refunded by other party : </b><?php echo $expenses_claimed_other_reimbursed_amounts[$key]; ?></div>
<br />
<?php
    }
}
?>
<br />
<div><b>Sign: </b><?php echo $eclaim['sign_name']; ?></div>
<?php if (!empty($eclaim['sign_image']) && isset($eclaim_files[$eclaim['sign_image']])) { ?>
<div><img src="<?php echo base_url('assets/uploads/') . $eclaim_files[$eclaim['sign_image']]['path'] . "/" . $eclaim_files[$eclaim['sign_image']]['name']; ?>"></div>
<?php } ?>
<?php if (!empty($eclaim['sign_image2'])) { ?>
<div><img src="<?php echo base_url('assets/uploads/') . $eclaim_files[$eclaim['sign_image2']]['path'] . "/" . $eclaim_files[$eclaim['sign_image2']]['name']; ?>"></div>
<?php } ?>
<div><b>Images: </b></div>
<?php 
$images = json_decode($eclaim['imgfile'], TRUE);
if ($images) {
foreach ( $images as $key => $value ) {
    if (!isset($eclaim_files[$value])) continue;
    $ext = strtolower(substr($eclaim_files[$value]['name'], -3));
    if ($ext == 'pdf') continue;
?>
<div><img src="<?php echo base_url('assets/uploads/') . $eclaim_files[$value]['path'] . "/" . $eclaim_files[$value]['name']; ?>"></div>
<?php
}
}
?>
<script type="text/javascript">
<!--
window.print();
//-->
</script>
