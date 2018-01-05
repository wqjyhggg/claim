<div>
	<div class="page-title">
		<div class="title_left">
			<h3>Medical Claim</h3>
		</div>
	</div>
	<div class="clearfix"></div>
	<!-- Policy search and List Section -->
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_content">
					<?php echo form_open_multipart("", array('class'=>'form-horizontal', 'method'=>'post', 'onsubmit'=>'return validate_form()', 'id'=>'main_form')); ?>
					<h4 class="move_down">SECTION A: CLAIMANT <i class="fa fa-angle-down pull-right"></i></h4>
					<div class="row" style="margin-bottom: 15px; display: none">
						<div class="form-group col-sm-3">
							<?php echo form_label('Insured First Name:', 'insured_first_name', array("class" => 'col-sm-12')); ?>
							<?php echo form_input("insured_first_name", $this->input->post("insured_first_name"), array("class" => "form-control required", 'placeholder' => 'Insured First Name')); ?>
							<?php echo form_error("insured_first_name"); ?>
						</div>
						<div class="col-sm-3">
							<?php echo form_label('Insured Last Name:', 'insured_last_name', array("class" => 'col-sm-12')); ?>
							<?php echo form_input("insured_last_name", $this->input->post("insured_last_name"), array("class" => "form-control", 'placeholder' => 'Insured Last Name' )); ?>
							<?php echo form_error("insured_last_name"); ?>
						</div>
						<div class="col-sm-3">
							<div class="col-sm-4">
								<?php echo form_label('&nbsp;', 'gender', array("class" => 'col-sm-12')); ?>
								<?php echo form_radio("gender", "male", $this->input->post("gender"), array('class' => 'setpremium')); ?> Male
							</div>
							<div class="col-sm-5">
								<?php echo form_label('&nbsp;', 'gender', array("class" => 'col-sm-12')); ?>
								<?php echo form_radio("gender", "female", $this->input->post("gender"), array('class' => 'setpremium'));?> Female
							</div>
						</div>
						<div class="col-sm-3" style='display:none;'>
							<?php echo form_label('ID', 'id', array("class" => 'col-sm-12')); ?>
							<?php echo form_input("personal_id", $this->input->post("personal_id"), array("class" => "form-control", 'placeholder' => 'ID')); ?>
							<?php echo form_error("personal_id"); ?>
						</div>
						<div class="form-group col-sm-3">
							<?php echo form_label('Date of Birth:', 'dob', array("class"=>'col-sm-12')); ?>
							<div class="input-group date">
								<?php echo form_input("dob", $this->input->post("dob"), array("class" => "form-control dob required", 'placeholder' => 'Date of Birth')); ?>
								<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
							</div>
							<?php echo form_error("dob"); ?>
						</div>
						<div class="clearfix"></div>

						<div class="form-group col-sm-3">
							<?php echo form_label('Policy#:', 'policy_no', array("class" => 'col-sm-12')); ?>
							<?php echo form_input("policy_no", ($this->input->post("policy_no") ? $this->input->post("policy_no") : $this->input->get("policy")), array("class" => "form-control required", 'placeholder' => 'Policy#')); ?>
							<?php echo form_error("policy_no"); ?>
							<?php echo form_hidden("policy_info", $this->input->post("policy_info")); ?>
							<input type='hidden' name='product_short' value='<?php echo ($this->input->post("product_short") ? $this->input->post("product_short") : $this->input->get("product_short")); ?>'>
							<input type='hidden' name='agent_id' value='<?php echo ($this->input->post("agent_id") ? $this->input->post("agent_id") : $this->input->get("agent_id")); ?>'>
							<input type='hidden' name='totaldays' value='<?php echo ($this->input->post("totaldays") ? $this->input->post("totaldays") : $this->input->get("totaldays")); ?>'>
						</div>
						<div class="form-group col-sm-3">
							<?php echo form_label('Case #:', 'case_no', array("class" => 'col-sm-12')); ?>
							<?php echo form_input("case_no", ($this->input->post("case_no") ? $this->input->post("case_no") : $this->input->get("case_no")), array("class" => "form-control", 'placeholder' => 'Case #')); ?>
							<?php echo form_error("case_no"); ?>
						</div>
						<div class="form-group col-sm-3" style='display:none;'>
							<?php echo form_label('School Name:', 'school_name', array("class" => 'col-sm-12')); ?>
							<?php echo form_input("school_name", $this->input->post("school_name"), array("class" => "form-control", 'placeholder' => 'School Name')); ?>
							<?php echo form_error("school_name"); ?>
						</div>
						<div class="form-group col-sm-3" style='display:none;'>
							<?php echo form_label('Group ID:', 'group_id', array("class" => 'col-sm-12')); ?>
							<?php echo form_input("group_id", $this->input->post("group_id"), array("class" => "form-control", 'placeholder' => 'Group ID')); ?>
							<?php echo form_error("group_id"); ?>
						</div>
						<div class="clearfix"></div>
						
						<div class="form-group col-sm-3" style='display:none;'>
							<?php echo form_label('Enroll Date:', 'apply_date', array("class"=>'col-sm-12')); ?>
							<div class="input-group date">
								<?php echo form_input("apply_date", $this->input->post("apply_date"), array("class" => "form-control datepicker", 'placeholder' => 'Enroll Date')); ?>
								<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
							</div>
						</div>
						<div class="form-group col-sm-3" style='display:none;'>
							<?php echo form_label('Arrival Date in Canada:', 'arrival_date', array("class"=>'col-sm-12')); ?>
							<div class="input-group date">
								<?php echo form_input("arrival_date", $this->input->post("arrival_date"), array("class" => "form-control datepicker", 'placeholder' => 'Arrival Date in Canada')); ?>
								<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
							</div>
						</div>
						<div class="form-group col-sm-3" style='display:none;'>
							<?php echo form_label('Full Name of Guardian if applicable:', 'guardian_name', array("class" => 'col-sm-12')); ?>
							<?php echo form_input("guardian_name", $this->input->post("guardian_name"), array("class" => "form-control", 'placeholder' => 'Full Name of Guardian if applicable')); ?>
							<?php echo form_error("guardian_name"); ?>
						</div>
						<div class="form-group col-sm-3" style='display:none;'>
							<?php echo form_label('Guardian Phone#:', 'guardian_phone', array("class" => 'col-sm-12')); ?>
							<?php echo form_input("guardian_phone", $this->input->post("guardian_phone"), array("class" => "form-control", 'placeholder' => 'Guardian Phone#')); ?>
							<?php echo form_error("guardian_phone"); ?>
						</div>

						<h4>Address in Canada </h4>
						<div class="col-sm-12">
							<div class="input-group col-sm-3" style="margin-bottom: 10px">
								<?php echo form_checkbox("same_policy", "Y", $this->input->post("same_policy"), array('class' => 'setpremium', 'style' => 'margin-left:10px')); ?>  Same with policy
							</div>
						</div>
						<div class="form-group col-sm-3">
							<?php echo form_label('Street Address:', 'street_address', array("class" => 'col-sm-12')); ?>
							<?php echo form_input("street_address", $this->input->post("street_address"), array("class" => "form-control", 'placeholder' => 'Street Address')); ?>
						</div>
						<div class="form-group col-sm-3">
							<?php echo form_label('City/Town:', 'city', array("class" => 'col-sm-12')); ?>
							<?php echo form_input("city", $this->input->post("city"), array("class" => "form-control", 'placeholder' => 'City/Town')); ?>
							<?php echo form_error("city"); ?>
						</div>
						<div class="form-group col-sm-3">
							<?php echo form_label('Province:', 'province', array("class" => 'col-sm-12')); ?>
							<?php echo form_input("province", $this->input->post("province"), array("class" => "form-control", 'placeholder' => 'Province')); ?>
							<?php echo form_error("province"); ?>
						</div>
						<div class="form-group col-sm-3">
							<?php echo form_label('PostCode:', 'post_code', array("class" => 'col-sm-12')); ?>
							<?php echo form_input("post_code", $this->input->post("post_code"), array("class" => "form-control", 'placeholder' => 'PostCode')); ?>
						</div>
						<div class="form-group col-sm-3">
							<?php echo form_label('Telephone:', 'telephone', array("class" => 'col-sm-12')); ?>
							<?php echo form_input("telephone", $this->input->post("telephone"), array("class" => "form-control", 'placeholder' => 'Telephone')); ?>
							<?php echo form_error("telephone"); ?>
						</div>
						<div class="form-group col-sm-3">
							<?php echo form_label('Email:', 'email', array("class" => 'col-sm-12')); ?>
							<?php echo form_input("email", $this->input->post("email"), array("class" => "form-control", 'placeholder' => 'Email')); ?>
							<?php echo form_error("email"); ?>
						</div>
						<div class="form-group col-sm-3">
							<?php echo form_label('Date of Departure:', 'exinfo_depature_date', array("class"=>'col-sm-12')); ?>
							<div class="input-group date">
								<?php echo form_input("exinfo[depature_date]", isset($exinfo["depature_date"]) ? $exinfo["depature_date"] : '', array("class" => "form-control datepicker", 'placeholder' => 'Date of Depature')); ?>
								<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
							</div>
						</div>
						<div class="form-group col-sm-3">
							<?php echo form_label('Date of Return to home province:', 'exinfo_return_date', array("class"=>'col-sm-12')); ?>
							<div class="input-group date">
								<?php echo form_input("exinfo[return_date]", isset($exinfo["return_date"]) ? $exinfo["return_date"] : '', array("class" => "form-control datepicker", 'placeholder' => 'Date of Return to home province')); ?>
								<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
							</div>
						</div>
						<div class="form-group col-sm-3">
							<?php echo form_label('Destination:', 'exinfo_destination', array("class" => 'col-sm-12')); ?>
							<?php echo form_input("exinfo[destination]", isset($exinfo["destination"]) ? $exinfo["destination"] : '', array("class" => "form-control", 'placeholder' => 'Destination')); ?>
						</div>
						
						<div class="form-group col-sm-3" style='display:none;'>
							<?php echo form_label('Date of Arrival in Canada:', 'arrival_date_canada', array("class"=>'col-sm-12')); ?>
							<div class="input-group date">
								<?php echo form_input("arrival_date_canada", $this->input->post("arrival_date_canada"), array("class" => "form-control datepicker", 'placeholder' => 'Date of Arrival in Canada')); ?>
								<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
							</div>
						</div>
						<div class="form-group col-sm-3" style='display:none;'>
							<?php echo form_label('Cellular:', 'cellular', array("class" => 'col-sm-12')); ?>
							<?php echo form_input("cellular", $this->input->post("cellular"), array("class" => "form-control", 'placeholder' => 'Cellular')); ?>
						</div>
					</div>
					
					<h4 class="move_down">Contact Information <i class="fa fa-angle-down pull-right"></i></h4>
					<div class="row" style="display: none">
						<div class="form-group col-sm-3">
							<?php echo form_label('First Name:', 'contact_first_name', array("class" => 'col-sm-12')); ?>
							<?php echo form_input("contact_first_name", $this->input->post("contact_first_name"), array("class" => "form-control", 'placeholder' => 'First Name')); ?>
							<?php echo form_error("contact_first_name"); ?>
						</div>
						<div class="form-group col-sm-3">
							<?php echo form_label('Last Name:', 'contact_last_name', array("class" => 'col-sm-12')); ?>
							<?php echo form_input("contact_last_name", $this->input->post("contact_last_name"), array("class" => "form-control", 'placeholder' => 'Last Name')); ?>
							<?php echo form_error("contact_last_name"); ?>
						</div>
						<div class="form-group col-sm-3">
							<?php echo form_label('Email:', 'contact_email', array("class" => 'col-sm-12')); ?>
							<?php echo form_input("contact_email", $this->input->post("contact_email"), array("class" => "form-control", 'placeholder' => 'Email')); ?>
							<?php echo form_error("contact_email"); ?>
						</div>
						<div class="form-group col-sm-3">
							<?php echo form_label('Phone:', 'contact_phone', array("class" => 'col-sm-12')); ?>
							<?php echo form_input("contact_phone", $this->input->post("contact_phone"), array("class" => "form-control", 'placeholder' => 'Phone')); ?>
							<?php echo form_error("contact_phone"); ?>
						</div>
					</div>
					<h4 class="move_down">Name and Address of Family Physician in Home Province <i class="fa fa-angle-down pull-right"></i></h4>
					<div class="row" style="display: none">
						<div class="col-sm-12">
							<div class="form-group col-sm-3">
								<?php echo form_label('Name:', 'physician_name', array("class" => 'col-sm-12')); ?>
								<?php echo form_input("physician_name", $this->input->post("physician_name"), array("class" => "form-control", 'placeholder' => 'Name')); ?>
							</div>
							<div class="form-group col-sm-3">
								<?php echo form_label('Clinic Name or Address:', 'clinic_name', array("class" => 'col-sm-12')); ?>
								<?php echo form_input("clinic_name", $this->input->post("clinic_name"), array("class" => "form-control", 'placeholder' => 'Clinic Name or Address')); ?>
							</div>
							<div class="form-group col-sm-3">
								<?php echo form_label('Street Address:', 'physician_street_address', array("class" => 'col-sm-12')); ?>
								<?php echo form_input("physician_street_address", $this->input->post("physician_street_address"), array("class" => "form-control", 'placeholder' => 'Street Address')); ?>
							</div>
							<div class="form-group col-sm-3">
								<?php echo form_label('City/Town:', 'physician_city', array("class" => 'col-sm-12')); ?>
								<?php echo form_input("physician_city", $this->input->post("physician_city"), array("class" => "form-control", 'placeholder' => 'City/Town')); ?>
								<?php  echo form_error("physician_city"); ?>
							</div>
							<div class="form-group col-sm-3">
								<?php echo form_label('Country:', 'country', array("class" => 'col-sm-12')); ?>
								<select name="country" class="form-control">
									<option value=""> -- Select Country -- </option>
									<?php foreach ($country as $key => $val): ?>
									<option value="<?php echo $key; ?>" <?php if ($key == $this->input->post("country")) { echo "selected"; } ?>><?php echo $val; ?></option>
									<?php endforeach; ?>
								</select>
							</div>
							<div class="form-group col-sm-3">
								<?php echo form_label('Postal Code:', 'physician_post_code', array("class" => 'col-sm-12')); ?>
								<?php echo form_input("physician_post_code", $this->input->post("physician_post_code"), array("class" => "form-control", 'placeholder' => 'Postal Code')); ?>
							</div>
							<div class="form-group col-sm-3">
								<?php echo form_label('Telephone:', 'physician_telephone', array("class" => 'col-sm-12')); ?>
								<?php echo form_input("physician_telephone", $this->input->post("physician_telephone"), array("class" => "form-control", 'placeholder' => 'Telephone')); ?>
								<?php echo form_error("physician_telephone"); ?>
							</div>
							<div class="form-group col-sm-3">
								<?php echo form_label('Alt Telephone:', 'physician_alt_telephone', array("class" => 'col-sm-12')); ?>
								<?php echo form_input("physician_alt_telephone", $this->input->post("physician_alt_telephone"), array("class" => "form-control", 'placeholder' => 'Alt Telephone')); ?>
								<?php echo form_error("physician_alt_telephone"); ?>
							</div>
						</div>

						<div class="col-sm-12">
							Do you have other travel medical insurance coverage? <input type="checkbox" name="exinfo[other_medical_insurance]" value="1" <?php if (!empty($exinfo["other_medical_insurance"])) { echo "checked"; } ?>> Yes. If 'yes', please provide the following information:_
						</div>
						<div class="form-group col-sm-3">
							<?php echo form_label('Name of Insurance Company:', 'exinfo_other_insurance_name', array("class" => 'col-sm-12')); ?>
							<?php echo form_input("exinfo[other_insurance_name]", isset($exinfo["other_insurance_name"]) ? $exinfo["other_insurance_name"] : '', array("class" => "form-control", 'placeholder' => 'Name of Insurance Company')); ?>
						</div>
						<div class="form-group col-sm-3">
							<?php echo form_label('Policy #:', 'exinfo_other_insurance_policy', array("class" => 'col-sm-12')); ?>
							<?php echo form_input("exinfo[other_insurance_policy]", isset($exinfo["other_insurance_policy"]) ? $exinfo["other_insurance_policy"] : '', array("class" => "form-control", 'placeholder' => 'Policy #')); ?>
						</div>
						<div class="form-group col-sm-3">
							<?php echo form_label('Member ID:', 'exinfo_other_insurance_number', array("class" => 'col-sm-12')); ?>
							<?php echo form_input("exinfo[other_insurance_number]", isset($exinfo["other_insurance_number"]) ? $exinfo["other_insurance_number"] : '', array("class" => "form-control", 'placeholder' => 'Member ID')); ?>
						</div>
						<div class="form-group col-sm-3">
							<?php echo form_label('Telephone:', 'exinfo_other_insurance_phone', array("class" => 'col-sm-12')); ?>
							<?php echo form_input("exinfo[other_insurance_phone]", isset($exinfo["other_insurance_phone"]) ? $exinfo["other_insurance_phone"] : '', array("class" => "form-control", 'placeholder' => 'Telephone')); ?>
						</div>
						<div class="col-sm-12">
							Do you have insurance coverage through your spouse? <input type="checkbox" name="exinfo[spouse_insurance]" value="1" <?php if (! empty($exinfo["spouse_insurance"])) { echo "checked"; } ?>> Yes. If 'yes', please provide the following information:_
						</div>
						<div class="form-group col-sm-3">
							<?php echo form_label('Name of Insurance Company:', 'exinfo_spouse_insurance_name', array("class" => 'col-sm-12')); ?>
							<?php echo form_input("exinfo[spouse_insurance_name]", isset($exinfo["spouse_insurance_name"]) ? $exinfo["spouse_insurance_name"] : '', array("class" => "form-control", 'placeholder' => 'Name of Insurance Company')); ?>
						</div>
						<div class="form-group col-sm-3">
							<?php echo form_label('Policy #:', 'exinfo_spouse_insurance_policy', array("class" => 'col-sm-12')); ?>
							<?php echo form_input("exinfo[spouse_insurance_policy]", isset($exinfo["spouse_insurance_policy"]) ? $exinfo["spouse_insurance_policy"] : '', array("class" => "form-control", 'placeholder' => 'Policy #')); ?>
						</div>
						<div class="form-group col-sm-3">
							<?php echo form_label('Member ID:', 'exinfo_spouse_insurance_number', array("class" => 'col-sm-12')); ?>
							<?php echo form_input("exinfo[spouse_insurance_number]", isset($exinfo["spouse_insurance_number"]) ? $exinfo["spouse_insurance_number"] : '', array("class" => "form-control", 'placeholder' => 'Member ID')); ?>
						</div>
						<div class="form-group col-sm-3">
							<?php echo form_label('Telephone:', 'exinfo_spouse_insurance_phone', array("class" => 'col-sm-12')); ?>
							<?php echo form_input("exinfo[spouse_insurance_phone]", isset($exinfo["spouse_insurance_phone"]) ? $exinfo["spouse_insurance_phone"] : '', array("class" => "form-control", 'placeholder' => 'Telephone')); ?>
						</div>
						<div class="form-group col-sm-3">
							<?php echo form_label('Spouse\’s Name:', 'exinfo_spouse_name', array("class" => 'col-sm-12')); ?>
							<?php echo form_input("exinfo[spouse_name]", isset($exinfo["spouse_name"]) ? $exinfo["spouse_name"] : '', array("class" => "form-control", 'placeholder' => 'Spouse\’s Name')); ?>
						</div>
						<div class="form-group col-sm-3">
							<?php echo form_label('Spouse\’s Date of Birth:', 'exinfo_spouse_dob', array("class" => 'col-sm-12')); ?>
							<div class="input-group date">
								<?php echo form_input("exinfo[spouse_dob]", isset($exinfo["spouse_dob"]) ? $exinfo["spouse_dob"] : '', array("class" => "form-control datepicker", 'placeholder' => 'Spouse\’s Date of Birth')); ?>
								<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
							</div>
						</div>
						<div class="clearfix"></div>
						<div class="col-sm-12">
							Do you have credit card insurance coverage? <input type="checkbox" name="exinfo[credit_card_insurance]" value="1" <?php if (! empty($exinfo["credit_card_insurance"])) { echo "checked"; } ?>> Yes. If 'yes', please provide the following information:_
						</div>
						<div class="form-group col-sm-3">
							<?php echo form_label('Name of the financial Institution:', 'exinfo_other_insurance_name', array("class" => 'col-sm-12')); ?>
							<?php echo form_input("exinfo[credit_card_insurance_name]", isset($exinfo["credit_card_insurance_name"]) ? $exinfo["credit_card_insurance_name"] : '', array("class" => "form-control", 'placeholder' => 'Name of the financial Institution')); ?>
						</div>
						<div class="form-group col-sm-3">
							<?php echo form_label('First 6 digits of credit card:', 'exinfo_credit_card_number', array("class" => 'col-sm-12')); ?>
							<?php echo form_input("exinfo[credit_card_number]", isset($exinfo["credit_card_number"]) ? $exinfo["credit_card_number"] : '', array("class" => "form-control", 'placeholder' => 'First 6 digits of credit card')); ?>
						</div>
						<div class="form-group col-sm-3">
							<?php echo form_label('Expiry Date(MM/YYYY):', 'exinfo_credit_card_expire', array("class" => 'col-sm-12')); ?>
							<?php echo form_input("exinfo[credit_card_expire]", isset($exinfo["credit_card_expire"]) ? $exinfo["credit_card_expire"] : '', array("class" => "form-control", 'placeholder' => 'Expiry Date(MM/YYYY)')); ?>
						</div>
						<div class="form-group col-sm-3">
							<?php echo form_label('Name of Cardholder:', 'exinfo_credit_card_holder', array("class" => 'col-sm-12')); ?>
							<?php echo form_input("exinfo[credit_card_holder]", isset($exinfo["credit_card_holder"]) ? $exinfo["credit_card_holder"] : '', array("class" => "form-control", 'placeholder' => 'Name of Cardholder')); ?>
						</div>
						<div class="clearfix"></div>
						<div class="col-sm-12">
							Do you have insurance benefits available through group insurance or any other source? <input type="checkbox" name="exinfo[group_insurance]" value="1" <?php if (! empty($exinfo["group_insurance"])) { echo "checked"; } ?>> Yes. If 'yes', please provide details below:_
						</div>
						<div class="col-sm-12">
							Group Insurance
						</div>
						<div class="form-group col-sm-6">
							<?php echo form_label('Name and Address of Insurance Company:', 'exinfo_group_insurance', array("class" => 'col-sm-12')); ?>
							<?php echo form_input("exinfo[group_insurance]", isset($exinfo["group_insurance"]) ? $exinfo["group_insurance"] :'', array("class" => "form-control", 'placeholder' => 'Name and Address of Insurance Company')); ?>
						</div>
						<div class="form-group col-sm-3">
							<?php echo form_label('Policy #:', 'exinfo_group_insurance_policy', array("class" => 'col-sm-12')); ?>
							<?php echo form_input("exinfo[group_insurance_policy]", isset($exinfo["group_insurance_policy"]) ? $exinfo["group_insurance_policy"] : '', array("class" => "form-control", 'placeholder' => 'Policy #')); ?>
						</div>
						<div class="form-group col-sm-3">
							<?php echo form_label('Telephone:', 'exinfo_group_insurance_phone', array("class" => 'col-sm-12')); ?>
							<?php echo form_input("exinfo[group_insurance_phone]", isset($exinfo["group_insurance_phone"]) ? $exinfo["group_insurance_phone"] : '', array("class" => "form-control", 'placeholder' => 'Telephone')); ?>
						</div>
						<div class="col-sm-12">
							Other Travel Insurance
						</div>
						<div class="form-group col-sm-6">
							<?php echo form_label('Name and Address of Insurance Company:', 'exinfo[other_travel_insurance]', array("class" => 'col-sm-12')); ?>
							<?php echo form_input("exinfo[other_travel_insurance]", isset($exinfo["other_travel_insurance"]) ? $exinfo["other_travel_insurance"] : '', array("class" => "form-control", 'placeholder' => 'Name and Address of Insurance Company')); ?>
						</div>
						<div class="form-group col-sm-3">
							<?php echo form_label('Policy #:', 'exinfo_other_travel_insurance_policy', array("class" => 'col-sm-12')); ?>
							<?php echo form_input("exinfo[other_travel_insurance_policy]", isset($exinfo["other_travel_insurance_policy"]) ? $exinfo["other_travel_insurance_policy"] : '', array("class" => "form-control", 'placeholder' => 'Policy #')); ?>
						</div>
						<div class="form-group col-sm-3">
							<?php echo form_label('Telephone:', 'exinfo_other_travel_insurance_phone', array("class" => 'col-sm-12')); ?>
							<?php echo form_input("exinfo[other_travel_insurance_phone]", isset($exinfo["other_travel_insurance_phone"]) ? $exinfo["other_travel_insurance_phone"] : '', array("class" => "form-control", 'placeholder' => 'Telephone')); ?>
						</div>
						<div class="clearfix"></div>
					</div>

					<h4 class="move_down" style='display:none'>Name and Address of Family Physician in Canada <i class="fa fa-angle-down pull-right"></i></h4>
					<div class="row" style="display: none">
						<div class="col-sm-12">
							<div class="form-group col-sm-3">
								<?php echo form_label('Name:', 'physician_name_canada', array("class" => 'col-sm-12')); ?>
								<?php echo form_input("physician_name_canada", $this->input->post("physician_name_canada"), array("class" => "form-control", 'placeholder' => 'Name')); ?>
								<?php echo form_error("physician_name_canada"); ?>
							</div>
							<div class="form-group col-sm-3">
								<?php echo form_label('Clinic Name or Address:', 'clinic_name_canada', array("class" => 'col-sm-12')); ?>
								<?php echo form_input("clinic_name_canada", $this->input->post("clinic_name_canada"), array("class" => "form-control", 'placeholder' => 'Clinic Name or Address')); ?>
							</div>
							<div class="form-group col-sm-3">
								<?php echo form_label('Street Address:', 'physician_street_address_canada', array("class" => 'col-sm-12')); ?>
								<?php echo form_input("physician_street_address_canada", $this->input->post("physician_street_address_canada"), array("class" => "form-control", 'placeholder' => 'Street Address')); ?>
							</div>
							<div class="form-group col-sm-3">
								<?php echo form_label('City/Town:', 'physician_city_canada', array("class" => 'col-sm-12')); ?>
								<?php echo form_input("physician_city_canada", $this->input->post("physician_city_canada"), array("class" => "form-control", 'placeholder' => 'City/Town')); ?>
								<?php echo form_error("physician_city_canada"); ?>
							</div>
							<div class="form-group col-sm-3">
								<?php echo form_label('Postal Code:', 'physician_post_code_canada', array("class" => 'col-sm-12')); ?>
								<?php echo form_input("physician_post_code_canada", $this->input->post("physician_post_code_canada"), array("class" => "form-control", 'placeholder' => 'Postal Code')); ?>
							</div>
							<div class="form-group col-sm-3">
								<?php echo form_label('Telephone:', 'physician_telephone_canada', array("class" => 'col-sm-12')); ?>
								<?php echo form_input("physician_telephone_canada", $this->input->post("physician_telephone_canada"), array("class" => "form-control", 'placeholder' => 'Telephone')); ?>
								<?php echo form_error("physician_telephone_canada"); ?>
							</div>
							<div class="form-group col-sm-3">
								<?php echo form_label('Alt Telephone:', 'physician_alt_telephone_canada', array("class" => 'col-sm-12')); ?>
								<?php echo form_input("physician_alt_telephone_canada", $this->input->post("physician_alt_telephone_canada"), array("class" => "form-control", 'placeholder' => 'Alt Telephone')); ?>
								<?php echo form_error("physician_alt_telephone_canada"); ?>
							</div>
						</div>
					</div>

					<h2 class="move_down" style='display:none'>Other Insurance Coverage <small></small><i class="fa fa-angle-down pull-right"></i></h2>
					<div class="row" style="display: none">
						<div class="col-sm-12">
							<div class="row">
								<div class="col-sm-12">
									<div class="col-sm-7">Do you have other insurance coverage including Canadian government health insurance?</div>
									<div class="col-sm-1">
										<?php echo form_radio("other_insurance_coverage", "Y", $this->input->post("other_insurance_coverage"), array('class' => 'setpremium'));?> Yes
									</div>
									<div class="col-sm-1">
										<?php echo form_radio("other_insurance_coverage", "N", $this->input->post("other_insurance_coverage"), array('class' => 'setpremium'));?> No
									</div>
									<div class="clearfix"></div>

									<div class="col-sm-7">Do you, your spouse or your parents/guardians have any other medical or travel insurance coverage?</div>
									<div class="col-sm-1">
										<?php echo form_radio("travel_insurance_coverage_guardians", "Y", $this->input->post("travel_insurance_coverage_guardians"), array('class' => 'setpremium')); ?>  Yes
									</div>
									<div class="col-sm-1">
										<?php echo form_radio("travel_insurance_coverage_guardians", "N", $this->input->post("travel_insurance_coverage_guardians"), array('class' => 'setpremium')); ?>  No
									</div>

									<div class="col-sm-12">If yes, provide details of other insurance company coverage below. If no, confirm by checking the box below.</div>
								</div>
								<div class="col-sm-3">
									<?php echo form_label('Full Name:', 'full_name', array("class" => 'col-sm-12')); ?>
									<?php echo form_input("full_name", $this->input->post("full_name"), array("class" => "form-control", 'placeholder' => 'Full Name')); ?>
									<?php echo form_error("full_name"); ?>
								</div>
								<div class="col-sm-3">
									<?php echo form_label('Employee Name:', 'employee_name', array("class" => 'col-sm-12')); ?>
									<?php echo form_input("employee_name", $this->input->post("employee_name"), array("class" => "form-control", 'placeholder' => 'Employee Name')); ?>
									<?php echo form_error("employee_name"); ?>
								</div>
								<div class="col-sm-3">
									<?php echo form_label('Street Address:', 'employee_street_address', array("class" => 'col-sm-12')); ?>
									<?php echo form_input("employee_street_address", $this->input->post("employee_street_address"), array("class" => "form-control", 'placeholder' => 'Street Address')); ?>
								</div>
								<div class="col-sm-3">
									<?php echo form_label('City/Town:', 'city_town', array("class" => 'col-sm-12')); ?>
									<?php echo form_input("city_town", $this->input->post("city_town"), array("class" => "form-control", 'placeholder' => 'City/Town')); ?>
									<?php echo form_error("city_town"); ?>
								</div>
								<div class="clearfix"></div>
								
								<div class="form-group col-sm-3">
									<?php echo form_label('Country:', 'country2', array("class" => 'col-sm-12')); ?>
									<select name="country2" class="form-control">
										<option value=""> -- Select Country -- </option>
										<?php foreach ($country2 as $key => $val):?>
										<option value="<?php echo $key; ?>" <?php if ($key == $this->input->post('country2')) { echo "selected"; } ?>><?php echo $val; ?></option>
										<?php endforeach; ?>
									</select>
								</div>
								<div class="col-sm-3">
									<?php echo form_label('Telephone:', 'employee_telephone', array("class" => 'col-sm-12')); ?>
									<?php echo form_input("employee_telephone", $this->input->post("employee_telephone"), array("class" => "form-control", 'placeholder' => 'Telephone')); ?>
									<?php echo form_error("employee_telephone"); ?>
								</div>
							</div>
						</div>
					</div>

					<h2 class="move_down">Medical Information<small></small> <i class="fa fa-angle-down pull-right"></i></h2>
					<div class="row" style="display: none">
						<div class="col-sm-12">
							<div class="row">
								<div class="form-group col-sm-12">
									<?php echo form_label('Brief description of your sickness or injury:', 'medical_description', array("class" => 'col-sm-12')); ?>
									<?php echo form_textarea("medical_description", $this->input->post("medical_description"), array("class" => "form-control", 'placeholder' => 'Brief description of your sickness or injury')); ?>
								</div>
								<div class="col-sm-6">
									<?php echo form_label('Date symptoms or injury first appeared:', 'date_symptoms', array("class" => 'col-sm-12')); ?>
									<?php echo form_input("date_symptoms", $this->input->post("date_symptoms"), array("class" => "form-control dob", 'placeholder' => 'Date symptoms or injury first appeared')); ?>
								</div>
								<div class="col-sm-6">
									<?php echo form_label('Date you first saw physician for this condition:', 'date_first_physician', array("class" => 'col-sm-12')); ?>
									<?php echo form_input("date_first_physician", $this->input->post("date_first_physician"), array("class" => "form-control dob", 'placeholder' => 'Date you first saw physician for this condition')); ?>
								</div>
								<div class="col-sm-12" style="margin-top: 20px">
									<div class="col-sm-7">Do you, your spouse or your parents/guardians have any other medical or travel insurance coverage?</div>
									<div class="col-sm-1">
										<?php echo form_radio("travel_insurance_coverage", "Y", $this->input->post("travel_insurance_coverage"), array('class' => 'setpremium')); ?>  Yes
									</div>
									<div class="col-sm-1">
										<?php echo form_radio("travel_insurance_coverage", "N", $this->input->post("travel_insurance_coverage"), array('class' => 'setpremium')); ?>  No
									</div>

									<div class="col-sm-12" style="margin-bottom: 10px">If yes, provide details of other insurance company coverage below. If no, confirm by checking the box below.</div>
									<div class="form-group col-sm-12">
										<div class="col-sm-3">
											<?php echo form_label('Date (MM/DD/YYYY):', 'medication_date_1', array("class"=>'col-sm-12'));   ?>
											<div class="input-group date">
												<?php echo form_input("medication_date_1", $this->input->post("medication_date_1"), array("class" => "form-control datepicker travel_insurance_coverage", 'placeholder' => 'Date (MM/DD/YYYY)')); ?>
												<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
											</div>
										</div>
										<div class="col-sm-3">
											<?php echo form_label('Medication:', 'medication_1', array("class" => 'col-sm-12')); ?>
											<?php echo form_input("medication_1", $this->input->post("medication_1"), array("class" => "form-control travel_insurance_coverage", 'placeholder' => 'Medication')); ?>
										</div>
									</div>
									<div class="form-group col-sm-12">
										<div class="col-sm-3">
											<?php echo form_label('Date (MM/DD/YYYY):', 'medication_date_2', array("class"=>'col-sm-12 travel_insurance_coverage'));   ?>
											<div class="input-group date">
												<?php echo form_input("medication_date_2", $this->input->post("medication_date_2"), array("class" => "form-control datepicker travel_insurance_coverage", 'placeholder' => 'Date (MM/DD/YYYY)')); ?>
												<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
											</div>
										</div>
										<div class="col-sm-3">
											<?php echo form_label('Medication:', 'medication_2', array("class" => 'col-sm-12')); ?>
											<?php echo form_input("medication_2", $this->input->post("medication_2"), array("class" => "form-control travel_insurance_coverage", 'placeholder' => 'Medication')); ?>
										</div>
									</div>
									<div class="form-group col-sm-12">
										<div class="col-sm-3">
											<?php echo form_label('Date (MM/DD/YYYY):', 'medication_date_3', array("class"=>'col-sm-12'));   ?>
											<div class="input-group date">
												<?php echo form_input("medication_date_3", $this->input->post("medication_date_3"), array("class" => "form-control datepicker travel_insurance_coverage", 'placeholder' => 'Date (MM/DD/YYYY)')); ?>
												<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
											</div>
										</div>
										<div class="col-sm-3">
											<?php echo form_label('Medication:', 'medication_3', array("class" => 'col-sm-12')); ?>
											<?php echo form_input("medication_3", $this->input->post("medication_3"), array("class" => "form-control travel_insurance_coverage", 'placeholder' => 'Medication')); ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>


					<h2 class="move_down">Payee Information <button class="btn btn-primary add_payee" name="filter" type="button" value="claim">Add a Payees</button></h2>
					<div class="row">
						<div class="col-sm-12">
							<div class="payee-data">
								<?php $payees = array(); ?>
								<?php if ($this->input->post('payees')) : ?>
								<?php     $arr = $this->input->post('payees'); ?>
								<?php     $i = 0; ?>
								<?php     foreach ($arr['bank'] as $key => $value ) : ?>
								<?php         $i++; ?>
								<?php         if ($this->input->post('payment_type_' . $i) == 'cheque') { ?>
								<?php             $payees["cheque : " . $arr["payee_name"][$key] . " : " . $arr["address"][$key]] = $arr["payee_name"][$key]; ?>
								<?php         } else { ?>
								<?php             $payees["direct deposit : " . $arr["payee_name"][$key] . " : " . $arr["bank"][$key] . " : " . $arr["account_cheque"][$key]] = $arr["payee_name"][$key]; ?>
								<?php         } ?>
								<div class="row" style="border: 1px solid rgb(204, 204, 204); padding: 10px; margin-bottom: 9px">
									<div class="col-sm-12">
										<div class="col-sm-2">
											<?php echo form_radio("payment_type_" . $i, "cheque", ($this->input->post('payment_type_' . $i) == 'cheque' ? TRUE : FALSE), array('class' => 'setpremium')); ?>
											<?php echo form_label('Cheque:', 'Cheque'); ?>
										</div>
										<div class="col-sm-2">
											<?php echo form_radio("payment_type_" . $i, "direct deposit", ($this->input->post('payment_type_' . $i) == 'direct deposit' ? TRUE : FALSE), array('class' => 'setpremium')); ?>
											<?php echo form_label('Direct Deposit', 'Direct Deposit'); ?>
											<?php echo form_hidden('payees[id][]', 0); ?>
										</div>
									</div>
									<br />
									<div class="col-sm-3 wire_transfer_section" <?php echo ($this->input->post('payment_type_' . $i) <> 'direct deposit'?'style="display:none"':''); ?>>
										<?php echo form_label('Bank Name:', 'Bank Name', array("class" => 'col-sm-12')); ?>
										<?php echo form_input("payees[bank][]", $arr["bank"][$key], array("class" => "form-control", 'placeholder' => 'Bank Name')); ?>
									</div>
									<div class="col-sm-3 cheque_section wire_transfer_section">
										<?php echo form_label('Payee Name:', 'Payee Name', array("class" => 'col-sm-12')); ?>
										<?php echo form_input("payees[payee_name][]", $arr["payee_name"][$key], array("class" => "form-control required", 'placeholder' => 'Payee Name')); ?>
									</div>
									<div class="col-sm-3 wire_transfer_section" <?php echo ($this->input->post('payment_type_' . $i) <> 'direct deposit'?'style="display:none"':''); ?>>
										<?php echo form_label('Account#:', 'Account', array("class" => 'col-sm-12')); ?>
										<?php echo form_input("payees[account_cheque][]", $arr["account_cheque"][$key], array("class" => "form-control", 'placeholder' => 'Account#')); ?>
									</div>
									<div class="col-sm-3 cheque_section" <?php echo ($this->input->post('payment_type_' . $i) == 'direct deposit'?'style="display:none"':''); ?>>
										<?php echo form_label('Address:', 'Address', array("class" => 'col-sm-12')); ?>
										<?php echo form_input("payees[address][]", $arr["address"][$key], array("class" => "form-control " . ($this->input->post('payment_type_' . $i) == 'direct deposit' ? '' : 'required'), 'placeholder' => 'Address')); ?>
									</div>
									<div class="col-sm-3"><label class='col-sm-12'>&nbsp;</label> <i class="col-sm-3 fa fa-trash row-link remove-payee"></i></div>
								</div>
								<?php     endforeach; ?>
								<?php endif; ?>
							</div>
						</div>
					</div>

					<h2 class="move_down">Expenses Claimed<i class="fa fa-angle-up pull-right"></i></h2>
					<div class="row">
						<div class="col-sm-12">
							<div class="expenses-list">
								<?php if ($this->input->post('expenses_claimed')) : ?>
								<?php $arr = $this->input->post('expenses_claimed'); ?>
								<?php foreach($arr['provider_name'] as $key => $value ) : ?>
								<div class="row" style="border: 1px solid rgb(204, 204, 204); padding: 10px;">
									<div class="col-sm-3">
										<?php echo form_label('Invoice#:', 'invoice', array("class" => 'col-sm-12')); ?>
										<?php echo form_input("expenses_claimed[invoice][]", $arr['invoice'][$key], array("class" => "form-control")); ?>
										<?php echo form_hidden('expenses_claimed[id][]', $arr['id'][$key]); ?>
									</div>
									<div class="col-sm-3">
										<?php echo form_label('Name of Provider:', 'provider_name', array("class" => 'col-sm-12')); ?>
										<?php echo form_input("expenses_claimed[provider_name][]", $arr['provider_name'][$key], array("class" => "form-control required")); ?>
									</div>
									<div class="col-sm-3">
										<?php echo form_label('Name of Referring Physician:', 'referencing_physician', array("class" => 'col-sm-12')); ?>
										<?php echo form_input("expenses_claimed[referencing_physician][]", $arr['referencing_physician'][$key], array("class" => "form-control")); ?>
									</div>
									<div class="col-sm-3">
										<?php echo form_label('Coverage Code:', 'coverage_code', array("class" => 'col-sm-12')); ?>
										<select name="expenses_claimed[coverage_code][]" class="form-control required">
											<option value="0">-- Select Coverage Code --</option>
											<?php foreach ($expenses_list as $key1 => $val): ?>
											<option value="<?php echo $key1; ?>" <?php if ($key1 == $arr["coverage_code"][$key]) { echo "selected"; } ?>><?php echo $val; ?></option>
											<?php endforeach; ?>
										</select>
									</div>
									<div class="clearfix"></div>

									<div class="col-sm-3">
										<?php echo form_label('Diagnosis:', 'diagnosis', array("class" => 'col-sm-12')); ?>
										<?php echo form_input("expenses_claimed[diagnosis][]", $arr['diagnosis'][$key], array("class" => "form-control autocomplete_field required")); ?>
									</div>
									<div class="col-sm-3">
										<?php echo form_label('Description of Services:', 'service_description', array("class" => 'col-sm-12')); ?>
										<?php echo form_input("expenses_claimed[service_description][]", $arr['service_description'][$key], array("class" => "form-control required")); ?>
									</div>
									<div class="col-sm-3">
										<?php echo form_label('Date of Service:', 'date_of_service', array("class" => 'col-sm-12')); ?>
										<?php echo form_input("expenses_claimed[date_of_service][]", $arr['date_of_service'][$key], array("class" => "form-control  datepicker required")); ?>
									</div>
									<div class="col-sm-3">
										<?php echo form_label('Amount Billed:', 'amount_billed_org', array("class" => 'col-sm-12')); ?>
										<?php echo form_input("expenses_claimed[amount_billed_org][]", $arr['amount_billed_org'][$key], array("class" => "form-control required")); ?>
										<?php echo form_hidden("expenses_claimed[amount_billed][]", $arr['amount_billed'][$key]); ?>
										<?php echo form_error("amount_billed_org"); ?>
									</div>
									<div class="clearfix"></div>

									<div class="col-sm-3">
										<?php echo form_label('Amount Client Paid:', 'amount_client_paid_org', array("class" => 'col-sm-12')); ?>
										<?php echo form_input("expenses_claimed[amount_client_paid_org][]", $arr['amount_client_paid_org'][$key], array("class" => "form-control required")); ?>
										<?php echo form_hidden("expenses_claimed[amount_client_paid][]", $arr['amount_client_paid'][$key]); ?>
										<?php echo form_error("amount_client_paid_org"); ?>
									</div>
									<div class="col-sm-3">
										<?php echo form_label('Amount Claimed:', 'amount_claimed', array("class" => 'col-sm-12')); ?>
										<?php echo form_input("expenses_claimed[amount_claimed_org][]", $arr["amount_claimed_org"][$key], array("class" => "form-control required")); ?>
										<?php echo form_hidden("expenses_claimed[amount_claimed][]", $arr["amount_claimed"][$key]); ?>
										<?php echo form_error("amount_claimed_org"); ?>
									</div>
									<div class="col-sm-3">
										<?php echo form_label('Payee:', 'payee', array("class" => 'col-sm-12')); ?>
										<select name="expenses_claimed[payee][]" class="form-control required">
											<?php if ($payees) { ?> 
											<?php foreach ( $payees as $pkey => $payee ) { ?> 
											<option value="<?php echo $pkey; ?>" <?php echo (($pkey == $arr['payee'][$key]) ? "Selected" : ""); ?>><?php echo $payee; ?></option>
											<?php } ?>
											<?php } ?>
										</select>
										<?php echo form_hidden("expenses_claimed[pay_to][]", $arr["pay_to"][$key]); ?>
									</div>
									<div class="col-sm-3">
										<?php echo form_label('currency:', 'currency', array("class" => 'col-sm-12')); ?>
										<?php if (empty($arr['currency'][$key])) { $arr['currency'][$key] = 'CAD'; } ?>
										<select name="expenses_claimed[currency][]" class="form-control required">
											<?php foreach ($currencies as $currency ) { ?>
											<option value="<?php echo $currency['name']; ?>" <?php echo ($arr['currency'][$key] == $currency['name']) ? 'selected' : ''; ?>><?php echo $currency['name']; ?></option>
											<?php } ?>
										</select>
									</div>
									<div class="clearfix"></div>

									<!-- div class="col-sm-3">
										<?php echo form_label('Comment:', 'comment', array("class" => 'col-sm-12')); ?>
										<?php echo form_input("expenses_claimed[comment][]", $arr['comment'][$key], array("class" => "form-control")); ?>
									</div -->
									
									<div class="col-sm-3 pull-right"><i class="fa fa-trash row-link remove_claim" style="padding-top: 33px;"></i></div>
								</div>
								<?php endforeach; ?>
								<?php endif; ?>
							</div>
							<button class="btn btn-primary add_new_expenses" type="button">Add new expenses item</button><br />
						</div>
					</div>

					<!-- Intake Forms List Section -->
					<br />
					<h2 class="modal-title intake-heading move_down" style="display: none">Notes</h2>
					<div class="row intake-forms-list col-sm-12"></div>
					<input type="hidden" name="no_of_form" value="0" />
					<!-- used to knnow how many forms added in this page -->
					<!-- end intake forms list  -->


					<h2 style="border-bottom: 1px solid #eee; font-size: 14px !important; padding-bottom: 7px;">Attached List (pdf only) <button class="btn btn-primary multiupload_files" type="button">Upload Attached</button></h2>
					<div class="row">
						<div class="col-sm-12">
							<div class="col-sm-3 uploaded_files"></div>
							<div class="col-sm-3"></div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-3">
							<?php echo form_label('Examiner:', 'assign_to', array("class" => 'col-sm-12')); ?>
							<select name="assign_to" class="form-control required">
								<option value="">-- Select Examiner --</option>
								<?php foreach ($examiners as $rc):?>
								<option value="<?php echo $rc['id']; ?>" <?php if ($rc['id'] == $this->input->post('assign_to')) { echo "selected"; } ?>><?php echo $rc['email']; ?></option>
								<?php endforeach; ?>
							</select>
						</div>
						<div class="col-sm-3">
							<?php echo form_label('Status:', 'status', array("class" => 'col-sm-12')); ?>
							<select name="status" class="form-control">
								<?php foreach ($status_list as $key => $val): ?>
								<option value="<?php echo $key; ?>" <?php if ($key == $this->input->post("status")) { echo "selected"; } ?>><?php echo $val; ?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
					<div class="row" style="margin-top: 20px">
						<div class="col-sm-2">
							<input class="btn btn-primary" name="Save" value="Save" type="submit">
						</div>
						<div class="col-sm-2">
							<?php echo anchor("claim", "Cancel", array("class"=>'btn btn-primary')); ?>
						</div>
						<!-- div class="col-sm-2">
							<input class="btn btn-primary" name="Examine" value="Examine" type="submit">
						</div>
						<div class="col-sm-2">
							<input class="btn btn-primary email_print" data-toggle="modal"  name="Email" value="Email/Print" type="button" data-target="#print_template">
						</div -->
					</div>
					<?php echo form_close(); ?>
				</div>
			</div>
		</div>
	</div>
