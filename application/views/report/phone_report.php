<div>
	<div class="page-title">
		<div class="title_left">
			<h3>Phone Report</h3>
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
					<?php if(!empty($records)): ?>
						<table class="table table-hover table-bordered">
							<thead>
								<tr>
									<th>&nbsp;</th>
									<th>Ints Ans</th>
									<th>Avg Talk</th>
									<th>Total Talk</th>
									<th>Avg ACW</th>
									<th>Total ACW</th>
									<th>Ints Abns</th>
									<th>Avg Abns</th>
									<th>% Aband</th>
									<th>Max Wait Ans</th>
									<th>Avg Speed Ans</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach($records as $key => $value ) { ?>
								<tr>
									<td><?php echo $key; ?></td>
									<td><?php echo $value['answers']; ?></td>
									<td><?php echo $value['avg_talk']; ?></td>
									<td><?php echo $value['total_talk']; ?></td>
									<td><?php echo $value['avg_pause']; ?></td>
									<td><?php echo $value['total_pause']; ?></td>
									<td><?php echo $value['abandoned']; ?></td>
									<td><?php echo $value['avg_abandoned']; ?></td>
									<td><?php echo $value['percent_abandoned']; ?>%</td>
									<td><?php echo $value['max_waiting']; ?></td>
									<td><?php echo $value['avg_waiting']; ?></td>
								</tr>
								<?php } ?>
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