<style>
h3 {
border-bottom: 1px solid #000;
}
</style>
<div>
    <h1 style="text-align:center; width:100%">Eclaim - <?php echo empty($eclaim['eclaim_no']) ? "ID#".$eclaim['id'] : $eclaim['eclaim_no']; ?></h1>
</div>
<div>
    <h1>JF Canadian Travel Insurance Baggage Benefit Claim Details</h1>
</div>
<h3>SECTION A: INSURED’S INFORMATION</h3>
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
<div><b>PostCode: </b><?php echo $eclaim["post_code"]; ?></div>
<div><b>Date of Departure: </b><?php echo isset($eclaim["exinfo_depature_date"]) ? $eclaim["exinfo_depature_date"] : ''; ?></div>
<div><b>Date of Return to home province: </b><?php echo isset($eclaim["exinfo_return_date"]) ? $eclaim["exinfo_return_date"] : ''; ?></div>
<div><b>Date of Arrival in Canada: </b><?php echo $eclaim["arrival_date_canada"]; ?></div>
<div><b>Destination: </b><?php echo isset($eclaim["exinfo_destination"]) ? $eclaim["exinfo_destination"] : ''; ?></div>
<div><b>Telephone: </b><?php echo $eclaim["telephone"]; ?></div>
<div><b>Email: </b><?php echo $eclaim["email"]; ?></div>
<div><b>Date of Arrival in Canada: </b><?php echo $eclaim["arrival_date_canada"]; ?></div>
<div><b>Cellular: </b><?php echo $eclaim["cellular"]; ?></div>

<div><b>Do you have other travel medical insurance coverage? </b><?php if (!empty($eclaim["exinfo_other_medical_insurance"])) { echo "Yes"; } ?></div>
<div><b>If 'yes', please provide the following information: </b></div>
<div><b>Name of Insurance Company: </b><?php echo isset($eclaim["exinfo_other_insurance_name"]) ? $eclaim["exinfo_other_insurance_name"] : ''; ?></div>
<div><b>Policy #: </b><?php echo isset($eclaim["exinfo_other_insurance_policy"]) ? $eclaim["exinfo_other_insurance_policy"] : ''; ?></div>
<div><b>Member ID: </b><?php echo isset($eclaim["exinfo_other_insurance_number"]) ? $eclaim["exinfo_other_insurance_number"] : ''; ?></div>
<div><b>Telephone: </b><?php echo isset($eclaim["exinfo_other_insurance_phone"]) ? $eclaim["exinfo_other_insurance_phone"] : ''; ?></div>

<div><b>Do you have insurance coverage through your spouse? </b><?php if (!empty($eclaim["exinfo_spouse_insurance"])) { echo "Yes"; } ?></div>
<div><b>If 'yes', please provide the following information: </b></div>
<div><b>Name of Insurance Company: </b><?php echo isset($eclaim["exinfo_spouse_insurance_name"]) ? $eclaim["exinfo_spouse_insurance_name"] : ''; ?></div>
<div><b>Policy #: </b><?php echo isset($eclaim["exinfo_spouse_insurance_policy"]) ? $eclaim["exinfo_spouse_insurance_policy"] : ''; ?></div>
<div><b>Member ID: </b><?php echo isset($eclaim["exinfo_spouse_insurance_number"]) ? $eclaim["exinfo_spouse_insurance_number"] : ''; ?></div>
<div><b>Telephone: </b><?php echo isset($eclaim["exinfo_spouse_insurance_phone"]) ? $eclaim["exinfo_spouse_insurance_phone"] : ''; ?></div>
<div><b>Spouse’s Name: </b><?php echo isset($eclaim["exinfo_spouse_name"]) ? $eclaim["exinfo_spouse_name"] : ''; ?></div>
<div><b>Spouse’s Date of Birth: </b><?php echo isset($eclaim["exinfo_spouse_dob"]) ? $eclaim["exinfo_spouse_dob"] : ''; ?></div>

