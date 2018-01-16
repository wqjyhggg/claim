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
							<?php echo form_label('Queues:', 'queue', array ("class" => 'col-sm-12')); ?>
							<select name="queue" class="form-control">
								<option value="">-- Select Queue --</option>
								<?php foreach ($queue_list as $key => $val) { ?>
								<option value="<?php echo $val['queue']; ?>" <?php if ($val['queue'] == $this->input->get('queue')) { echo "selected"; } ?>><?php echo $val['queue']; ?></option>
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

					<div class="table-responsive">
						<div class="col-sm-6">
							<table class="table">
								<tr>
									<td><b>Queue :</b></td>
									<td><?php echo $this->input->get('queue'); ?></td>
								</tr>
								<tr>
									<td><b>Date Range :</b></td>
									<td><?php echo $this->input->get('start_dt') . " - " . $this->input->get('end_dt'); ?></td>
								</tr>
							</table>
						</div>
					</div>
					<div class="table-responsive">
						<hr>
						<?php if(!empty($records)): ?>
						<?php $t_in_calls = $t_in_total_talk = $t_total_pause = $t_in_total_waiting = $t_out_calls = $t_out_total_talk = 0; ?>
						<?php foreach($records as $key => $value ) { ?>
						<?php 
							$t_in_calls += $value['data']['in_calls'];
							$t_in_total_talk += $value['data']['in_total_talk'];
							$t_total_pause += $value['data']['total_pause'];
							$t_in_total_waiting += $value['data']['in_calls'] * $value['data']['in_avg_waiting'];
							$t_out_calls += $value['data']['out_calls'];
							$t_out_total_talk += $value['data']['out_total_talk'];
						?>
						<table class="table table-hover table-bordered">
							<thead>
								<tr>
									<th>Email</th>
									<th>Ints</th>
									<th>Avg Talk</th>
									<th>Total Talk</th>
									<th>Avg ACW</th>
									<th>Total ACW</th>
									<th>Avg Speed Ans</th>
									<th>Outs</th>
									<th>Out Avg Talk</th>
									<th>Out Total Talk</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><?php echo $value['user']['email']; ?></td>
									<td><?php echo $value['data']['in_calls']; ?></td>
									<td><?php echo $this->phone_model->second_to_time($value['data']['in_avg_talk']); ?></td>
									<td><?php echo $this->phone_model->second_to_time($value['data']['in_total_talk']); ?></td>
									<td><?php echo $this->phone_model->second_to_time($value['data']['avg_pause']); ?></td>
									<td><?php echo $this->phone_model->second_to_time($value['data']['total_pause']); ?></td>
									<td><?php echo $this->phone_model->second_to_time($value['data']['in_avg_waiting']); ?></td>
									<td><?php echo $value['data']['out_calls']; ?></td>
									<td><?php echo $this->phone_model->second_to_time($value['data']['out_avg_talk']); ?></td>
									<td><?php echo $this->phone_model->second_to_time($value['data']['out_total_talk']); ?></td>
								</tr>
							</tbody>
						</table>
						<hr>
						<?php } ?>
						<table class="table table-hover table-bordered">
							<thead>
								<tr>
									<th>&nbsp;</th>
									<th>Ints</th>
									<th>Avg Talk</th>
									<th>Total Talk</th>
									<th>Avg ACW</th>
									<th>Total ACW</th>
									<th>Avg Speed Ans</th>
									<th>Outs</th>
									<th>Out Avg Talk</th>
									<th>Out Total Talk</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><b>Total</b></td>
									<td><?php echo $t_in_calls; ?></td>
									<td><?php echo empty($t_in_calls) ? '0' : $this->phone_model->second_to_time($t_in_total_talk/$t_in_calls); ?></td>
									<td><?php echo $this->phone_model->second_to_time($t_in_total_talk); ?></td>
									<td><?php echo empty($t_in_calls) ? '0' : $this->phone_model->second_to_time($t_total_pause/$t_in_calls); ?></td>
									<td><?php echo $this->phone_model->second_to_time($t_total_pause); ?></td>
									<td><?php echo empty($t_in_calls) ? '0' : $this->phone_model->second_to_time($t_in_total_waiting/$t_in_calls); ?></td>
									<td><?php echo $t_out_calls; ?></td>
									<td><?php echo empty($t_out_calls) ? '0' : $this->phone_model->second_to_time($t_out_total_talk/$t_out_calls); ?></td>
									<td><?php echo $this->phone_model->second_to_time($t_out_total_talk); ?></td>
								</tr>
							</tbody>
						</table>
						<?php else: ?>
						<center><?php echo heading("No record available", 4); ?></center>
						<?php endif; ?>
					</div>
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