</div>

<div style="display: none">
	<div id="products">
		<select name="product_short" class="form-control">
			<option value="">--Select Product--</option>
			<?php foreach ($products as $key => $val): ?>
			<option value="<?php echo $key; ?>" <?php if ($key == $this->input->post("product_short")) { echo "selected"; } ?>><?php echo $val; ?></option>
			<?php endforeach; ?>
		</select>
	</div>
</div>

<style>
.autocomplete-suggestions {
	width: 603px !important;
}
</style>
<!-- Email print doc content here -->
<div id="print_template" class="modal fade" role="dialog">
	<div class="modal-dialog  modal-lg">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Print/email Template Letter</h4>
			</div>
			<?php echo form_open_multipart("case/send_print_email", array("id" => 'send_print_email')); ?>
			<div class="modal-body">
				<div class="row">
					<div class="col-sm-6">
						<div>
							<label for="mail_label" class="col-sm-2">Mail Address:</label>
							<div class="form-group col-sm-6">
								<input name="same_address" value="1" id="mail_address" class="col-sm-1" type="checkbox">
								<label for="mail_address" class="col-sm-10 pull-right" style="margin-top: 3px;">Use same address with the policy</label>
							</div>
						</div>
						<div>
							<?php echo form_label('To:', 'email', array("class" => 'col-sm-12')); ?>
							<div class="form-group col-sm-12">
								<?php echo form_input("email", "", array("class" => "form-control col-sm-6 form-group email required", 'placeholder' => 'Email Address')); ?>
							</div>
						</div>
					</div>
					<div class="form-group col-sm-12">
						<div class="form-group col-sm-3">
							<?php echo form_label('Street No.:', 'street_no_email', array("class" => 'col-sm-12')); ?>
							<?php echo form_input("street_no_email", "", array("class" => "form-control required", 'placeholder' => 'Street No.')); ?>
							<?php echo form_error("street_no_email"); ?>
						</div>
						<div class="form-group col-sm-3">
							<?php echo form_label('Street Name.:', 'street_name_email', array("class" => 'col-sm-12')); ?>
							<?php echo form_input("street_name_email", "", array("class" => "form-control required", 'placeholder' => 'Street Name.')); ?>
							<?php echo form_error("street_name_email"); ?>
						</div>
						<div class="form-group col-sm-3">
							<?php echo form_label('City:', 'city_email', array("class" => 'col-sm-12')); ?>
							<?php echo form_input("city_email", "", array("class" => "form-control required", 'placeholder' => 'City')); ?>
							<?php echo form_error("city"); ?>
						</div>
						<div class="form-group col-sm-3">
							<?php echo form_label('Province:', 'province_email', array("class" => 'col-sm-12')); ?>
							<select name="province_email" class="form-control">
								<?php foreach ($province as $key => $val): ?>
								<option value="<?php echo $key; ?>" <?php if ($key == $this->input->post("province_email")) { echo "selected"; } ?>><?php echo $val; ?></option>
								<?php endforeach; ?>
							</select>
							<?php echo form_error("province_email"); ?>
						</div>
						<?php echo form_label('Select Template:', 'select_template', array("class" => 'col-sm-12')); ?>
						<div class="form-group col-sm-12">
							<?php foreach($docs as $doc): ?>
							<div class="select-doc col-sm-2" doc="<?php echo $doc['id'] ?>"><i class="fa fa-file-word-o large"></i><?php echo $doc['name']?></div>
							<?php endforeach; ?>
						</div>
					</div>
					<div class="form-group col-sm-12 docfiles">
						<?php foreach($docs as $doc): ?>
						<div class="col-sm-12 doc-description doc-<?php echo $doc['id'] ?>" style="display: none">
							<div class="col-sm-12 doc_title"><?php echo heading($doc['name']); ?></div>
							<div class="col-sm-12 doc-desc">
								<?php $find = array('{otc_logo}', '{otc_logo_big}', '{current_date}'); ?>
								<?php $replace = array(img(array('src' => 'assets/img/otc.jpg', 'width' => '130')), img(array('src' => 'assets/img/otc_big.jpg','width' => '262')), date("F d, Y")); ?>
								<?php echo str_replace($find, $replace, $doc ['description']); ?>
							</div>
						</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<label class="col-sm-12">&nbsp;</label>
				<button type="button" class="btn btn-info preview-template" disabled>Preview</button>
				<button class="btn btn-primary email-intakeform" disabled>Email</button>
				<button type="button" class="btn btn-info print" disabled>Print</button>
				<button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
			</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>
