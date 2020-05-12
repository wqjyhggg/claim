<div>
	<div class="page-title">
		<div class="title_left">
			<h3>Eclaim - ID#<?php echo $eclaim['id']; ?></h3>
	  </div>
	</div>
	<div class="clearfix"></div>
	<!-- Policy search and List Section -->
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<?php echo $message; ?>
				<div class="x_content">
					<?php echo form_open("eclaim/create_claim", array('class'=>'form-horizontal', 'method'=>'post', 'id'=>'main_form')); ?>
					<div class="case_info">
						<h4 class="move_down">
							Claimant Information <i class="fa fa-angle-down pull-right"></i>
						</h4>
						<div class="row" style="display: none">
							<div class="form-group col-sm-3">
								<?php echo form_label('Insured First Name:', 'insured_first_name', array("class" => 'col-sm-12')); ?>
								<?php echo form_input("insured_first_name", $eclaim["insured_first_name"], array("class" => "form-control required", 'placeholder' => 'Insured First Name')); ?>
								<?php echo form_error("insured_first_name"); ?>
							</div>
							<div class="col-sm-3">
								<?php echo form_label('Insured Last Name:', 'insured_last_name', array("class" => 'col-sm-12')); ?>
								<?php echo form_input("insured_last_name", $eclaim["insured_last_name"], array("class" => "form-control", 'placeholder' => 'Insured Last Name')); ?>
							</div>
							<div class="col-sm-3">
								<div class="col-sm-4">
									<?php echo form_label('&nbsp;', 'gender', array("class" => 'col-sm-12')); ?>
									<?php echo form_radio("gender", "male", ($eclaim["gender"] == 'male' ? TRUE : FALSE), array('class' => 'setpremium')); ?>  Male
								</div>
								<div class="col-sm-5">
									<?php echo form_label('&nbsp;', 'gender', array("class" => 'col-sm-12')); ?>
									<?php echo form_radio("gender", "female", ($eclaim["gender"] == 'female' ? TRUE : FALSE), array('class' => 'setpremium')); ?>  Female
								</div>
							</div>
							<div class="col-sm-3">
								<?php echo form_label('ID', 'id', array("class" => 'col-sm-12')); ?>
								<?php echo form_input("personal_id", $policy["student_id"], array("class" => "form-control", 'placeholder' => 'ID')); ?>
								<?php echo form_error("personal_id"); ?>
							</div>
							<div class="clearfix"></div>
							
							<div class="form-group col-sm-3">
								<?php echo form_label('Date of Birth:', 'dob', array("class"=>'col-sm-12'));   ?>
								<div class="input-group date">
									<?php echo form_input("dob", $eclaim["dob"], array("class" => "form-control dob required", 'placeholder' => 'Date of Birth')); ?>
									<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
								</div>
								<?php echo form_error("dob"); ?>
							</div>
							<div class="form-group col-sm-3">
								<?php echo form_label('Policy#:', 'policy_no', array("class" => 'col-sm-12')); ?>
								<?php echo form_input("policy_no", $eclaim["policy_no"], array("class" => "form-control required", 'placeholder' => 'Policy#', 'readonly' => 'readonly')); ?>
								<?php echo form_error("policy_no"); ?>
								<?php echo form_hidden("id", $eclaim['id']); ?>
								<?php echo form_hidden("eclaim_no", $eclaim['eclaim_no']); ?>
								<?php echo form_hidden("product_short", $eclaim['product_short']); ?>
							</div>
							<div class="form-group col-sm-3">
								<?php echo form_label('Case #:', 'case_no', array("class" => 'col-sm-12')); ?>
								<?php echo form_input("case_no", $eclaim['case_no'], array("class" => "form-control", 'placeholder' => 'Case #')); ?>
								<?php echo form_error("case_no"); ?>
							</div>
							<div class="form-group col-sm-3">
								<?php echo form_label('School Name:', 'school_name', array("class" => 'col-sm-12')); ?>
								<?php echo form_input("school_name", $eclaim["school_name"], array("class" => "form-control", 'placeholder' => 'School Name')); ?>
								<?php echo form_error("school_name"); ?>
							</div>
							<div class="form-group col-sm-3">
								<?php echo form_label('Group ID:', 'group_id', array("class" => 'col-sm-12')); ?>
								<?php echo form_input("group_id", $eclaim["group_id"], array("class" => "form-control", 'placeholder' => 'Group ID')); ?>
								<?php echo form_error("group_id"); ?>
							</div>
							<div class="form-group col-sm-3">
								<?php echo form_label('Enroll Date:', 'apply_date', array("class"=>'col-sm-12')); ?>
								<div class="input-group date">
									<?php echo form_input("apply_date", $policy["apply_date"], array("class" => "form-control datepicker",'placeholder' => 'Enroll Date')); ?>
									<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
								</div>
							</div>
							<div class="form-group col-sm-3">
								<?php echo form_label('Arrival Date in Canada:', 'arrival_date', array("class"=>'col-sm-12')); ?>
								<div class="input-group date">
									<?php echo form_input("arrival_date", $eclaim["arrival_date"], array("class" => "form-control datepicker", 'placeholder' => 'Arrival Date in Canada')); ?>
									<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
								</div>
							</div>
							<div class="form-group col-sm-3">
								<?php echo form_label('Full Name of Guardian if applicable:', 'guardian_name', array("class" => 'col-sm-12')); ?>
								<?php echo form_input("guardian_name", $eclaim["guardian_name"], array("class" => "form-control", 'placeholder' => 'Full Name of Guardian if applicable')); ?>
							</div>
							<div class="form-group col-sm-3">
								<?php echo form_label('Guardian Phone#:', 'guardian_phone', array("class" => 'col-sm-12')); ?>
								<?php echo form_input("guardian_phone", $eclaim["guardian_phone"], array("class" => "form-control", 'placeholder' => 'Guardian Phone#')); ?>
							</div>
						</div>

						<h4 class="move_down">Address in Canada <i class="fa fa-angle-down pull-right"></i></h4>
						<div class="row" style="display: none">
							<div class="form-group col-sm-3">
								<?php echo form_label('Street Address:', 'street_address', array("class" => 'col-sm-12')); ?>
								<?php echo form_input("street_address", $eclaim["street_address"], array("class" => "form-control", 'placeholder' => 'Street Address')); ?>
							</div>
							<div class="form-group col-sm-3">
								<?php echo form_label('City/Town:', 'city', array("class" => 'col-sm-12')); ?>
								<?php echo form_input("city", $eclaim["city"], array("class" => "form-control", 'placeholder' => 'City/Town')); ?>
							</div>
							<div class="form-group col-sm-3">
								<?php echo form_label('Province:', 'province', array("class" => 'col-sm-12')); ?>
								<?php echo form_input("province", $eclaim["province"], array("class" => "form-control", 'placeholder' => 'Province')); ?>
							</div>
							<div class="form-group col-sm-3">
								<?php echo form_label('Telephone:', 'telephone', array("class" => 'col-sm-12')); ?>
								<?php echo form_input("telephone", $eclaim["telephone"], array("class" => "form-control", 'placeholder' => 'Telephone')); ?>
							</div>
							<div class="form-group col-sm-3">
								<?php echo form_label('Email:', 'email', array("class" => 'col-sm-12')); ?>
								<?php echo form_input("email", $eclaim["email"], array("class" => "form-control", 'placeholder' => 'Email')); ?>
							</div>
							<div class="form-group col-sm-3">
								<?php echo form_label('PostCode:', 'post_code', array("class" => 'col-sm-12')); ?>
								<?php echo form_input("post_code", $eclaim["post_code"], array("class" => "form-control", 'placeholder' => 'PostCode')); ?>
							</div>
							<div class="form-group col-sm-3">
								<?php echo form_label('Date of Arrival in Canada:', 'arrival_date_canada', array("class"=>'col-sm-12')); ?>
								<div class="input-group date">
									<?php echo form_input("arrival_date_canada", $eclaim["arrival_date_canada"], array("class" => "form-control datepicker",'placeholder' => 'Date of Arrival in Canada')); ?>
									<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
								</div>
							</div>
							<div class="form-group col-sm-3">
								<?php echo form_label('Cellular:', 'cellular', array("class" => 'col-sm-12')); ?>
								<?php echo form_input("cellular", $eclaim["cellular"], array("class" => "form-control", 'placeholder' => 'Cellular')); ?>
							</div>
						</div>

						<h4 class="move_down">Contact Information <i class="fa fa-angle-down pull-right"></i></h4>
						<div class="row" style="display: none">
							<div class="form-group col-sm-3">
								<?php echo form_label('First Name:', 'contact_first_name', array("class" => 'col-sm-12')); ?>
								<?php echo form_input("contact_first_name", $eclaim["contact_first_name"], array("class" => "form-control",'placeholder' => 'First Name')); ?>
								<?php echo form_error("contact_first_name"); ?>
							</div>
							<div class="form-group col-sm-3">
								<?php echo form_label('Last Name:', 'contact_last_name', array("class" => 'col-sm-12')); ?>
								<?php echo form_input("contact_last_name", $eclaim["contact_last_name"], array("class" => "form-control", 'placeholder' => 'Last Name')); ?>
								<?php echo form_error("contact_last_name"); ?>
							</div>
							<div class="form-group col-sm-3">
								<?php echo form_label('Email:', 'contact_email', array("class" => 'col-sm-12')); ?>
								<?php echo form_input("contact_email", $eclaim["contact_email"], array("class" => "form-control", 'placeholder' => 'Email')); ?>
								<?php echo form_error("contact_email"); ?>
							</div>
							<div class="form-group col-sm-3">
								<?php echo form_label('Phone:', 'contact_phone', array("class" => 'col-sm-12')); ?>
								<?php echo form_input("contact_phone", $eclaim["contact_phone"], array("class" => "form-control", 'placeholder' => 'Phone')); ?>
								<?php echo form_error("contact_phone"); ?>
							</div>
						</div>

						<h4 class="move_down">Name and Address of Family Physician in Country of Origin <i class="fa fa-angle-down pull-right"></i></h4>
						<div class="row" style="display: none">
							<div class="col-sm-12">
								<div class="form-group col-sm-3">
									<?php echo form_label('Name:', 'physician_name', array("class" => 'col-sm-12')); ?>
									<?php echo form_input("physician_name", $eclaim["physician_name"], array("class" => "form-control", 'placeholder' => 'Name')); ?>
								</div>
								<div class="form-group col-sm-3">
									<?php echo form_label('Clinic Name or Address:', 'clinic_name', array("class" => 'col-sm-12')); ?>
									<?php echo form_input("clinic_name", $eclaim["clinic_name"], array("class" => "form-control", 'placeholder' => 'Clinic Name or Address')); ?>
								</div>
								<div class="form-group col-sm-3">
									<?php echo form_label('Street Address:', 'physician_street_address', array("class" => 'col-sm-12')); ?>
									<?php echo form_input("physician_street_address", $eclaim["physician_street_address"], array("class" => "form-control", 'placeholder' => 'Street Address')); ?>
								</div>
								<div class="form-group col-sm-3">
									<?php echo form_label('City/Town:', 'physician_city', array("class" => 'col-sm-12')); ?>
									<?php echo form_input("physician_city", $eclaim["physician_city"], array("class" => "form-control", 'placeholder' => 'City/Town')); ?>
								</div>
								<div class="form-group col-sm-3">
									<?php echo form_label('Country:', 'country', array("class" => 'col-sm-12')); ?>
									<select name="country" class="form-control">
										<option value=""> -- Select Country -- </option>
										<?php foreach ($country as $key => $val):?>
										<option value="<?php echo $key; ?>" <?php if (($key == $eclaim['country']) || ($val == $eclaim['country'])) { echo "selected"; } ?>><?php echo $val; ?></option>
										<?php endforeach; ?>
										<option value=""> N/A </option>
									</select>
								</div>
								<div class="form-group col-sm-3">
									<?php echo form_label('Postal Code:', 'physician_post_code', array("class" => 'col-sm-12')); ?>
									<?php echo form_input("physician_post_code", $eclaim["physician_post_code"], array("class" => "form-control", 'placeholder' => 'Postal Code')); ?>
								</div>
								<div class="form-group col-sm-3">
									<?php echo form_label('Telephone:', 'physician_telephone', array("class" => 'col-sm-12')); ?>
									<?php echo form_input("physician_telephone", $eclaim["physician_telephone"], array("class" => "form-control", 'placeholder' => 'Telephone')); ?>
								</div>
								<div class="form-group col-sm-3">
									<?php echo form_label('Alt Telephone:', 'physician_alt_telephone', array("class" => 'col-sm-12')); ?>
									<?php echo form_input("physician_alt_telephone", $eclaim["physician_alt_telephone"], array("class" => "form-control", 'placeholder' => 'Alt Telephone')); ?>
								</div>
							</div>
						</div>

						<h4 class="move_down">Name and Address of Family Physician in Canada <i class="fa fa-angle-down pull-right"></i></h4>
						<div class="row" style="display: none">
							<div class="col-sm-12">
								<div class="form-group col-sm-3">
									<?php echo form_label('Name:', 'physician_name_canada', array("class" => 'col-sm-12')); ?>
									<?php echo form_input("physician_name_canada", $eclaim["physician_name_canada"], array("class" => "form-control", 'placeholder' => 'Name')); ?>
								</div>
								<div class="form-group col-sm-3">
									<?php echo form_label('Clinic Name or Address:', 'clinic_name_canada', array("class" => 'col-sm-12')); ?>
									<?php echo form_input("clinic_name_canada", $eclaim["clinic_name_canada"], array("class" => "form-control", 'placeholder' => 'Clinic Name or Address')); ?>
								</div>
								<div class="form-group col-sm-3">
									<?php echo form_label('Street Address:', 'physician_street_address_canada', array("class" => 'col-sm-12')); ?>
									<?php echo form_input("physician_street_address_canada", $eclaim["physician_street_address_canada"], array("class" => "form-control", 'placeholder' => 'Street Address')); ?>
								</div>
								<div class="form-group col-sm-3">
									<?php echo form_label('City/Town:', 'physician_city_canada', array("class" => 'col-sm-12')); ?>
									<?php echo form_input("physician_city_canada", $eclaim["physician_city_canada"], array("class" => "form-control", 'placeholder' => 'City/Town')); ?>
								</div>
								<div class="form-group col-sm-3">
									<?php echo form_label('Postal Code:', 'physician_post_code_canada', array("class" => 'col-sm-12')); ?>
									<?php echo form_input("physician_post_code_canada", $eclaim["physician_post_code_canada"], array("class" => "form-control", 'placeholder' => 'Postal Code')); ?>
								</div>
								<div class="form-group col-sm-3">
									<?php echo form_label('Telephone:', 'physician_telephone_canada', array("class" => 'col-sm-12')); ?>
									<?php echo form_input("physician_telephone_canada", $eclaim["physician_telephone_canada"], array("class" => "form-control", 'placeholder' => 'Telephone')); ?>
								</div>
								<div class="form-group col-sm-3">
									<?php echo form_label('Alt Telephone:', 'physician_alt_telephone_canada', array("class" => 'col-sm-12')); ?>
									<?php echo form_input("physician_alt_telephone_canada", $eclaim["physician_alt_telephone_canada"], array("class" => "form-control", 'placeholder' => 'Alt Telephone')); ?>
								</div>
							</div>
						</div>

						<h2 class="move_down">Other Insurance Coverage <i class="fa fa-angle-down pull-right"></i></h2>
						<div class="row" style="display: none">
							<div class="col-sm-12">
								<div class="row">
									<div class="col-sm-12">
										<div class="col-sm-7">Do you have other insurance coverage including Canadian government health insurance?</div>
										<div class="col-sm-1">
											<?php echo form_radio("other_insurance_coverage", "Y", ($eclaim["other_insurance_coverage"] == 'Y' ? TRUE : FALSE), array('class' => 'setpremium')); ?>  Yes
										</div>
										<div class="col-sm-1">
											<?php echo form_radio("other_insurance_coverage", "N", $eclaim["other_insurance_coverage"] == 'N' ? TRUE : FALSE, array('class' => 'setpremium')); ?>  No
										</div>
										<div class="clearfix"></div>

										<div class="col-sm-7">Do you, your spouse or your parents/guardians have any other medical or travel insurance coverage?</div>
										<div class="col-sm-1">
											<?php echo form_radio("travel_insurance_coverage_guardians", "Y", ($eclaim["travel_insurance_coverage_guardians"] == 'Y' ? TRUE : FALSE), array('class' => 'setpremium')); ?>  Yes
										</div>
										<div class="col-sm-1">
											<?php echo form_radio("travel_insurance_coverage_guardians", "N", $eclaim["travel_insurance_coverage_guardians"] == 'N' ? TRUE : FALSE, array('class' => 'setpremium')); ?>  No
										</div>

										<div class="col-sm-12">If yes, provide details of other insurance company coverage below.</div>
									</div>
									<div class="col-sm-3">
										<?php echo form_label('Full Name:', 'full_name', array("class" => 'col-sm-12')); ?>
										<?php echo form_input("full_name", $eclaim["full_name"], array("class" => "form-control", 'placeholder' => 'Full Name')); ?>
									</div>
									<div class="col-sm-3">
										<?php echo form_label('Employer Name:', 'employee_name', array("class" => 'col-sm-12')); ?>
										<?php echo form_input("employee_name", $eclaim["employee_name"], array("class" => "form-control", 'placeholder' => 'Employer Name')); ?>
									</div>
									<div class="col-sm-3">
										<?php echo form_label('Street Address:', 'employee_street_address', array("class" => 'col-sm-12')); ?>
										<?php echo form_input("employee_street_address", $eclaim["employee_street_address"], array("class" => "form-control", 'placeholder' => 'Street Address')); ?>
									</div>
									<div class="col-sm-3">
										<?php echo form_label('City/Town:', 'city_town', array("class" => 'col-sm-12')); ?>
										<?php echo form_input("city_town", $eclaim["city_town"], array("class" => "form-control", 'placeholder' => 'City/Town')); ?>
									</div>
									<div class="col-sm-3">
										<?php echo form_label('Post Code:', 'employee_post_code', array("class" => 'col-sm-12')); ?>
										<?php echo form_input("employee_post_code", $eclaim["employee_post_code"], array("class" => "form-control", 'placeholder' => 'Post Code')); ?>
										<?php echo form_error("employee_post_code"); ?>
									</div>
									<div class="form-group col-sm-3">
										<?php echo form_label('Country:', 'country2', array("class" => 'col-sm-12')); ?>
										<select name="country2" class="form-control">
											<option value=""> -- Select Country -- </option>
											<?php foreach ($country as $key => $val):?>
											<option value="<?php echo $key; ?>" <?php if (($key == $eclaim['country2']) || ($val == $eclaim['country2'])) { echo "selected"; } ?>><?php echo $val; ?></option>
											<?php endforeach; ?>
											<option value=""> N/A </option>
										</select>
									</div>
									<div class="col-sm-3">
										<?php echo form_label('Telephone:', 'employee_telephone', array("class" => 'col-sm-12')); ?>
										<?php echo form_input("employee_telephone", $eclaim["employee_telephone"], array("class" => "form-control", 'placeholder' => 'Telephone')); ?>
									</div>
								</div>
							</div>
						</div>

						<h2 class="move_down">Medical Information <small></small> <i class="fa fa-angle-down pull-right"></i></h2>
						<div class="row" style="display: none">
							<div class="col-sm-12">
								<?php echo form_label('Diagnosis:', 'diagnosis', array("class" => 'col-sm-12')); ?>
								<?php echo form_input("diagnosis", $eclaim["diagnosis"], array("class" => "form-control required", 'placeholder' => 'Diagnosis')); ?>
								<?php echo form_error("diagnosis"); ?>
							</div>
							<div class="form-group col-sm-12">
								<?php echo form_label('Brief description of your sickness or injury:', 'medical_description', array("class" => 'col-sm-12')); ?>
								<?php echo form_textarea("medical_description", $eclaim["medical_description"], array("class" => "form-control", 'placeholder' => 'Brief description of your sickness or injury')); ?>
							</div>
							<div class="col-sm-6">
								<?php echo form_label('Date symptoms or injury first appeared:', 'date_symptoms', array("class" => 'col-sm-12')); ?>
								<?php echo form_input("date_symptoms", $eclaim["date_symptoms"], array("class" => "form-control dob", 'placeholder' => 'Date symptoms or injury first appeared')); ?>
								<?php echo form_error("date_symptoms"); ?>
							</div>
							<div class="col-sm-6">
								<?php echo form_label('Date you first saw physician for this condition:', 'date_first_physician', array("class" => 'col-sm-12')); ?>
								<?php echo form_input("date_first_physician", $eclaim["date_first_physician"], array("class" => "form-control dob", 'placeholder' => 'Date you first saw physician for this condition')); ?>
							</div>
							<div class="col-sm-12" style="margin-top: 20px">

								<div class="col-sm-7">Have you ever been treated for this or a similar condition before?</div>
								<div class="col-sm-1">
									<?php echo form_radio("treatment_before", "Y", $eclaim["treatment_before"] == 'Y', array('class' => 'setpremium')); ?>  Yes
								</div>
								<div class="col-sm-1">
									<?php echo form_radio("treatment_before", "N", $eclaim["treatment_before"] != 'Y', array('class' => 'setpremium')); ?>  No
								</div>
								<div class="col-sm-12">If you answered “yes”, provide all dates of treatment and list all medications taken before the effective date of the current policy:</div>
								<div class="form-group col-sm-12">
									<div class="col-sm-3">
										<?php echo form_label('Date:', 'medication_date_1', array("class"=>'col-sm-12'));   ?>
										<div class="input-group date">
											<?php echo form_input("medication_date_1", $eclaim["medication_date_1"], array("class" => "form-control datepicker", 'placeholder' => 'Date')); ?>
											<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
										</div>
									</div>
									<div class="col-sm-3">
										<?php echo form_label('Medication:', 'medication_1', array("class" => 'col-sm-12')); ?>
										<?php echo form_input("medication_1", $eclaim["medication_1"], array("class" => "form-control", 'placeholder' => 'Medication')); ?>
									</div>
								</div>
								<div class="form-group col-sm-12">
									<div class="col-sm-3">
										<?php echo form_label('Date:', 'medication_date_2', array("class"=>'col-sm-12'));   ?>
										<div class="input-group date">
											<?php echo form_input("medication_date_2", $eclaim["medication_date_2"], array("class" => "form-control datepicker", 'placeholder' => 'Date')); ?>
											<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
										</div>
									</div>
									<div class="col-sm-3">
										<?php echo form_label('Medication:', 'medication_2', array("class" => 'col-sm-12')); ?>
										<?php echo form_input("medication_2", $eclaim["medication_2"], array("class" => "form-control", 'placeholder' => 'Medication')); ?>
									</div>
								</div>
								<div class="form-group col-sm-12">
									<div class="col-sm-3">
										<?php echo form_label('Date:', 'medication_date_3', array("class"=>'col-sm-12'));   ?>
										<div class="input-group date">
											<?php echo form_input("medication_date_3", $eclaim["medication_date_3"], array("class" => "form-control datepicker", 'placeholder' => 'Date')); ?>
											<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
										</div>
									</div>
									<div class="col-sm-3">
										<?php echo form_label('Medication:', 'medication_3', array("class" => 'col-sm-12')); ?>
										<?php echo form_input("medication_3", $eclaim["medication_3"], array("class" => "form-control", 'placeholder' => 'Medication')); ?>
									</div>
								</div>
							</div>
						</div>
						<h2 class="move_down">
							Payee Information
							<i class="fa fa-angle-down pull-right"></i>
						</h2>
						<div class="row" style="display: none">
							<div class="col-sm-12">
								<div class="payee-data">
									<div class="row" style="border: 1px solid rgb(204, 204, 204); padding: 10px; margin-bottom: 9px">
										<div class="col-sm-3">
											<?php echo form_label('Payment Type', 'payment_type'); ?>
											<div style="text-transform: capitalize;"><?php echo $eclaim["payees_payment_type"]; ?></div>
											<input type="hidden" name="payees_payment_type" value="<?php echo $eclaim["payees_payment_type"]; ?>" class="payees_payment_type"/>
										</div>
										<div class="col-sm-3">
											<?php echo form_label('Payee Name:', 'Payee Name', array("class" => 'col-sm-12')); ?>
											<?php echo form_input("payees_payee_name", $eclaim["payees_payee_name"], array("class" => "form-control required", 'placeholder' => 'Payee Name', "readonly" => "readonly")); ?>
										</div>
										<div class="col-sm-3" <?php echo ($eclaim["payees_payment_type"] == 'cheque'?'style="display:none"':''); ?>>
											<?php echo form_label('Email Address:', 'Email Address', array("class" => 'col-sm-12')); ?>
											<?php echo form_input("payees_bank", $eclaim["payees_email"], array("class" => "form-control", 'placeholder' => 'Email Address', "readonly" => "readonly")); ?>
										</div>
										<div class="col-sm-3" style="display:none">
											<?php echo form_label('Account#:', 'Account', array("class" => 'col-sm-12')); ?>
											<?php echo form_input("payees_account_cheque", $eclaim["payees_account_cheque"], array("class" => "form-control", 'placeholder' => 'Account#', "readonly" => "readonly")); ?>
										</div>
										<div class="col-sm-3 cheque_section" <?php echo ($eclaim["payees_payment_type"] != 'cheque'?'style="display:none"':''); ?>>
											<label for="Address" class="col-sm-12">Address:</label>
											<?php echo form_input("payees_address", $eclaim["payees_address"], array("class" => "form-control " . ($eclaim["payees_payment_type"] != 'cheque' ? '' : 'required'), 'placeholder' => 'Address', "readonly" => "readonly")); ?>
										</div>
										<div class="col-sm-3 cheque_section" <?php echo ($eclaim["payees_payment_type"] != 'cheque'?'style="display:none"':''); ?>>
											<label for="City" class="col-sm-12">City:</label>
											<?php echo form_input("payees_city", $eclaim["payees_city"], array("class" => "form-control " . ($eclaim["payees_payment_type"] != 'cheque' ? '' : 'required'), 'placeholder' => 'City', "readonly" => "readonly")); ?>
										</div>
										<div class="col-sm-3 cheque_section" <?php echo ($eclaim["payees_payment_type"] != 'cheque'?'style="display:none"':''); ?>>
											<label for="Province" class="col-sm-12">Province:</label>
											<?php echo form_input("payees_province", $eclaim["payees_province"], array("class" => "form-control " . ($eclaim["payees_payment_type"] != 'cheque' ? '' : 'required'), 'placeholder' => 'Province', "readonly" => "readonly")); ?>
										</div>
										<div class="col-sm-3 cheque_section" <?php echo ($eclaim["payees_payment_type"] != 'cheque'?'style="display:none"':''); ?>>
											<label for="Country" class="col-sm-12">Country:</label>
											<?php echo form_input("payees_country", $eclaim["payees_country"], array("class" => "form-control " . ($eclaim["payees_payment_type"] != 'cheque' ? '' : 'required'), 'placeholder' => 'Country', "readonly" => "readonly")); ?>
										</div>
										<div class="col-sm-3 cheque_section" <?php echo ($eclaim["payees_payment_type"] != 'cheque'?'style="display:none"':''); ?>>
											<label for="Postcode" class="col-sm-12">Postcode:</label>
											<?php echo form_input("payees_postcode", $eclaim["payees_postcode"], array("class" => "form-control " . ($eclaim["payees_payment_type"] != 'cheque' ? '' : 'required'), 'placeholder' => 'Postcode', "readonly" => "readonly")); ?>
										</div>
									</div>
								</div>
							</div>
						</div>

						<h2 class="move_down">
							Expenses Claimed
							<i class="fa fa-angle-down pull-right"></i>
						</h2>
						<div class="row" style="display: none">
							<div class="col-sm-12">
								<div class="expenses-list">
									<!-- list all expenses items list here -->
									<?php
									$expenses_claimed_service_descriptions = json_decode($eclaim["expenses_claimed_service_description"], TRUE);
									$expenses_claimed_provider_names = json_decode($eclaim["expenses_claimed_provider_name"], TRUE);
									$expenses_claimed_referencing_physicians = json_decode($eclaim["expenses_claimed_referencing_physician"], TRUE);
									$expenses_claimed_date_of_services = json_decode($eclaim["expenses_claimed_date_of_service"], TRUE);
									$expenses_claimed_amount_client_paid_orgs = json_decode($eclaim["expenses_claimed_amount_client_paid_org"], TRUE);
									$expenses_claimed_amount_claimed_orgs = json_decode($eclaim["expenses_claimed_amount_claimed_org"], TRUE);
									if ($expenses_claimed_service_descriptions && is_array($expenses_claimed_service_descriptions)) {
									?>
									<?php foreach ( $expenses_claimed_service_descriptions as $key => $value ) : ?>
									<div class="row" style="border: 1px solid rgb(204, 204, 204); padding: 10px;">
										<div class="col-sm-3">
											<?php echo form_label('Name of Provider:', 'provider_name', array("class" => 'col-sm-12')); ?>
											<?php echo form_input("expenses_claimed_provider_name[]", $expenses_claimed_provider_names[$key]); ?>
										</div>
										<div class="col-sm-3">
											<?php echo form_label('Name of Referring Physician:', 'referencing_physician', array("class" => 'col-sm-12')); ?>
											<?php echo form_input("expenses_claimed_referencing_physician[]", $expenses_claimed_referencing_physicians[$key]); ?>
										</div>
										<div class="col-sm-3">
											<?php echo form_label('Description of Services:', 'service_description', array("class" => 'col-sm-12')); ?>
											<?php echo form_input("expenses_claimed_service_description[]", $expenses_claimed_service_descriptions[$key]); ?>
										</div>
										<div class="col-sm-3">
											<?php echo form_label('Date of Service:', 'date_of_service', array("class" => 'col-sm-12')); ?>
											<?php echo form_input("expenses_claimed_date_of_service[]", $expenses_claimed_date_of_services[$key]); ?>
										</div>
										<div class="clearfix"></div>

										<div class="col-sm-3">
											<?php echo form_label('Amount Client Paid:', 'amount_client_paid', array("class" => 'col-sm-12')); ?>
											<?php echo form_input("expenses_claimed_amount_client_paid_org[]", $expenses_claimed_amount_client_paid_orgs[$key]); ?>
										</div>
										<div class="col-sm-3">
											<?php echo form_label('Amount Claimed:', 'amount_claimed', array("class" => 'col-sm-12')); ?>
											<?php echo form_input("expenses_claimed_amount_claimed_org[]", $expenses_claimed_amount_client_paid_orgs[$key]); ?>
										</div>
										<div class="clearfix"></div>
									</div>
									<?php endforeach; ?>
									<?php } ?>
								</div>
							</div>
						</div>
						<br />
						<h2 class="modal-title intake-heading move_down">Sign: <i class="fa fa-angle-down pull-right"></i></h2>
						<div class="row intake-forms-list col-sm-12" style="display: none">
							<div class="col-sm-12 intake-forms">
								<div class="col-sm-12">
									<?php echo $eclaim['sign_name']; ?>
								</div>
								<div class="col-sm-12">
								<?php if (isset($eclaim_files[$eclaim['sign_image']])) { ?>
									<img class="img-responsive" src="<?php echo base_url('assets/uploads/') . $eclaim_files[$eclaim['sign_image']]['path'] . "/" . $eclaim_files[$eclaim['sign_image']]['name']; ?>">
									<?php echo form_hidden("sign_image", $eclaim['sign_image']); ?>
									<?php echo form_hidden("sign_image2", $eclaim['sign_image2']); ?>
								<?php } ?>
								</div>
								<?php if (!empty($eclaim['sign_image2'])) { ?>
								<div class="col-sm-12">
								<?php if (isset($eclaim_files[$eclaim['sign_image2']])) { ?>
									<img class="img-responsive" src="<?php echo base_url('assets/uploads/') . $eclaim_files[$eclaim['sign_image2']]['path'] . "/" . $eclaim_files[$eclaim['sign_image2']]['name']; ?>">
								<?php } ?>
								</div>
								<?php } ?>
							</div>
						</div>
						<br />
						<h2 class="modal-title intake-heading move_down">Images: <i class="fa fa-angle-down pull-right"></i></h2>
						<div class="row intake-forms-list col-sm-12" style="display: none">
							<?php echo form_hidden("images", $eclaim['images']); ?>
							<?php $images = json_decode($eclaim['imgfile'], TRUE); ?>
							<?php if (!empty($images)) { ?>
							<?php foreach ( $images as $key => $value ) : ?>
							<div class="col-sm-12 intake-forms">
								<div class="col-sm-12">
								<?php if (isset($eclaim_files[$value])) { ?>
									<img class="img-responsive" src="<?php echo base_url('assets/uploads/') . $eclaim_files[$value]['path'] . "/" . $eclaim_files[$value]['name']; ?>">
								<?php } ?>
								</div>
							</div>
							<?php endforeach; ?>
							<?php } ?>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-sm-12">
							<?php echo form_label('Note:', 'notes', array("class" => 'col-sm-12')); ?>
							<?php echo form_textarea("notes", $eclaim["notes"], array("class" => "form-control", 'placeholder' => 'Note', 'style' => "height:100px")); ?>
							<?php echo form_error("notes"); ?>
						</div>
						<div class="form-group col-sm-12 files"></div>
					</div>
					<div class="row" style="margin-top: 20px">
						<div class="row">
							<?php if ($this->ion_auth->in_group(array(Users_model::GROUP_ADMIN, Users_model::GROUP_CLAIMER)) && ($eclaim['status'] == 1)) { ?>
							<div class="col-sm-2">
								<input class="btn btn-primary" name="Save" value="Transfer to Claim" type="submit">
							</div>
							<div class="col-sm-2">
								<input class="btn btn-primary" name="Refuse" value="Refuse Claim" type="button">
							</div>
							<?php } ?>
							<div class="col-sm-2">
								<?php echo anchor("eclaim/export/".$eclaim['id'], "Print", "target='_blank' class='btn btn-primary'"); ?>
							</div>
						</div>
					</div>
					<?php echo form_close(); ?>
					<?php echo form_open("eclaim/setcaseno", array('class'=>'form-horizontal', 'method'=>'post')); ?>
					<div class="row" style="margin-top: 20px">
						<div class="row">
							<div class="col-sm-2">
								<?php echo form_input("case_no", $eclaim['case_no']); ?>
								<?php echo form_hidden("id", $eclaim['id']); ?>
							</div>
							<div class="col-sm-2">
								<button class="btn btn-primary" name="csubmit" value="eclaim">Save Case Noearch</button>
							</div>
						</div>
					</div>
					<?php echo form_close(); ?>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
