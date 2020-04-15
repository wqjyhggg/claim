<div .on("keyup", ".company_nameinput", function(){ $(".company_nameinput").val($(this).val()); }) >
	<div class="page-title">
		<div class="title_left">
			<h3>Eclaim - ID#<?php echo $eclaim['id']; ?></h3>
      </div>
	  <span style="float: right; margin-right: 8rem; margin-top: 1rem;"><?php echo anchor("eclaim/export/".$eclaim['id'], "Print", "target='_blank'"); ?></span>
	</div>
	<div class="clearfix"></div>
	<!-- Policy search and List Section -->
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<?php echo $message; ?>
				<div class="x_title">
					<h2>Trip Cancellation and Intrruption Claim Details</h2>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<?php echo form_open("eclaim/create_claim", array('class'=>'form-horizontal', 'method'=>'post', 'id'=>'main_form')); ?>
					<div class="case_info">
						<h4 class="move_down">SECTION A: INSURED’S INFORMATION <i class="fa fa-angle-down pull-right"></i></h4>
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
							<div class="col-sm-3" style='display:none;'>
								<?php echo form_label('ID', 'id', array("class" => 'col-sm-12')); ?>
								<?php echo form_input("personal_id", "", array("class" => "form-control", 'placeholder' => 'ID')); ?>
								<?php echo form_error("personal_id"); ?>
							</div>
							<div class="form-group col-sm-3">
								<?php echo form_label('Date of Birth:', 'dob', array("class"=>'col-sm-12'));   ?>
								<div class="input-group date">
									<?php echo form_input("dob", $eclaim["dob"], array("class" => "form-control dob required", 'placeholder' => 'Date of Birth')); ?>
									<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
								</div>
								<?php echo form_error("dob"); ?>
							</div>
							<div class="clearfix"></div>

							<div class="form-group col-sm-3">
								<?php echo form_label('Second Insured First Name:', 'exinfo_insured2_first_name', array("class" => 'col-sm-12')); ?>
								<?php echo form_input("exinfo[insured2_first_name]", isset($eclaim["exinfo_insured2_first_name"]) ? $eclaim["exinfo_insured2_first_name"] : '', array("class" => "form-control", 'placeholder' => 'Second Insured First Name')); ?>
							</div>
							<div class="col-sm-3">
								<?php echo form_label('Second Insured Last Name:', 'exinfo_insured2_last_name', array("class" => 'col-sm-12')); ?>
								<?php echo form_input("exinfo[insured2_last_name]", isset($eclaim["exinfo_insured2_last_name"]) ? $eclaim["exinfo_insured2_last_name"] : '', array("class" => "form-control", 'placeholder' => 'Insured Last Name' )); ?>
							</div>
							<div class="col-sm-3">
								<div class="col-sm-4">
									<?php echo form_label('&nbsp;', 'gender', array("class" => 'col-sm-12')); ?>
									<?php echo form_radio("exinfo[gender2]", "male", isset($eclaim["exinfo_gender2"]) ? $eclaim["exinfo_gender2"] : '', array('class' => 'setpremium')); ?> Male
								</div>
								<div class="col-sm-5">
									<?php echo form_label('&nbsp;', 'gender', array("class" => 'col-sm-12')); ?>
									<?php echo form_radio("exinfo[gender2]", "female", isset($eclaim["exinfo_gender2"]) ? $eclaim["exinfo_gender2"] : '', array('class' => 'setpremium'));?> Female
								</div>
							</div>
							<div class="form-group col-sm-3">
								<?php echo form_label('Date of Birth:', 'exinfo_dob2', array("class"=>'col-sm-12')); ?>
								<div class="input-group date">
									<?php echo form_input("exinfo[dob2]", isset($eclaim["exinfo_dob2"]) ? $eclaim["exinfo_dob2"] : '', array("class" => "form-control dob", 'placeholder' => 'Date of Birth')); ?>
									<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
								</div>
							</div>
							<div class="clearfix"></div>

							<div class="form-group col-sm-3">
								<?php echo form_label('Policy#:', 'policy_no', array("class" => 'col-sm-12')); ?>
								<?php echo form_input("policy_no", $eclaim["policy_no"], array("class" => "form-control required", 'placeholder' => 'Policy#', 'readonly' => 'readonly')); ?>
								<?php echo form_error("policy_no"); ?>
								<?php echo form_hidden("id", $eclaim['id']); ?>
								<?php echo form_hidden("exinfo_type", 'top_trip'); ?>
								<?php echo form_hidden("product_short", $eclaim['product_short']); ?>
							</div>
							<div class="form-group col-sm-3" style='display:none;'>
								<?php echo form_label('School Name:', 'school_name', array("class" => 'col-sm-12')); ?>
								<?php echo form_input("school_name", $eclaim["school_name"], array("class" => "form-control", 'placeholder' => 'School Name')); ?>
								<?php echo form_error("school_name"); ?>
							</div>
							<div class="form-group col-sm-3" style='display:none;'>
								<?php echo form_label('Group ID:', 'group_id', array("class" => 'col-sm-12')); ?>
								<?php echo form_input("group_id", $eclaim["group_id"], array("class" => "form-control", 'placeholder' => 'Group ID')); ?>
								<?php echo form_error("group_id"); ?>
							</div>
							<div class="form-group col-sm-3" style='display:none;'>
								<?php echo form_label('Enroll Date:', 'apply_date', array("class"=>'col-sm-12')); ?>
								<div class="input-group date">
									<?php echo form_input("apply_date", $policy["apply_date"], array("class" => "form-control datepicker",'placeholder' => 'Enroll Date')); ?>
									<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
								</div>
							</div>
							<div class="form-group col-sm-3" style='display:none;'>
								<?php echo form_label('Arrival Date in Canada:', 'arrival_date', array("class"=>'col-sm-12')); ?>
								<div class="input-group date">
									<?php echo form_input("arrival_date", $eclaim["arrival_date"], array("class" => "form-control datepicker", 'placeholder' => 'Arrival Date in Canada')); ?>
									<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
								</div>
							</div>
							<div class="form-group col-sm-3" style='display:none;'>
								<?php echo form_label('Full Name of Guardian if applicable:', 'guardian_name', array("class" => 'col-sm-12')); ?>
								<?php echo form_input("guardian_name", $eclaim["guardian_name"], array("class" => "form-control", 'placeholder' => 'Full Name of Guardian if applicable')); ?>
							</div>
							<div class="form-group col-sm-3" style='display:none;'>
								<?php echo form_label('Guardian Phone#:', 'guardian_phone', array("class" => 'col-sm-12')); ?>
								<?php echo form_input("guardian_phone", $eclaim["guardian_phone"], array("class" => "form-control", 'placeholder' => 'Guardian Phone#')); ?>
							</div>
							<div class="clearfix"></div>
							
							<h4 class="subTitle">Address in Canada </h4>
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
								<?php echo form_label('PostCode:', 'post_code', array("class" => 'col-sm-12')); ?>
								<?php echo form_input("post_code", $eclaim["post_code"], array("class" => "form-control", 'placeholder' => 'PostCode')); ?>
							</div>
							<div class="form-group col-sm-3">
								<?php echo form_label('Destination:', 'exinfo_destination', array("class" => 'col-sm-12')); ?>
								<?php echo form_input("exinfo[destination]", isset($eclaim["exinfo_destination"]) ? $eclaim["exinfo_destination"] : '', array("class" => "form-control", 'placeholder' => 'Destination')); ?>
							</div>
							<div class="form-group col-sm-3">
								<?php echo form_label('Telephone:', 'telephone', array("class" => 'col-sm-12')); ?>
								<?php echo form_input("telephone", $eclaim["telephone"], array("class" => "form-control", 'placeholder' => 'Telephone')); ?>
							</div>
							<div class="form-group col-sm-3">
								<?php echo form_label('Fax:', 'exinfo_fax', array("class" => 'col-sm-12')); ?>
								<?php echo form_input("exinfo[fax]", isset($eclaim["exinfo_fax"]) ? $eclaim["exinfo_fax"] : '', array("class" => "form-control", 'placeholder' => 'Fax')); ?>
							</div>
							<div class="form-group col-sm-3">
								<?php echo form_label('Email:', 'email', array("class" => 'col-sm-12')); ?>
								<?php echo form_input("email", $eclaim["email"], array("class" => "form-control", 'placeholder' => 'Email')); ?>
							</div>
							<div class="form-group col-sm-3" style="display: none">
								<?php echo form_label('Date of Arrival in Canada:', 'arrival_date_canada', array("class"=>'col-sm-12')); ?>
								<div class="input-group date">
									<?php echo form_input("arrival_date_canada", $eclaim["arrival_date_canada"], array("class" => "form-control datepicker",'placeholder' => 'Date of Arrival in Canada')); ?>
									<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
								</div>
							</div>
							<div class="form-group col-sm-3" style="display: none">
								<?php echo form_label('Cellular:', 'cellular', array("class" => 'col-sm-12')); ?>
								<?php echo form_input("cellular", $eclaim["cellular"], array("class" => "form-control", 'placeholder' => 'Cellular')); ?>
							</div>
							<div class="form-group col-sm-3">
								<?php echo form_label('Date of Departure:', 'exinfo_depature_date', array("class"=>'col-sm-12')); ?>
								<div class="input-group date">
									<?php echo form_input("exinfo[depature_date]", isset($eclaim["exinfo_depature_date"]) ? $eclaim["exinfo_depature_date"] : '', array("class" => "form-control datepicker", 'placeholder' => 'Date of Depature')); ?>
									<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
								</div>
							</div>
							<div class="form-group col-sm-3">
								<?php echo form_label('Date of Return:', 'exinfo_return_date', array("class"=>'col-sm-12')); ?>
								<div class="input-group date">
									<?php echo form_input("exinfo[return_date]", isset($eclaim["exinfo_return_date"]) ? $eclaim["exinfo_return_date"] : '', array("class" => "form-control datepicker", 'placeholder' => 'Date of Return')); ?>
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
									<option value="Trip Cancellation" <?php if ('Trip Cancellation' == $eclaim["exinfo_loss_type"]) { echo "selected"; } ?>>Trip Cancellation</option>
									<option value="Trip Intrruption" <?php if ('Trip Intrruption' == $eclaim["exinfo_loss_type"]) { echo "selected"; } ?>>Trip Intrruption</option>
									<option value="Delays" <?php if ('Delays' == $eclaim["exinfo_loss_type"]) { echo "selected"; } ?>>Delays</option>
								</select>
							</div>
							<div class="clearfix"></div>
							<div class="form-group col-sm-3">
								If loss is due to sickness, please provide details: 
							</div>
							<div class="form-group col-sm-9">
								<?php echo form_input("exinfo[sickness]", isset($eclaim["exinfo_sickness"]) ? $eclaim["exinfo_sickness"] : '', array("class" => "form-control")); ?>
							</div>
							<div class="clearfix"></div>
							<div class="form-group col-sm-3">
								Date symptoms or injury first appeared: 
							</div>
							<div class="form-group col-sm-3">
								<div class="input-group date">
									<?php echo form_input("exinfo[injury1_date]", isset($eclaim["exinfo_injury1_date"]) ? $eclaim["exinfo_injury1_date"] : '', array("class" => "form-control datepicker")); ?>
									<?php echo form_hidden("date_symptoms", isset($eclaim["exinfo_injury1_date"]) ? $eclaim["exinfo_injury1_date"] : ''); ?>
									<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
								</div>
							</div>
							<div class="clearfix"></div>
							<div class="form-group col-sm-3">
								Date you first saw physician for this condition: 
							</div>
							<div class="form-group col-sm-3">
								<div class="input-group date">
									<?php echo form_input("exinfo[physician_date]", isset($eclaim["exinfo_physician_date"]) ? $eclaim["exinfo_physician_date"] : '', array("class" => "form-control datepicker")); ?>
									<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
								</div>
							</div>
							<div class="clearfix"></div>
							<div class="form-group col-sm-3">
								If loss is due to injury, please provide details: 
							</div>
							<div class="form-group col-sm-9">
								<?php echo form_input("exinfo[injury_details]", isset($eclaim["exinfo_injury_details"]) ? $eclaim["exinfo_injury_details"] : '', array("class" => "form-control")); ?>
							</div>
							<div class="clearfix"></div>
							<div class="form-group col-sm-3">
								Describe how the injury/accident occured: 
							</div>
							<div class="form-group col-sm-9">
								<?php echo form_input("exinfo[injury_describe]", isset($eclaim["exinfo_injury_describe"]) ? $eclaim["exinfo_injury_describe"] : '', array("class" => "form-control")); ?>
							</div>
							<div class="clearfix"></div>
							<div class="form-group col-sm-3">
								Date of injury/accident: 
							</div>
							<div class="form-group col-sm-3">
								<div class="input-group date">
									<?php echo form_input("exinfo[injury_date]", isset($eclaim["exinfo_injury_date"]) ? $eclaim["exinfo_injury_date"] : '', array("class" => "form-control datepicker")); ?>
									<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
								</div>
							</div>
							<div class="clearfix"></div>
							<div class="form-group col-sm-3">
								If loss is due to death, please provide details: 
							</div>
							<div class="form-group col-sm-9">
								<?php echo form_input("exinfo[death_describe]", isset($eclaim["exinfo_death_describe"]) ? $eclaim["exinfo_death_describe"] : '', array("class" => "form-control")); ?>
							</div>
							<div class="clearfix"></div>
							<div class="form-group col-sm-3">
								Date of death: 
							</div>
							<div class="form-group col-sm-3">
								<div class="input-group date">
									<?php echo form_input("exinfo[death_date]", isset($eclaim["exinfo_death_date"]) ? $eclaim["exinfo_death_date"] : '', array("class" => "form-control datepicker")); ?>
									<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
								</div>
							</div>
							<div class="clearfix"></div>
							<div class="form-group col-sm-3">
								Cause of death: 
							</div>
							<div class="form-group col-sm-3">
								<?php echo form_input("exinfo[death_cause]", isset($eclaim["exinfo_death_cause"]) ? $eclaim["exinfo_death_cause"] : '', array("class" => "form-control")); ?>
							</div>
							<div class="clearfix"></div>
							<div class="form-group col-sm-3">
								Your relationship to sick, injured or deceased person: 
							</div>
							<div class="form-group col-sm-3">
								<?php echo form_input("exinfo[relation]", isset($eclaim["exinfo_relation"]) ? $eclaim["exinfo_relation"] : '', array("class" => "form-control")); ?>
							</div>
							<div class="clearfix"></div>
							<div class="form-group col-sm-3">
								Name of patient or deceased: 
							</div>
							<div class="form-group col-sm-3">
								<?php echo form_input("exinfo[patient_name]", isset($eclaim["exinfo_patient_name"]) ? $eclaim["exinfo_patient_name"] : '', array("class" => "form-control")); ?>
							</div>
							<div class="clearfix"></div>
							<h4>Name and Address of patient’s usual Family Physician</h4>
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
									<?php  echo form_error("physician_city"); ?>
								</div>
								<div class="form-group col-sm-3">
									<?php echo form_label('Country:', 'country', array("class" => 'col-sm-12')); ?>
									<select name="country" class="form-control">
										<option value=""> -- Select Country -- </option>
										<?php foreach ($country as $key => $val): ?>
										<option value="<?php echo $key; ?>" <?php if (($key == $eclaim["country"]) || ($val == $eclaim['country'])) { echo "selected"; } ?>><?php echo $val; ?></option>
										<?php endforeach; ?>
									</select>
								</div>
								<div class="form-group col-sm-3">
									<?php echo form_label('Postal Code:', 'physician_post_code', array("class" => 'col-sm-12')); ?>
									<?php echo form_input("physician_post_code", $eclaim["physician_post_code"], array("class" => "form-control", 'placeholder' => 'Postal Code')); ?>
								</div>
								<div class="form-group col-sm-3">
									<?php echo form_label('Telephone:', 'physician_telephone', array("class" => 'col-sm-12')); ?>
									<?php echo form_input("physician_telephone", $eclaim["physician_telephone"], array("class" => "form-control", 'placeholder' => 'Telephone')); ?>
									<?php echo form_error("physician_telephone"); ?>
								</div>
								<div class="form-group col-sm-3">
									<?php echo form_label('Alt Telephone:', 'physician_alt_telephone', array("class" => 'col-sm-12')); ?>
									<?php echo form_input("physician_alt_telephone", $eclaim["physician_alt_telephone"], array("class" => "form-control", 'placeholder' => 'Alt Telephone')); ?>
									<?php echo form_error("physician_alt_telephone"); ?>
								</div>
							</div>
							<div class="clearfix"></div>
	
							<h4 class="subTitle">Name and Address of any other physician who may have treated the patient in the last 12 months</h4>
							<div class="col-sm-12">
								<div class="form-group col-sm-3">
									<?php echo form_label('Name:', 'physician_name_canada', array("class" => 'col-sm-12')); ?>
									<?php echo form_input("physician_name_canada", $eclaim["physician_name_canada"], array("class" => "form-control", 'placeholder' => 'Name')); ?>
									<?php echo form_error("physician_name_canada"); ?>
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
									<?php echo form_error("physician_city_canada"); ?>
								</div>
								<div class="form-group col-sm-3">
									<?php echo form_label('Postal Code:', 'physician_post_code_canada', array("class" => 'col-sm-12')); ?>
									<?php echo form_input("physician_post_code_canada", $eclaim["physician_post_code_canada"], array("class" => "form-control", 'placeholder' => 'Postal Code')); ?>
								</div>
								<div class="form-group col-sm-3">
									<?php echo form_label('Telephone:', 'physician_telephone_canada', array("class" => 'col-sm-12')); ?>
									<?php echo form_input("physician_telephone_canada", $eclaim["physician_telephone_canada"], array("class" => "form-control", 'placeholder' => 'Telephone')); ?>
									<?php echo form_error("physician_telephone_canada"); ?>
								</div>
								<div class="form-group col-sm-3">
									<?php echo form_label('Alt Telephone:', 'physician_alt_telephone_canada', array("class" => 'col-sm-12')); ?>
									<?php echo form_input("physician_alt_telephone_canada", $eclaim["physician_alt_telephone_canada"], array("class" => "form-control", 'placeholder' => 'Alt Telephone')); ?>
									<?php echo form_error("physician_alt_telephone_canada"); ?>
								</div>
							</div>
							<div class="form-group col-sm-6">
								If loss is due to other circumstances, please provide description of loss: 
							</div>
							<div class="form-group col-sm-6">
								<?php echo form_input("exinfo[circumstances]", isset($eclaim["exinfo_circumstances"]) ? $eclaim["exinfo_circumstances"] : '', array("class" => "form-control")); ?>
							</div>
							<div class="clearfix"></div>
							<div class="form-group col-sm-3">
								Date the loss first occured: 
							</div>
							<div class="form-group col-sm-3">
								<div class="input-group date">
									<?php echo form_input("exinfo[occured_date]", isset($eclaim["exinfo_occured_date"]) ? $eclaim["exinfo_occured_date"] : '', array("class" => "form-control datepicker")); ?>
									<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
								</div>
							</div>
							<div class="clearfix"></div>
							<div class="form-group col-sm-3">
								Date you cancelled with travel agent/travel supplier: 
							</div>
							<div class="form-group col-sm-3">
								<div class="input-group date">
									<?php echo form_input("exinfo[cancelled_date]", isset($eclaim["exinfo_cancelled_date"]) ? $eclaim["exinfo_cancelled_date"] : '', array("class" => "form-control datepicker")); ?>
									<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
								</div>
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

						<h2 class="move_down">SECTION D: OTHER INSURANCE COVERAGE <small></small><i class="fa fa-angle-down pull-right"></i></h2>
						<div class="row" style="display: none">
							<div class="col-sm-5">Do you have credit card insurance coverage?</div>
							<div class="col-sm-1">
								<?php echo form_radio("exinfo[credit_card_insurance]", "Y", isset($eclaim['exinfo_credit_card_insurance']) ? $eclaim['exinfo_credit_card_insurance'] : '', array('class' => 'setpremium'));?> Yes
							</div>
							<div class="col-sm-1">
								<?php echo form_radio("exinfo[credit_card_insurance]", "N", isset($eclaim['exinfo_credit_card_insurance']) ? $eclaim['exinfo_credit_card_insurance'] : '', array('class' => 'setpremium'));?> No
							</div>
							<div class="col-sm-5">If ‘Yes’, please provide the following information</div>
							<div class="clearfix"></div>
	
							<div class="form-group col-sm-3">
								Name of the financial Institution: 
							</div>
							<div class="form-group col-sm-9">
								<?php echo form_input("exinfo[credit_card_name]", isset($eclaim["exinfo_credit_card_name"]) ? $eclaim["exinfo_credit_card_name"] : '', array("class" => "form-control")); ?>
							</div>
	
							<div class="form-group col-sm-3">
								First 6 digits of credit card: 
							</div>
							<div class="form-group col-sm-3">
								<?php echo form_input("exinfo[credit_card_number]", isset($eclaim["exinfo_credit_card_number"]) ? $eclaim["exinfo_credit_card_number"] : '', array("class" => "form-control")); ?>
							</div>
	
							<div class="form-group col-sm-3">
								Expiry Date(MM/YYYY): 
							</div>
							<div class="form-group col-sm-3">
								<?php echo form_input("exinfo[credit_card_expire]", isset($eclaim["exinfo_credit_card_expire"]) ? $eclaim["exinfo_credit_card_expire"] : '', array("class" => "form-control")); ?>
							</div>
	
							<div class="form-group col-sm-3">
								Name of Cardholder: 
							</div>
							<div class="form-group col-sm-3">
								<?php echo form_input("exinfo[credit_card_holder]", isset($eclaim["exinfo_credit_card_holder"]) ? $eclaim["exinfo_credit_card_holder"] : '', array("class" => "form-control")); ?>
							</div>
							<div class="clearfix"></div>
							<div class="col-sm-12">
								Do you have insurance benefits available through group insurance or any other source? <input type="checkbox" name="exinfo[group_insurance]" value="1" <?php if (! empty($eclaim["exinfo_group_insurance"])) { echo "checked"; } ?>> Yes. If 'yes', please provide details below:_
							</div>
							<div class="col-sm-12">
								Group Insurance
							</div>
							<div class="form-group col-sm-6">
								<?php echo form_label('Name and Address of Insurance Company:', 'exinfo_group_insurance', array("class" => 'col-sm-12')); ?>
								<?php echo form_input("exinfo[group_insurance]", isset($eclaim["exinfo_group_insurance_company"]) ? $eclaim["exinfo_group_insurance_company"] :'', array("class" => "form-control", 'placeholder' => 'Name and Address of Insurance Company')); ?>
							</div>
							<div class="form-group col-sm-3">
								<?php echo form_label('Policy #:', 'exinfo_group_insurance_policy', array("class" => 'col-sm-12')); ?>
								<?php echo form_input("exinfo[group_insurance_policy]", isset($eclaim["exinfo_group_insurance_policy"]) ? $eclaim["exinfo_group_insurance_policy"] : '', array("class" => "form-control", 'placeholder' => 'Policy #')); ?>
							</div>
							<div class="form-group col-sm-3">
								<?php echo form_label('Telephone:', 'exinfo_group_insurance_phone', array("class" => 'col-sm-12')); ?>
								<?php echo form_input("exinfo[group_insurance_phone]", isset($eclaim["exinfo_group_insurance_phone"]) ? $eclaim["exinfo_group_insurance_phone"] : '', array("class" => "form-control", 'placeholder' => 'Telephone')); ?>
							</div>
							<div class="col-sm-12">
								Other Travel Insurance
							</div>
							<div class="form-group col-sm-6">
								<?php echo form_label('Name and Address of Insurance Company:', 'exinfo[other_travel_insurance]', array("class" => 'col-sm-12')); ?>
								<?php echo form_input("exinfo[other_insurance_name]", isset($eclaim["exinfo_other_insurance_name"]) ? $eclaim["exinfo_other_insurance_name"] : '', array("class" => "form-control", 'placeholder' => 'Name and Address of Insurance Company')); ?>
							</div>
							<div class="form-group col-sm-3">
								<?php echo form_label('Policy #:', 'exinfo_other_travel_insurance_policy', array("class" => 'col-sm-12')); ?>
								<?php echo form_input("exinfo[other_insurance_number]", isset($eclaim["exinfo_other_insurance_number"]) ? $eclaim["exinfo_other_insurance_number"] : '', array("class" => "form-control", 'placeholder' => 'Policy #')); ?>
							</div>
							<div class="form-group col-sm-3">
								<?php echo form_label('Telephone:', 'exinfo_other_travel_insurance_phone', array("class" => 'col-sm-12')); ?>
								<?php echo form_input("exinfo[other_insurance_phone]", isset($eclaim["exinfo_other_insurance_phone"]) ? $eclaim["exinfo_other_insurance_phone"] : '', array("class" => "form-control", 'placeholder' => 'Telephone')); ?>
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

										<div class="col-sm-12">If yes, provide details of other insurance company coverage below. If no, confirm by checking the box below.</div>
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
						<div class="row intake-forms-list col-sm-12" style="display: none">
							<div class="col-sm-12 intake-forms">
								<div class="expenses-list">
									<!-- list all expenses items list here -->
									<?php
									$expenses_claimed_service_descriptions = json_decode($eclaim["expenses_claimed_service_description"], TRUE);
									$expenses_claimed_provider_names = json_decode($eclaim["expenses_claimed_provider_name"], TRUE);
									$expenses_claimed_referencing_physicians = json_decode($eclaim["expenses_claimed_referencing_physician"], TRUE);
									$expenses_claimed_date_of_services = json_decode($eclaim["expenses_claimed_date_of_service"], TRUE);
									$expenses_claimed_amount_client_paid_orgs = json_decode($eclaim["expenses_claimed_amount_client_paid_org"], TRUE);
									$expenses_claimed_amount_claimed_orgs = json_decode($eclaim["expenses_claimed_amount_claimed_org"], TRUE);
									if (!empty($expenses_claimed_service_descriptions)) :
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
											<?php echo form_input("expenses_claimed_amount_claimed_org[]", $expenses_claimed_amount_claimed_orgs[$key]); ?>
										</div>
										<div class="clearfix"></div>
									</div>
									<?php endforeach; ?>
									<?php endif; ?>
								</div>
							</div>
						</div>
						<h2 class="modal-title intake-heading move_down">Sign: <i class="fa fa-angle-down pull-right"></i></h2>
						<div class="row intake-forms-list col-sm-12" style="display: none">
							<div class="col-sm-12 intake-forms">
								<div class="col-sm-12">
									<?php echo $eclaim['sign_name']; ?>
								</div>
								<div class="col-sm-12">
									<img class="img-responsive" src="<?php echo base_url('assets/uploads/') . $eclaim_files[$eclaim['sign_image']]['path'] . "/" . $eclaim_files[$eclaim['sign_image']]['name']; ?>">
								</div>
							</div>
						</div>
						<br />
						<h2 class="move_down">
							Attached Images
							<i class="fa fa-angle-down pull-right"></i>
						</h2>
						<div class="row" style="display: none">
							<div class="col-sm-12">
								<div class="col-sm-12 uploaded_files">
									<?php $images = json_decode($eclaim['imgfile'], TRUE); ?>
									<?php foreach ( $images as $key => $value ) : ?>
									<div class="col-sm-12 intake-forms">
										<div class="col-sm-12">
											<img class="img-responsive" src="<?php echo base_url('assets/uploads/') . $eclaim_files[$value]['path'] . "/" . $eclaim_files[$value]['name']; ?>">
										</div>
									</div>
									<?php endforeach; ?>
								</div>
								<div class="col-sm-3">&nbsp;</div>
							</div>
						</div>
						<br />
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
							<div class="col-sm-2">
								<input class="btn btn-primary" name="Save" value="Save as Claim" type="submit">
							</div>
							<div class="col-sm-2">
								<input class="btn btn-primary" name="Refuse" value="Refuse Claim" type="button">
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
	if (confirm('Are you sure you want to accept Eclaim?')) {
		e.preventDefault();
		$.ajax({
				url: "<?php echo base_url("eclaim/disapprove/".$eclaim['id']); ?>",
				method:"post",
				data:$('#main_form').serialize(),
				dataType: "json",
				success: function(data) {
					if (data.status == 1) {
						window.location = "<?php echo base_url("eclaim"); ?>";
					}
				}
			})
	} else {
		return false;
	}
})
</script>
