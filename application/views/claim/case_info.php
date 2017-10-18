<?php if (! empty($case_details)) { ?>
<h4 class="move_down">Case Basic Info option<i class="fa fa-angle-down pull-right"></i></h4>
<div class="row" style="display: none">
	<div class="form-group col-sm-4">
		<?php echo form_label('Case Number:', 'case_no', array("class"=>'col-sm-12')); ?>
		<div class="form-group col-sm-12"><?php echo $case_details['case_no']; ?></div>
	</div>
	<div class="form-group col-sm-4">
		<?php echo form_label('Create Date:', 'created', array("class"=>'col-sm-12')); ?>
		<div class="form-group col-sm-12"><?php echo date("Y-m-d", strtotime($case_details['created'])); ?></div>
	</div>
	<div class="form-group col-sm-4">
		<?php echo form_label('Created By:', 'created_by', array("class"=>'col-sm-12')); ?>
		<div class="form-group col-sm-12"><?php echo $case_details['created_by']; ?></div>
	</div>
</div>

<h4 class="move_down">Visiting Address<i class="fa fa-angle-down pull-right"></i></h4>
<div class="row" style="display: none">
	<div class="form-group col-sm-4">
		<?php echo form_label('Street No.:', 'street_no', array("class" => 'col-sm-12')); ?>
		<div class="form-group col-sm-12"><?php echo $case_details['street_no']; ?></div>
	</div>
	<div class="form-group col-sm-4">
		<?php echo form_label('Street Name.:', 'street_name', array("class" => 'col-sm-12')); ?>
		<div class="form-group col-sm-12"><?php echo $case_details['street_name']; ?></div>
	</div>
	<div class="form-group col-sm-4">
		<?php echo form_label('City:', 'city', array("class" => 'col-sm-12')); ?>
		<div class="form-group col-sm-12"><?php echo $case_details['city']; ?></div>
	</div>

	<div class="form-group col-sm-4">
		<?php echo form_label('Province:', 'province', array("class" => 'col-sm-12')); ?>
		<div class="form-group col-sm-12"><?php echo $case_details['province']; ?></div>
	</div>
	<div class="form-group col-sm-4">
		<?php echo form_label('Country:', 'country', array("class" => 'col-sm-12')); ?>
		<div class="form-group col-sm-12"><?php echo $case_details['country']; ?></div>
	</div>
	<div class="form-group col-sm-2">
		<?php echo form_label('Post Code:', 'post_code', array("class" => 'col-sm-12')); ?>
		<div class="form-group col-sm-12"><?php echo $case_details['post_code']; ?></div>
	</div>
	<div class="form-group col-sm-4">
		<?php echo form_label('Assign To:', 'assign_to', array("class" => 'col-sm-12')); ?>
		<div class="form-group col-sm-12"><?php echo $case_details['assign_to_email']; ?></div>
	</div>
	<div class="form-group col-sm-4">
		<?php echo form_label('Reason:', 'reason', array("class" => 'col-sm-12')); ?>
		<div class="form-group col-sm-12"><?php echo $case_details['reason']; ?></div>
	</div>
</div>

<h4 class="move_down">Caller Info<i class="fa fa-angle-down pull-right"></i></h4>
<div class="row" style="display: none">
	<div class="form-group col-sm-4">
		<?php echo form_label('First Name:', 'first_name', array("class" => 'col-sm-12')); ?>
		<div class="form-group col-sm-12"><?php echo $case_details['first_name']; ?></div>
	</div>
	<div class="form-group col-sm-4">
		<?php echo form_label('Last Name.:', 'last_name', array("class" => 'col-sm-12')); ?>
		<div class="form-group col-sm-12"><?php echo $case_details['last_name']; ?></div>
	</div>
	<div class="form-group col-sm-4">
		<?php echo form_label('Phone Number:', 'phone_number', array("class" => 'col-sm-12')); ?>
		<div class="form-group col-sm-12"><?php echo $case_details['phone_number']; ?></div>
	</div>
	<div class="form-group col-sm-4">
		<?php echo form_label('Email:', 'email', array("class" => 'col-sm-12')); ?>
		<div class="form-group col-sm-12"><?php echo $case_details['email']; ?></div>
	</div>
	<div class="form-group col-sm-4">
		<?php echo form_label('Relationship:', 'relations', array("class" => 'col-sm-12')); ?>
		<div class="form-group col-sm-12"><?php echo $case_details['relations']; ?></div>
	</div>
	<div class="form-group col-sm-4">
		<?php echo form_label('Country:', 'country2', array("class" => 'col-sm-12')); ?>
		<div class="form-group col-sm-12"><?php echo $case_details['country2']; ?></div>
	</div>
</div>

<h4 class="move_down hospital_info">Doctor Info/Hospital Info <i class="fa fa-angle-down pull-right"></i></h4>
<div class="row" style="display: none">
	<div class="form-group col-sm-4">
		<?php echo form_label('Main Diagnosis:', 'diagnosis', array("class" => 'col-sm-12')); ?>
		<div class="form-group col-sm-12"><?php echo $case_details['diagnosis']; ?></div>
	</div>
	<div class="form-group col-sm-4">
		<?php echo form_label('Treatment:', 'treatment', array("class" => 'col-sm-12')); ?>
		<div class="form-group col-sm-12"><?php echo $case_details['treatment']; ?></div>
	</div>
	<div class="form-group col-sm-4">
		<?php echo form_label('Third Party Recovery:', 'third_party_recovery', array("class" => 'col-sm-12')); ?>
		<div class="form-group col-sm-12"><?php echo $case_details['third_party_recovery']; ?></div>
	</div>
</div>

<h4 class="move_down">Assistance Client Info<i class="fa fa-angle-down pull-right"></i></h4>
<div class="row" style="display: none">
	<div class="form-group col-sm-4">
		<?php echo form_label('Policy Number:', 'policy_no', array("class" => 'col-sm-12')); ?>
		<div class="form-group col-sm-12"><?php echo $case_details['policy_no']; ?></div>
	</div>
	<div class="form-group col-sm-4">
		<?php echo form_label('Insured Name:', 'insured_name', array("class" => 'col-sm-12')); ?>
		<div class="form-group col-sm-6"><?php echo $case_details['insured_firstname'].' '.$case_details['insured_lastname']; ?></div>
	</div>
	<div class="form-group col-sm-4">
		<?php echo form_label('Insured Address:', 'insured_address', array("class"=>'col-sm-12'));   ?>
		<div class="form-group col-sm-12"><?php echo $case_details['insured_address']; ?></div>
	</div>
	<div class="form-group col-sm-4">
		<?php echo form_label('Day of Birth:', 'dob', array("class"=>'col-sm-12'));   ?>
		<div class="form-group col-sm-6"><?php echo ($case_details['dob'] <> '0000-00-00')?$case_details['dob']:'N/A'; ?></div>
	</div>
</div>

<h4 class="move_down">Assign Case Manager<i class="fa fa-angle-down pull-right"></i></h4>
<div class="row" style="display: none">
	<div class="form-group col-sm-4">
		<?php echo form_label('Case Manager:', 'case_manager', array("class" => 'col-sm-12')); ?>
		<div class="form-group col-sm-12"><?php echo $case_details['case_manager_name']; ?></div>
	</div>
	<div class="form-group col-sm-4">
		<?php echo form_label('Priority:', 'priority', array("class" => 'col-sm-12')); ?>
		<div class="form-group col-sm-12"><?php echo $case_details['priority']; ?></div>
	</div>
	<div class="form-group col-sm-12">
		<h4>Reservers C$</h4>
		<?php echo form_label('Reserve Amount:', 'reserve_amount', array("class"=>'col-sm-12'));   ?>
		<div class="form-group col-sm-4"><?php echo "$" . ($case_details ['reserve_amount'] ? $case_details ['reserve_amount'] : 0); ?></div>
	</div>
</div>
<?php } else { ?>
<center><?php echo heading("No record available", 4); ?></center>
<?php } ?>