<div><b>Do you have credit card insurance coverage? </b><?php if (!empty($eclaim["exinfo_credit_card_insurance"])) { echo "Yes"; } ?></div>
<div><b>If 'yes', please provide the following information: </b></div>
<div><b>Name of the financial Institution: </b><?php echo isset($eclaim["exinfo_credit_card_name"]) ? $eclaim["exinfo_credit_card_name"] : ''; ?></div>
<div><b>First 6 digits of credit card: </b><?php echo isset($eclaim["exinfo_credit_card_number"]) ? $eclaim["exinfo_credit_card_number"] : ''; ?></div>
<div><b>Expiry Date(MM/YYYY): </b><?php echo isset($eclaim["exinfo_credit_card_expire"]) ? $eclaim["exinfo_credit_card_expire"] : ''; ?></div>
<div><b>Name of Cardholder: </b><?php echo isset($eclaim["exinfo_credit_card_holder"]) ? $eclaim["exinfo_credit_card_holder"] : ''; ?></div>

<div><b>Do you have insurance benefits available through group insurance or any other source? </b><?php if (!empty($eclaim["exinfo_group_insurance"])) { echo "Yes"; } ?></div>
<div><b>If 'yes', please provide details below: </b></div>
<div><b>Group Insurance </b></div>
<div><b>Name and Address of Insurance Company: </b><?php echo isset($eclaim["exinfo_group_insurance_company"]) ? $eclaim["exinfo_group_insurance_company"] :''; ?></div>
<div><b>Policy #: </b><?php echo isset($eclaim["exinfo_group_insurance_policy"]) ? $eclaim["exinfo_group_insurance_policy"] : ''; ?></div>
<div><b>Telephone: </b><?php echo isset($eclaim["exinfo_group_insurance_phone"]) ? $eclaim["exinfo_group_insurance_phone"] : ''; ?></div>
<div><b>Other Travel Insurance </b></div>
<div><b>Name and Address of Insurance Company: </b><?php echo isset($eclaim["exinfo_other_insurance_name"]) ? $eclaim["exinfo_other_insurance_name"] :''; ?></div>
<div><b>Policy #: </b><?php echo isset($eclaim["exinfo_other_insurance_number"]) ? $eclaim["exinfo_other_insurance_number"] : ''; ?></div>
<div><b>Telephone: </b><?php echo isset($eclaim["exinfo_other_insurance_phone"]) ? $eclaim["exinfo_other_insurance_phone"] : ''; ?></div>
<br />
<h3>SECTION B: TYPE OF LOSS</h3>
<div><b>Type: </b><?php echo isset($eclaim["exinfo_loss_type"]) ? $eclaim["exinfo_loss_type"] : ""; ?></div>
<div><b>Describe how and where the loss occured: </b><?php echo isset($eclaim["exinfo_loss_describe"]) ? $eclaim["exinfo_loss_describe"] : ''; ?></div>
<div><b>Date loss occured: </b><?php echo isset($eclaim["exinfo_loss_date"]) ? $eclaim["exinfo_loss_date"] : ''; ?></div>
<div><b>To whom was loss reported: </b><?php echo isset($eclaim["exinfo_loss_report_to"]) ? $eclaim["exinfo_loss_report_to"] : ''; ?></div>
<div><b>If seleced Other please specify: </b><?php echo isset($eclaim["exinfo_loss_report_other"]) ? $eclaim["exinfo_loss_report_other"] : ''; ?></div>
<br />
<h3>Contact Information</h3>
<div><b>First Name: </b><?php echo isset($eclaim["contact_first_name"]) ? $eclaim["contact_first_name"] : ''; ?></div>
<div><b>Last Name: </b><?php echo isset($eclaim["contact_last_name"]) ? $eclaim["contact_last_name"] : ''; ?></div>
<div><b>Email: </b><?php echo isset($eclaim["contact_email"]) ? $eclaim["contact_email"] : ''; ?></div>
<div><b>Phone: </b><?php echo isset($eclaim["contact_phone"]) ? $eclaim["contact_phone"] : ''; ?></div>
<br />
<h3>Name and Address of Family Physician in Country of Origin</h3>
<div><b>Name: </b><?php echo isset($eclaim["physician_name"]) ? $eclaim["physician_name"] : ''; ?></div>
<div><b>Clinic Name or Address: </b><?php echo isset($eclaim["clinic_name"]) ? $eclaim["clinic_name"] : ''; ?></div>
<div><b>Street Address: </b><?php echo isset($eclaim["physician_street_address"]) ? $eclaim["physician_street_address"] : ''; ?></div>
<div><b>City/Town: </b><?php echo isset($eclaim["physician_city"]) ? $eclaim["physician_city"] : ''; ?></div>
<div><b>Country: </b><?php foreach ($country as $key => $val) { if (($key == $eclaim['country']) || ($val == $eclaim['country'])) { echo $val; break; } } ?>
<div><b>Postal Code: </b><?php echo isset($eclaim["physician_post_code"]) ? $eclaim["physician_post_code"] : ''; ?></div>
<div><b>Telephone: </b><?php echo isset($eclaim["physician_telephone"]) ? $eclaim["physician_telephone"] : ''; ?></div>
<div><b>Alt Telephone: </b><?php echo isset($eclaim["physician_alt_telephone"]) ? $eclaim["physician_alt_telephone"] : ''; ?></div>
<br />
<h3>Name and Address of Family Physician in Canada</h3>
<div><b>Name: </b><?php echo isset($eclaim["clinic_name_canada"]) ? $eclaim["clinic_name_canada"] : ''; ?></div>
<div><b>Clinic Name or Address: </b><?php echo isset($eclaim["clinic_name_canada"]) ? $eclaim["clinic_name_canada"] : ''; ?></div>
<div><b>Street Address: </b><?php echo isset($eclaim["physician_street_address_canada"]) ? $eclaim["physician_street_address_canada"] : ''; ?></div>
<div><b>City/Town: </b><?php echo isset($eclaim["physician_city_canada"]) ? $eclaim["physician_city_canada"] : ''; ?></div>
<div><b>Postal Code: </b><?php echo isset($eclaim["physician_post_code_canada"]) ? $eclaim["physician_post_code_canada"] : ''; ?></div>
<div><b>Telephone: </b><?php echo isset($eclaim["physician_telephone_canada"]) ? $eclaim["physician_telephone_canada"] : ''; ?></div>
<div><b>Alt Telephone: </b><?php echo isset($eclaim["physician_alt_telephone_canada"]) ? $eclaim["physician_alt_telephone_canada"] : ''; ?></div>
<br />
<h3>Other Insurance Coverage</h3>
<div><b>Do you have other insurance coverage including Canadian government health insurance? </b><?php echo ($eclaim["other_insurance_coverage"] == 'Y') ? 'Yes' : 'No'; ?></div>
<div><b>Do you, your spouse or your parents/guardians have any other medical or travel insurance coverage? </b><?php echo ($eclaim["travel_insurance_coverage_guardians"] == 'Y') ? 'Yes' : 'No'; ?></div>
<div><b>If yes, provide details of other insurance company coverage below. If no, confirm by checking the box below. </b><?php echo ($eclaim["travel_insurance_coverage_guardians"] == 'Y') ? 'Yes' : 'No'; ?></div>
<div><b>Full Name: </b><?php echo isset($eclaim["full_name"]) ? $eclaim["full_name"] : ''; ?></div>
<div><b>Employer Name: </b><?php echo isset($eclaim["employee_name"]) ? $eclaim["employee_name"] : ''; ?></div>
<div><b>Street Address: </b><?php echo isset($eclaim["employee_street_address"]) ? $eclaim["employee_street_address"] : ''; ?></div>
<div><b>City/Town: </b><?php echo isset($eclaim["city_town"]) ? $eclaim["city_town"] : ''; ?></div>
<div><b>Country: </b><?php foreach ($country2 as $key => $val) { if (($key == $eclaim['country2']) || ($val == $eclaim['country2'])) { echo $val; } } ?></div>
<div><b>Telephone: </b><?php echo isset($eclaim["employee_telephone"]) ? $eclaim["employee_telephone"] : ''; ?></div>
<br />
<h3>Medical Information</h3>
<div><b>Diagnosis: </b><?php echo isset($eclaim["diagnosis"]) ? $eclaim["diagnosis"] : ''; ?></div>
<div><b>Brief description of your sickness or injury: </b><?php echo isset($eclaim["medical_description"]) ? $eclaim["medical_description"] : ''; ?></div>
<div><b>Date symptoms or injury first appeared: </b><?php echo isset($eclaim["date_symptoms"]) ? $eclaim["date_symptoms"] : ''; ?></div>
<div><b>Date you first saw physician for this condition: </b><?php echo isset($eclaim["date_first_physician"]) ? $eclaim["date_first_physician"] : ''; ?></div>
<div><b>Have you ever been treated for this or a similar condition before? </b><?php ($eclaim["treatment_before"] == 'Y') ? 'Yes' : 'No'; ?></div>
<div><b>If you answered “yes”, provide all dates of treatment and list all medications taken before the effective date of the current policy: </b>/div>
<div><b>Date (MM/DD/YYYY): </b><?php echo isset($eclaim["medication_date_1"]) ? $eclaim["medication_date_1"] : '__________'; ?><b> &nbsp; &nbsp; Medication: </b><?php echo isset($eclaim["medication_1"]) ? $eclaim["medication_1"] : ''; ?></div>
<div><b>Date (MM/DD/YYYY): </b><?php echo isset($eclaim["medication_date_2"]) ? $eclaim["medication_date_2"] : '__________'; ?><b> &nbsp; &nbsp; Medication: </b><?php echo isset($eclaim["medication_2"]) ? $eclaim["medication_2"] : ''; ?></div>
<div><b>Date (MM/DD/YYYY): </b><?php echo isset($eclaim["medication_date_3"]) ? $eclaim["medication_date_3"] : '__________'; ?><b> &nbsp; &nbsp; Medication: </b><?php echo isset($eclaim["medication_3"]) ? $eclaim["medication_3"] : ''; ?></div>
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
if (isset($expenses_claimed_service_descriptions)) {
    foreach ( $expenses_claimed_service_descriptions as $key => $value ) { ?>
<div><b>Name of Provider: </b><?php echo isset($expenses_claimed_provider_names[$key]) ? $expenses_claimed_provider_names[$key] : ''; ?></div>
<div><b>Name of Referring Physician: </b><?php echo isset($expenses_claimed_referencing_physicians[$key]) ? $expenses_claimed_referencing_physicians[$key] : ''; ?></div>
<div><b>Description of Services: </b><?php echo isset($expenses_claimed_service_descriptions[$key]) ? $expenses_claimed_service_descriptions[$key] : ''; ?></div>
<div><b>Date of Service: </b><?php echo isset($expenses_claimed_date_of_services[$key]) ? $expenses_claimed_date_of_services[$key] : ''; ?></div>
<div><b>Amount Client Paid: </b><?php echo isset($expenses_claimed_amount_client_paid_orgs[$key]) ? $expenses_claimed_amount_client_paid_orgs[$key] : ''; ?></div>
<div><b>Amount Claimed: </b><?php echo isset($expenses_claimed_amount_claimed_orgs[$key]) ? $expenses_claimed_amount_claimed_orgs[$key] : ''; ?></div>
<div><b>Amount reimbursed / refunded by other party : </b><?php echo $expenses_claimed_other_reimbursed_amounts[$key]; ?></div>
<?php 
    }
}
?>
<br />
<div><b>Sign: </b><?php echo $eclaim['sign_name']; ?></div>
<div><img src="<?php echo base_url('assets/uploads/') . $eclaim_files[$eclaim['sign_image']]['path'] . "/" . $eclaim_files[$eclaim['sign_image']]['name']; ?>"></div>
<?php if (!empty($eclaim['sign_image2'])) { ?>
<div><img src="<?php echo base_url('assets/uploads/') . $eclaim_files[$eclaim['sign_image2']]['path'] . "/" . $eclaim_files[$eclaim['sign_image2']]['name']; ?>"></div>
<?php } ?>
<div><b>Images: </b></div>
<?php 
$images = json_decode($eclaim['imgfile'], TRUE);
foreach ( $images as $key => $value ) {
    if (!isset($eclaim_files[$value])) continue;
    $ext = strtolower(substr($eclaim_files[$value]['name'], -3));
    if ($ext == 'pdf') continue;
?>
<div><img src="<?php echo base_url('assets/uploads/') . $eclaim_files[$value]['path'] . "/" . $eclaim_files[$value]['name']; ?>"></div>
<?php
}
?>
<script type="text/javascript">
<!--
window.print();
//-->
</script>