<!-- end here -->

<!-- Create Intake Form Modal -->
<div id="create_intake_form" class="modal fade" role="dialog">
	<div class="modal-dialog  modal-lg">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Create Note</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="form-group col-sm-6">
						<?php echo form_label('Note #:', 'form_id', array("class" => 'col-sm-12')); ?>
						<div class="form-group col-sm-12">####</div>
					</div>
					<div class="form-group col-sm-6">
						<?php echo form_label('Create Date:', 'create_date', array("class" => 'col-sm-12')); ?>
						<div class="form-group col-sm-12"><?php echo date("Y-m-d"); ?></div>
					</div>
					<div class="form-group col-sm-12">
						<?php echo form_label('Notes:', 'intake_notes', array("class" => 'col-sm-12')); ?>
						<?php echo form_textarea("intake_notes", $this->input->post("intake_notes"), array("class" => "form-control", 'placeholder' => 'Notes', 'style' => "height:100px")); ?>
						<?php echo form_error("intake_notes"); ?>
					</div>
					<div class="form-group col-sm-12 files"></div>
				</div>
			</div>
			<div class="modal-footer">
				<label class="col-sm-12">&nbsp;</label>
				<button class="btn btn-primary save-intakeform">Save</button>
				<a href="javascript:void(0)" class="btn btn-primary multiupload">Upload Attached</a>
				<button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<!-- end intake form model here -->

