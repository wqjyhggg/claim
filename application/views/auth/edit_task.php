<div>
	<div class="page-title">
		<div class="title_left">
			<h3>Edit Task</h3>
		</div>
	</div>
	<div class="clearfix"></div>

	<!-- Create Provider Section -->
	<div class="row">
		<?php echo $message; ?>
		<div class="col-md-12 col-sm-6 col-xs-12">
			<div class="x_panel">
				<div class="x_content">
				<?php echo form_open("", array('class'=>'form-horizontal', 'method'=>'post')); ?>
					<div class="row">
						<div class="form-group col-sm-6">
							<?php echo form_label('Type:', 'type', array("class" => 'col-sm-12')); ?>
							<div class="form-group col-sm-12"><?php echo $task_details['type']; ?></div>
						</div>
						<div class="form-group col-sm-6">
							<?php echo form_label('Case / Claim Number:', 'case_no', array("class" => 'col-sm-12')); ?>
							<div class="form-group col-sm-12"><?php echo $task_details['task_no']; ?></div>
						</div>
						<div class="form-group col-sm-6">
							<?php echo form_label('Insured Name:', 'Insured Name', array("class" => 'col-sm-12')); ?>
							<div class="form-group col-sm-12"><?php echo $task_details['insured_name']; ?></div>
						</div>
						<div class="form-group col-sm-6">
							<?php echo form_label('Created By:', 'created', array("class" => 'col-sm-12')); ?>
							<div class="form-group col-sm-12"><?php echo $task_details['created_email']; ?></div>
						</div>
						<div class="form-group col-sm-6">
							<?php echo form_label('Assigned To:', 'assigned', array("class" => 'col-sm-12')); ?>
							<div class="form-group col-sm-12"><?php echo $task_details['assigned_email']; ?></div>
						</div>
						<div class="form-group col-sm-3">
							<?php echo form_label('Due Date:', 'due_date', array("class" => 'col-sm-12')); ?>
							<div class="input-group date">
								<?php echo form_input("due_date", $task_details['due_date'], array("class"=>"form-control datepicker_due", 'placeholder'=>'Due Date')); ?>
								<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
							</div>
						</div>
						<div class="form-group col-sm-3">
							<?php echo form_label('Due Time:', 'due_time', array("class" => 'col-sm-12')); ?>
							<div class="input-group time">
							<?php echo form_input(array("name" => "due_time", "type" => "time"), $task_details['due_time'], array("class" => "form-control datepicker_time", 'placeholder' => 'Due Time')); ?>
							<span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
							</div>
						</div>
						
						<div class="col-sm-6">
							<?php  echo form_label('Priority:', 'priority', array("class"=>'col-sm-12')); ?>
							<div class="form-group col-sm-12">
								<select name="priority" class="form-control">
									<?php foreach ($priorities as $rc) : ?>
									<option value="<?php echo $rc; ?>" <?php if ($task_details["priority"] == $rc) { echo "selected"; } ?>><?php echo $rc; ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>

						<div class="col-sm-6">
							<?php  echo form_label('Status:', 'status', array("class"=>'col-sm-12')); ?>
							<div class="form-group col-sm-12">
								<select name="status" class="form-control">
									<?php foreach ($statuses as $rc) : ?>
									<option value="<?php echo $rc; ?>" <?php if ($task_details["status"] == $rc) { echo "selected"; } ?>><?php echo $rc; ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
					</div>
					<div class="clearfix"></div>

					<div class="row">
						<?php if ($this->ion_auth->in_group(array(Users_model::GROUP_ADMIN))) { ?>					
						<div class="form-group col-sm-6">
							<?php echo form_label('Follow Up EAC:', 'user_id', array("class" => 'col-sm-12')); ?>
							<div class="form-group col-sm-12">
								<select name="user_id" class="form-control">
									<option value="0"> -- Change EAC -- </option>
									<?php foreach ($eacs as $rc) : ?>
									<option value="<?php echo $rc['id']; ?>"><?php echo $rc['email']; ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<?php } ?>
					</div>					
					<div class="clearfix"></div>

					<div class="row">
						<div class="form-group col-sm-12">
							<div class="col-sm-4"><?php echo anchor("auth/mytasks", "Back", array("class"=>'btn btn-info'))?></div>
							<?php if ($this->ion_auth->in_group(array(Users_model::GROUP_ADMIN, Users_model::GROUP_MANAGER, Users_model::GROUP_EXAMINER))) { ?>					
							<div class="col-sm-4"><button class="btn btn-primary">Save</button></div>
							<?php } ?>
							<div class="col-sm-4"><?php echo anchor("auth/finish_task/".$task_details['id'], "Finish", array("class"=>'btn btn-info'))?></div>
						</div>
					</div>
					<div class="clearfix"></div>
				<?php echo form_close(); ?>
				</div>
			</div>
		</div>
	</div>
</div>

<?php echo link_tag('assets/css/bootstrap-datepicker.css'); ?>
<script src="<?php echo base_url() ?>/assets/js/bootstrap-datetimepicker.js"></script>
<script>
$(document).ready(function() {
	$(".datepicker").datepicker({
		startDate: '-105y',
		endDate: '+2y',
	});

	$(".datepicker_due").datepicker({
		startDate: '-0y',
		endDate: '+1m',
	});
})
$(document).on("click",".more_filters", function(){
   $(".more_items").toggle();
})
</script>
