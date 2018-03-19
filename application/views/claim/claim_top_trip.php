<div .on("keyup", ".company_nameinput", function(){ $(".company_nameinput").val($(this).val()); }) >
	<div class="page-title">
		<div class="title_left">
			<h3>Claim - #<?php echo $claim_details['claim_no']; ?></h3>
      </div>
	</div>
	<div class="clearfix"></div>
	<!-- Policy search and List Section -->
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<?php echo $message; ?>
				<div class="x_title">
					<h2>Trip Cancellation and Intrruption Claim Details</h2>
					<?php if (!empty($claim_details['case_no'])) { echo anchor("emergency_assistance/edit_case/".$claim_details['id'], 'Case Info <i class="fa fa-link"></i>', array("class"=>'btn btn-primary pull-right')); } ?>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<?php echo form_open_multipart("", array('class'=>'form-horizontal', 'method'=>'post', 'onsubmit'=>'return validate_form()', 'id'=>'main_form')); ?>
					<div class="case_info">
						<h4 class="move_down">SECTION A: INSURED’S INFORMATION <i class="fa fa-angle-down pull-right"></i></h4>
						<div class="row" style="display: none">
							<div class="form-group col-sm-3">
								<?php echo form_label('Insured First Name:', 'insured_first_name', array("class" => 'col-sm-12')); ?>
								<?php echo form_input("insured_first_name", $claim_details["insured_first_name"], array("class" => "form-control required", 'placeholder' => 'Insured First Name')); ?>
								<?php echo form_error("insured_first_name"); ?>
							</div>
							<div class="col-sm-3">
								<?php echo form_label('Insured Last Name:', 'insured_last_name', array("class" => 'col-sm-12')); ?>
								<?php echo form_input("insured_last_name", $claim_details["insured_last_name"], array("class" => "form-control", 'placeholder' => 'Insured Last Name')); ?>
							</div>
							<div class="col-sm-3">
								<div class="col-sm-4">
									<?php echo form_label('&nbsp;', 'gender', array("class" => 'col-sm-12')); ?>
									<?php echo form_radio("gender", "male", ($claim_details["gender"] == 'male' ? TRUE : FALSE), array('class' => 'setpremium')); ?>  Male
								</div>
								<div class="col-sm-5">
									<?php echo form_label('&nbsp;', 'gender', array("class" => 'col-sm-12')); ?>
									<?php echo form_radio("gender", "female", ($claim_details["gender"] == 'female' ? TRUE : FALSE), array('class' => 'setpremium')); ?>  Female
								</div>
							</div>
							<div class="col-sm-3" style='display:none;'>
								<?php echo form_label('ID', 'id', array("class" => 'col-sm-12')); ?>
								<?php echo form_input("personal_id", $claim_details["personal_id"], array("class" => "form-control", 'placeholder' => 'ID')); ?>
								<?php echo form_error("personal_id"); ?>
							</div>
							<div class="form-group col-sm-3">
								<?php echo form_label('Date of Birth:', 'dob', array("class"=>'col-sm-12'));   ?>
								<div class="input-group date">
									<?php echo form_input("dob", $claim_details["dob"], array("class" => "form-control dob required", 'placeholder' => 'Date of Birth')); ?>
									<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
								</div>
								<?php echo form_error("dob"); ?>
							</div>
							<div class="clearfix"></div>

							<div class="form-group col-sm-3">
								<?php echo form_label('Second Insured First Name:', 'exinfo_insured2_first_name', array("class" => 'col-sm-12')); ?>
								<?php echo form_input("exinfo[insured2_first_name]", isset($exinfo["insured2_first_name"]) ? $exinfo["insured2_first_name"] : '', array("class" => "form-control", 'placeholder' => 'Second Insured First Name')); ?>
							</div>
							<div class="col-sm-3">
								<?php echo form_label('Second Insured Last Name:', 'exinfo_insured2_last_name', array("class" => 'col-sm-12')); ?>
								<?php echo form_input("exinfo[insured2_last_name]", isset($exinfo["insured2_last_name"]) ? $exinfo["insured2_last_name"] : '', array("class" => "form-control", 'placeholder' => 'Insured Last Name' )); ?>
							</div>
							<div class="col-sm-3">
								<div class="col-sm-4">
									<?php echo form_label('&nbsp;', 'gender', array("class" => 'col-sm-12')); ?>
									<?php echo form_radio("exinfo[gender2]", "male", isset($exinfo["gender2"]) ? $exinfo["gender2"] : '', array('class' => 'setpremium')); ?> Male
								</div>
								<div class="col-sm-5">
									<?php echo form_label('&nbsp;', 'gender', array("class" => 'col-sm-12')); ?>
									<?php echo form_radio("exinfo[gender2]", "female", isset($exinfo["gender2"]) ? $exinfo["gender2"] : '', array('class' => 'setpremium'));?> Female
								</div>
							</div>
							<div class="form-group col-sm-3">
								<?php echo form_label('Date of Birth:', 'exinfo_dob2', array("class"=>'col-sm-12')); ?>
								<div class="input-group date">
									<?php echo form_input("exinfo[dob2]", isset($exinfo["dob2"]) ? $exinfo["dob2"] : '', array("class" => "form-control dob", 'placeholder' => 'Date of Birth')); ?>
									<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
								</div>
							</div>
							<div class="clearfix"></div>

							<div class="form-group col-sm-3">
								<?php echo form_label('Policy#:', 'policy_no', array("class" => 'col-sm-12')); ?>
								<?php echo form_input("policy_no", $claim_details["policy_no"], array("class" => "form-control required", 'placeholder' => 'Policy#', 'disabled' => 'disabled')); ?>
								<?php echo form_error("policy_no"); ?>
								<input type='hidden' name='product_short' value='<?php echo $claim_details["product_short"]; ?>'>
								<input type='hidden' name='agent_id' value='<?php echo $claim_details["agent_id"]; ?>'>
							</div>
							<div class="form-group col-sm-3">
								<?php echo form_label('Case #:', 'case_no', array("class" => 'col-sm-12')); ?>
								<?php echo form_input("case_no", ($this->input->post("case_no") ? $this->input->post("case_no") : $this->input->get("policy")), array("class" => "form-control", 'placeholder' => 'Case #')); ?>
								<?php echo form_error("case_no"); ?>
							</div>
							<div class="form-group col-sm-3" style='display:none;'>
								<?php echo form_label('School Name:', 'school_name', array("class" => 'col-sm-12')); ?>
								<?php echo form_input("school_name", $claim_details["school_name"], array("class" => "form-control", 'placeholder' => 'School Name')); ?>
								<?php echo form_error("school_name"); ?>
							</div>
							<div class="form-group col-sm-3" style='display:none;'>
								<?php echo form_label('Group ID:', 'group_id', array("class" => 'col-sm-12')); ?>
								<?php echo form_input("group_id", $claim_details["group_id"], array("class" => "form-control", 'placeholder' => 'Group ID')); ?>
								<?php echo form_error("group_id"); ?>
							</div>
							<div class="form-group col-sm-3" style='display:none;'>
								<?php echo form_label('Enroll Date:', 'apply_date', array("class"=>'col-sm-12')); ?>
								<div class="input-group date">
									<?php echo form_input("apply_date", $claim_details["apply_date"], array("class" => "form-control datepicker",'placeholder' => 'Enroll Date')); ?>
									<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
								</div>
							</div>
							<div class="form-group col-sm-3" style='display:none;'>
								<?php echo form_label('Arrival Date in Canada:', 'arrival_date', array("class"=>'col-sm-12')); ?>
								<div class="input-group date">
									<?php echo form_input("arrival_date", $claim_details["arrival_date"], array("class" => "form-control datepicker", 'placeholder' => 'Arrival Date in Canada')); ?>
									<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
								</div>
							</div>
							<div class="form-group col-sm-3" style='display:none;'>
								<?php echo form_label('Full Name of Guardian if applicable:', 'guardian_name', array("class" => 'col-sm-12')); ?>
								<?php echo form_input("guardian_name", $claim_details["guardian_name"], array("class" => "form-control", 'placeholder' => 'Full Name of Guardian if applicable')); ?>
							</div>
							<div class="form-group col-sm-3" style='display:none;'>
								<?php echo form_label('Guardian Phone#:', 'guardian_phone', array("class" => 'col-sm-12')); ?>
								<?php echo form_input("guardian_phone", $claim_details["guardian_phone"], array("class" => "form-control", 'placeholder' => 'Guardian Phone#')); ?>
							</div>
							<div class="clearfix"></div>
							
							<h4>Address in Canada </h4>
							<div class="form-group col-sm-3">
								<?php echo form_label('Street Address:', 'street_address', array("class" => 'col-sm-12')); ?>
								<?php echo form_input("street_address", $claim_details["street_address"], array("class" => "form-control", 'placeholder' => 'Street Address')); ?>
							</div>
							<div class="form-group col-sm-3">
								<?php echo form_label('City/Town:', 'city', array("class" => 'col-sm-12')); ?>
								<?php echo form_input("city", $claim_details["city"], array("class" => "form-control", 'placeholder' => 'City/Town')); ?>
							</div>
							<div class="form-group col-sm-3">
								<?php echo form_label('Province:', 'province', array("class" => 'col-sm-12')); ?>
								<?php echo form_input("province", $claim_details["province"], array("class" => "form-control", 'placeholder' => 'Province')); ?>
							</div>
							<div class="form-group col-sm-3">
								<?php echo form_label('PostCode:', 'post_code', array("class" => 'col-sm-12')); ?>
								<?php echo form_input("post_code", $claim_details["post_code"], array("class" => "form-control", 'placeholder' => 'PostCode')); ?>
							</div>
							<div class="form-group col-sm-3">
								<?php echo form_label('Destination:', 'exinfo_destination', array("class" => 'col-sm-12')); ?>
								<?php echo form_input("exinfo[destination]", isset($exinfo["destination"]) ? $exinfo["destination"] : '', array("class" => "form-control", 'placeholder' => 'Destination')); ?>
							</div>
							<div class="form-group col-sm-3">
								<?php echo form_label('Telephone:', 'telephone', array("class" => 'col-sm-12')); ?>
								<?php echo form_input("telephone", $claim_details["telephone"], array("class" => "form-control", 'placeholder' => 'Telephone')); ?>
							</div>
							<div class="form-group col-sm-3">
								<?php echo form_label('Fax:', 'exinfo_fax', array("class" => 'col-sm-12')); ?>
								<?php echo form_input("exinfo[fax]", isset($exinfo["fax"]) ? $exinfo["fax"] : '', array("class" => "form-control", 'placeholder' => 'Fax')); ?>
							</div>
							<div class="form-group col-sm-3">
								<?php echo form_label('Email:', 'email', array("class" => 'col-sm-12')); ?>
								<?php echo form_input("email", $claim_details["email"], array("class" => "form-control", 'placeholder' => 'Email')); ?>
							</div>
							<div class="form-group col-sm-3" style="display: none">
								<?php echo form_label('Date of Arrival in Canada:', 'arrival_date_canada', array("class"=>'col-sm-12')); ?>
								<div class="input-group date">
									<?php echo form_input("arrival_date_canada", $claim_details["arrival_date_canada"], array("class" => "form-control datepicker",'placeholder' => 'Date of Arrival in Canada')); ?>
									<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
								</div>
							</div>
							<div class="form-group col-sm-3" style="display: none">
								<?php echo form_label('Cellular:', 'cellular', array("class" => 'col-sm-12')); ?>
								<?php echo form_input("cellular", $claim_details["cellular"], array("class" => "form-control", 'placeholder' => 'Cellular')); ?>
							</div>
							<div class="form-group col-sm-3">
								<?php echo form_label('Date of Departure:', 'exinfo_depature_date', array("class"=>'col-sm-12')); ?>
								<div class="input-group date">
									<?php echo form_input("exinfo[depature_date]", isset($exinfo["depature_date"]) ? $exinfo["depature_date"] : '', array("class" => "form-control datepicker", 'placeholder' => 'Date of Depature')); ?>
									<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
								</div>
							</div>
							<div class="form-group col-sm-3">
								<?php echo form_label('Date of Return:', 'exinfo_return_date', array("class"=>'col-sm-12')); ?>
								<div class="input-group date">
									<?php echo form_input("exinfo[return_date]", isset($exinfo["return_date"]) ? $exinfo["return_date"] : '', array("class" => "form-control datepicker", 'placeholder' => 'Date of Return')); ?>
									<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
								</div>
							</div>
						</div>

						<h4 class="move_down">SECTION B: TYPE OF LOSS <i class="fa fa-angle-down pull-right"></i></h4>
						<div class="row" style="display: none">
							<div class="form-group col-sm-3">
								<?php echo form_label('Type:', 'exinfo_loss_type', array("class" => 'col-sm-12')); ?>
								<select name="exinfo[loss_type]" class="form-control">
									<option value=""> -- Select Type of Loss -- </option>
									<option value="Trip Cancellation" <?php if ('Trip Cancellation' == $exinfo["loss_type"]) { echo "selected"; } ?>>Trip Cancellation</option>
									<option value="Trip Intrruption" <?php if ('Trip Intrruption' == $exinfo["loss_type"]) { echo "selected"; } ?>>Trip Intrruption</option>
									<option value="Delays" <?php if ('Delays' == $exinfo["loss_type"]) { echo "selected"; } ?>>Delays</option>
								</select>
							</div>
							<div class="clearfix"></div>
							<div class="form-group col-sm-3">
								If loss is due to sickness, please provide details: 
							</div>
							<div class="form-group col-sm-9">
								<?php echo form_input("exinfo[sickness]", isset($exinfo["sickness"]) ? $exinfo["sickness"] : '', array("class" => "form-control")); ?>
							</div>
							<div class="form-group col-sm-3">
								Date symptoms or injury first appeared: 
							</div>
							<div class="form-group col-sm-3">
								<div class="input-group date">
									<?php echo form_input("exinfo[injury1_date]", isset($exinfo["injury1_date"]) ? $exinfo["injury1_date"] : '', array("class" => "form-control datepicker")); ?>
									<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
								</div>
							</div>
							<div class="form-group col-sm-3">
								Date you first saw physician for this condition: 
							</div>
							<div class="form-group col-sm-3">
								<div class="input-group date">
									<?php echo form_input("exinfo[physician_date]", isset($exinfo["physician_date"]) ? $exinfo["physician_date"] : '', array("class" => "form-control datepicker")); ?>
									<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
								</div>
							</div>
							<div class="form-group col-sm-3">
								If loss is due to injury, please provide details: 
							</div>
							<div class="form-group col-sm-9">
								<?php echo form_input("exinfo[injury_details]", isset($exinfo["injury_details"]) ? $exinfo["injury_details"] : '', array("class" => "form-control")); ?>
							</div>
							<div class="form-group col-sm-3">
								Describe how the injury/accident occured: 
							</div>
							<div class="form-group col-sm-9">
								<?php echo form_input("exinfo[injury_describe]", isset($exinfo["injury_describe"]) ? $exinfo["injury_describe"] : '', array("class" => "form-control")); ?>
							</div>
							<div class="form-group col-sm-3">
								Date of injury/accident: 
							</div>
							<div class="form-group col-sm-3">
								<div class="input-group date">
									<?php echo form_input("exinfo[injury_date]", isset($exinfo["injury_date"]) ? $exinfo["injury_date"] : '', array("class" => "form-control datepicker")); ?>
									<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
								</div>
							</div>
							<div class="clearfix"></div>
							<div class="form-group col-sm-3">
								If loss is due to death, please provide details: 
							</div>
							<div class="form-group col-sm-9">
								<?php echo form_input("exinfo[death_describe]", isset($exinfo["death_describe"]) ? $exinfo["death_describe"] : '', array("class" => "form-control")); ?>
							</div>
							<div class="form-group col-sm-3">
								Date of death: 
							</div>
							<div class="form-group col-sm-3">
								<div class="input-group date">
									<?php echo form_input("exinfo[death_date]", isset($exinfo["death_date"]) ? $exinfo["death_date"] : '', array("class" => "form-control datepicker")); ?>
									<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
								</div>
							</div>
							<div class="form-group col-sm-3">
								Cause of death: 
							</div>
							<div class="form-group col-sm-3">
								<?php echo form_input("exinfo[death_cause]", isset($exinfo["death_cause"]) ? $exinfo["death_cause"] : '', array("class" => "form-control")); ?>
							</div>
							<div class="form-group col-sm-3">
								Your relationship to sick, injured or deceased person: 
							</div>
							<div class="form-group col-sm-3">
								<?php echo form_input("exinfo[relation]", isset($exinfo["relation"]) ? $exinfo["relation"] : '', array("class" => "form-control")); ?>
							</div>
							<div class="form-group col-sm-3">
								Name of patient or deceased: 
							</div>
							<div class="form-group col-sm-3">
								<?php echo form_input("exinfo[patient_name]", isset($exinfo["patient_name"]) ? $exinfo["patient_name"] : '', array("class" => "form-control")); ?>
							</div>
	
							<h4>Name and Address of patient’s usual Family Physician</h4>
		
							<div class="col-sm-12">
								<div class="form-group col-sm-3">
									<?php echo form_label('Name:', 'physician_name', array("class" => 'col-sm-12')); ?>
									<?php echo form_input("physician_name", $claim_details["physician_name"], array("class" => "form-control", 'placeholder' => 'Name')); ?>
								</div>
								<div class="form-group col-sm-3">
									<?php echo form_label('Clinic Name or Address:', 'clinic_name', array("class" => 'col-sm-12')); ?>
									<?php echo form_input("clinic_name", $claim_details["clinic_name"], array("class" => "form-control", 'placeholder' => 'Clinic Name or Address')); ?>
								</div>
								<div class="form-group col-sm-3">
									<?php echo form_label('Street Address:', 'physician_street_address', array("class" => 'col-sm-12')); ?>
									<?php echo form_input("physician_street_address", $claim_details["physician_street_address"], array("class" => "form-control", 'placeholder' => 'Street Address')); ?>
								</div>
								<div class="form-group col-sm-3">
									<?php echo form_label('City/Town:', 'physician_city', array("class" => 'col-sm-12')); ?>
									<?php echo form_input("physician_city", $claim_details["physician_city"], array("class" => "form-control", 'placeholder' => 'City/Town')); ?>
									<?php  echo form_error("physician_city"); ?>
								</div>
								<div class="form-group col-sm-3">
									<?php echo form_label('Country:', 'country', array("class" => 'col-sm-12')); ?>
									<select name="country" class="form-control">
										<option value=""> -- Select Country -- </option>
										<?php foreach ($country as $key => $val): ?>
										<option value="<?php echo $key; ?>" <?php if ($key == $claim_details["country"]) { echo "selected"; } ?>><?php echo $val; ?></option>
										<?php endforeach; ?>
									</select>
								</div>
								<div class="form-group col-sm-3">
									<?php echo form_label('Postal Code:', 'physician_post_code', array("class" => 'col-sm-12')); ?>
									<?php echo form_input("physician_post_code", $claim_details["physician_post_code"], array("class" => "form-control", 'placeholder' => 'Postal Code')); ?>
								</div>
								<div class="form-group col-sm-3">
									<?php echo form_label('Telephone:', 'physician_telephone', array("class" => 'col-sm-12')); ?>
									<?php echo form_input("physician_telephone", $claim_details["physician_telephone"], array("class" => "form-control", 'placeholder' => 'Telephone')); ?>
									<?php echo form_error("physician_telephone"); ?>
								</div>
								<div class="form-group col-sm-3">
									<?php echo form_label('Alt Telephone:', 'physician_alt_telephone', array("class" => 'col-sm-12')); ?>
									<?php echo form_input("physician_alt_telephone", $claim_details["physician_alt_telephone"], array("class" => "form-control", 'placeholder' => 'Alt Telephone')); ?>
									<?php echo form_error("physician_alt_telephone"); ?>
								</div>
							</div>
							<div class="clearfix"></div>
	
							<h4>Name and Address of any other physician who may have treated the patient in the last 12 months</h4>
							<div class="col-sm-12">
								<div class="form-group col-sm-3">
									<?php echo form_label('Name:', 'physician_name_canada', array("class" => 'col-sm-12')); ?>
									<?php echo form_input("physician_name_canada", $claim_details["physician_name_canada"], array("class" => "form-control", 'placeholder' => 'Name')); ?>
									<?php echo form_error("physician_name_canada"); ?>
								</div>
								<div class="form-group col-sm-3">
									<?php echo form_label('Clinic Name or Address:', 'clinic_name_canada', array("class" => 'col-sm-12')); ?>
									<?php echo form_input("clinic_name_canada", $claim_details["clinic_name_canada"], array("class" => "form-control", 'placeholder' => 'Clinic Name or Address')); ?>
								</div>
								<div class="form-group col-sm-3">
									<?php echo form_label('Street Address:', 'physician_street_address_canada', array("class" => 'col-sm-12')); ?>
									<?php echo form_input("physician_street_address_canada", $claim_details["physician_street_address_canada"], array("class" => "form-control", 'placeholder' => 'Street Address')); ?>
								</div>
								<div class="form-group col-sm-3">
									<?php echo form_label('City/Town:', 'physician_city_canada', array("class" => 'col-sm-12')); ?>
									<?php echo form_input("physician_city_canada", $claim_details["physician_city_canada"], array("class" => "form-control", 'placeholder' => 'City/Town')); ?>
									<?php echo form_error("physician_city_canada"); ?>
								</div>
								<div class="form-group col-sm-3">
									<?php echo form_label('Postal Code:', 'physician_post_code_canada', array("class" => 'col-sm-12')); ?>
									<?php echo form_input("physician_post_code_canada", $claim_details["physician_post_code_canada"], array("class" => "form-control", 'placeholder' => 'Postal Code')); ?>
								</div>
								<div class="form-group col-sm-3">
									<?php echo form_label('Telephone:', 'physician_telephone_canada', array("class" => 'col-sm-12')); ?>
									<?php echo form_input("physician_telephone_canada", $claim_details["physician_telephone_canada"], array("class" => "form-control", 'placeholder' => 'Telephone')); ?>
									<?php echo form_error("physician_telephone_canada"); ?>
								</div>
								<div class="form-group col-sm-3">
									<?php echo form_label('Alt Telephone:', 'physician_alt_telephone_canada', array("class" => 'col-sm-12')); ?>
									<?php echo form_input("physician_alt_telephone_canada", $claim_details["physician_alt_telephone_canada"], array("class" => "form-control", 'placeholder' => 'Alt Telephone')); ?>
									<?php echo form_error("physician_alt_telephone_canada"); ?>
								</div>
							</div>
							<div class="form-group col-sm-6">
								If loss is due to other circumstances, please provide description of loss: 
							</div>
							<div class="form-group col-sm-6">
								<?php echo form_input("exinfo[circumstances]", isset($exinfo["circumstances"]) ? $exinfo["circumstances"] : '', array("class" => "form-control")); ?>
							</div>
							<div class="form-group col-sm-3">
								Date the loss first occured: 
							</div>
							<div class="form-group col-sm-3">
								<div class="input-group date">
									<?php echo form_input("exinfo[first occured_date]", isset($exinfo["occured_date"]) ? $exinfo["occured_date"] : '', array("class" => "form-control datepicker")); ?>
									<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
								</div>
							</div>
							<div class="form-group col-sm-3">
								Date you cancelled with travel agent/travel supplier: 
							</div>
							<div class="form-group col-sm-3">
								<div class="input-group date">
									<?php echo form_input("exinfo[cancelled_date]", isset($exinfo["cancelled_date"]) ? $exinfo["cancelled_date"] : '', array("class" => "form-control datepicker")); ?>
									<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
								</div>
							</div>
						</div>
					
						<h4 class="move_down">Contact Information <i class="fa fa-angle-down pull-right"></i></h4>
						<div class="row" style="display: none">
							<div class="form-group col-sm-3">
								<?php echo form_label('First Name:', 'contact_first_name', array("class" => 'col-sm-12')); ?>
								<?php echo form_input("contact_first_name", $claim_details["contact_first_name"], array("class" => "form-control",'placeholder' => 'First Name')); ?>
								<?php echo form_error("contact_first_name"); ?>
							</div>
							<div class="form-group col-sm-3">
								<?php echo form_label('Last Name:', 'contact_last_name', array("class" => 'col-sm-12')); ?>
								<?php echo form_input("contact_last_name", $claim_details["contact_last_name"], array("class" => "form-control", 'placeholder' => 'Last Name')); ?>
								<?php echo form_error("contact_last_name"); ?>
							</div>
							<div class="form-group col-sm-3">
								<?php echo form_label('Email:', 'contact_email', array("class" => 'col-sm-12')); ?>
								<?php echo form_input("contact_email", $claim_details["contact_email"], array("class" => "form-control", 'placeholder' => 'Email')); ?>
								<?php echo form_error("contact_email"); ?>
							</div>
							<div class="form-group col-sm-3">
								<?php echo form_label('Phone:', 'contact_phone', array("class" => 'col-sm-12')); ?>
								<?php echo form_input("contact_phone", $claim_details["contact_phone"], array("class" => "form-control", 'placeholder' => 'Phone')); ?>
								<?php echo form_error("contact_phone"); ?>
							</div>
						</div>

						<h2 class="move_down">SECTION D: OTHER INSURANCE COVERAGE <small></small><i class="fa fa-angle-down pull-right"></i></h2>
						<div class="row" style="display: none">
							<div class="col-sm-5">Do you have credit card insurance coverage?</div>
							<div class="col-sm-1">
								<?php echo form_radio("exinfo[credit_card_insurance]", "Y", isset($exinfo['credit_card_insurance']) ? $exinfo['credit_card_insurance'] : '', array('class' => 'setpremium'));?> Yes
							</div>
							<div class="col-sm-1">
								<?php echo form_radio("exinfo[credit_card_insurance]", "N", isset($exinfo['credit_card_insurance']) ? $exinfo['credit_card_insurance'] : '', array('class' => 'setpremium'));?> No
							</div>
							<div class="col-sm-5">If ‘Yes’, please provide the following information</div>
							<div class="clearfix"></div>
	
							<div class="form-group col-sm-3">
								Name of the financial Institution: 
							</div>
							<div class="form-group col-sm-9">
								<?php echo form_input("exinfo[credit_card_name]", isset($exinfo["credit_card_name"]) ? $exinfo["credit_card_name"] : '', array("class" => "form-control")); ?>
							</div>
	
							<div class="form-group col-sm-3">
								First 6 digits of credit card: 
							</div>
							<div class="form-group col-sm-3">
								<?php echo form_input("exinfo[credit_card_number]", isset($exinfo["credit_card_number"]) ? $exinfo["credit_card_number"] : '', array("class" => "form-control")); ?>
							</div>
	
							<div class="form-group col-sm-3">
								Expiry Date(MM/YYYY): 
							</div>
							<div class="form-group col-sm-3">
								<?php echo form_input("exinfo[credit_card_expire]", isset($exinfo["credit_card_expire"]) ? $exinfo["credit_card_expire"] : '', array("class" => "form-control")); ?>
							</div>
	
							<div class="form-group col-sm-3">
								Name of Cardholder: 
							</div>
							<div class="form-group col-sm-3">
								<?php echo form_input("exinfo[credit_card_holder]", isset($exinfo["credit_card_holder"]) ? $exinfo["credit_card_holder"] : '', array("class" => "form-control")); ?>
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
	
						<h2 class="move_down" style="display: none">Other Insurance Coverage <i class="fa fa-angle-down pull-right"></i></h2>
						<div class="row" style="display: none">
							<div class="col-sm-12">
								<div class="row">
									<div class="col-sm-12">
										<div class="col-sm-7">Do you have other insurance coverage including Canadian government health insurance?</div>
										<div class="col-sm-1">
											<?php echo form_radio("other_insurance_coverage", "Y", ($claim_details["other_insurance_coverage"] == 'Y' ? TRUE : FALSE), array('class' => 'setpremium')); ?>  Yes
										</div>
										<div class="col-sm-1">
											<?php echo form_radio("other_insurance_coverage", "N", $claim_details["other_insurance_coverage"] == 'N' ? TRUE : FALSE, array('class' => 'setpremium')); ?>  No
										</div>
										<div class="clearfix"></div>

										<div class="col-sm-7">Do you, your spouse or your parents/guardians have any other medical or travel insurance coverage?</div>
										<div class="col-sm-1">
											<?php echo form_radio("travel_insurance_coverage_guardians", "Y", ($claim_details["travel_insurance_coverage_guardians"] == 'Y' ? TRUE : FALSE), array('class' => 'setpremium')); ?>  Yes
										</div>
										<div class="col-sm-1">
											<?php echo form_radio("travel_insurance_coverage_guardians", "N", $claim_details["travel_insurance_coverage_guardians"] == 'N' ? TRUE : FALSE, array('class' => 'setpremium')); ?>  No
										</div>

										<div class="col-sm-12">If yes, provide details of other insurance company coverage below. If no, confirm by checking the box below.</div>
									</div>
									<div class="col-sm-3">
										<?php echo form_label('Full Name:', 'full_name', array("class" => 'col-sm-12')); ?>
										<?php echo form_input("full_name", $claim_details["full_name"], array("class" => "form-control", 'placeholder' => 'Full Name')); ?>
									</div>
									<div class="col-sm-3">
										<?php echo form_label('Employer Name:', 'employee_name', array("class" => 'col-sm-12')); ?>
										<?php echo form_input("employee_name", $claim_details["employee_name"], array("class" => "form-control", 'placeholder' => 'Employer Name')); ?>
									</div>
									<div class="col-sm-3">
										<?php echo form_label('Street Address:', 'employee_street_address', array("class" => 'col-sm-12')); ?>
										<?php echo form_input("employee_street_address", $claim_details["employee_street_address"], array("class" => "form-control", 'placeholder' => 'Street Address')); ?>
									</div>
									<div class="col-sm-3">
										<?php echo form_label('City/Town:', 'city_town', array("class" => 'col-sm-12')); ?>
										<?php echo form_input("city_town", $claim_details["city_town"], array("class" => "form-control", 'placeholder' => 'City/Town')); ?>
									</div>
									<div class="form-group col-sm-3">
										<?php echo form_label('Country:', 'country2', array("class" => 'col-sm-12')); ?>
										<select name="country2" class="form-control">
											<option value=""> -- Select Country -- </option>
											<?php foreach ($country2 as $key => $val):?>
											<option value="<?php echo $key; ?>" <?php if ($key == $this->input->post('country2')) { echo "selected"; } ?>><?php echo $val; ?></option>
											<?php endforeach; ?>
											<option value=""> N/A </option>
										</select>
									</div>
									<div class="col-sm-3">
										<?php echo form_label('Telephone:', 'employee_telephone', array("class" => 'col-sm-12')); ?>
										<?php echo form_input("employee_telephone", $claim_details["employee_telephone"], array("class" => "form-control", 'placeholder' => 'Telephone')); ?>
									</div>
								</div>
							</div>
						</div>

						<h2 class="move_down" style="display: none">Medical Information <small></small> <i class="fa fa-angle-down pull-right"></i></h2>
						<div class="row" style="display: none">
							<div class="col-sm-12">
								<div class="row">
									<div class="col-sm-12">
										<?php echo form_label('Diagnosis:', 'diagnosis', array("class" => 'col-sm-12')); ?>
										<?php echo form_input("diagnosis", $claim_details["diagnosis"], array("class" => "form-control required", 'placeholder' => 'Diagnosis')); ?>
										<?php echo form_error("diagnosis"); ?>
									</div>
									<div class="form-group col-sm-12">
										<?php echo form_label('Brief description of your sickness or injury:', 'medical_description', array("class" => 'col-sm-12')); ?>
										<?php echo form_textarea("medical_description", $claim_details["medical_description"], array("class" => "form-control", 'placeholder' => 'Brief description of your sickness or injury')); ?>
									</div>
									<div class="col-sm-6">
										<?php echo form_label('Date symptoms or injury first appeared:', 'date_symptoms', array("class" => 'col-sm-12')); ?>
										<?php echo form_input("date_symptoms", $claim_details["date_symptoms"], array("class" => "form-control dob", 'placeholder' => 'Date symptoms or injury first appeared')); ?>
									</div>
									<div class="col-sm-6">
										<?php echo form_label('Date you first saw physician for this condition:', 'date_first_physician', array("class" => 'col-sm-12')); ?>
										<?php echo form_input("date_first_physician", $claim_details["date_first_physician"], array("class" => "form-control dob", 'placeholder' => 'Date you first saw physician for this condition')); ?>
									</div>
									<div class="col-sm-12" style="margin-top: 20px">
										<div class="col-sm-7">Have you ever been treated for this or a similar condition before?</div>
										<div class="col-sm-1">
											<?php echo form_radio("treatment_before", "Y", $this->input->post("treatment_before"), array('class' => 'setpremium')); ?>  Yes
										</div>
										<div class="col-sm-1">
											<?php echo form_radio("treatment_before", "N", $this->input->post("treatment_before"), array('class' => 'setpremium')); ?>  No
										</div>
										<div class="col-sm-12">If you answered “yes”, provide all dates of treatment and list all medications taken before the effective date of the current policy:</div>
										<div class="form-group col-sm-12">
											<div class="col-sm-3">
												<?php echo form_label('Date (MM/DD/YYYY):', 'medication_date_1', array("class"=>'col-sm-12'));   ?>
												<div class="input-group date">
													<?php echo form_input("medication_date_1", $claim_details["medication_date_1"], array("class" => "form-control datepicker", 'placeholder' => 'Date (MM/DD/YYYY)')); ?>
													<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
												</div>
											</div>
											<div class="col-sm-3">
												<?php echo form_label('Medication:', 'medication_1', array("class" => 'col-sm-12')); ?>
												<?php echo form_input("medication_1", $claim_details["medication_1"], array("class" => "form-control", 'placeholder' => 'Medication')); ?>
											</div>
										</div>
										<div class="form-group col-sm-12">
											<div class="col-sm-3">
												<?php echo form_label('Date (MM/DD/YYYY):', 'medication_date_2', array("class"=>'col-sm-12'));   ?>
												<div class="input-group date">
													<?php echo form_input("medication_date_2", $claim_details["medication_date_2"], array("class" => "form-control datepicker", 'placeholder' => 'Date (MM/DD/YYYY)')); ?>
													<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
												</div>
											</div>
											<div class="col-sm-3">
												<?php echo form_label('Medication:', 'medication_2', array("class" => 'col-sm-12')); ?>
												<?php echo form_input("medication_2", $claim_details["medication_2"], array("class" => "form-control", 'placeholder' => 'Medication')); ?>
											</div>
										</div>
										<div class="form-group col-sm-12">
											<div class="col-sm-3">
												<?php echo form_label('Date (MM/DD/YYYY):', 'medication_date_3', array("class"=>'col-sm-12'));   ?>
												<div class="input-group date">
													<?php echo form_input("medication_date_3", $claim_details["medication_date_3"], array("class" => "form-control datepicker", 'placeholder' => 'Date (MM/DD/YYYY)')); ?>
													<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
												</div>
											</div>
											<div class="col-sm-3">
												<?php echo form_label('Medication:', 'medication_3', array("class" => 'col-sm-12')); ?>
												<?php echo form_input("medication_3", $claim_details["medication_3"], array("class" => "form-control", 'placeholder' => 'Medication')); ?>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<h2 class="move_down">
							Payee Information
							<?php if($edit): ?>
							<button class="btn btn-primary add_payee" name="filter" type="button" value="claim">Add a Payees</button>
							<?php endif; ?>
							<i class="fa fa-angle-down pull-right"></i>
						</h2>
						<div class="row" style="display: none">
							<div class="col-sm-12">
								<div class="payee-data">
									<?php if (! empty($payees)) : ?>
									<?php $i = 0; ?>
									<?php foreach ( $payees as $key => $value ) : ?>
									<?php $i ++; ?>
									<div class="row" style="border: 1px solid rgb(204, 204, 204); padding: 10px; margin-bottom: 9px">
										<div class="col-sm-12">
											<div class="col-sm-2">
												<?php echo form_radio("payment_type_" . $i, "cheque", ($value ["payment_type"] == 'cheque' ? TRUE : FALSE), array('class' => 'setpremium')); ?>
												<?php echo form_label('Cheque:', 'Cheque'); ?>
											</div>
											<div class="col-sm-2">
												<?php echo form_radio("payment_type_" . $i, "direct deposit", ($value ["payment_type"] == 'direct deposit' ? TRUE : FALSE), array('class' => 'setpremium')); ?>
												<?php echo form_label('Direct Deposit', 'Direct Deposit'); ?>
												<?php echo form_hidden('payees[id][]', $value ['id']); ?>
											</div>
										</div>
										<br />
										<div class="col-sm-3 wire_transfer_section" <?php echo ($value["payment_type"] <> 'direct deposit'?'style="display:none"':''); ?>>
											<?php echo form_label('Bank Name:', 'Bank Name', array("class" => 'col-sm-12')); ?>
											<?php echo form_input("payees[bank][]", $value ["bank"], array("class" => "form-control", 'placeholder' => 'Bank Name')); ?>
										</div>
										<div class="col-sm-3 cheque_section wire_transfer_section">
											<?php echo form_label('Payee Name:', 'Payee Name', array("class" => 'col-sm-12')); ?>
											<?php echo form_input("payees[payee_name][]", $value ["payee_name"], array("class" => "form-control required", 'placeholder' => 'Payee Name')); ?>
										</div>
										<div class="col-sm-3 wire_transfer_section" <?php echo ($value["payment_type"] <> 'direct deposit'?'style="display:none"':''); ?>>
											<?php echo form_label('Account#:', 'Account', array("class" => 'col-sm-12')); ?>
											<?php echo form_input("payees[account_cheque][]", $value ["account_cheque"], array("class" => "form-control", 'placeholder' => 'Account#')); ?>
										</div>
										<div class="col-sm-3 cheque_section" <?php echo ($value["payment_type"] == 'direct deposit'?'style="display:none"':''); ?>>
											<label for="Address" class="col-sm-12">Address: &nbsp;&nbsp;<span class='payee_policy_addr'><i class="fa fa-copy"></i> use policy address</span></label>
											<?php echo form_input("payees[address][]", $value ["address"], array("class" => "form-control " . ($value ["payment_type"] == 'direct deposit' ? '' : 'required'), 'placeholder' => 'Address')); ?>
										</div>
										<?php if($edit): ?>
										<div class="col-sm-3"><label class='col-sm-12'>&nbsp;</label> <i class="col-sm-3 fa fa-trash row-link remove-payee"></i></div>
										<?php endif;?>
									</div>
									<?php endforeach; ?>
									<?php endif; ?>
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
									<?php if (! empty($expenses_claimed)) : ?>
									<?php $this->load->model('expenses_model'); ?>
									<?php foreach ( $expenses_claimed as $key => $value ) : ?>
									<?php  if ($value['status'] === Expenses_model::EXPENSE_STATUS_Paid) { ?>
									<div class="row" style="border: 1px solid rgb(204, 204, 204); padding: 10px;">
										<div class="col-sm-3">
											<?php echo form_label('Invoice#:', 'invoice', array("class" => 'col-sm-12')); ?>
											<?php echo $value ['invoice']; ?>
											<?php echo form_hidden("expenses_claimed[invoice][]", $value['invoice']); ?>
											<?php echo form_hidden('expenses_claimed[id][]', $value['id']); ?>
										</div>
										<div class="col-sm-3">
											<?php echo form_label('Name of Provider:', 'provider_name', array("class" => 'col-sm-12')); ?>
											<?php echo $value['provider_name']; ?>
											<?php echo form_hidden("expenses_claimed[provider_name][]", $value ['provider_name']); ?>
										</div>
										<div class="col-sm-3">
											<?php echo form_label('Name of Referring Physician:', 'referencing_physician', array("class" => 'col-sm-12')); ?>
											<?php echo $value['referencing_physician']; ?>
											<?php echo form_hidden("expenses_claimed[referencing_physician][]", $value ['referencing_physician']); ?>
										</div>
										<div class="col-sm-3">
											<?php echo form_label('Coverage Code:', 'coverage_code', array("class" => 'col-sm-12')); ?>
											<?php echo $value['coverage_code']; ?>
											<?php echo form_hidden("expenses_claimed[coverage_code][]", $value['coverage_code']); ?>
										</div>
										<div class="clearfix"></div>

										<!-- div class="col-sm-3">
											<?php echo form_label('Diagnosis:', 'diagnosis', array("class" => 'col-sm-12')); ?>
											<?php echo $value['diagnosis']; ?>
											<?php echo form_hidden("expenses_claimed[diagnosis][]", $value ['diagnosis']); ?>
										</div -->
										<div class="col-sm-3">
											<?php echo form_label('Description of Services:', 'service_description', array("class" => 'col-sm-12')); ?>
											<?php echo $value['service_description']; ?>
											<?php echo form_hidden("expenses_claimed[service_description][]", $value ['service_description']); ?>
										</div>
										<div class="col-sm-3">
											<?php echo form_label('Date of Service:', 'date_of_service', array("class" => 'col-sm-12')); ?>
											<?php echo $value['date_of_service']; ?>
											<?php echo form_hidden("expenses_claimed[date_of_service][]", $value ['date_of_service']); ?>
										</div>
										<div class="col-sm-3">
											<?php echo form_label('Amount Billed:', 'amount_billed', array("class" => 'col-sm-12')); ?>
											<?php echo $value['amount_billed_org']; ?>
											<?php echo form_hidden("expenses_claimed[amount_billed_org][]", $value ['amount_billed_org']); ?>
											<?php echo form_hidden("expenses_claimed[amount_billed][]", $value ['amount_billed']); ?>
										</div>
										<div class="clearfix"></div>

										<div class="col-sm-3">
											<?php echo form_label('Amount Client Paid:', 'amount_client_paid', array("class" => 'col-sm-12')); ?>
											<?php echo $value['amount_client_paid_org']; ?>
											<?php echo form_hidden("expenses_claimed[amount_client_paid_org][]", $value ['amount_client_paid_org']); ?>
											<?php echo form_hidden("expenses_claimed[amount_client_paid][]", $value ['amount_client_paid']); ?>
										</div>
										<div class="col-sm-3">
											<?php echo form_label('Amount Claimed:', 'amount_claimed', array("class" => 'col-sm-12')); ?>
											<?php echo $value["amount_claimed_org"]; ?>
											<?php echo form_hidden("expenses_claimed[amount_claimed_org][]", $value ["amount_claimed_org"]); ?>
											<?php echo form_hidden("expenses_claimed[amount_claimed][]", $value ["amount_claimed"]); ?>
										</div>
										<div class="col-sm-3">
											<?php echo form_label('Payee:', 'payee', array("class" => 'col-sm-12')); ?>
											<?php echo $value["pay_to"]; ?>
											<?php echo form_hidden("expenses_claimed[pay_to][]", $value ["pay_to"]); ?>
											<?php echo form_hidden("expenses_claimed[payee][]", $value ["payee"]); ?>
										</div>
										<div class="col-sm-3">
											<?php echo form_label('currency:', 'currency', array("class" => 'col-sm-12')); ?>
											<?php echo $value ['currency']; ?>
											<?php echo form_hidden('expenses_claimed[currency][]', $value ['currency']); ?>
										</div>
										<div class="clearfix"></div>

										<!-- div class="col-sm-3">
											<?php echo form_label('Comment:', 'comment', array("class" => 'col-sm-12')); ?>
											<?php echo $value ['comment']; ?>
											<?php echo form_hidden("expenses_claimed[comment][]", $value ['comment']); ?>
										</div -->
									</div>
									<?php  } else { ?>
									<div class="row" style="border: 1px solid rgb(204, 204, 204); padding: 10px;">
										<div class="col-sm-3">
											<?php echo form_label('Invoice#:', 'invoice', array("class" => 'col-sm-12')); ?>
											<?php echo form_input("expenses_claimed[invoice][]", $value ['invoice'], array("class" => "form-control")); ?>
											<?php echo form_hidden('expenses_claimed[id][]', $value ['id']); ?>
										</div>
										<div class="col-sm-3">
											<?php echo form_label('Name of Provider:', 'provider_name', array("class" => 'col-sm-12')); ?>
											<?php echo form_input("expenses_claimed[provider_name][]", $value ['provider_name'], array("class" => "form-control required")); ?>
										</div>
										<div class="col-sm-3">
											<?php echo form_label('Name of Referring Physician:', 'referencing_physician', array("class" => 'col-sm-12')); ?>
											<?php echo form_input("expenses_claimed[referencing_physician][]", $value ['referencing_physician'], array("class" => "form-control")); ?>
										</div>
										<div class="col-sm-3">
											<?php echo form_label('Coverage Code:', 'coverage_code', array("class" => 'col-sm-12')); ?>
											<select name="expenses_claimed[coverage_code][]" class="form-control required">
												<option value="0">-- Select Coverage Code --</option>
												<?php foreach ($expenses_list as $key => $val): ?>
												<option value="<?php echo $key; ?>" <?php if ($key == $value ["coverage_code"]) { echo "selected"; } ?>><?php echo $val; ?></option>
												<?php endforeach; ?>
											</select>
										</div>
										<div class="clearfix"></div>

										<!-- div class="col-sm-3">
											<?php echo form_label('Diagnosis:', 'diagnosis', array("class" => 'col-sm-12')); ?>
											<?php echo form_input("expenses_claimed[diagnosis][]", $value ['diagnosis'], array("class" => "form-control autocomplete_field required")); ?>
										</div -->
										<div class="col-sm-3">
											<?php echo form_label('Description of Services:', 'service_description', array("class" => 'col-sm-12')); ?>
											<?php echo form_input("expenses_claimed[service_description][]", $value ['service_description'], array("class" => "form-control required")); ?>
										</div>
										<div class="col-sm-3">
											<?php echo form_label('Date of Service:', 'date_of_service', array("class" => 'col-sm-12')); ?>
											<?php echo form_input("expenses_claimed[date_of_service][]", $value ['date_of_service'], array("class" => "form-control  datepicker required")); ?>
										</div>
										<div class="col-sm-3">
											<?php echo form_label('Amount Billed:', 'amount_billed_org', array("class" => 'col-sm-12')); ?>
											<?php echo form_input("expenses_claimed[amount_billed_org][]", $value ['amount_billed_org'], array("class" => "form-control required")); ?>
											<?php echo form_hidden("expenses_claimed[amount_billed][]", $value ['amount_billed']); ?>
											<?php echo form_error("amount_billed_org"); ?>
										</div>
										<div class="clearfix"></div>

										<div class="col-sm-3">
											<?php echo form_label('Amount Client Paid:', 'amount_client_paid_org', array("class" => 'col-sm-12')); ?>
											<?php echo form_input("expenses_claimed[amount_client_paid_org][]", $value ['amount_client_paid_org'], array("class" => "form-control required")); ?>
											<?php echo form_hidden("expenses_claimed[amount_client_paid][]", $value ['amount_client_paid']); ?>
											<?php echo form_error("amount_client_paid_org"); ?>
										</div>
										<div class="col-sm-3">
											<?php echo form_label('Amount Claimed:', 'amount_claimed_org', array("class" => 'col-sm-12')); ?>
											<?php echo form_input("expenses_claimed[amount_claimed_org][]", $value ["amount_claimed_org"], array("class" => "form-control required")); ?>
											<?php echo form_hidden("expenses_claimed[amount_claimed][]", $value ["amount_claimed"]); ?>
											<?php echo form_error("amount_claimed_org"); ?>
										</div>
										<div class="col-sm-3">
											<?php echo form_label('Payee:', 'payee', array("class" => 'col-sm-12')); ?>
											<select name="expenses_claimed[payee][]" class="form-control required">
												<?php foreach ( $payees as $pkey => $payee ) { ?> 
												<option value="<?php echo $pkey; ?>" <?php echo (($pkey == $value['pay_to']) ? "Selected" : ""); ?>><?php echo $payee['payee_name']; ?></option>
												<?php } ?>
											</select>
											<?php echo form_hidden("expenses_claimed[pay_to][]", $value ["pay_to"]); ?>
										</div>
										<div class="col-sm-3">
											<?php echo form_label('currency:', 'currency', array("class" => 'col-sm-12')); ?>
											<?php if (empty($arr['currency'][$key])) { $arr['currency'][$key] = 'CAD'; } ?>
											<select name="expenses_claimed[currency][]" class="form-control required">
												<?php foreach ($currencies as $currency ) { ?>
												<option value="<?php echo $currency['name']; ?>" <?php echo ($value ['currency'] == $currency['name']) ? 'selected' : ''; ?>><?php echo $currency['name']; ?></option>
												<?php } ?>
											</select>
										</div>
										<div class="clearfix"></div>

										<!-- div class="col-sm-3">
											<?php echo form_label('Comment:', 'comment', array("class" => 'col-sm-12')); ?>
											<?php echo form_input("expenses_claimed[comment][]", $value ['comment'], array("class" => "form-control")); ?>
										</div -->
										
										<?php if($edit): ?>
										<div class="col-sm-3 pull-right"><i class="fa fa-trash row-link remove_claim" style="padding-top: 33px;"></i></div>
										<?php endif; ?>
									</div>
									<?php  } ?>
									<?php endforeach; ?>
									<?php endif; ?>
								</div>
							</div>
							<?php if($edit): ?>
							<button class="btn btn-primary add_new_expenses" type="button">Add new expenses item</button><br />
							<?php endif; ?>
						</div>
						
						<?php if(!empty($intake_forms)): ?>
						<!-- Intake Forms List Section -->
						<br />
						<h2 class="modal-title intake-heading move_down">Notes: <i class="fa fa-angle-down pull-right"></i></h2>
						<div class="row intake-forms-list col-sm-12" style="display: none">
							<?php $i = 0; ?>
							<?php foreach ( $intake_forms as $key => $value ) : ?>
							<?php $i ++; ?>
							<div class="col-sm-12 intake-forms">
								<div class="col-sm-2">
									<div class="col-sm-12"><?php echo $i.". #".$value['user_id']?></div>
									<div class="col-sm-12"><?php echo $value['created_by']?></div>
									<div class="col-sm-12"><?php echo $value['created']; ?></div>
								</div>
								<div class="col-sm-10">
									<div class="col-sm-12"><?php echo $value['notes'] ?></div>
									<div class="form-group col-sm-11 files">
										<br />
										<?php $files = $value ['docs'] ? explode(",", $value ['docs']) : array(); ?>
										<?php if (! empty($files)) : ?>
										<?php foreach ( $files as $file ) : ?>
										<div class="col-sm-9" style="">
											<span class="file-label"><?php echo anchor("file/".$file . '__' . $value['id'], $file, array('target'=>'_blank')); ?></span>
											<?php echo anchor("file/" . $file . '__' . $value['id'], '<i class="fa fa-search row-link"></i>', array('target'=>'_blank', 'title'=>'Browse File')); ?>
											<?php echo anchor("download/" . $file . '__' . $value['id'], '<i class="fa fa-download row-link"></i>', array('title'=>'Download File')); ?>
										</div>
										<?php endforeach; ?>
										<?php endif; ?>
									</div>
									<div class="col-sm-1&quot;"><i class="fa fa-remove row-link remove-form pull-right" alt="<?php echo $value['id']; ?>"></i></div>
								</div>
							</div>
							<?php endforeach; ?>
						</div>
						<input type="hidden" name="no_of_form" value="0" />
						<!-- used to knnow how many forms added in this page -->
						<!-- end intake forms list  -->
						<?php endif; ?>
						<h2 class="move_down">
							Attached List
							<?php if($edit): ?>
							<button class="btn btn-primary multiupload_files" type="button">Upload Attached</button>
							<?php endif; ?>
							<i class="fa fa-angle-down pull-right"></i>
						</h2>
						<div class="row" style="display: none">
							<div class="col-sm-12">
								<div class="col-sm-12 uploaded_files">
									<?php $files = $claim_details ['files'] ? explode(",", $claim_details ['files']) : array(); ?>
									<?php if (! empty($files)) : ?>
									<?php foreach ( $files as $file ) : ?>
									<div class="col-sm-9" style="">
										<span class="file-label"><?php echo anchor("file_claim/".$file . '__' . $claim_details['id'], $file, array('target'=>'_blank')); ?></span>
										<?php echo anchor("file_claim/" . $file . '__' . $claim_details['id'], '<i class="fa fa-search row-link"></i>', array('target'=>'_blank', 'title'=>'Browse File')); ?>
										<?php echo anchor("claim_doc_download/" . $file . '__' . $claim_details['id'], '<i class="fa fa-download row-link"></i>', array('title'=>'Download File')); ?>
										<?php echo anchor("claim_doc_delete/" . $file . '__' . $claim_details['id'], '<i class="fa fa-trash row-link remove_doc"></i>', array('title'=>'Delete File')); ?>
									</div>
									<?php endforeach; ?>
									<?php endif; ?>
								</div>
								<div class="col-sm-3">&nbsp;</div>
							</div>
						</div>
						<br />
						<div class="row">
							<div class="col-sm-3">
								<?php echo form_label('Processing Status:', 'status', array("class" => 'col-sm-12')); ?>
								<?php echo !empty($status_list[$claim_details["status"]]) ? $status_list[$claim_details["status"]] : 'N / A'; /* echo form_dropdown("status", $status_list, $claim_details["status"], array("class" => 'form-control')); */?>
							</div>
							<div class="col-sm-3">
								<?php echo form_label('Examiner:', 'assign_to', array("class" => 'col-sm-12')); ?>
								<?php echo $examiner_email; ?>
							</div>
						</div>
					</div>

					<div class="row" style="margin-top: 20px">
						<div class="row">
							<?php if($edit): ?>
							<div class="col-sm-2">
								<input class="btn btn-primary" name="Save" value="Save" type="submit">
							</div>
							<div class="col-sm-2">
								<?php echo anchor("claim", "Cancel", array("class"=>'btn btn-primary')); ?>
							</div>
							<?php if ($this->ion_auth->in_group(array(Users_model::GROUP_ADMIN, Users_model::GROUP_EXAMINER))) { ?>
							<div class="col-sm-2">
								<?php echo anchor('claim/examine_claim/'.$claim_details['id'], 'Examine', array('class'=>'btn btn-primary'))?>
							</div>
							<?php } ?>
							<?php if (0 && !$this->ion_auth->in_group(array(Users_model::GROUP_INSURER))) { ?>
							<div class="col-sm-2">
								<input class="btn btn-primary email_print" data-toggle="modal" name="Email" value="Email/Print" type="button" data-target="#print_template">
							</div>
							<?php } ?>
							<?php else: ?>
							<div class="col-sm-2">
								<?php echo anchor("claim", "Cancel", array("class"=>'btn btn-primary')); ?>
							</div>
							<?php endif; ?>
						</div>
					</div>
					<?php echo form_close(); ?>
				</div>
			</div>
		</div>
	</div>
