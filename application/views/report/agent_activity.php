<?php $this->load->model('phone_model'); ?>
<div>
	<div class="page-title">
		<div class="title_left">
			<h3>Agent Activity Report</h3>
		</div>
	</div>
	<div class="clearfix"></div>
	<!-- Product List Section -->
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_content">
					<!-- search filter start -->
					<?php echo form_open("", array('class'=>'form-horizontal', 'method'=>'get')); ?>
					<div class="row">
						<div class="form-group col-sm-3">
							<?php echo form_label('Staff:', 'user_id', array ("class" => 'col-sm-12')); ?>
							<select name="user_id" class="form-control">
								<option value="">-- Select Staff --</option>
								<?php foreach ($user_list as $key => $val) { ?>
								<option value="<?php echo $val['id']; ?>" <?php if ($val['id'] == $this->input->get('user_id')) { echo "selected"; } ?>><?php echo $val['email']; ?></option>
								<?php } ?>
							</select>
						</div>
						<div class="form-group col-sm-3">
							<?php echo form_label('Date From:', 'start_dt', array("class"=>'col-sm-12')); ?>
							<div class="input-group date">
								<?php echo form_input ( "start_dt", $this->input->get( "start_dt" ), array ("class" => "form-control datepicker", 'placeholder' => 'Date From') ); ?>
								<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
							</div>
						</div>
						<div class="form-group col-sm-3">
							<?php echo form_label('Date To:', 'end_dt', array("class"=>'col-sm-12')); ?>
							<div class="input-group date">
								<?php echo form_input ( "end_dt", $this->input->get( "end_dt" ), array ("class" => "form-control datepicker", 'placeholder' => 'Date To') ); ?>
								<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
							</div>
						</div>
						<div class="clearfix"><br /></div>
						<div class="col-sm-11">
							<label class="col-sm-12">&nbsp;</label>
							<label class="col-sm-1">&nbsp;</label>
							<?php echo anchor($export_url, 'Export', array('title'=>'Export', 'class' => 'btn btn-primary')); ?>
							<button class="btn btn-primary pull-right" name="filter" value="1">Search</button>
						</div>
					</div>
					<?php echo form_close(); ?>
					<!-- search policy filter end -->
					<div class="clearfix"><br /></div>

					<?php if(!empty($records)): ?>
					<?php foreach($records as $key => $value ) { ?>
					<div class="table-responsive">
						<div class="col-sm-6">
							<table class="table">
								<tr>
									<td><b>Email :</b></td>
									<td><?php echo $value['email']; ?></td>
								</tr>
								<tr>
									<td><b>Name :</b></td>
									<td><?php echo $value['first_name'] . " " . $value['last_name']; ?></td>
								</tr>
								<tr>
									<td><b>Date Range :</b></td>
									<td><?php echo $this->input->get('start_dt') . " - " . $this->input->get('end_dt'); ?></td>
								</tr>
								<tr>
									<td><b>ACW (pause) :</b></td>
									<td><?php echo $this->phone_model->second_to_time($value['pause']); ?></td>
								</tr>
								<tr>
									<td><b>Break :</b></td>
									<td><?php echo $this->phone_model->second_to_time($value['break']); ?></td>
								</tr>
								<tr>
									<td><b>Answer Call :</b></td>
									<td><?php echo $this->phone_model->second_to_time($value['incall']); ?></td>
								</tr>
								<tr>
									<td><b>Call Out :</b></td>
									<td><?php echo $this->phone_model->second_to_time($value['outcall']); ?></td>
								</tr>
								<tr>
									<td><b>Available (waiting for call) :</b></td>
									<td><?php echo $this->phone_model->second_to_time($value['waiting']); ?></td>
								</tr>
								<tr>
									<td><b>Total time :</b></td>
									<td><?php echo $this->phone_model->second_to_time($value['pause'] + $value['break'] + $value['incall'] + $value['outcall'] + $value['waiting']); ?></td>
								</tr>
							</table>
						</div>
					</div>
					<?php } ?>
					<?php else: ?>
					<center><?php echo heading("No record available", 4); ?></center>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
	<!-- End List Section -->
</div>
<?php echo link_tag('assets/css/bootstrap-datepicker.css'); ?>
<script src="<?php echo base_url() ?>/assets/js/bootstrap-datetimepicker.js"></script>
<script>
$(document).ready(function() {
	$(".datepicker").datepicker({
		format: "yyyy-mm-dd",
	    endDate: '+0m'
    });
});
</script>