<div style="display: none">
	<div class="base-row">
		<div class="row" style="border: 1px solid rgb(204, 204, 204); padding: 10px;">
			<div class="col-sm-3">
				<?php echo form_label('Invoice#:', 'invoice', array("class" => 'col-sm-12')); ?>
				<?php echo form_input("expenses_claimed[invoice][]", '', array("class" => "form-control")); ?>
				<?php echo form_hidden('expenses_claimed[id][]', ''); ?>
			</div>
			<div class="col-sm-3">
				<?php echo form_label('Name of Provider:', 'provider_name', array("class" => 'col-sm-12')); ?>
				<?php echo form_input("expenses_claimed[provider_name][]", '', array("class" => "form-control required alphanum")); ?>
			</div>
			<div class="col-sm-3">
				<?php echo form_label('Name of Referring Physician:', 'referencing_physician', array("class" => 'col-sm-12')); ?>
				<?php echo form_input("expenses_claimed[referencing_physician][]", '', array("class" => "form-control alphanum")); ?>
			</div>
			<div class="col-sm-3">
				<?php echo form_label('Coverage Code:', 'coverage_code', array("class" => 'col-sm-12')); ?>
				<select name="expenses_claimed[coverage_code][]" class="form-control required">
					<option value="0">-- Select Coverage Code --</option>
					<?php foreach ($expenses_list as $key => $val): ?>
					<option value="<?php echo $key; ?>"><?php echo $val; ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			<div class="col-sm-3">
				<?php echo form_label('Diagnosis:', 'diagnosis', array("class" => 'col-sm-12')); ?>
				<?php echo form_input("expenses_claimed[diagnosis][]", '', array("class" => "form-control autocomplete_field required")); ?>
			</div>
			<div class="col-sm-3">
				<?php echo form_label('Description of Services:', 'service_description', array("class" => 'col-sm-12')); ?>
				<?php echo form_input("expenses_claimed[service_description][]", '', array("class" => "form-control required")); ?>
			</div>
			<div class="col-sm-3">
				<?php echo form_label('Date of Service:', 'date_of_service', array("class" => 'col-sm-12')); ?>
				<?php echo form_input("expenses_claimed[date_of_service][]", '', array("class" => "form-control  datepicker required")); ?>
			</div>
			<div class="col-sm-3">
				<?php echo form_label('Amount Billed:', 'amount_billed_org', array("class" => 'col-sm-12')); ?>
				<?php echo form_input("expenses_claimed[amount_billed_org][]", '', array("class" => "form-control required")); ?>
				<?php echo form_hidden("expenses_claimed[amount_billed][]", ''); ?>
				<?php echo form_error("amount_billed_org"); ?>
			</div>
			<div class="col-sm-3">
				<?php echo form_label('Amount Client Paid:', 'amount_client_paid_org', array("class" => 'col-sm-12')); ?>
				<?php echo form_input("expenses_claimed[amount_client_paid_org][]", '', array("class" => "form-control required")); ?>
				<?php echo form_hidden("expenses_claimed[amount_client_paid][]", ''); ?>
				<?php echo form_error("amount_client_paid_org"); ?>
			</div>
			<div class="col-sm-3">
				<?php echo form_label('Amount Claimed:', 'amount_claimed_org', array("class" => 'col-sm-12')); ?>
				<?php echo form_input("expenses_claimed[amount_claimed_org][]", '', array("class" => "form-control required")); ?>
				<?php echo form_hidden("expenses_claimed[amount_claimed][]", ''); ?>
				<?php echo form_error("amount_claimed_org"); ?>
			</div>
			<div class="col-sm-3">
				<?php echo form_label('Payee:', 'payee', array("class" => 'col-sm-12')); ?>
				<select name="expenses_claimed[payee][]" class="form-control required">
					<option value="">--Select Payee--</option>
					<?php if ($payees) { ?> 
					<?php foreach ( $payees as $pkey => $payee ) { ?> 
					<option value="<?php echo $pkey; ?>" <?php echo (($pkey == $arr['payee'][$key]) ? "Selected" : ""); ?>><?php echo $payee; ?></option>
					<?php } ?>
					<?php } ?>
				</select>
				<?php echo form_hidden("expenses_claimed[pay_to][]", ''); ?>
			</div>
			<div class="col-sm-3">
				<?php echo form_label('currency:', 'currency', array("class" => 'col-sm-12')); ?>
				<select name="expenses_claimed[currency][]" class="form-control required">
					<?php foreach ($currencies as $currency ) { ?>
					<option value="<?php echo $currency['name']; ?>" <?php if ($currency['name'] == 'CAD') { echo "selected"; } ?>><?php echo $currency['name']; ?></option>
					<?php } ?>
				</select>
			</div>
			<div class="clearfix"></div>

			<!-- div class="col-sm-3">
				<?php echo form_label('Comment:', 'comment', array("class" => 'col-sm-12')); ?>
				<?php echo form_input("expenses_claimed[comment][]", '', array("class" => "form-control")); ?>
			</div -->
			<div class="col-sm-3 pull-right">
				<i class="fa fa-trash row-link remove_claim" style="padding-top: 33px;"></i>
			</div>
		</div>
	</div>