</div>

<style>
.autocomplete-suggestions { width: 603px !important; }
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
			<?php echo form_open_multipart("claim/send_print_email_claim", array("id" => 'send_print_email')); ?>
			<div class="modal-body ">
				<div class="row">
					<div class="col-sm-6">
						<div>
							<label for="mail_label" class="col-sm-2">Mail Addres:</label>
							<div class="form-group col-sm-6">
								<input name="priority" value="HIGH" id="mail_address" class="col-sm-1" type="checkbox"> <label for="mail_address" class="col-sm-10 pull-right" style="margin-top: 3px;">Use same ddress with the policy</label>
							</div>
						</div>
						<div>
							<?php echo form_label('To:', 'email', array("class" => 'col-sm-12')); ?>
							<div class="form-group col-sm-12">
								<?php echo form_input("email", "", array("class" => "form-control col-sm-6 form-group email required", 'placeholder' => 'Email Address')); ?>
								<?php echo form_hidden('type', 'email'); // used for which action need to perform "email or deny claim" ?>
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
							<div class="col-sm-12 doc_title">
								<?php echo heading($doc['name']); ?>
							</div>
							<div class="col-sm-12 doc-desc">
								<?php $find = array('{otc_logo}', '{otc_logo_big}', '{current_date}'); ?>
								<?php $replace = array(img(array('src' => 'assets/img/otc.jpg', 'width' => '130')), img(array('src' => 'assets/img/otc_big.jpg', 'width' => '262')), date("F d, Y")); ?>
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
						<div class="form-group col-sm-12">
							<?php echo date("Y-m-d"); ?>
						</div>
					</div>
					<div class="form-group col-sm-12">
						<?php echo form_label('Note:', 'intake_notes', array("class" => 'col-sm-12')); ?>
						<?php echo form_textarea("intake_notes", $this->input->post("intake_notes"), array("class" => "form-control", 'placeholder' => 'Note', 'style' => "height:100px")); ?>
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
		<div class="row"
			style="border: 1px solid rgb(204, 204, 204); padding: 10px;">
			<div class="col-sm-3">
				<?php echo form_label('Invoice#:', 'invoice', array("class" => 'col-sm-12')); ?>
				<?php echo form_input("expenses_claimed[invoice][]", $this->input->post("invoice"), array("class" => "form-control")); ?>
			</div>
			<div class="col-sm-3">
				<?php echo form_label('Name of Provider:', 'provider_name', array("class" => 'col-sm-12')); ?>
				<?php echo form_input("expenses_claimed[provider_name][]", $this->input->post("provider_name"), array("class" => "form-control required")); ?>
			</div>
			<div class="col-sm-3">
				<?php echo form_label('Name of Referring Physician:', 'referencing_physician', array("class" => 'col-sm-12')); ?>
				<?php echo form_input("expenses_claimed[referencing_physician][]", $this->input->post("referencing_physician"), array("class" => "form-control")); ?>
			</div>
			<div class="col-sm-3">
				<?php echo form_label('Coverage Code:', 'coverage_code', array("class" => 'col-sm-12')); ?>
				<select name="expenses_claimed[coverage_code][]" class="form-control required">
					<option value="0">-- Select Coverage Code --</option>
					<?php foreach ($expenses_list as $key => $val): ?>
					<option value="<?php echo $key; ?>" <?php if ($key == $this->input->post("coverage_code")) { echo "selected"; } ?>><?php echo $val; ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			<div class="clearfix"></div>

			<!-- div class="col-sm-3">
				<?php echo form_label('Diagnosis:', 'diagnosis', array("class" => 'col-sm-12')); ?>
				<?php echo form_input("expenses_claimed[diagnosis][]", $this->input->post("diagnosis"), array("class" => "form-control autocomplete_field required")); ?>
			</div -->
			<div class="col-sm-3">
				<?php echo form_label('Description of Services:', 'service_description', array("class" => 'col-sm-12')); ?>
				<?php echo form_input("expenses_claimed[service_description][]", $this->input->post("service_description"), array("class" => "form-control required")); ?>
			</div>
			<div class="col-sm-3">
				<?php echo form_label('Date of Service:', 'date_of_service', array("class" => 'col-sm-12')); ?>
				<?php echo form_input("expenses_claimed[date_of_service][]", $this->input->post("date_of_service"), array("class" => "form-control  datepicker required")); ?>
			</div>
			<div class="col-sm-3">
				<?php echo form_label('Amount Billed:', 'amount_billed', array("class" => 'col-sm-12')); ?>
				<?php echo form_input("expenses_claimed[amount_billed_org][]", $this->input->post("amount_billed_org"), array("class" => "form-control required")); ?>
				<?php echo form_hidden("expenses_claimed[amount_billed][]", $this->input->post("amount_billed")); ?>
			</div>
			<div class="clearfix"></div>

			<div class="col-sm-3">
				<?php echo form_label('Amount Client Paid:', 'amount_client_paid', array("class" => 'col-sm-12')); ?>
				<?php echo form_input("expenses_claimed[amount_client_paid_org][]", $this->input->post("amount_client_paid_org"), array("class" => "form-control required")); ?>
				<?php echo form_hidden("expenses_claimed[amount_client_paid][]", $this->input->post("amount_client_paid")); ?>
			</div>
			<div class="col-sm-3">
				<?php echo form_label('Amount Claimed:', 'amount_claimed', array("class" => 'col-sm-12')); ?>
				<?php echo form_input("expenses_claimed[amount_claimed_org][]", $this->input->post("amount_claimed_org"), array("class" => "form-control required")); ?>
				<?php echo form_hidden("expenses_claimed[amount_claimed][]", $this->input->post("amount_claimed")); ?>
			</div>
			<div class="col-sm-3">
				<?php echo form_label('Payee:', 'payee', array("class" => 'col-sm-12')); ?>
				<select name="expenses_claimed[payee][]" class="form-control required">
					<option value="">--Select Payee--</option>
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
				<?php echo form_input("expenses_claimed[comment][]", $this->input->post("comment"), array("class" => "form-control")); ?>
			</div -->

			<div class="col-sm-3 pull-right">
				<i class="fa fa-trash row-link remove_claim" style="padding-top: 33px;"></i>
			</div>
		</div>
	</div>
