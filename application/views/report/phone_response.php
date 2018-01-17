<?php $this->load->model('phone_model'); ?>
<div>
	<div class="page-title">
		<div class="title_left">
			<h3>Phone Responese Report</h3>
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
						<table class="table table-hover table-bordered">
							<thead>
								<tr>
									<th>Date</th>
									<th>Ints Offerred</th>
									<th>Ints Answered</th>
									<th>Ints Aband</th>
									<th>&lt; 10s</th>
									<th>&lt; 20s</th>
									<th>&lt; 30s</th>
									<th>&lt; 40s</th>
									<th>&lt; 50s</th>
									<th>Aband Rate</th>
									<th>Ave Speed Ans</th>
								</tr>
							</thead>
							<tbody>
								<?php $t_calls = $t_answers = $t_abandons = $t_less10 = $t_less20 = $t_less30 = $t_less40 = $t_less50 = $t_total_abandon = $t_total_answer = 0; ?>
								<?php foreach($records as $key => $value ) { ?>
								<?php 
									$t_calls += $value['calls'];
									$t_answers += $value['answers'];
									$t_abandons += $value['abandons'];
									$t_less10 += $value['less10'];
									$t_less20 += $value['less20'];
									$t_less30 += $value['less30'];
									$t_less40 += $value['less40'];
									$t_less50 += $value['less50'];
									$t_total_answer += $value['total_answer'];
									?>
								<tr>
									<td><?php echo $key; ?></td>
									<td><?php echo $value['calls']; ?></td>
									<td><?php echo $value['answers']; ?></td>
									<td><?php echo $value['abandons']; ?></td>
									<td><?php echo empty($value['answers']) ? 0 : number_format($value['less10'] * 100 / $value['answers'], 2); ?>%</td>
									<td><?php echo empty($value['answers']) ? 0 : number_format($value['less20'] * 100 / $value['answers'], 2); ?>%</td>
									<td><?php echo empty($value['answers']) ? 0 : number_format($value['less30'] * 100 / $value['answers'], 2); ?>%</td>
									<td><?php echo empty($value['answers']) ? 0 : number_format($value['less40'] * 100 / $value['answers'], 2); ?>%</td>
									<td><?php echo empty($value['answers']) ? 0 : number_format($value['less50'] * 100 / $value['answers'], 2); ?>%</td>
									<td><?php echo empty($value['answers']) ? 0 : 100; ?>%</td>
									<td><?php echo $this->phone_model->second_to_time($value['avg_answer']); ?></td>
								</tr>
								<?php } ?>
								<tr>
									<td><b>Total</b></td>
									<td><?php echo $t_calls; ?></td>
									<td><?php echo $t_answers; ?></td>
									<td><?php echo $t_abandons; ?></td>
									<td><?php echo empty($t_answers) ? 0 : number_format($t_less10 * 100 / $t_answers, 2); ?>%</td>
									<td><?php echo empty($t_answers) ? 0 : number_format($t_less20 * 100 / $t_answers, 2); ?>%</td>
									<td><?php echo empty($t_answers) ? 0 : number_format($t_less30 * 100 / $t_answers, 2); ?>%</td>
									<td><?php echo empty($t_answers) ? 0 : number_format($t_less40 * 100 / $t_answers, 2); ?>%</td>
									<td><?php echo empty($t_answers) ? 0 : number_format($t_less50 * 100 / $t_answers, 2); ?>%</td>
									<td><?php echo empty($t_answers) ? 0 : 100; ?>%</td>
									<td><?php echo empty($t_answers) ? 0 : $this->phone_model->second_to_time($t_total_answer/$t_answers); ?></td>
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