</div>

<div style="display: none">
	<div class="payee-buffer">
		<div class="row"
			style="border: 1px solid rgb(204, 204, 204); padding: 10px; margin-bottom: 9px">
			<div class="col-sm-12">
				<div class="col-sm-2">
					<?php echo form_radio("payment_type", "cheque", TRUE, array('class' => 'setpremium')); ?>
					<?php echo form_label('Cheque:', 'Cheque'); ?>
				</div>
				<div class="col-sm-2">
					<?php echo form_radio("payment_type", "direct deposit", FALSE, array('class' => 'setpremium')); ?>
					<?php echo form_label('Direct Deposit', 'Direct Deposit'); ?>
					<?php echo form_hidden("payees[id][]", ''); ?>
				</div>
			</div>
			<br />
			<div class="col-sm-3 wire_transfer_section" style="display: none">
				<?php echo form_label('Bank Name:', 'Bank Name', array("class" => 'col-sm-12')); ?>
				<?php echo form_input("payees[bank][]", $this->input->post("bank"), array("class" => "form-control alphanum", 'placeholder' => 'Bank Name')); ?>
				<?php echo form_error("bank"); ?>
			</div>
			<div class="col-sm-3 cheque_section wire_transfer_section">
				<?php echo form_label('Payee Name:', 'Payee Name', array("class" => 'col-sm-12')); ?>
				<?php echo form_input("payees[payee_name][]", $this->input->post("payee_name"), array("class" => "form-control required alphanum", 'placeholder' => 'Payee Name')); ?>
				<?php echo form_error("payee_name"); ?>
			</div>
			<div class="col-sm-3 wire_transfer_section" style="display: none">
				<?php echo form_label('Account#:', 'Account', array("class" => 'col-sm-12')); ?>
				<?php echo form_input("payees[account_cheque][]", $this->input->post("account_cheque"), array("class" => "form-control", 'placeholder' => 'Account#')); ?>
				<?php echo form_error("account_cheque"); ?>
			</div>
			<div class="col-sm-3 cheque_section">
				<?php echo form_label('Address:', 'Address', array("class" => 'col-sm-12')); ?>
				<?php echo form_input("payees[address][]", $this->input->post("address"), array("class" => "form-control required", 'placeholder' => 'Address')); ?>
			</div>
			<div class="col-sm-3">
				<label class='col-sm-12'>&nbsp;</label> <i class="col-sm-3 fa fa-trash row-link remove-payee"></i>
			</div>
		</div>
	</div>