$(document).ready(function() {
	// show area once any error occured
	$(".alert-error").map(function() {
		if($(this).text()){
			$(this).closest('.row').show();
			$(this).closest('.row').prev('.move_down').children('i').removeClass('fa-angle-down').addClass('fa-angle-up');
		}
	})
})
// to load, show/hide contents
.on("click", ".move_down", function() {
	$(this).next("div.row").slideToggle();
	$(this).children("i").toggleClass("fa-angle-up").toggleClass("fa-angle-down");
})
// once user clicked on accept button
.on("click", "input[name=Save]", function(e) {
	if (confirm('Are you sure you want to accept Eclaim?')) {
		e.preventDefault();
		$('#main_form').submit();
	} else {
		return false;
	}
})
// when clicked over deny button
.on("click", "input[name=Refuse]", function(e) {
	if (confirm('Are you sure you want to refuse this Eclaim?')) {
		e.preventDefault();
		$.ajax({
				url: "<?php echo base_url("eclaim/disapprove/".$eclaim['id']); ?>",
				method:"post",
				data:$('#main_form').serialize(),
				dataType: "json",
				success: function(data) {
					if (data.status == 2) {
						window.location = "<?php echo base_url("eclaim"); ?>";
					}
				}
			})
	} else {
		return false;
	}
})
</script>
