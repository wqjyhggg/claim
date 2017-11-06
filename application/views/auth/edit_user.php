<div>
	<div class="page-title">
		<div class="title_left">
			<h3><?php echo $pagetitle; ?></h3>
		</div>
	</div>
	<div class="clearfix"></div>
	<!-- Product List Section -->
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>User Form<small></small></h2><?php echo anchor("auth/users", 'Cancel', array("class"=>'btn btn-primary pull-right')) ;?>
					<div class="clearfix"></div>
					<?php echo $message; ?>
				</div>
				<div class="x_content">
					<?php echo form_open($action_url, array("class"=>'form-horizontal'));?>
					<div class="row">
						<div class="col-sm-3 form-group">
							<?php echo form_label('Email', 'email', array("class"=>'col-sm-12'));?>
							<div class="col-sm-12 input-group">
								<?php echo form_input($email);?>
							</div>
						</div>
						<div class="col-sm-3 form-group">
							<?php echo form_label('Password', 'password', array("class"=>'col-sm-12'));?>
							<div class="col-sm-12 input-group">
								<?php echo form_input($password);?>
							</div>
						</div>

						<div class="col-sm-3 form-group">
							<?php echo form_label('Confirm Password', 'password_confirm', array("class"=>'col-sm-12'));?>
							<div class="col-sm-12 input-group">
								<?php echo form_input($password_confirm);?>
							</div>
						</div>
						<div class="col-sm-3 form-group">
							<?php echo form_label('Title', 'title', array("class"=>'col-sm-12'));?>
							<div class="col-sm-12 input-group">
								<?php echo form_input($title);?>
							</div>
						</div>
						<div class="clearfix"></div>
						
						<div class="col-sm-3 form-group">
							<?php echo form_label('First Name', 'first_name', array("class"=>'col-sm-12'));?>
							<div class="col-sm-12 input-group">
								<?php echo form_input($first_name);?>
							</div>
						</div>

						<div class="col-sm-3 form-group">
							<?php echo form_label('Last Name', 'last_name', array("class"=>'col-sm-12'));?>
							<div class="col-sm-12 input-group">
								<?php echo form_input($last_name);?>
							</div>
						</div>

						<div class="col-sm-3 form-group">
							<?php echo form_label('Company', 'company', array("class"=>'col-sm-12'));?>
							<div class="col-sm-12 input-group">
								<?php echo form_input($company);?>
							</div>
						</div>

						<div class="col-sm-3 form-group">
							<?php echo form_label('Phone', 'phone', array("class"=>'col-sm-12'));?>
							<div class="col-sm-12 input-group">
								<?php echo form_input($phone);?>
							</div>
						</div>
						<div class="clearfix"></div>

						<?php echo heading('Member of groups', 2);?>
						<div class="col-sm-12 form-group">
							<?php foreach ($allgroups as $group):?>
							<div class="col-sm-3">
								<label class="form_checkbox">
									<input type="checkbox" name="groups[]" value="<?php echo $group; ?>" <?php echo in_array($group, $currentGroups) ? ' checked="checked"' : '';?>>
									<?php echo htmlspecialchars($group,ENT_QUOTES,'UTF-8');?>
								</label>
							</div>
							<?php endforeach?>
						</div>
						<div class="clearfix"></div>
					</div>

					<div class="row" id='products_div' style="display: none">
						<div class="col-sm-12 form-group">
							<?php echo form_label('Select Products', 'products', array("class"=>'col-sm-12'));?>
							<?php foreach ($allproducts as $key => $name):?>
							<div class="col-sm-2">
								<label class="form_checkbox">
									<input type="checkbox" name="products[]" value="<?php echo $key; ?>" <?php echo in_array($key, $currentProducts) ? ' checked="checked"' : '';?>>
									<?php echo htmlspecialchars($name,ENT_QUOTES,'UTF-8');?>
								</label>
							</div>
							<?php endforeach?>
						</div>
					</div>

					<div class="row">
						<div class="col-sm-6 form-group manager_panel" style="display: none">
							<?php echo form_label('Select Shift', 'shift', array("class"=>'col-sm-12'));?>
							<div class="col-sm-12 input-group">
								<?php echo form_dropdown ( "shift", $shift_options, empty ( $user ['shift'] ) ? 0 : $user ['shift'], array('class' => 'form-control') ); ?>
							</div>
						</div>

						<div class="col-sm-12 form-group">
							<?php echo form_hidden('id', empty($user['id']) ? 0 : $user['id'] );?>
							<?php echo form_hidden($csrf); ?>
							<?php echo form_submit('submit', "Submit", array("class"=>'btn btn-primary pull-right'));?>
						</div>
					</div>
					<?php echo form_close();?>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
// check on window load function
var GROUP_ADMIN,GROUP_ACCOUNTANT,GROUP_EAC,GROUP_MANAGER,GROUP_CLAIMER,GROUP_EXAMINER,GROUP_INSURER;

function manager_panel() {
	if ($(this).val() == '<?php echo Users_model::GROUP_EAC; ?>') {
		GROUP_EAC = ($(this).is(":checked"));
	} else if ($(this).val() == '<?php echo Users_model::GROUP_ADMIN; ?>') {
		GROUP_ADMIN = ($(this).is(":checked"));
	} else if ($(this).val() == '<?php echo Users_model::GROUP_ACCOUNTANT; ?>') {
		GROUP_ACCOUNTANT = ($(this).is(":checked"));
	} else if ($(this).val() == '<?php echo Users_model::GROUP_MANAGER; ?>') {
		GROUP_MANAGER = ($(this).is(":checked"));
	} else if ($(this).val() == '<?php echo Users_model::GROUP_CLAIMER; ?>') {
		GROUP_CLAIMER = ($(this).is(":checked"));
	} else if ($(this).val() == '<?php echo Users_model::GROUP_EXAMINER; ?>') {
		GROUP_EXAMINER = ($(this).is(":checked"));
	} else if ($(this).val() == '<?php echo Users_model::GROUP_INSURER; ?>') {
		GROUP_INSURER = ($(this).is(":checked"));
	}
	if (GROUP_EAC) {
		// show manager panel
		$(".manager_panel").show();
	} else {
		$(".manager_panel").hide();
	}
	if (GROUP_ADMIN || GROUP_ACCOUNTANT) {
		$("#products_div").hide();
	} else {
		$("#products_div").show();
	}
}

$("input[type=checkbox]").each(manager_panel);

// show manager panel if user is emc
$(document).on("click", "input[type=checkbox]", manager_panel);
</script>