</div>

<!-- word templates here -->
<div style="display: none" class="word_templates">
	<?php if(!empty($word_templates)): ?>
	<ul>
		<?php foreach($word_templates as $tmp): ?>
		<li style='list-style: outside none none;'><?php echo form_checkbox('word_doc', $tmp['content']).' <b>'.$tmp['title'].'</b>: '.$tmp['content'] ?></li>
		<?php endforeach; ?>
	</ul>
	<?php endif; ?>
</div>

<script src="<?php echo base_url() ?>/assets/js/jQuery.print.js"></script>
<script src="<?php echo base_url() ?>/assets/js/jquery.validate.min.js"></script>
<?php echo link_tag('assets/css/bootstrap-datepicker.css'); ?>
<script src="<?php echo base_url() ?>/assets/js/bootstrap-datetimepicker.js"></script>
<script>
   $(document).ready(function() {
      // enable disable travel_insurance_coverage
      $("input[name=travel_insurance_coverage]").click(function(){
         if($(this).val() == 'Y'){
            $(".travel_insurance_coverage").removeAttr('disabled');
         } else{            
            $(".travel_insurance_coverage").attr('disabled', 'disabled');
         }
      })

      // show area once any error occured
      $(".alert-error").map(function(){
         if($(this).text()){
            $(this).closest('.row').show();
            $(this).closest('.row').prev('.move_down').children('i').removeClass('fa-angle-down').addClass('fa-angle-up');
         }
      })

      // load atleast one claim item form for first use
      var curhtml = $.trim($(".expenses-list").html());
      if (curhtml.length == 0) {
	      var html = $(".base-row").html();
	      $(".expenses-list").append(html);
      }
      $(".autocomplete_field").autocomplete({
        serviceUrl: "<?php echo base_url()."claim/search_diagnosis/description"; ?>" ,
        minLength: 2,
        dataType: "json",
      });
      $(".dob").datepicker({
        startDate: '-105y',
        endDate: '0',
      });


      $(".datepicker").datepicker({
        startDate: '-105y',
        endDate: '+2y',
      });

   })

   .on("click",".more_filters", function(){
      $(".more_items").toggle();
   })

   // fuzzy search
   .on("click", ".autocomplete_field", function() {
      $(".autocomplete_field").autocomplete({
        serviceUrl: "<?php echo base_url()."claim/search_diagnosis/description"; ?>" ,
        minLength: 2,
        dataType: "json",
      });
    })

   .on("click", ".add_new_expenses", function(e){
      var html = $(".base-row").html();
      $(".expenses-list").append(html);
      $(".autocomplete_field").autocomplete({
        serviceUrl: "<?php echo base_url()."claim/search_diagnosis/description"; ?>" ,
        minLength: 2,
        dataType: "json",
      });
      $(".datepicker").datepicker({
           startDate: '-105y',
           endDate: '+2y',
       });


      $(this).parent('.move_down').next('.row').show();

      $(this).next('i').removeClass('fa-angle-down').addClass('fa-angle-up');
      e.stopPropagation()
   })
   .on("click", ".remove_claim", function(){
      $(this).parent("div").parent("div").remove();
   })

   .on("click", ".add_payee", function(e){
      var html = $(".payee-buffer").html();

      var length = $(".payee-data .row").length;

      html = html.replace(/payment_type/g, "payment_type_"+(length+1));

      $(".payee-data").append(html);

      $(this).parent('.move_down').next('.row').show();

      $(this).next('i').removeClass('fa-angle-down').addClass('fa-angle-up');
      e.stopPropagation()
   })

   .on("click", ".remove-payee", function(){
      $(this).parent("div").parent("div").remove();
   })

   // show email/print function
   .on("click", ".select-doc", function(){

      // hide all doc files here
      $(".doc-description").hide();
      $(".select-doc").removeClass("active");

      // get doc if
      var id = $(this).attr("doc");
      $(this).addClass("active");

      // show related doc file
      $(".doc-"+id).show();

      // get selected case details object
      var obj = $(".email_print");

      // get policy info
      var data = $.parseJSON(localStorage.getItem("policy_data"));

      // replace string from casemanager name etc
      var str = $(".doc-"+id+"  .doc-desc").html();
      str = str.replace(/{insured_name}/gi, $("input[name=insured_first_name]").val()+' '+$("input[name=insured_last_name]").val())
      .replace(/{claimant_name}/gi, $("input[name=insured_first_name]").val()+' '+$("input[name=insured_last_name]").val())
      .replace("{insured_address}", $("input[name=street_address]").val()+' '+$("input[name=city]").val()+' '+$("input[name=province]").val())
      .replace("{insured_lastname}", $("input[name=insured_last_name]").val())
      .replace("{policy_no}", $("input[name=policy_no]").val())
      .replace("{case_no}", $("input[name=case_no]").val())
      .replace("{policy_coverage_info}", "{policy_coverage_info}")
      .replace("{casemanager_name}", '<?php echo $this->ion_auth->user()->row()->first_name ?>')
      .replace("{claimexaminer_name}", '')
      .replace("{current_date_+_90}", '<?php echo date('Y-m-d', strtotime(' + 90 days')) ?>')

      .replace("{clinic_name}", $("input[name=clinic_name]").val())
      .replace("{insured_dob}", $("input[name=dob]").val())

      .replace("{policy_holder}", $("input[name=insured_first_name]").val()+' '+$("input[name=insured_last_name]").val())
      .replace("{coverage_period}", data[0].effective_date+" to  "+data[0].expiry_date);

      $(".doc-"+id+" .doc-desc").html(str);

      // reset all edit/preview section
      $(".preview-template").text("Preview").removeClass("active-preview");

      // enable disable buttons
      $(".print").attr("disabled", "disabled");
      $(".preview-template, .email-intakeform").removeAttr("disabled");
   })

   // to load, show/hide contents
   .on("click", ".move_down", function(){
      $(this).next("div.row").slideToggle();
      $(this).children("i").toggleClass("fa-angle-up").toggleClass("fa-angle-down");
   })

   // fill autofill on key type
   .on("keyup", ".company_name input", function(){
      $(".company_name input").val($(this).val());
   })

   // preview template script
   .on("click", ".preview-template", function(){
      // get selected doc
      $(this).toggleClass("active-preview");
      var doc_id = $(".select-doc.active").attr("doc");
      if($(this).hasClass("active-preview"))
      {
         $(this).text("Edit Template");
         var $outer = $(".doc-"+doc_id+" .outer-text input, .doc-"+doc_id+" .outer-text textarea, .doc-"+doc_id+" .select-product select");
         $outer.each(function(){
            var text = $.trim($(this).val());

            $(this).parent("p,span").html(text.replace(/\n/g, "<br>"));
            $(this).remove();
         });

         // show selected word templates
         $(".outer_custom_comment").each(function(){
            var text = [];
            $("input[name=word_doc]:checked").each(function(){
               text.push(" - "+$(this).val());
            })
            var text = text.join("<br>");
            text += "<br>";
            $(this).html(text.replace(/\n/g, "<br>"));
            $(this).children('ul').remove();
         });


         // enable print button
         $(".print").removeAttr("disabled");
      }
      else
      {
         $(this).text("Preview");
         var $outer = $(".outer-text");
         $outer.each(function(){
            var text = $.trim($(this).html()).replace(/<br>/g, "\n");

            $(this).empty();
            if(!$(this).hasClass("area"))
               $(this).append("<input class='outer-text' value='" + text + "'></input>");
            else
               $(this).append("<textarea  style='width:100%' rows='6'>"+ text +"</textarea>");
         });

         // for the products list
         var $outer_select = $(".select-product");
         $outer_select.each(function(){
            var text = $.trim($(this).text());

            $(this).empty();
            $(this).append($("#products").html()).children("select").val(text);
         });

         // create word template selection for deny reason
         var $outer = $(".outer_custom_comment");
         $outer.each(function(){
            var text = $.trim($('.word_templates').html());

            $(this).empty();
            $(this).append(text);
         });


         // disable print button
         $(".print").attr("disabled", "disabled");
      }

   })

   // print button script here
   .on("click", ".print", function(){
      var doc_id = $(".select-doc.active").attr("doc");
      $(".doc-"+doc_id).print({
           globalStyles: false,
           mediaPrint: true,
           iframe: true,
           noPrintSelector: ".avoid-this",
       });
   })

   // send email print to recepient email:-
   .on("submit", "#send_print_email", function(e){
      e.preventDefault();
      var doc_id = $(".select-doc.active").attr("doc");
      if($(this).valid())
      {
         $(".preview-template").trigger('click');
         var template = $(".doc-"+doc_id).children("div.doc-desc").html();
         $.ajax({
            url: "<?php echo base_url("claim/send_print_email") ?>",
            method: "post",
            dataType:"json",
            data:{
               email:$("#send_print_email input[name=email]").val(),
               street_no:$("#send_print_email input[name=street_no_email]").val(),
               street_name:$("#send_print_email input[name=street_name_email]").val(),
               city:$("#send_print_email input[name=city_email]").val(),
               province:$("#send_print_email select[name=province_email]").val(),
               template:template,
               doc: $("#send_print_email .select-doc.active").text()
            },
            beforeSend: function(){
               $(".modal-content").addClass("csspinner load1");
            },
            success: function(data) {
               // create new intake form - - count no of intake forms
               var count = $(".intake-forms").length + 1;

               // place no of form in hidden field
               $("input[name=no_of_form]").val(count);

               // get notes and files
               var notes = data.data_intake;
               var files = '<div class="col-sm-9" style=""><input type="hidden" name="file_pdf_'+count+'" value="'+data.file_name+'" /><span class="file-label">'+data.file_name+'</span> <i class="fa fa-trash row-link" id="'+count+'"></i></div>';

               // generate html data
               var html = '<div class="col-sm-12 intake-forms"><div class="col-sm-2"><div class="col-sm-12">'+count+'. #<?php echo $this->ion_auth->user()->row()->id; ?></div><div class="col-sm-12"><?php echo $this->ion_auth->user()->row()->first_name; ?></div><div class="col-sm-12"><?php echo date("Y-m-d H:i:s"); ?></div></div><div class="col-sm-10"><div class=col-sm-12"><input type="hidden" name="notes_'+count+'" value="'+notes+'" />' + notes + '</div><div id="intake-files-'+count+'" class="form-group col-sm-11">'+files+'</div><div class="col-sm-1&quot;"><i class="fa fa-remove row-link remove-form pull-right"></i></div></div></div>';

               // place every value to intake display area
               $(".intake-forms-list").append(html);

               // show intake heading here
               $(".intake-heading").show();

               // close model popup
               $('#print_template').modal('hide');

               $(".modal-content").removeClass("csspinner load1");

            }
         })
      }
   })

   // once auto file clicked
   .on("change","input[type=file]", function(){

      // validate file extension
      var ext = $(this).val().split('.').pop().toLowerCase();
      if($.inArray(ext, ['pdf']) == -1) {
          alert('invalid extension! Please attach only pdf file.');
          $(this).val('');
          return false;
      }

      // display file name and delete button
      $(this).next("span.file-label").text($(this).val()).parent("div.col-sm-9").show();
   })

   // custom script for multi file upload
   .on("click",".multiupload", function(){
      var count = $("input[type=file]").length;

      // count no of intake forms
      var no_of_form = $(".intake-forms").length + 1;

      // add new file here
      $(".modal-body .files").append('<div class="col-sm-9" style="display:none"><input style="display:none" type="file" name="files_'+no_of_form+'[]" id="file'+(count+1)+'" accept="pdf" /><span class="file-label"></span> <i class="fa fa-trash row-link" id="'+(count+1)+'"></i></div>');

      // place trigger clicked once file append in files class
      $('#file'+(count+1)).trigger("click");
   })

   // custom script for multi file upload
   .on("click",".multiupload_files", function(){
      var count = $("input[type=file]").length;

      // count no of intake forms
      var no_of_form = $(".uploaded_files .col-sm-9").length + 1;

      // add new file here
      $(".uploaded_files").append('<div class="col-sm-9"  style="display:none" ><input style="display:none" type="file" name="files_multi[]" id="file'+(count+1)+'" accept="pdf" /><span class="file-label"></span> <i class="fa fa-trash row-link" id="'+(count+1)+'"></i></div>');

      // place trigger clicked once file append in files class
      $('#file'+(count+1)).trigger("click");
   })

   // delete files
   .on("click",".fa-trash", function(){
      $(this).parent("div").remove();
      $("#file"+$(this).attr("id")).remove();
   })

   // delete intake form
   .on("click",".fa.fa-remove.row-link.remove-form.pull-right", function(){
      var id = $(this).attr("alt");

      if(confirm('Are you sure you want to delete? '))
      {
         // remove form area instant to make it visible fast
         $(this).parent("div").parent("div").parent("div.intake-forms").remove();

         $.ajax({
            url: "<?php echo base_url("emergency_assistance/deleteform/") ?>"+id,
            method: "get"
         })
      } else {
         return false;
      }
   })

   // once user click over save intake form, we are just hold every value untill claim is not submitted
   .on("click", '.save-intakeform', function(){

      // check notes field filled or not
      if(!$("textarea[name=intake_notes]").val())
      {
         alert("Please add notes first.")
         return false;
      }

      // count no of intake forms
      var count = $(".intake-forms").length + 1;

      // place no of form in hidden field
      $("input[name=no_of_form]").val(count);

      // get notes and files
      var notes = $("textarea[name=intake_notes]").val();
      var files = $(".modal-body .files").clone();

      // generate html data
      var html = '<div class="col-sm-12 intake-forms"><div class=col-sm-12"><input type="hidden" name="notes_'+count+'" value="'+notes+'" />' + notes + '</div><div id="intake-files-'+count+'"></div> <div class=col-sm-3"><i class="fa fa-remove row-link remove-form pull-right"></i></div> <div class="col-sm-12">By: <?php echo $this->ion_auth->user()->row()->first_name; ?> on <i><?php echo date("Y-m-d"); ?></i></div></div>';

      // place every value to intake display area
      $(".intake-forms-list").append(html);

      // set clone files to that area
      $("#intake-files-"+count).html(files);

      // close model popup
      $('#create_intake_form').modal('hide');

      // save intake heading
      $(".intake-heading").show()
   })

   // get  policy information here
   .on("change", "input[name=policy_no]", function(){
      $.ajax({
         url: "<?php echo base_url("emergency_assistance/get_policy_info"); ?>",
         method:"get",
         data:{policy:$(this).val()},
         dataType: "json",
         beforeSend: function(){
            $(".nav-m22d").addClass("csspinner load1");
         },
         success: function(data){
            if(typeof data.plan_list != "undefined" && data.plan_list.length)
            {
               localStorage.setItem("policy_data", JSON.stringify(data.plan_list));
               $("input[name=policy_info]").val(JSON.stringify(data.plan_list));
               if (data.plan_list[0].status_id == 6) {
                   alert("Sorry, Refunded policy can't Create claim.");
               } else if (data.plan_list[0].status_id == 5) {
                   alert("Sorry, Canceled policy can't Create claim.");
               } else {
               $("input[name=product_short]").val(data.plan_list[0].product_short);
               $("input[name=agent_id]").val(data.plan_list[0].agent_id);
               $("input[name=totaldays]").val(data.plan_list[0].totaldays);

               $("input[name=insured_first_name]").val(data.plan_list[0].firstname);
               $("input[name=insured_last_name]").val(data.plan_list[0].lastname);
               if(data.plan_list[0].gender == 'M')
                  $("input[value=male]").prop('checked', true);
               else
                  $("input[value=female]").prop('checked', true);

               $("input[name=personal_id]").val(data.plan_list[0].student_id);
               $("input[name=dob]").val(data.plan_list[0].birthday);
               $("input[name=school_name]").val(data.plan_list[0].institution);
               $("input[name=group_id]").val();
               $("input[name=apply_date]").val(data.plan_list[0].apply_date);
               $("input[name=arrival_date]").val(data.plan_list[0].arrival_date);
               $("input[name=guardian_name]").val();
               $("input[name=guardian_phone]").val();


               if($("input[name=same_policy]").is(":checked"))
               {
                  // fill all json values to address fields
                  $("input[name=street_address]").val(data.plan_list[0].street_number+" "+data.plan_list[0].street_name);
                  $("input[name=city]").val(data.plan_list[0].city);
                  $("input[name=province]").val(data.plan_list[0].province2);
                  $("input[name=telephone]").val(data.plan_list[0].phone1);
                  $("input[name=email]").val(data.plan_list[0].contact_email);
                  $("input[name=post_code]").val(data.plan_list[0].postcode);
                  $("input[name=arrival_date_canada]").val(data.plan_list[0].arrival_date);
               }
               }
            } else {
               alert("Sorry1, policy information does not exists, please check policy no and try again");
               $("input[name=policy_no]").val('Unknown - ' + $("input[name=policy_no]").val());

               $("input[name=policy_info]").val('');
               $("input[name=product_short]").val('');
               $("input[name=agent_id]").val('');
               $("input[name=totaldays]").val('');

               // reset all fields
               $("input[name=insured_first_name]").val('');
               $("input[name=insured_last_name]").val('');
               $("input[value=male]").prop('checked', false);
               $("input[value=female]").prop('checked', false);
               $("input[name=personal_id]").val('');
               $("input[name=dob]").val('');
               $("input[name=school_name]").val('');
               $("input[name=group_id]").val();
               $("input[name=apply_date]").val('');
               $("input[name=arrival_date]").val('');
               $("input[name=guardian_name]").val('');
               $("input[name=guardian_phone]").val('');

               $("input[name=street_address],input[name=city],input[name=province],input[name=telephone],input[name=email],input[name=post_code],input[name=arrival_date_canada],input[name=cellular]").val("");

            }
            $(".nav-m22d").removeClass("csspinner load1");
         }
      })
   })

   // once user clicked on same with policy button
   .on("click", "input[name=same_policy]", function(){

      // get local data
      var data = $.parseJSON(localStorage.getItem("policy_data"));
      if($(this).is(":checked") && $("input[name=policy_no]").val())
      {
         // fill all json values to address fields
         $("input[name=street_address]").val(data[0].street_number+" "+data[0].street_name);
         $("input[name=city]").val(data[0].city);
         $("input[name=province]").val(data[0].province2);
         $("input[name=telephone]").val(data[0].phone1);
         $("input[name=email]").val(data[0].contact_email);
         $("input[name=post_code]").val(data[0].postcode);
         $("input[name=arrival_date_canada]").val(data[0].arrival_date);
         // $("input[name=cellular]").val(data.plan_list.street_number);
      }
      else
      {
         $("input[name=street_address],input[name=city],input[name=province],input[name=telephone],input[name=email],input[name=post_code],input[name=arrival_date_canada],input[name=cellular]").val("");
      }
   })

   // once user clicked on same with policy button
   .on("click", "#mail_address", function(){

      // get local data
      var data = $.parseJSON(localStorage.getItem("policy_data"));
      if($(this).is(":checked"))
      {
         // fill all json values to address fields
         $("input[name=email]").val(data[0].contact_emai);
         $("input[name=street_no_email]").val(data[0].street_number);
         $("input[name=street_name_email]").val(data[0].street_name);
         $("input[name=city_email]").val(data[0].city);
         $("select[name=province_email]").val(data[0].province2);
      }
      else
      {
         $("input[name=street_no_email],input[name=street_name_email],input[name=city_email],select[name=province_email]").val("");
      }
   })

   // once user select pay type
   .on("click", "input[name^=payment_type]", function(){
      var element = $(this).parent("div").parent("div").parent("div");
      if($(this).val() == 'cheque'){
         element.find(".wire_transfer_section").hide().find("input").removeClass('required error-true');
         element.find(".cheque_section").show().find("input").addClass('required');
      } else {
         element.find(".cheque_section").hide().find("input").removeClass('required error-true');
         element.find(".wire_transfer_section").show().find("input").addClass('required');
      }
   })

   // to list payee in expenses payee
   .on("keyup", "input[name='payees[payee_name][]'],input[name='payees[address][]'],input[name='payees[bank][]'],input[name='payees[account_cheque][]']", function(){
      // build a list of all payees name here
      var html = "<option value=''>--Select Payee--</option>";
      $("input[name='payees[payee_name][]']").each(function(){
         if($(this).val()) {
             var p = $(this).parent().parent();
             var v = p.find('input[type=radio]:checked').val();
             if (v == 'cheque') {
                 v = v + " : " + p.find("input[name='payees[payee_name][]']").val() + " : " + p.find("input[name='payees[address][]']").val();
             } else {
                 v = v + " : " + p.find("input[name='payees[payee_name][]']").val() + " : " + p.find("input[name='payees[bank][]']").val() + " : " + p.find("input[name='payees[account_cheque][]']").val();
             }
            html += '<option value="'+v+'">'+$(this).val()+'</option>';
         }
      })

      $("select[name='expenses_claimed[payee][]']").html(html);
   })

   // to check unique payee name
   .on("change", "input[name='payees[payee_name][]']", function(){
      // check all payees name here
      var val = $(this).val();
      if (val){
         var counter = 0;
         $("input[name='payees[payee_name][]']").each(function(){
            if($(this).val() == val)
               counter++;
         })
         if (counter > 1){
            alert("payee name already exists, please try different name.");
            $(this).val("");
            return false;
         }
      }
   })

	<?php if ($this->input->get('policy')) { ?>
      $.ajax({
         url: "<?php echo base_url("emergency_assistance/get_policy_info"); ?>",
         method:"get",
         data:{policy:"<?php echo $this->input->get('policy'); ?>"},
         dataType: "json",
         beforeSend: function(){
            $(".nav-m22d").addClass("csspinner load1");
         },
         success: function(data){
            if(typeof data.plan_list != "undefined" && data.plan_list.length)
            {
               localStorage.setItem("policy_data", JSON.stringify(data.plan_list));
               $("input[name=policy_info]").val(JSON.stringify(data.plan_list));
               if (data.plan_list[0].status_id == 6) {
                   alert("Sorry, Refunded policy <?php echo $this->input->get('policy'); ?> can't Create claim.");
               } else if (data.plan_list[0].status_id == 5) {
                   alert("Sorry, Canceled policy <?php echo $this->input->get('policy'); ?> can't Create claim.");
               } else {
                   $("input[name=product_short]").val(data.plan_list[0].product_short);
                   $("input[name=agent_id]").val(data.plan_list[0].agent_id);
                   $("input[name=totaldays]").val(data.plan_list[0].totaldays);

               $("input[name=insured_first_name]").val(<?php if ($this->input->get('firstname')) { echo "'".$this->input->get('firstname')."'"; } else { ?>data.plan_list[0].firstname<?php } ?>);
               $("input[name=insured_last_name]").val(<?php if ($this->input->get('lastname')) { echo "'".$this->input->get('lastname')."'"; } else { ?>data.plan_list[0].lastname<?php } ?>);
               if(<?php if ($this->input->get('gender')) { echo "'".$this->input->get('gender')."'"; } else { ?>data.plan_list[0].gender<?php } ?> == 'M')
                  $("input[value=male]").prop('checked', true);
               else
                  $("input[value=female]").prop('checked', true);

               $("input[name=personal_id]").val(data.plan_list[0].student_id);
               $("input[name=dob]").val(<?php if ($this->input->get('birthday')) { echo "'".$this->input->get('birthday')."'"; } else { ?>data.plan_list[0].birthday<?php } ?>);
               $("input[name=school_name]").val(data.plan_list[0].institution);
               $("input[name=group_id]").val();
               $("input[name=apply_date]").val(data.plan_list[0].apply_date);
               $("input[name=arrival_date]").val(data.plan_list[0].arrival_date);
               $("input[name=guardian_name]").val();
               $("input[name=guardian_phone]").val();
               }
            } else {
               $(".nav-m22d").removeClass("csspinner load1");
               alert("Sorry2, policy information does not exists, please check policy no and try again");
               $(this).val('Unknown - ' + $(this).val());
            }
            $(".nav-m22d").removeClass("csspinner load1");
         }
      })
   <?php } ?>