</div>
<div style="display: none">
	<div class="payee-buffer">
		<div class="row" style="border: 1px solid rgb(204, 204, 204); padding: 10px; margin-bottom: 9px">
			<div class="col-sm-12">
				<div class="col-sm-2">
					<?php echo form_radio("payment_type", "cheque", TRUE, array('class' => 'setpremium')); ?>
					<?php echo form_label('Cheque:', 'Cheque'); ?>
				</div>
				<div class="col-sm-2">
					<?php echo form_radio("payment_type", "direct deposit", FALSE, array('class' => 'setpremium')); ?>
					<?php echo form_label('Direct Deposit', 'Direct Deposit'); ?>
					<?php echo form_hidden('payees[id][]', ''); ?>
				</div>
			</div>
			<br />
			<div class="col-sm-3 wire_transfer_section" style="display: none">
				<?php echo form_label('Bank Name:', 'Bank Name', array("class" => 'col-sm-12')); ?>
				<?php echo form_input("payees[bank][]", $this->input->post("bank"), array("class" => "form-control", 'placeholder' => 'Bank Name')); ?>
			</div>
			<div class="col-sm-3 cheque_section wire_transfer_section">
				<?php echo form_label('Payee Name:', 'Payee Name', array("class" => 'col-sm-12')); ?>
				<?php echo form_input("payees[payee_name][]", $this->input->post("payee_name"), array("class" => "form-control", 'placeholder' => 'Payee Name')); ?>
			</div>
			<div class="col-sm-3 wire_transfer_section" style="display: none">
				<?php echo form_label('Account#:', 'Account', array("class" => 'col-sm-12')); ?>
				<?php echo form_input("payees[account_cheque][]", $this->input->post("account_cheque"), array("class" => "form-control", 'placeholder' => 'Account#')); ?>
			</div>
			<div class="col-sm-3 cheque_section">
				<label for="Address" class="col-sm-12">Address: &nbsp;&nbsp;<span class='payee_policy_addr'><i class="fa fa-copy"></i> use policy address</span></label>
				<?php echo form_input("payees[address][]", $this->input->post("address"), array("class" => "form-control", 'placeholder' => 'Address')); ?>
			</div>
			<div class="col-sm-3">
				<label class='col-sm-12'>&nbsp;</label> <i class="col-sm-3 fa fa-trash row-link remove-payee"></i>
			</div>
		</div>
	</div>
