<style>
.modal-lg { width: 75%; }
.outer-text { margin: 0; }
</style>
<div>
	<div class="page-title">
		<div class="title_left">
			<h3>Case Information <?php if (isset($case_details['case_no'])) { echo " - #" . $case_details['case_no']; } ?></h3>
			<?php
			if ($hasclaim) {
				echo anchor('claim/claim_detail/'.$case_details['id'], '<i class="fa fa-book"></i> Go to Claim', array("class"=>'btn btn-primary'));
			} else {
			if (($this->ion_auth->in_group(array(Users_model::GROUP_ADMIN, Users_model::GROUP_CLAIMER, Users_model::GROUP_EXAMINER))) && empty($case_details['claim_no']) && !empty($case_details['policy_no'])) {
				echo anchor('claim/create_claim?policy='.$case_details['policy_no'].'&case_no='.$case_details['case_no'].'&product_short='.$case_details['product_short'].'&firstname='.urlencode($case_details['insured_firstname']).'&lastname='.urlencode($case_details['insured_lastname']).'&birthday='.urlencode($case_details['dob']).'&gender='.(($case_details["gender"] == 'female') ? 'F' : 'M'), '<i class="fa fa-plus-circle"></i> Create Claim', array("class"=>'btn btn-primary'));
			}
			}
			?>   
      </div>
	</div>
	<div class="clearfix"></div>

	<!-- Policy search and List Section -->
	<div class="row">
		<?php echo $message; ?>
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Case Details</h2>
					<?php if (!empty($case_details['claim_no'])) { echo anchor("claim/claim_detail/".$case_details['id'], 'Claim Info <i class="fa fa-link"></i>', array("class"=>'btn btn-primary pull-right')); } ?>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<!-- search policy filter start -->
					<?php echo form_open('emergency_assistance/edit_case/'.$case_details['id'].'?ref='.$this->input->get('ref'), array('class'=>'form-horizontal')); ?>
					<h4 class="move_down">Assistance Client Info <i class="fa fa-angle-down pull-right"></i></h4>
					<div class="row" style="margin-bottom: 15px;">
						<div class="form-group col-sm-4">
							<?php echo form_label('Policy Number:', 'policy_no', array("class"=>'col-sm-12')); ?>
							<?php echo form_input("policy_no", $case_details["policy_no"], array("class"=>"form-control", 'placeholder'=>'Policy Number')); ?>
							<?php echo form_error("policy_no"); ?>
							<?php echo form_hidden('policy_info', $case_details['policy_info']); ?>
							<?php echo form_hidden('product_short', $case_details['product_short']); ?>
							<?php echo form_hidden('totaldays', $case_details['totaldays']); ?>
							<?php echo form_hidden('agent_id', $case_details['agent_id']); ?>
						</div>
						<div class="form-group col-sm-4">
							<?php echo form_label('Insured Name:', 'insured_name', array("class"=>'col-sm-12')); ?>
							<div class="form-group col-sm-6">
								<?php echo form_input("insured_firstname", $case_details["insured_firstname"], array("class"=>"form-control col-sm-6", 'placeholder'=>'Insured First Name')); ?>
								<?php echo form_error("insured_firstname");?>
							</div>
							<div class="form-group col-sm-6">
								<?php echo form_input("insured_lastname", $case_details["insured_lastname"], array("class"=>"form-control col-sm-6", 'placeholder'=>'Insured Last Name')); ?>
								<?php echo form_error("insured_lastname"); ?>
							</div>
						</div>
						<div class="form-group col-sm-2">
							<?php echo form_label('Gender', 'gender', array("class" => 'col-sm-12')); ?>
							<select name="gender" class="form-control">
								<option value="male"  <?php if ($case_details["gender"] != 'female') { echo "selected"; } ?>>Male</option>
								<option value="female"  <?php if ($case_details["gender"] == 'female') { echo "selected"; } ?>>Female</option>
							</select>
						</div>
						<div class="form-group col-sm-2">
							<?php echo form_label('Date of Birth:' . (($customer_ages>0) ? ' (Age: ' . $customer_ages . ' )' : ''), 'dob', array("class"=>'col-sm-12')); ?>
							<div class="input-group date">
								<?php echo form_input("dob", $case_details["dob"], array("class"=>"form-control datepicker", 'placeholder'=>'Date of Birth')); ?>
								<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
							</div>
							<?php echo form_error("dob"); ?>
						</div>
						<div class="clearfix"></div>
						<div class="form-group col-sm-6">
							<div class="col-sm-4">
							<?php echo form_label('Departure Date:', 'Departure') ?>
							</div>
							<div class="input-group date col-sm-8">
								<?php echo form_input("departure_date", $case_details["departure_date"], array("class"=>"form-control datepicker", 'placeholder'=>'Departure Date')); ?><span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
							</div>
						</div>
						<div class="clearfix"></div>
						<?php if (!empty($policy)) { ?>
            <div class="form-group col-sm-3"><?php echo form_label('Apply Date:', 'Apply') . $policy['apply_date']; ?></div>
						<div class="form-group col-sm-3"><?php echo form_label('Arrived Date:', 'Arrived') . $policy['arrival_date']; ?></div>
						<div class="form-group col-sm-3"><?php echo form_label('Effective Date:', 'Effective') . $policy['effective_date']; ?></div>
						<div class="form-group col-sm-3"><?php echo form_label('Expired Date:', 'Expired') . $policy['expiry_date']; ?></div>
						<div class="form-group col-sm-4"><?php echo form_label('Sum Insured:', 'Sum Insured') . '$' . number_format($policy['sum_insured'], 2); ?></div>
						<div class="form-group col-sm-4"><?php echo form_label('Deductible:', 'Deductible') . '$' . number_format($policy['deductible_amount'], 2); ?></div>
						<?php if (!empty($policy['stable_condition'])) { ?>
						<div class="form-group col-sm-4"><?php echo ($policy['stable_condition'] == 1) ? 'Including stable pre-existing condition coverage' : 'Excluding stable pre-existing condition coverage'; ?></div>
						<?php } ?>
						<?php } ?>
					</div>
					<h4>Case Basic Info option</h4>
					<div class="row">
						<div class="form-group col-sm-4">
							<?php echo form_label('Case Number:', 'case_no', array("class"=>'col-sm-12')); ?>
							<div class="form-group col-sm-12"><?php echo $case_details['case_no']; ?></div>
							<?php echo form_error("case_no"); ?>
						</div>
						<div class="form-group col-sm-4">
							<?php echo form_label('Create Date:', 'created', array("class"=>'col-sm-12')); ?>
							<div class="form-group col-sm-12"><?php echo date("Y-m-d", strtotime($case_details['created'])); ?></div>
						</div>
						<div class="form-group col-sm-4">
							<?php echo form_label('Created By:', 'created_by', array("class"=>'col-sm-12')); ?>
							<div class="form-group col-sm-12"><?php echo $created_email; ?></div>
						</div>
						<div class="form-group col-sm-4">
							<?php echo form_label('Assigned To:', 'assign_to_email', array("class"=>'col-sm-12')); ?>
							<div class="form-group col-sm-12"><?php echo $assign_to_email; ?></div>
						</div>
						<div class="form-group col-sm-4">
							<?php echo form_label('Case catagory:', 'reason', array("class"=>'col-sm-12')); ?>
							<select name="reason" class="form-control">
								<option value="">-- Select Catagory --</option>
								<?php foreach ($reasons as $rc) { ?>
								<option value="<?php echo $rc; ?>" <?php if ($rc == $case_details['reason']) { echo "selected"; } ?>><?php echo $rc; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<h4>Visiting Address</h4>
					<div class="row">
						<div class="form-group col-sm-2">
							<?php echo form_label('Street No.:', 'street_no', array("class"=>'col-sm-12')); ?>
							<?php echo form_input("street_no", $case_details['street_no'], array("class"=>"form-control", 'placeholder'=>'Street No.')); ?>
							<?php echo form_error("street_no"); ?>
						</div>
						<div class="form-group col-sm-4">
							<?php echo form_label('Street Name.:', 'street_name', array("class"=>'col-sm-12')); ?>
							<?php echo form_input("street_name", $case_details["street_name"], array("class"=>"form-control", 'placeholder'=>'Street Name.')); ?>
							<?php echo form_error("street_name"); ?>
						</div>
						<div class="form-group col-sm-2">
							<?php echo form_label('Suite No.:', 'suite_number', array("class"=>'col-sm-12')); ?>
							<?php echo form_input("suite_number", $case_details['suite_number'], array("class"=>"form-control", 'placeholder'=>'Suite No.')); ?>
							<?php echo form_error("suite_number"); ?>
						</div>
						<div class="form-group col-sm-4">
							<?php echo form_label('City:', 'city', array("class"=>'col-sm-12')); ?>
							<?php echo form_input("city", $case_details["city"], array("class"=>"form-control", 'placeholder'=>'City')); ?>
							<?php echo form_error("city"); ?>
						</div>
						<div class="form-group col-sm-4">
							<?php echo form_label('Province:', 'province', array("class"=>'col-sm-12')); ?>
							<select name="province" class="form-control">
								<?php foreach ($provinces as $key => $val) { ?>
								<option value="<?php echo $key; ?>" <?php if ($key == $case_details['province']) { echo "selected"; } ?>><?php echo $val; ?></option>
								<?php } ?>
							</select>
						</div>
						<div class="form-group col-sm-4">
							<?php echo form_label('Country:', 'country', array("class"=>'col-sm-12')); ?>
							<select name="country" class="form-control">
								<option value="">-- Select Country --</option>
								<?php foreach ($country as $key => $val) { ?>
								<option value="<?php echo $key; ?>" <?php if ($key == $case_details['country']) { echo "selected"; } ?>><?php echo $val; ?></option>
								<?php } ?>
							</select>
							<?php echo form_error("province"); ?>
						</div>
						<div class="form-group col-sm-2">
							<?php echo form_label('Postal Code:', 'post_code', array("class"=>'col-sm-12')); ?>
							<?php echo form_input("post_code", $case_details["post_code"], array("class"=>"form-control", 'placeholder'=>'Postal Code')); ?>
							<?php echo form_error("post_code"); ?>
						</div>
						<div class="col-sm-2">
							<label class="col-sm-12">&nbsp;</label>
							<?php if (! $this->ion_auth->in_group(array(Users_model::GROUP_INSURER))) { ?>
							<?php echo anchor("emergency_assistance/search_provider", '<i class="fa fa-search"></i> Search Provider', array("class"=>'btn btn-primary search_provider')) ?>
							<?php } ?>
						</div>
					</div>
					<h4>Caller Info</h4>
					<div class="row">
						<div class="form-group col-sm-4">
							<?php echo form_label('First Name:', 'first_name', array("class"=>'col-sm-12')); ?>
							<?php echo form_input("first_name", $case_details["first_name"], array("class"=>"form-control", 'placeholder'=>'First Name')); ?>
							<?php echo form_error("first_name"); ?>
						</div>
						<div class="form-group col-sm-4">
							<?php echo form_label('Last Name.:', 'last_name', array("class"=>'col-sm-12')); ?>
							<?php echo form_input("last_name", $case_details["last_name"], array("class"=>"form-control", 'placeholder'=>'Last Name.')); ?>
							<?php echo form_error("last_name"); ?>
						</div>
						<div class="form-group col-sm-4">
							<?php echo form_label('Phone Number:', 'phone_number', array("class"=>'col-sm-12')); ?>
							<?php echo form_input("phone_number", $case_details["phone_number"], array("class"=>"form-control", 'placeholder'=>'Phone Number')); ?>
							<?php echo form_error("phone_number"); ?>
						</div>
						<div class="clearfix"></div>
						<div class="form-group col-sm-4">
							<?php echo form_label('Email:', 'email', array("class"=>'col-sm-12')); ?>
							<?php echo form_input("email", $case_details["email"], array("class"=>"form-control", 'placeholder'=>'Email')); ?>
							<?php echo form_error("email"); ?>
						</div>
						<div class="form-group col-sm-4">
							<?php echo form_label('Relationship:', 'relations', array("class"=>'col-sm-12')); ?>
							<select name="relations" class="form-control">
								<option value="">-- Select Relationship --</option>
								<?php foreach ($relationships as $rc) { ?>
								<option value="<?php echo $rc; ?>" <?php if ($rc == $case_details['relations']) { echo "selected"; } ?>><?php echo $rc; ?></option>
								<?php } ?>
							</select>
							<?php echo form_error("relations"); ?>
						</div>
						<div class="form-group col-sm-4">
							<?php echo form_label('Place of Call:', 'place_of_call', array("class"=>'col-sm-12')); ?>
							<?php echo form_input("place_of_call", $case_details["place_of_call"], array("class"=>"form-control", 'placeholder'=>'Place of Call')); ?>
							<?php echo form_error("place_of_call"); ?>
						</div>
						<div class="form-group col-sm-4">
							<?php echo form_label('Incident Date:', 'incident_date', array("class"=>'col-sm-12')); ?>
							<div class="input-group date">
								<?php echo form_input("incident_date", $case_details["incident_date"], array("class"=>"form-control datepicker", 'placeholder'=>'Incident Date')); ?>
								<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
							</div>
							<?php echo form_error("incident_date"); ?>
						</div>
						<div class="form-group col-sm-4">
							<?php echo form_label('Country:', 'country2', array("class"=>'col-sm-12')); ?>
							<select name="country2" class="form-control">
								<option value="">-- Select Country --</option>
								<?php foreach ($country2 as $key => $val) { ?>
								<option value="<?php echo $key; ?>" <?php if ($key == $case_details['country2']) { echo "selected"; } ?>><?php echo $val; ?></option>
								<?php } ?>
							</select>
							<?php echo form_error("country2"); ?>
						</div>
					</div>
					<h4 class="hospital_info">Doctor Info/Hospital Info</h4>
					<div class="row inpationdocinfo">
						<label class="form-group col-sm-12">Inpatient Info</label>
						<div class="form-group col-sm-4">
							<?php echo form_label('Admission Date:', 'addmission_date', array("class"=>'col-sm-12')); ?>
							<div class="input-group date">
								<?php echo form_input("addmission_date", $case_details["addmission_date"], array("class"=>"form-control datepicker_discharge", 'placeholder'=>'Admission Date')); ?>
								<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
							</div>
							<?php echo form_error("addmission_date"); ?>
						</div>
						<div class="form-group col-sm-4">
							<?php echo form_label('Discharge Date:', 'discharge_date', array("class"=>'col-sm-12')); ?>
							<div class="input-group date">
								<?php echo form_input("discharge_date", $case_details["discharge_date"], array("class"=>"form-control datepicker_discharge", 'placeholder'=>'Discharge Date')); ?>
								<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
							</div>
							<?php echo form_error("discharge_date"); ?>
						</div>
						<div class="form-group col-sm-4">
							<?php echo form_label('Room Number:', 'room_number', array("class"=>'col-sm-12')); ?>
							<?php echo form_input("room_number", $case_details["room_number"], array("class"=>"form-control", 'placeholder'=>'Room Number')); ?>
							<?php echo form_error("room_number"); ?>
						</div>
						<div class="form-group col-sm-4">
							<?php echo form_label('Account Number:', 'account_number', array("class"=>'col-sm-12')); ?>
							<?php echo form_input("account_number", $case_details["account_number"], array("class"=>"form-control", 'placeholder'=>'Account Number')); ?>
							<?php echo form_error("account_number"); ?>
						</div>
						<div class="form-group col-sm-4">
							<?php echo form_label('Hospital Charge:', 'hospital_charge', array("class"=>'col-sm-12')); ?>
							<?php echo form_input("hospital_charge", $case_details["hospital_charge"], array("class"=>"form-control", 'placeholder'=>'Hospital Charge')); ?>
							<?php echo form_error("hospital_charge"); ?>
						</div>
						<div class="form-group col-sm-4">
							<?php echo form_label('Currency:', 'inpatient_currency', array("class"=>'col-sm-12')); ?>
							<?php echo $inpatient_currency; ?>
							<?php echo form_error("inpatient_currency"); ?>
						</div>
					</div>
					<div class="row">
						<label class="form-group col-sm-12 doctor_info">Home Doctor Info</label>
						<div class="form-group col-sm-4">
							<?php echo form_label('First Name:', 'doctor_first_name', array("class"=>'col-sm-12')); ?>
							<?php echo form_input("doctor_first_name", $case_details["doctor_first_name"], array("class"=>"form-control", 'placeholder'=>'First Name')); ?>
							<?php echo form_error("doctor_first_name"); ?>
						</div>
						<div class="form-group col-sm-4">
							<?php echo form_label('Last Name:', 'doctor_last_name', array("class"=>'col-sm-12')); ?>
							<?php echo form_input("doctor_last_name", $case_details["doctor_last_name"], array("class"=>"form-control", 'placeholder'=>'Last Name')); ?>
							<?php echo form_error("doctor_last_name"); ?>
						</div>
						<div class="form-group col-sm-4">
							<?php echo form_label('Country:', 'doctor_country', array("class"=>'col-sm-12')); ?>
							<?php echo $doctor_country; ?>
							<?php echo form_error("doctor_country"); ?>
						</div>
						<div class="form-group col-sm-4">
							<?php echo form_label('Province:', 'doctor_province', array("class"=>'col-sm-12')); ?>
							<?php echo $doctor_province; ?>
							<?php echo form_error("doctor_province"); ?>
						</div>
						<div class="form-group col-sm-4">
							<?php echo form_label('Address:', 'doctor_address', array("class"=>'col-sm-12')); ?>
							<?php echo form_input("doctor_address", $case_details["doctor_address"], array("class"=>"form-control", 'placeholder'=>'Address')); ?>
							<?php echo form_error("doctor_address"); ?>
						</div>
						<div class="form-group col-sm-4">
							<?php echo form_label('City:', 'doctor_city', array("class"=>'col-sm-12')); ?>
							<?php echo form_input("doctor_city", $case_details["doctor_city"], array("class"=>"form-control", 'placeholder'=>'City')); ?>
							<?php echo form_error("doctor_city"); ?>
						</div>
						<div class="form-group col-sm-4">
							<?php echo form_label('Postal Code:', 'doctor_post_code', array("class"=>'col-sm-12')); ?>
							<?php echo form_input("doctor_post_code", $case_details["doctor_post_code"], array("class"=>"form-control", 'placeholder'=>'Postal Code')); ?>
							<?php echo form_error("doctor_post_code"); ?>
						</div>
						<div class="form-group col-sm-4">
							<?php echo form_label('Phone Number:', 'doctor_phone', array("class"=>'col-sm-12')); ?>
							<?php echo form_input("doctor_phone", $case_details["doctor_phone"], array("class"=>"form-control", 'placeholder'=>'Phone Number')); ?>
							<?php echo form_error("doctor_phone"); ?>
						</div>
					</div>
					<div class="row outpationdocinfo">
						<label class="form-group col-sm-12">Outpatient Info / Hospital Info</label>
						<div class="form-group col-sm-4">
							<?php echo form_label('Provider:', 'outpatient_provider', array("class"=>'col-sm-12')); ?>
							<?php echo form_input("outpatient_provider", $case_details["outpatient_provider"], array("class"=>"form-control", 'placeholder'=>'Provider')); ?>
							<?php echo form_error("outpatient_provider"); ?>
						</div>
						<div class="form-group col-sm-4">
							<?php echo form_label('Federal tax ID#:', 'outpatient_federal_tax', array("class"=>'col-sm-12')); ?>
							<?php echo form_input("outpatient_federal_tax", $case_details["outpatient_federal_tax"], array("class"=>"form-control", 'placeholder'=>'Federal tax ID Number')); ?>
							<?php echo form_error("outpatient_federal_tax"); ?>
						</div>
						<div class="form-group col-sm-4">
							<?php echo form_label('Facility:', 'outpatient_facility', array("class"=>'col-sm-12')); ?>
							<?php echo form_input("outpatient_facility", $case_details["outpatient_facility"], array("class"=>"form-control", 'placeholder'=>'Facility')); ?>
							<?php echo form_error("outpatient_facility"); ?>
						</div>
						<div class="form-group col-sm-4">
							<?php echo form_label('Physician:', 'outpatient_physician', array("class"=>'col-sm-12')); ?>
							<?php echo form_input("outpatient_physician", $case_details["outpatient_physician"], array("class"=>"form-control", 'placeholder'=>'Physician')); ?>
							<?php echo form_error("outpatient_physician"); ?>
						</div>
						<div class="form-group col-sm-4">
							<?php echo form_label('Address 1:', 'outpatient_address1', array("class"=>'col-sm-12')); ?>
							<?php echo form_input("outpatient_address1", $case_details["outpatient_address1"], array("class"=>"form-control", 'placeholder'=>'Address 1')); ?>
							<?php echo form_error("outpatient_address1"); ?>
						</div>
						<div class="form-group col-sm-4">
							<?php echo form_label('Address 2:', 'outpatient_address2', array("class"=>'col-sm-12')); ?>
							<?php echo form_input("outpatient_address2", $case_details["outpatient_address2"], array("class"=>"form-control", 'placeholder'=>'Address 2')); ?>
							<?php echo form_error("outpatient_address2"); ?>
						</div>
						<div class="form-group col-sm-4">
							<?php echo form_label('City:', 'outpatient_city', array("class"=>'col-sm-12')); ?>
							<?php echo form_input("outpatient_city", $case_details["outpatient_city"], array("class"=>"form-control", 'placeholder'=>'City')); ?>
							<?php echo form_error("outpatient_city"); ?>
						</div>
						<div class="form-group col-sm-4">
							<?php echo form_label('Province:', 'outpatient_province', array("class"=>'col-sm-12')); ?>
							<?php echo $outpatient_province; ?>
							<?php echo form_error("outpatient_province"); ?>
						</div>
						<div class="form-group col-sm-4">
							<?php echo form_label('Country:', 'outpatient_country', array("class"=>'col-sm-12')); ?>
							<?php echo $outpatient_country; ?>
							<?php echo form_error("outpatient_country"); ?>
						</div>
						<div class="form-group col-sm-4">
							<?php echo form_label('Postal Code:', 'outpatient_post_code', array("class"=>'col-sm-12')); ?>
							<?php echo form_input("outpatient_post_code", $case_details["outpatient_post_code"], array("class"=>"form-control", 'placeholder'=>'Postal Code')); ?>
							<?php echo form_error("outpatient_post_code"); ?>
						</div>
						<div class="form-group col-sm-4">
							<?php echo form_label('Phone:', 'outpatient_phone', array("class"=>'col-sm-12')); ?>
							<?php echo form_input("outpatient_phone", $case_details["outpatient_phone"], array("class"=>"form-control", 'placeholder'=>'Phone Number')); ?>
							<?php echo form_error("outpatient_phone"); ?>
						</div>
						<div class="form-group col-sm-4">
							<?php echo form_label('FAX:', 'outpatient_fax', array("class"=>'col-sm-12')); ?>
							<?php echo form_input("outpatient_fax", $case_details["outpatient_fax"], array("class"=>"form-control", 'placeholder'=>'Fax Number')); ?>
							<?php echo form_error("outpatient_fax"); ?>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-sm-4">
							<?php echo form_label('Main Diagnosis:', 'diagnosis', array("class"=>'col-sm-12')); ?>
							<?php echo form_input("diagnosis", $case_details["diagnosis"], array("class"=>"form-control", 'placeholder'=>'Main Diagnosis')); ?>
							<?php echo form_error("diagnosis"); ?>
						</div>
						<div class="form-group col-sm-4">
							<?php echo form_label('Treatment:', 'treatment', array("class"=>'col-sm-12')); ?>
							<?php echo form_input("treatment", $case_details["treatment"], array("class"=>"form-control", 'placeholder'=>'Treatment')); ?>
							<?php echo form_error("treatment"); ?>
						</div>
						<div class="form-group col-sm-4">
							<?php echo form_label('Third Party Recovery:', 'third_party_recovery', array("class"=>'col-sm-12')); ?>
							<?php echo form_checkbox("third_party_recovery", "Y", ($case_details["third_party_recovery"] == 'Y'?TRUE:FALSE), array('style'=>'margin-left: 12px;')); ?>
							<?php echo form_error("third_party_recovery"); ?>
						</div>
						<?php if (0) { ?>
						<div class="form-group col-sm-12">
							<?php echo form_label('Medical Notes:', 'medical_notes', array("class"=>'col-sm-12')); ?>
							<?php echo form_textarea("medical_notes", $case_details["medical_notes"], array("class"=>"form-control", 'placeholder'=>'Medical Notes', 'style'=>'height:87px')); ?>
							<?php echo form_error("medical_notes"); ?>
						</div>
						<?php } ?>
					</div>
					<h4>Case Manager</h4>
					<div class="row">
						<?php if ($this->ion_auth->in_group(array(Users_model::GROUP_ADMIN, Users_model::GROUP_MANAGER))) { ?>
						<div class="form-group col-sm-4">
							<?php echo form_label('Case Manager:', 'case_manager', array("class"=>'col-sm-12')); ?>
							<select name="case_manager" class="form-control">
								<option value="">-- Select Manager --</option>
								<?php foreach ($managers as $rc) { ?>
								<option value="<?php echo $rc['id']; ?>" <?php if ($rc['id'] == $case_details['case_manager']) { echo "selected"; } ?>><?php echo $rc['email']; ?></option>
								<?php } ?>
							</select>
							<?php echo form_error("case_manager"); ?>
						</div>
						<?php } else { ?>
						<div class="form-group col-sm-4">
							<?php echo form_label('Case Manager:', 'case_manager', array("class"=>'col-sm-12')); ?>
							<input type='hidden' name='case_manager' value='<?php echo $case_details['case_manager']; ?>'>
							<?php echo $case_details['case_manager_email']; ?>
						</div>
						<?php } ?>
						<div class="form-group col-sm-4">
							<?php echo form_label('Priority:', 'priority', array("class"=>'col-sm-12')); ?>
							<select name="priority" class="form-control">
								<option value="">-- Select Priority --</option>
								<?php foreach ($priorities as $val) { ?>
								<option value="<?php echo $val; ?>" <?php if ($val == $case_details['priority']) { echo "selected"; } ?>><?php echo $val; ?></option>
								<?php } ?>
							</select>
							<?php echo form_error("priority"); ?>
						</div>
						<div class="form-group col-sm-12">
							<h4>Reserve C$ </h4>
							<?php echo form_label('Reserve Amount:', 'reserve_amount', array("class"=>'col-sm-12')); ?>
							<div class="form-group col-sm-4">
								<?php echo form_input("reserve_amount", $case_details["reserve_amount"], array("class"=>"form-control", 'placeholder'=>'Reserve Amount')); ?>
								<?php echo form_error("reserve_amount"); ?>
							</div>
							<div class="form-group col-sm-4">
								Init Reserve Amount : <?php echo $case_details["init_reserve_amount"]; ?>
							</div>
						</div>
						<?php if (! $this->ion_auth->in_group(array(Users_model::GROUP_INSURER))) { ?>
						<div class="col-sm-12">
							<label class="col-sm-12">&nbsp;</label>
							<button class="btn btn-primary">Save</button>
							<button type="button" class="btn btn-primary create_intake_form" data-toggle="modal" data-target="#create_intake_form"><i class="fa fa-plus-circle"></i> Create Note</button>
							<?php if ($this->ion_auth->in_group(array(Users_model::GROUP_EAC))) { ?>
							<?php echo anchor("auth/mytasks", "Cancel", array("class"=>'btn btn-info')); ?>
							<?php } else if ($this->ion_auth->in_group(array(Users_model::GROUP_INSURER))) { ?>
							<?php echo anchor("emergency_assistance/case_management", "Cancel", array("class"=>'btn btn-info')); ?>
							<?php } else { ?>
							<?php echo anchor("emergency_assistance", "Cancel", array("class"=>'btn btn-info')); ?>
							<?php } ?>
							<?php if ($this->ion_auth->in_group(array(Users_model::GROUP_ADMIN, Users_model::GROUP_MANAGER, Users_model::GROUP_EXAMINER))) { ?>
							<button type="button" class="btn btn-primary follow_up" data-toggle="modal" data-target="#follow_reason">Follow Up <i class="fa fa-angle-double-right"></i></button>
							<?php if($case_details['status'] == 'A') { ?>
							<button type="button" class="btn btn-primary mark_inactive">Deactivate</button>
							<?php } else { ?>
							<button type="button" class="btn btn-primary mark_active">Activate</button>
							<?php } ?>
							<button insured_address="<?php echo nl2br(htmlspecialchars($case_details['insured_address'])); ?>" insured_lastname="<?php echo htmlspecialchars($case_details['insured_lastname']); ?>" insured_firstname="<?php echo htmlspecialchars($case_details['insured_firstname']) ?>" policy_no="<?php echo htmlspecialchars($case_details['policy_no']) ?>" case_no="<?php echo htmlspecialchars($case_details['case_no']) ?>" casemanager_name="<?php echo isset($case_details['case_manager_name']) ? $case_details['case_manager_name'] : ''; ?>" class="btn btn-primary email_print" type="button" data-toggle="modal" data-target="#print_template">Email/Print</button>
							<?php } ?>
						</div>
						<?php } ?>
					</div>
					<?php echo form_close(); ?>
					<?php if(!empty($intake_forms)) { ?>
					<h4 class="modal-title intake-heading" <?php if(empty($intake_forms)) { ?> style="display: none" <?php } ?>>Notes</h4>
					<div class="row intake-forms-list col-sm-12">
						<?php $i = 0; /* $last_form = sizeof($intake_forms); */ ?>
						<?php foreach ($intake_forms as $key => $value) { ?>
                        <?php $i++; $last = true; /* $last = false; if ($i == $last_form) { $last = true; } */ ?>
                        <div class="col-sm-12 intake-forms">
							<div class="col-sm-2">
								<div class="col-sm-12"><?php echo $i." : " . $value['created'] ?></div>
								<div class="col-sm-12" style="overflow-x: auto;"><?php echo "Created by : " . $value['username']; ?></div>
								<?php if ($value['followup']) { echo '<div class="col-sm-12" style="overflow-x: auto;">Follow up by: ' . $value['followup'] ."</div>"; } ?>
							</div>
							<?php $note_tm = strtotime($value['created']) + $note_delay - time(); ?>
							<?php if (($my_user_id == $value['created_by']) && $last && ($note_tm > 0)) { ?>
							<div class="col-sm-10">
								<div class="col-sm-12">
									<form action="<?php echo $note_update_url."/".$value['id']; ?>" method="POST" class="form-horizontal">
										<div class="col-sm-11">
											<textarea name="new_note" cols="40" rows="10"  class="form-control required" placeholder="Notes" style="height:100px"><?php echo $value['notes'] ?></textarea>
										</div>
										<div class="col-sm-1">
											<input type="submit" value="Update">
										</div>
									</form>
								</div>
								<div class="form-group col-sm-11 files">
									<br />
									<?php $files = $value['docs'] ? explode(",", $value['docs']) : array(); ?>
									<?php if (!empty($files)) { ?>
									<?php foreach ($files as $file) { ?>
									<div class="col-sm-9" style="">
										<span class="file-label"><?php echo anchor((substr($file,0,4)=="http")?$file:"file/".$file . '__' . $value['id'], $file, array('target'=>'_blank')); ?></span>
										<?php echo anchor((substr($file,0,4)=="http")?$file:"file/" . $file . '__' . $value['id'], '<i class="fa fa-search row-link"></i>', array('target'=>'_blank', 'title'=>'Browse File')); ?>
										<?php echo anchor((substr($file,0,4)=="http")?$file:"download/" . $file . '__' . $value['id'], '<i class="fa fa-download row-link"></i>', array('title'=>'Download File','data-id'=>$value['id'])); ?>
										<i class="fa fa-remove row-link remove-form pull-right remove_doc" data-id="<?php echo $value['id']; ?>" data-file="<?php echo $file; ?>"></i>
									</div>
									<?php } ?>
									<?php } ?>
									<?php if (!empty($value['phonefile'])) { ?>
									<div class="col-sm-9" style="">
										<span class="file-label"><?php echo anchor($value['phonefile'], $value['phonefile'], array('target'=>'_blank')); ?>
										<i class="fa fa-remove row-link remove-form pull-right remove_phone" data-id="<?php echo $value['id']; ?>"></i></span>
									</div>
									<?php } ?>
								</div>
							</div>
							<?php } else { ?>
							<div class="col-sm-10">
								<div class="col-sm-12">
									<?php echo str_replace(array("\r\n", "\n\r", "\n", "\r"), "<br />", $value['notes']); ?>
								</div>
								<div class="form-group col-sm-11 files">
									<br />
									<?php $files = $value['docs'] ? explode(",", $value['docs']) : array(); ?>
									<?php if (!empty($files)) { ?>
									<?php foreach ($files as $file) { ?>
									<div class="col-sm-9" style="">
										<span class="file-label"><?php echo anchor((substr($file,0,4)=="http")?$file:"file/".$file . '__' . $value['id'], $file, array('target'=>'_blank')); ?></span>
										<?php echo anchor((substr($file,0,4)=="http")?$file:"file/" . $file . '__' . $value['id'], '<i class="fa fa-search row-link"></i>', array('target'=>'_blank', 'title'=>'Browse File')); ?>
										<?php echo anchor((substr($file,0,4)=="http")?$file:"download/" . $file . '__' . $value['id'], '<i class="fa fa-download row-link"></i>', array('title'=>'Download File')); ?>
									</div>
									<?php } ?>
									<?php } ?>
									<?php if (!empty($value['phonefile'])) { ?>
									<div class="col-sm-9" style="">
										<span class="file-label"><?php echo anchor($value['phonefile'], $value['phonefile'], array('target'=>'_blank')); ?></span>
									</div>
									<?php } ?>
								</div>
								<!-- div class="col-sm-1&quot;"><i class="fa fa-remove row-link remove-form pull-right" alt="<?php echo $value['id']; ?>"></i></div -->
							</div>
							<?php } ?>
						</div>
						<?php } ?>
					</div>
					<?php } ?>
					<!-- search policy filter end -->
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php if ($this->ion_auth->in_group(array(Users_model::GROUP_ADMIN, Users_model::GROUP_MANAGER, Users_model::GROUP_EXAMINER))) { ?>
<!-- Email print doc content here -->
<div id="print_template" class="modal fade" role="dialog">
	<div class="modal-dialog  modal-lg">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Print/email Template Letter</h4>
			</div>
			<?php echo form_open_multipart("emergency_assistance/send_print_email", array("id"=>'send_print_email')); ?>
			<div class="modal-body">
				<div class="row">
					<div class="col-sm-6">
						<div>
							<label for="mail_label" class="col-sm-2">Mail Addres:</label>
							<div class="form-group col-sm-6">
								<input name="priority" value="HIGH" id="mail_address" class="col-sm-1" type="checkbox">
								<label for="mail_address" class="col-sm-10 pull-right" style="margin-top: 3px;">Use same address with the policy</label>
							</div>
						</div>
					</div>
					<div class="form-group col-sm-12">
						<div class="form-group col-sm-6">
							<?php echo form_label('To:', 'email', array("class"=>'col-sm-12')); ?>
							<div class="form-group col-sm-12">
								<?php echo form_input("email_template", $case_details['email'], array("class"=>"form-control form-group email required", 'placeholder'=>'Email Address')); ?>
							</div>
						</div>
						<div class="form-group col-sm-3">
							<?php echo form_label('Firstname:', 'first_name_email', array("class"=>'col-sm-12')); ?>
							<div class="form-group col-sm-12">
								<?php echo form_input("first_name_email", $case_details['insured_firstname'], array("class"=>"form-control form-group required", 'placeholder'=>'First Name')); ?>
							</div>
						</div>
						<div class="form-group col-sm-3">
							<?php echo form_label('lastname:', 'last_name_email', array("class"=>'col-sm-12')); ?>
							<div class="form-group col-sm-12">
								<?php echo form_input("last_name_email", $case_details['insured_lastname'], array("class"=>"form-control form-group required", 'placeholder'=>'Last Name')); ?>
							</div>
						</div>
					</div>
					<div class="form-group col-sm-12">
						<div class="form-group col-sm-4">
							<?php echo form_label('Street No.:', 'street_no_email', array("class"=>'col-sm-12')); ?>
							<?php echo form_input("street_no_email", $case_details['street_no'], array("class"=>"form-control required", 'placeholder'=>'Street No.')); ?>
							<?php echo form_error("street_no_email"); ?>
						</div>
						<div class="form-group col-sm-4">
							<?php echo form_label('Street Name.:', 'street_name_email', array("class"=>'col-sm-12')); ?>
							<?php echo form_input("street_name_email", $case_details['street_name'], array("class"=>"form-control required", 'placeholder'=>'Street Name.')); ?>
							<?php echo form_error("street_name_email"); ?>
						</div>
						<div class="form-group col-sm-4">
							<?php echo form_label('City:', 'city_email', array("class"=>'col-sm-12')); ?>
							<?php echo form_input("city_email", $case_details['city'], array("class"=>"form-control required", 'placeholder'=>'City')); ?>
							<?php echo form_error("city"); ?>
						</div>
						<div class="form-group col-sm-4">
							<?php echo form_label('Province:', 'province_email', array("class"=>'col-sm-12')); ?>
							<?php echo form_input("province_email", $case_details['province'], array("class"=>"form-control required", 'placeholder'=>'Province')); ?>
							<?php echo form_error("province_email"); ?>
						</div>
						<div class="form-group col-sm-4">
							<?php echo form_label('Country:', 'country_email', array("class"=>'col-sm-12')); ?>
							<?php echo form_input("country_email", $case_details['country'], array("class"=>"form-control required", 'placeholder'=>'Country')); ?>
							<?php echo form_error("country_email"); ?>
						</div>
						<div class="form-group col-sm-4">
							<?php echo form_label('Post Code:', 'post_code_email', array("class"=>'col-sm-12')); ?>
							<?php echo form_input("post_code_email", $case_details['post_code'], array("class"=>"form-control required", 'placeholder'=>'Post Code')); ?>
							<?php echo form_error("post_code_email"); ?>
						</div>
						<div class="clearfix"></div>
						<?php echo form_label('Select Template:', 'select_template', array("class"=>'col-sm-12')); ?>
						<div class="form-group col-sm-12">
							<?php foreach($docs as $doc): ?>
							<div class="select-doc col-sm-2" doc="<?php echo $doc['id'] ?>">
								<i class="fa fa-file-word-o large"></i><?php echo $doc['name'] ?>
							</div>
							<?php endforeach; ?>
						</div>
					</div>
					<div class="form-group col-sm-12 docfiles">
						<?php foreach($docs as $doc): ?>
						<div class="col-sm-12 doc-description doc-<?php echo $doc['id'] ?>" style="display: none">
							<div class="col-sm-12 doc-desc">
								<?php
								// find and replace text
								$find = array('{otc_logo}', '{otc_logo_big}', '{current_date}');
								// $replace = array(img(array('src'=>'assets/img/otc.jpg','width'=>'130')), img(array('src'=>'assets/img/otc_big.jpg','width'=>'262')), date("F d, Y"));
								$replace = array(img(array('src' => 'assets/img/otc.jpg', 'width' => '130')), img(array('src' => 'assets/img/otc_big.jpg', 'width' => '262')), date("F d, Y"));
								echo str_replace($find, $replace, $doc['description']);
								?>
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
				<button type="button" class="btn btn-info email-template-cancel" data-dismiss="modal">Cancel</button>
			</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>
<!-- end here -->
<?php } ?>

<!-- follow up model window here -->
<div id="follow_reason" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Follow up</h4>
			</div>
			<?php echo form_open_multipart("emergency_assistance/follow_up_cases", array("id"=>'follow_up_cases')); ?>
			<div class="modal-body">
				<div class="row">
					<div class="col-sm-12">
						<div>
							<?php echo form_label('Please Enter Note:', 'notes', array("class"=>'col-sm-12')); ?>
							<div class="col-sm-12">
								<?php echo form_textarea("notes", "", array("class"=>"form-control col-sm-6 form-group required", 'placeholder'=>'Please Enter Note')); ?>
							</div>
							<div class="col-sm-12 follow-section">
								<select name="assign_to_follow" class="form-control">
									<option value="">-- Select EAC --</option>
									<?php foreach ($seacs as $rc):?>
									<option value="<?php echo $rc['id']; ?>" <?php if ($rc['id'] == $case_details['assign_to']) { echo "selected"; } ?>><?php echo $rc['schedule']; ?></option>
									<?php endforeach; ?>
								</select>
							</div>
							<div class="form-group col-sm-6">
								<?php echo form_label('Due Date:', 'due_date', array("class" => 'col-sm-12')); ?>
								<div class="input-group date">
									<?php echo form_input("due_date", $this->input->post("due_date"), array("class"=>"form-control datepicker_due", 'placeholder'=>'Due Date')); ?>
									<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
								</div>
							</div>
							<div class="form-group col-sm-6">
								<?php echo form_label('Due Time (hour):', 'due_time', array("class" => 'col-sm-12')); ?>
								<?php $due_time = $this->input->post("due_time") ? $this->input->post("due_time") : date("H") . ":00:00"; ?>
								<div class="input-group time">
									<select name="due_time" class="form-control">
										<option value="00:00:00" <?php if ($due_time == '00:00:00') { echo "selected"; } ?>>12 AM ( 0 )</option>
										<option value="01:00:00" <?php if ($due_time == '01:00:00') { echo "selected"; } ?>>1 AM ( 1 )</option>
										<option value="02:00:00" <?php if ($due_time == '02:00:00') { echo "selected"; } ?>>2 AM ( 2 )</option>
										<option value="03:00:00" <?php if ($due_time == '03:00:00') { echo "selected"; } ?>>3 AM ( 3 )</option>
										<option value="04:00:00" <?php if ($due_time == '04:00:00') { echo "selected"; } ?>>4 AM ( 4 )</option>
										<option value="05:00:00" <?php if ($due_time == '05:00:00') { echo "selected"; } ?>>5 AM ( 5 )</option>
										<option value="06:00:00" <?php if ($due_time == '06:00:00') { echo "selected"; } ?>>6 AM ( 6 )</option>
										<option value="07:00:00" <?php if ($due_time == '07:00:00') { echo "selected"; } ?>>7 AM ( 7 )</option>
										<option value="08:00:00" <?php if ($due_time == '08:00:00') { echo "selected"; } ?>>8 AM ( 8 )</option>
										<option value="09:00:00" <?php if ($due_time == '09:00:00') { echo "selected"; } ?>>9 AM ( 9 )</option>
										<option value="10:00:00" <?php if ($due_time == '10:00:00') { echo "selected"; } ?>>10 AM ( 10 )</option>
										<option value="11:00:00" <?php if ($due_time == '11:00:00') { echo "selected"; } ?>>11 AM ( 11 )</option>
										<option value="12:00:00" <?php if ($due_time == '12:00:00') { echo "selected"; } ?>>12 PM ( 12 )</option>
										<option value="13:00:00" <?php if ($due_time == '13:00:00') { echo "selected"; } ?>>1 PM ( 13 )</option>
										<option value="14:00:00" <?php if ($due_time == '14:00:00') { echo "selected"; } ?>>2 PM ( 14 )</option>
										<option value="15:00:00" <?php if ($due_time == '15:00:00') { echo "selected"; } ?>>3 PM ( 15 )</option>
										<option value="16:00:00" <?php if ($due_time == '16:00:00') { echo "selected"; } ?>>4 PM ( 16 )</option>
										<option value="17:00:00" <?php if ($due_time == '17:00:00') { echo "selected"; } ?>>5 PM ( 17 )</option>
										<option value="18:00:00" <?php if ($due_time == '18:00:00') { echo "selected"; } ?>>6 PM ( 18 )</option>
										<option value="19:00:00" <?php if ($due_time == '19:00:00') { echo "selected"; } ?>>7 PM ( 19 )</option>
										<option value="20:00:00" <?php if ($due_time == '20:00:00') { echo "selected"; } ?>>8 PM ( 20 )</option>
										<option value="21:00:00" <?php if ($due_time == '21:00:00') { echo "selected"; } ?>>9 PM ( 21 )</option>
										<option value="22:00:00" <?php if ($due_time == '22:00:00') { echo "selected"; } ?>>10 PM ( 22 )</option>
										<option value="23:00:00" <?php if ($due_time == '23:00:00') { echo "selected"; } ?>>11 PM ( 23 )</option>
									</select>
								<?php /* echo form_input(array("name" => "due_time", "type" => "time"), $this->input->post("due_time") ? $this->input->post("due_time") : date("H:i"), array("class" => "form-control datepicker_time", 'placeholder' => 'Due Time')); */ ?>
								<!-- span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span -->
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<label class="col-sm-12">&nbsp;</label>
				<button class="btn btn-info complete-follow">Follow Up</button>
				<button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
			</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>
<!-- follow up model end here -->

<!-- Create Intake Form Modal -->
<div id="create_intake_form" class="modal fade" role="dialog">
	<div class="modal-dialog  modal-lg">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Create Note</h4>
			</div>
			<?php echo form_open_multipart("emergency_assistance/create_intakeform", array("id"=>'create_intakeform')); ?>
			<?php echo form_hidden("case_id", $case_id); ?>
			<div class="modal-body">
				<div class="row">
					<div class="form-group col-sm-4">
						<?php echo form_label('Create Date:', 'create_date', array("class"=>'col-sm-12')); ?>
						<div class="form-group col-sm-12">
							<?php echo date("Y-m-d"); ?>
						</div>
					</div>
					<div class="form-group col-sm-6">
						<?php echo form_label('Phone File:', 'phonefile', array("class" => 'col-sm-12')); ?>
						<span id='phonelink'></span>
						<span id='phonefilelist'></span>
						<a href="javascript:void(0)" class="btn btn-primary getmyphonefile">Get Phone File</a>
						<a href="javascript:void(0)" class="removemyphonefile" style='display:none;'><i class="fa fa-trash row-link"></i></a>
						<?php echo form_hidden("phonefile", $this->input->post("phonefile"), array("class" => "form-control", 'placeholder' => 'Phone File')); ?>
						<?php echo form_error("intake_notes"); ?>
					</div>
					<div class="form-group col-sm-12">
						<?php echo form_label('Notes:', 'intake_notes', array("class"=>'col-sm-12')); ?>
						<?php echo form_textarea("intake_notes", $this->input->post("intake_notes"), array("class"=>"form-control required", 'placeholder'=>'Notes', 'style'=>"height:100px")); ?>
						<?php echo form_error("intake_notes"); ?>
					</div>
					<div class="form-group col-sm-12 files"></div>
				</div>
			</div>
			<div class="modal-footer">
				<label class="col-sm-12">&nbsp;</label>
				<button class="btn btn-primary save-intakeform" type="submit">Save</button>
				<a href="javascript:void(0)" class="btn btn-primary multiupload">Upload Attached</a>
				<button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
			</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>
<!-- end intake form model here -->

<div style="display: none">
	<div id="products"><?php echo $products; ?></div>
</div>

<?php echo link_tag('assets/css/bootstrap-datepicker.css'); ?>
<script src="<?php echo base_url() ?>/assets/js/bootstrap-datetimepicker.js"></script>
<script src="<?php echo base_url() ?>/assets/js/jQuery.print.js"></script>
<script src="<?php echo base_url() ?>/assets/js/jquery.validate.min.js"></script>
<script>
function page_info_adjust() {
	if ($("select[name=reason]").val() == 'Outpatient') {
		$(".hospital_info").text("Doctor Info");
		$(".doctor_info").text("Home Doctor Info");
		$(".outpationdocinfo").show();
		$(".inpationdocinfo").hide();
	} else if ($("select[name=reason]").val() == 'Inpatient') {
		$(".outpationdocinfo").hide();
		$(".inpationdocinfo").show();
		$(".hospital_info").text("Hospital Info");
		$(".doctor_info").text("Attending Physician");
	} else {
		$(".outpationdocinfo").hide();
		$(".inpationdocinfo").show();
		$(".hospital_info").text("Doctor Info/Hospital Info");
		$(".doctor_info").text("Attending Physician");
	}
}

var employee_id = '<?php echo isset($case_details['assign_to']) ? (int)$case_details['assign_to'] : 0; ?>';

$(document).ready(function() {
	$("#create_intakeform").validate();

	$(".datepicker_due").datepicker({
		startDate: '-0y',
		endDate: '+1m',
	});

	$(".datepicker").datepicker({
		startDate: '-117y',
		endDate: '+0y',
	});

	$(".datepicker_discharge").datepicker({
		startDate: '-117y',
	});

	$("select[name=reason]").change(page_info_adjust);
	page_info_adjust();
})

	.on("click", ".getmyphonefile", function() {
		$.ajax({
			url: "<?php echo base_url("phone/getfile"); ?>",
			method:"get",
			// data:{policy:$(this).val()},
			dataType: "json",
			beforeSend: function(){
				$(".nav-m22d").addClass("csspinner load1");
			},
			success: function(data){
				if (typeof data.ok != "undefined") {
					$("#phonefilelist").html(data.html);
					$(".phonefilelistclass").click(function() {
						var url = $(this).attr("data-url");
						$('#phonelink').html('<a href="' + url + '" target="_blank">' + url + '</a>');
						$('input[name=phonefile]').val(url);
						$('.removemyphonefile').show();
						$("#phonefilelist").html('');
					});
				}
				$('.getmyphonefile').hide();
				$(".nav-m22d").removeClass("csspinner load1");
			}
		})
	})

	.on("click", ".removemyphonefile", function(){
		$('#phonelink').html('');
		$('input[name=phonefile]').val('');
		$('.removemyphonefile').hide();
		$('.getmyphonefile').show();
	})

	// once auto file clicked
   .on("change","input[type=file]", function(){

      // validate file extension
      var ext = $(this).val().split('.').pop().toLowerCase();
      if($.inArray(ext, ['pdf','doc','docx','xls','xlsx','msg']) == -1) {
          alert('invalid extension! Please attach .pdf, .doc, .docx, .xls, .xlsx or .msg file.');
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
      $(".modal-body .files").append('<div class="col-sm-9" style="display:none"><input style="display:none" type="file" name="files[]" id="file'+(count+1)+'" accept="pdf" /><span class="file-label"></span> <i class="fa fa-trash row-link" id="'+(count+1)+'"></i></div>');

      // place trigger clicked once file append in files class
      $('#file'+(count+1)).trigger("click");
   })

   .on("click", ".move_down", function(){
      $(this).next("div.row").slideToggle();
      $(this).children("i").toggleClass("fa-angle-up").toggleClass("fa-angle-down");
   })

   	// delete intake form phone file
	.on("click",".remove_doc", function() {
		var id = $(this).attr("data-id");
		var file = $(this).attr("data-file");

		if (confirm('Are you sure you want to remove? ')) {
			$.ajax({
				url: "<?php echo base_url("emergency_assistance/removedocfile/") ?>" + id + "/" + file,
				method: "get",
				success: function() {
					window.location.reload();
				}
			})
		} else {
			return false;
		}
	})

	// delete intake form phone file
	.on("click",".remove_phone", function() {
		var id = $(this).attr("data-id");

		if (confirm('Are you sure you want to remove? ')) {
			$.ajax({
				url: "<?php echo base_url("emergency_assistance/removephonefile/") ?>" + id,
				method: "get",
				success: function() {
					window.location.reload();
				}
			})
		} else {
			return false;
		}
	})
   
   // delete intake form
   //.on("click",".fa.fa-remove.row-link.remove-form.pull-right", function(){
   //   var id = $(this).attr("alt");

   //   if(confirm('Are you sure you want to delete? '))
   //   {
         // remove form area instant to make it visible fast
         //$(this).parent("div").parent("div").parent("div.intake-forms").remove();

         //$.ajax({
         //   url: "<?php echo base_url("emergency_assistance/deleteform/") ?>"+id,
         //   method: "get"
         //})
   //   } else {
   //      return false;
   //   }
   //})

   // clicking on save assign button
   .on("click", ".mark_inactive", function(){

      if(!confirm("Are you sure you want to Deactivate case?"))
         return false;

      // selected cases 
      var cases = [];
      $("input[name=case]:checked").each(function(){
         cases.push($(this).val());
      })
      var cases = cases.join(",");

      // assign cases to emc manager here
      $.ajax({
         url: "<?php echo base_url("emergency_assistance/update_case_status/D") ?>",
         method: "post",
         data:{cases:"<?php echo $case_id; ?>"},
         beforeSend: function(){
            $(".right_col").addClass("csspinner load1");
         },
         success: function() {
            window.location.reload();
         }
      })
   })

   // clicking on save assign button
   .on("click", ".mark_active", function(){

      if(!confirm("Are you sure you want to activate case?"))
         return false;

      // selected cases 
      var cases = [];
      $("input[name=case]:checked").each(function(){
         cases.push($(this).val());
      })
      var cases = cases.join(",");

      // assign cases to emc manager here
      $.ajax({
         url: "<?php echo base_url("emergency_assistance/update_case_status/A") ?>",
         method: "post",
         data:{cases:"<?php echo $case_id; ?>"},
         beforeSend: function(){
            $(".right_col").addClass("csspinner load1");
         },
         success: function() {
            window.location.reload();
         }
      })
   })

   // show email/print cancel
   .on("click", ".email-template-cancel", function(){
	   window.location.reload();                                              
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

      var data = $("input[name=policy_info]").val()?$.parseJSON($("input[name=policy_info]").val()):'';
      // replace string from casemanager name etc
      var str = $(".doc-"+id+"  .doc-desc").html();
      var insured_name = $("input[name=first_name_email]").val() + ' ' + $("input[name=last_name_email]").val();
      var insured_address = $("input[name=street_no_email]").val() + ' ' + $("input[name=street_name_email]").val();
      var insured_address2 = $("input[name=city_email]").val() + ', ' + $("input[name=province_email]").val();
      var pre_sex = "Mrs."; 
      if ($("select[name=gender]").val() != 'female') pre_sex = "Mr.";
 
      str = str.replace(/value="{insured_name}/gi, 'value="' + insured_name.replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;'))
	  .replace(/{insured_name}/gi, insured_name)
      .replace(/value="{claimant_name}/, 'value="' + insured_name.replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;'))
      .replace(/{claimant_name}/g, insured_name)
      .replace(/value="{insured_address}/g, 'value="' + insured_address.replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;'))
      .replace(/{insured_address}/g, insured_address)
      .replace(/value="{insured_address2}/g, 'value="' + insured_address2.replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;'))
      .replace(/{insured_address2}/g, insured_address2)
      .replace(/value="{insured_postcode}/g, 'value="' + $("input[name=post_code_email]").val().replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;'))
      .replace(/{insured_postcode}/g, $("input[name=post_code_email]").val())
      .replace(/value="{insured_lastname}/g, 'value="' + $("input[name=last_name_email]").val().replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;'))
      .replace(/{insured_lastname}/g, $("input[name=last_name_email]").val())
      <?php if (empty($policy)) { ?>
      .replace(/value="{coverage_period}/g, 'value="')
      .replace(/coverage_period/g, '')
      <?php } else { ?>
      .replace(/value="{coverage_period}/g, 'value="' + ('<?php echo $policy['effective_date'] . " to " . $policy['expiry_date']; ?>').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;'))
      .replace(/coverage_period/g, '<?php echo $policy['effective_date'] . " to " . $policy['expiry_date']; ?>')
      <?php } ?>
      .replace(/value="{policy_full_name}/g, 'value="' + ('<?php echo $product_full_name?>').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;'))
      .replace(/policy_full_name/g, '<?php echo $product_full_name?>')
      .replace(/value="{policy_no}/g, 'value="' + obj.attr("policy_no").replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;'))
      .replace(/policy_no/g, obj.attr("policy_no"))
      .replace(/{pre_sex}/g, pre_sex)
      .replace(/case_no/g, obj.attr("case_no"))
      .replace(/value="{casemanager_name}/g, 'value="' + obj.attr("casemanager_name").replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;'))
      .replace(/casemanager_name/g, obj.attr("casemanager_name"));
      if(data)
         str = str.replace(/coverage_period/g, data[0].effective_date+" to "+data[0].expiry_date);
      else
         str = str.replace(/coverage_period/g, '');

      $(".doc-"+id+" .doc-desc").html(str);

      // reset all edit//preview section
      $(".preview-template").text("Preview").removeClass("active-preview");

      // enable disable buttons
      $(".print").attr("disabled", "disabled");
      $(".preview-template, .email-intakeform").removeAttr("disabled");
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
            if(!$(this).hasClass("area")) {
				$(this).append("<input class='outer-text' value='" + text.replace(/'/g, "\\\'") + "'></input>");
			}
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
            url: "<?php echo base_url("emergency_assistance/send_print_email") ?>",
            method: "post",
            data:{
               email:$("input[name=email_template]").val(), 
               street_no:$("input[name=street_no_email]").val(), 
               street_name:$("input[name=street_name_email]").val(), 
               city:$("input[name=city_email]").val(), 
               province:$("select[name=province_email]").val(), 
               template:template,
               case_id: "<?php echo $case_id; ?>",
               doc: $(".select-doc.active").text()
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

   // once user clicked on same with policy button
   .on("click", "#mail_address", function(){

      // get local data
      var data = $.parseJSON($("input[name=policy_info]").val());
      if($(this).is(":checked"))
      {
         // fill all json values to address fields
         $("input[name=email]").val(data[0].contact_email);
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

   // set validation on emc select list
   .on("change", "select[name=assign_to_follow]", function(){

      var val = $(this).val();
      // set selected employee
      employee_id = val;
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
            if(typeof data.plan_list != "undefined" && data.plan_list.length) {
               localStorage.setItem("policy_data", JSON.stringify(data.plan_list));
               $("input[name=policy_info]").val(JSON.stringify(data.plan_list));
               
               $("input[name=product_short]").val((data.plan_list[0].product_short));
               $("input[name=totaldays]").val((data.plan_list[0].totaldays));
               $("input[name=agent_id]").val((data.plan_list[0].agent_id));

               $("input[name=insured_firstname]").val((data.plan_list[0].firstname));
               $("input[name=insured_lastname]").val((data.plan_list[0].lastname));
               $("textarea[name=insured_address]").val(data.plan_list[0].street_number+" "+data.plan_list[0].street_name);
               $("input[name=dob]").val((data.plan_list[0].birthday));  
               if(data.plan_list[0].gender == 'M')
                   $("select[name=gender]").val('male');
               else
                   $("select[name=gender]").val('female');

               $("input[name=street_no]").val((data.plan_list[0].street_number));
               $("input[name=street_name]").val((data.plan_list[0].street_name));
               $("input[name=suite_number]").val((data.plan_list[0].suite_number));
               $("input[name=city]").val((data.plan_list[0].city));
               $("input[name=province]").val((data.plan_list[0].province2));
               $("input[name=country]").val((data.plan_list[0].country2));
               $("input[name=post_code]").val((data.plan_list[0].postcode));
            } else {
               alert("Sorry, policy information does not exists, please check policy no and try again");               
               $("input[name=policy_no]").val('Unknown - ' + $("input[name=policy_no]").val());
            }
            $(".nav-m22d").removeClass("csspinner load1");
         }
      })
   })


// clicking on follow button
.on("submit", "#follow_up_cases", function(e){                                            
   
   // prevent form to submit
   e.preventDefault();


   if($(this).valid())
   {

      // check if employee selected or not
      if(!employee_id)
      {
         alert("Please select user first.");
         return false;
      }

      // assign emc user to selected cases 
      var cases = [];
      $("input[name=case]:checked").each(function(){
         cases.push($(this).val());
      })
      var cases = cases.join(",");

      // assign cases to emc manager here
      $.ajax({
         url: "<?php echo base_url("emergency_assistance/follow_up_cases") ?>",
         method: "post",
         data:{cases:"<?php echo $case_id; ?>", employee_id: employee_id, notes: $("textarea[name=notes]").val(), due_date: $("input[name=due_date]").val(), due_time: $("input[name=due_time]").val() },
         beforeSend: function(){
            $(".modal-dialog").addClass("csspinner load1");
         },
         success: function() {
            window.location.reload();
         }
      })
   }
})

.on("click", '.search_provider', function(e){
   e.preventDefault();
   var href = $(this).attr("href")+"?street_no="+$("input[name=street_no]").val()+"&street_name="+$("input[name=street_name]").val()+"&city="+$("input[name=city]").val()+"&province="+$("select[name=province]").val()+"&country="+$("select[name=country2]").val()+"&post_code="+$("input[name=post_code]").val()+"";

   $(this).target = "_blank";
   window.open(href,"Search Providers", "width=1250,height=600"); 
})

// create input boxes where requirement need
var $outer = $(".outer-text");
$outer.each(function(){
   var text = $.trim($(this).text());

   $(this).empty();
   if(!$(this).hasClass("area"))
      $(this).append("<input class='outer-text' value='" + text.replace(/'/g, "\\\'") + "'></input>");
   else        
      $(this).append("<textarea  style='width:100%' rows='6' value=''>"+ text +"</textarea>");
});

var $outer_select = $(".select-product");
$outer_select.each(function(){
   var text = $.trim($(this).text());

   $(this).empty();
   $(this).append($("#products").html());
});
</script>