// create input boxes where requirement need
var $outer = $(".outer-text");
$outer.each(function(){
   var text = $.trim($(this).text());

   $(this).empty();
   if(!$(this).hasClass("area"))
      $(this).append("<input class='outer-text' value='" + text + "'></input>");
   else
      $(this).append("<textarea  style='width:100%' rows='6' value=''>"+ text +"</textarea>");
});

// create word template selection for deny reason
var $outer = $(".outer_custom_comment");
$outer.each(function(){
   var text = $.trim($('.word_templates').html());

   $(this).empty();
   $(this).append(text);
});




// create a dropdown list for product selection
var $outer_select = $(".select-product");
$outer_select.each(function(){
   var text = $.trim($(this).text());

   $(this).empty();
   $(this).append($("#products").html());
});

// to validate expenses items
function validate_form(){
   // check length of expenses items if not deleted
   var length = $(".expenses-list .row").length;
   if(!length){
      alert("Please create alteast one expenses claimed item.");
      $(".add_new_expenses").focus();
      return false;
   }

   // validate invoice required
   var $validate = 1;
   var $validate_num = 1;

   $("#main_form .required").map(function(){
      if(!$(this).val()){
         $validate = 0;
         $(this).addClass('error-true');
      }
      else {
         $(this).removeClass('error-true');
      }
   })
   $("#main_form .alphanum").map(function(){
      if($.isNumeric($(this).val())){
         $validate_num = 0;
         $(this).addClass('error-true');
      }
      else {
         if($(this).val())
            $(this).removeClass('error-true');
      }
   })

   var email = $("input[name=email]").val();   
   var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
   if(email && !regex.test(email)){
      $validate = 0;
      $("input[name=email]").addClass('error-true');
   } else{
      $("input[name=email]").removeClass('error-true');
   }


   if(!$validate){
      alert("Please fill all required fields.");

      // show area once any error occured
      $(".error-true").map(function(){
         $(this).closest('.row').show();
         $(this).closest('.row').prev('.move_down').children('i').removeClass('fa-angle-down').addClass('fa-angle-up');
      })

      return false;
   }

   if(!$validate_num){
      alert("Invalid name formate in 'Name of Provider', 'Name of Referring Physician', 'Payee Name' or 'Bank Name'");

      // show area once any error occured
      $(".error-true").map(function(){
         $(this).closest('.row').show();
         $(this).closest('.row').prev('.move_down').children('i').removeClass('fa-angle-down').addClass('fa-angle-up');
      })

      return false;
   }
   return true;
}


// outer_custom_comment
</script>