</div>

<!-- prepare expenses list used to fill in explanation of benifit doc -->
<div style="display: none" id="claim-items">
	<table style="margin-bottom: 14px;" width="100%" border="1">
		<thead>
			<tr>
				<th>Service Description</th>
				<th>Date of Service</th>
				<th>Claim Amount</th>
				<th>Payable Amount</th>
				<th>Claim Notes</th>
			</tr>
		</thead>
		<tbody>
			<?php if (! empty($expenses_claimed)) : ?>
			<?php  $claim_total = $payable = 0; ?>
			<?php foreach ( $expenses_claimed as $key => $value ) : ?>
			<?php  $claim_total += $value ['amount_claimed']; ?>
			<?php  $payable += $value ['amt_payable']; ?>
			<tr>
				<td><?php echo $value['service_description'] ?></td>
				<td><?php echo $value['date_of_service'] ?></td>
				<td><?php echo $value['amount_claimed'] ?></td>
				<td>$<?php echo $value['amt_payable'] ?></td>
				<td><?php echo $value['comment'] ?></td>
			</tr>
			<?php endforeach; ?>
			<?php else : ?>
			<tr>
				<td colspan="20">No records available</td>
			</tr>
			<?php endif; ?>
			<tr>
				<td></td>
				<th>Totals:</th>
				<td>$<?php  echo $claim_total; ?></td>
				<td>$<?php  echo $payable; ?></td>
				<td></td>
			</tr>
		</tbody>
	</table>
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
		// get policy data
		<?php $policy_info = json_decode($claim_details ['policy_info'], TRUE); ?>

		// show area once any error occured
		$(".alert-error").map(function(){
			if($(this).text()){
				$(this).closest('.row').show();
				$(this).closest('.row').prev('.move_down').children('i').removeClass('fa-angle-down').addClass('fa-angle-up');
			}
		})

      // fill autofill on key type
      .on("keyup", ".company_name input", function(){
         $(".company_name input").val($(this).val());
      })
      
      $("select[name='expenses_claimed[payee][]']").change(function(){
         $(this).next('input').val($(this).val());
      })
      
      // select default payee
      $("input[name='expenses_claimed[payee_id][]']").map(function(){
         $(this).prev('select').val($(this).val());
      })

      $("input[name='expenses_claimed[pay_to][]']").map(function(){
         $(this).prev('select').val($(this).val());
      })
      
      $(".datepicker").datepicker({
           startDate: '-105y',
           endDate: '+2y',
       });

      $(".dob").datepicker({
           startDate: '-105y',
           endDate: '0',
       });
   })
   .on("click",".more_filters", function(){
      $(".more_items").toggle();
   })

   // to load, show/hide contents
   .on("click", ".move_down", function(){
      $(this).next("div.row").slideToggle();
      $(this).children("i").toggleClass("fa-angle-up").toggleClass("fa-angle-down");
   })

   // fuzzy search
   //.on("click", ".autocomplete_field", function() {
   //   $(".autocomplete_field").autocomplete({
   //     serviceUrl: "<?php echo base_url()."claim/search_diagnosis/description"; ?>" ,
   //     minLength: 2,
   //     dataType: "json",
   //   });
   // })

   // once user clicked over add new expenses button
   .on("click", ".add_new_expenses", function(e){
      var html = $(".base-row").html();
      $(".expenses-list").append(html);
      //$(".autocomplete_field").autocomplete({
      //  serviceUrl: "<?php echo base_url()."claim/search_diagnosis/description"; ?>" ,
      //  minLength: 2,
      //  dataType: "json",
      //});
      $(".datepicker").datepicker({
           startDate: '-105y',
           endDate: '+2y',
       });


      $(this).parent('.move_down').next('.row').show();

      $(this).next('i').removeClass('fa-angle-down').addClass('fa-angle-up');
      e.stopPropagation()
   })

   // once user clicked over remove claim function
   .on("click", ".remove_claim", function(){

      if(confirm('Are you sure you want to remove claim item?')){
         $(this).parent("div").parent("div").remove();

         // remove payee from db if already stored
         var id = $(this).parent("div").parent("div").find("input[name='expenses_claimed[id][]']").val();
         if(id){
            $.ajax({
               url: "<?php echo base_url("claim/delete_claim_item/") ?>"+id,
               method: "get"
            })
         }
      }
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
	.on("click", ".payee_policy_addr", function() {
		var addr = $(this).closest("div").find("input[name='payees[address][]']");
		var data = $.parseJSON(localStorage.getItem("policy_data"));
		addr.val(data[0].street_number+" "+data[0].street_name + data[0].city + ", " + data[0].province2 + " " + data[0].postcode);
	})

   .on("click", ".remove-payee", function(){

      if(confirm('Are you sure you want to remove payee?')){
         $(this).parent("div").parent("div").remove();

         // remove payee from db if already stored
         var payee_id = $(this).parent("div").parent("div").find("input[name='payees[id][]']").val();
         if(payee_id){
            $.ajax({
               url: "<?php echo base_url("claim/delete_payee/") ?>"+payee_id,
               method: "get"
            })
         }
      }

      // settings to reload payees list on expenses items
      var html = "<option value=''>--Select Payee--</option>";
      $("input[name='payees[payee_name][]']").each(function(){
         if($(this).val())
            html += '<option value="'+$(this).val()+'">'+$(this).val()+'</option>';
      })

      $("select[name='expenses_claimed[payee][]']").html(html);

      // select default payee
      $("input[name='expenses_claimed[payee_id][]']").map(function(){
         $(this).prev('select').val($(this).val());
      })

      $("input[name='expenses_claimed[pay_to][]']").map(function(){
         $(this).prev('select').val($(this).val());
      })
      
      // remap payment_type names to avoide errors
      $count = 0;
      $(".payee-data .row").map(function(){
         $count++;
         $(this).find('input[name^=payment_type]').attr('name', 'payment_type_'+$count);
      })
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
      .replace("{claimexaminer_name}", '<?php echo $this->ion_auth->user()->row()->first_name . " " . $this->ion_auth->user()->row()->last_name; ?>')
      .replace("{current_date_+_90}", '<?php echo date('Y-m-d', strtotime(' + 90 days')) ?>')

      .replace("{clinic_name}", $("input[name=clinic_name]").val())
      .replace("{insured_dob}", $("input[name=dob]").val())
      .replace("{insured_diagnosis}", $("input[name='expenses_claimed[diagnosis][]']").val())

      .replace("{policy_holder}", $("input[name=insured_first_name]").val()+' '+$("input[name=insured_last_name]").val())
      .replace("{coverage_period}", "<?php echo @$policy_info[0]['effective_date']." to ".@$policy_info[0]['expiry_date'] ?>");

      $(".doc-"+id+" .doc-desc").html(str);

      // reset all edit//preview section
      $(".preview-template").text("Preview").removeClass("active-preview");

      // enable disable buttons
      $(".print").attr("disabled", "disabled");
      $(".preview-template, .email-intakeform").removeAttr("disabled");
   })

   .on("click", ".email_print", function(){
         $("input[name=type]").val("email");
         $(".email-intakeform").text("Email");
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
      var no_of_form = $(".intake-forms").length + 1;

      // add new file here
      $(".uploaded_files").append('<div class="col-sm-9"  style="display:none" ><input style="display:none" type="file" name="files_multi[]" id="file'+(count+1)+'" accept="pdf" /><span class="file-label"></span> <i class="fa fa-trash row-link" id="'+(count+1)+'"></i></div>');

      // place trigger clicked once file append in files class
      $('#file'+(count+1)).trigger("click");
   })

   // delete intake form
   .on("click",".fa.fa-remove.row-link.remove-form.pull-right", function(){
      var id = $(this).attr("alt");

      if(confirm('Are you sure you want to delete?'))
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

   // once user clicked on same with policy button
   .on("click", "#mail_address", function(){
      if($(this).is(":checked"))
      {
         // fill all json values to address fields
         $("input[name=email]").val('<?php echo @$policy_info[0]['contact_email'] ?>');
         $("input[name=street_no_email]").val('<?php echo @$policy_info[0]['street_number'] ?>');
         $("input[name=street_name_email]").val('<?php echo @$policy_info[0]['street_name'] ?>');
         $("input[name=city_email]").val('<?php echo @$policy_info[0]['city'] ?>');
         $("select[name=province_email]").val('<?php echo @$policy_info[0]['province2'] ?>');
      }
      else
      {
         $("input[name=street_no_email],input[name=street_name_email],input[name=city_email],select[name=province_email]").val("");
      }
   })
   // delete attached document
   .on("click",".remove_doc", function(e){

      e.preventDefault();

      var link = $(this).parent('a').attr("href");

      if(confirm('Are you sure you want to delete? '))
      {
         // remove form area instant to make it visible fast
         $(this).parent("a").parent("div").remove();

         $.ajax({
            url: link,
            method: "get"
         })
      } else {
         return false;
      }
   })

   // once user click over save intake form, we are just hold every value untill case is not submitted
   .on("click", '.save-intakeform', function(){

      // check notes field filled or not
      if(!$("textarea[name=intake_notes]").val())
      {
         alert("Please add note first.")
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

   .on("click", ".edit_claim", function(){
      var data = $.parseJSON($(this).attr("attr"));

      // place all values to input fields
      $.each(data, function( index, value ) {
         $(".edit-claim-item input[name="+index+"]").val(value);
         $(".edit-claim-item select[name="+index+"]").val(value);
      });

      // change label
      $(".claim-label").text("Edit Claim("+(data.claim_no?data.claim_no:'#####')+") No."+data.count);

      $(".edit-claim-item").show();
   })

   .on("submit", "#save_item", function(e){
      e.preventDefault();
      var href = $(this).attr("action");
      $.ajax({
            url: href,
            method: "post",
            data:$(this).serialize(),
            beforeSend: function(){
               $(".modal-content").addClass("csspinner load1");
            },
            success: function() {
               window.location.reload();
            }
         })
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
            url: "<?php echo base_url("claim/send_print_email_claim") ?>",
            method: "post",
            data:{
               email:$("#send_print_email input[name=email]").val(),
               street_no:$("#send_print_email  input[name=street_no_email]").val(),
               street_name:$("#send_print_email  input[name=street_name_email]").val(),
               city:$("#send_print_email  input[name=city_email]").val(),
               province:$("#send_print_email  select[name=province_email]").val(),
               template:template,
               case_id: "<?php echo $claim_details['id']; ?>",
               doc: $("#send_print_email .select-doc.active").text(),
               type: $("#send_print_email input[name=type]").val()
            },
            beforeSend: function(){
               $(".modal-content").addClass("csspinner load1");
            },
            success: function() {
               window.location.reload();
            }
         })
      }
   })

   // once user clicked on accept button
   .on("click", "input[name=Accept]", function(){
      if(confirm('Are you sure you want to accept claim?')){

         $.ajax({
            url: "<?php echo base_url("claim/status/accept") ?>",
            method: "post",
            data:{
               claim_id:"<?php echo $claim_details['id']; ?>",
            },
            beforeSend: function(){
               $(".main_container").addClass("csspinner load1");
            },
            success: function() {
               // redirect to payment page
               window.location = "<?php echo base_url("claim/payments?claim=".$claim_details['id']); ?>";
            }
         })
      } else {
         return false;
      }
   })

   // when clicked over deny button
   .on("click", "input[name=Deny]", function(){
      $(".deny_reasons").show();
   })

   // when user select any deny reason
   .on("change", "select[name=reason]", function(){
      if($(this).val()) {
          if(confirm('Are you sure you want to deny claim?')){

            // change email button label
            $(".email-intakeform").text("Email and Deny Claim");

            // deny claim and close its details
            $("input[name=type]").val("deny");
            $('#print_template').modal('show');
            $("div[doc="+$(this).val()+"]").trigger('click');
         } else {
            return false;
         }
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

      // select default payee
      $("input[name='expenses_claimed[payee_id][]']").map(function(){
         $(this).prev('select').val($(this).val());
      })

      $("input[name='expenses_claimed[pay_to][]']").map(function(){
          $(this).prev('select').val($(this).val());
       })
       
   })

   // to check unique payee name
   .on("change", "input[name='payees[payee_name][]']", function(){
      // check all payees name here
      var val = $(this).val();
      if(val){
         var counter = 0;
         $("input[name='payees[payee_name][]']").each(function(){
            if($(this).val() == val)
               counter++;
         })
         if(counter > 1){
            alert("payee name already exists, please try different name.");
            $(this).val("");
            return false;
         }
      }

      // select default payee
      $("input[name='expenses_claimed[payee_id][]']").map(function(){
         $(this).prev('select').val($(this).val());
      })

      $("input[name='expenses_claimed[pay_to][]']").map(function(){
          $(this).prev('select').val($(this).val());
       })
       
   })


// create input boxes where the requirement need
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

var $outer_select = $(".select-product");
$outer_select.each(function(){
   var text = $.trim($(this).text());

   $(this).empty();
   $(this).append($("#products").html());
});

$(".claim-items").html($("#claim-items").html())

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
   $("#main_form .required").map(function(o){
      if(!$(this).val()){
         $validate = 0;
         $(this).addClass('error-true');
      }
      else {
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


         $(this).closest('.row').parent('.expenses-list').closest('.row').show();
         $(this).closest('.row').parent('.expenses-list').closest('.row').prev('.move_down').children('i').removeClass('fa-angle-down').addClass('fa-angle-up');
      })

      return false;
   }
   return true;
}

</script>
