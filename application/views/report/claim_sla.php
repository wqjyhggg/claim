<?php $this->load->model('claim_model'); ?>
	<style>
		.buttonexport {
			margin-top: 1.8em;
			margin-left: 14em;
		}

		.buttonsubmit {
			margin-top: 1.8em;
		}
	</style>
<div width='100%'>
	<div class="page-title" width='100%'>
		<div class="title_left" width='100%'>
			<h3>Claim SLA Report</h3>
		</div>
	</div>
	<div class="clearfix"></div>
	<!-- Product List Section -->
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel">
					<div class="x_content">
						<?php echo form_open($current_url, array('class' => 'form-horizontal', 'method' => 'get')); ?>
						<div class="row">
							<div class="form-group col-sm-3">
								<div class="col-sm-6">
									<?php echo form_label('&nbsp;', 'is_examiner', array("class" => 'col-sm-12')); ?>
									<?php echo form_radio("is_examiner", "0", ($is_examiner != 1), array('class' => 'setpremium')); ?> By Claim Amt.
								</div>
								<div class="col-sm-5">
									<?php echo form_label('&nbsp;', 'is_examiner', array("class" => 'col-sm-12')); ?>
									<?php echo form_radio("is_examiner", "1", ($is_examiner == 1), array('class' => 'setpremium')); ?> By Examiner
								</div>
							</div>
							<div class="form-group col-sm-3">
								<div class="col-sm-5">
									<?php echo form_label('&nbsp;', 'is_eclaim', array("class" => 'col-sm-12')); ?>
									<?php echo form_radio("is_eclaim", "0", ($is_eclaim != 1), array('class' => 'setpremium')); ?> No EClaim
								</div>
								<div class="col-sm-5">
									<?php echo form_label('&nbsp;', 'is_eclaim', array("class" => 'col-sm-12')); ?>
									<?php echo form_radio("is_eclaim", "1", ($is_eclaim == 1), array('class' => 'setpremium')); ?> EClaim
								</div>
							</div>
							<div class="form-group col-sm-3">
								<?php echo form_label('Product:', 'product_id', array("class" => 'col-sm-12')); ?>
								<select name="product_short" class="form-control">
									<option value="" <?php if (empty($product_short)) {
																			echo "selected";
																		} ?>> -- Select as Product -- </option>
									<?php foreach ($products as $key => $prod) : ?>
										<option value="<?php echo $key; ?>" <?php if ($key == $product_short) {
																													echo "selected";
																												} ?>><?php echo $prod; ?></option>
									<?php endforeach; ?>
								</select>
							</div>
							<div class="form-group col-sm-3">
								<div id="examiner_div" style="display: none;">
									<?php echo form_label('Examiner:', 'examiners', array("class" => 'col-sm-12')); ?>
									<select name="examiner_id" class="form-control">
										<option value="0" <?php if (empty($examiner_id)) {
																				echo "selected";
																			} ?>> -- Select as Examiner -- </option>
										<?php foreach ($examiners as $val) : ?>
											<option value="<?php echo $val['id']; ?>" <?php if ($val['id'] == $examiner_id) {
																																	echo "selected";
																																} ?>><?php echo $val['email']; ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="form-group col-sm-3">
								<?php echo form_label('From Date:', 'start_dt', array("class" => 'col-sm-12'));   ?>
								<div class="input-group date">
									<?php echo form_input("start_dt", $start_dt, array("class" => "form-control datepicker required", 'placeholder' => 'From Date')); ?>
									<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
								</div>
								<?php echo form_error("dob"); ?>
							</div>
							<div class="form-group col-sm-3">
								<?php echo form_label('To Date:', 'end_dt', array("class" => 'col-sm-12'));   ?>
								<div class="input-group date">
									<?php echo form_input("end_dt", $end_dt, array("class" => "form-control datepicker required", 'placeholder' => 'To Date')); ?>
									<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
								</div>
								<?php echo form_error("dob"); ?>
							</div>
							<div class="form-group col-sm-3">
								<a class="btn btn-primary buttonexport" href="<?php echo $export_url; ?>" value="1" target="_blank">Export</a>
							</div>
							<div class="form-group col-sm-3">
								<button class="btn btn-primary buttonsubmit" name="submit" value="1">Submit</button>
							</div>
							<?php echo form_close(); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	<!-- End List Section -->
	<?php if (!empty($reports)) { ?>
		<?php if (!empty($is_examiner == 1)) { ?>
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel">
						<div class="x_content">
							<div class="table-responsive">
								<table class="table table-hover table-bordered">
									<thead>
										<tr>
											<th>Examiner</th>
											<th>Total Number of Claims</th>
											<th>Number of Open Claims</th>
											<th>Number of Closed Claims</th>
											<th>Value of Open Claims</th>
											<th>Value of Closed Claims</th>
											<th>Eclaim Avg. Transfer Time</th>
											<th>Open Claims Pending Time</th>
											<th>Closed Claims Avg. Close Time</th>
											<th>Avg. Paid Claim Amount</th>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($reports as $value) { ?>
											<tr>
												<td><?php echo $value['email']; ?></td>
												<td><?php echo $value['count']; ?></td>
												<td><?php echo $value['open']; ?></td>
												<td><?php echo $value['closed']; ?></td>
												<td><?php echo $value['total_open']; ?></td>
												<td><?php echo $value['total_closed']; ?></td>
												<td><?php echo $value['eclaim_tf_days']; ?></td>
												<td><?php echo $value['pending_days']; ?></td>
												<td><?php echo $value['close_days']; ?></td>
												<td><?php echo $value['paid_avg']; ?></td>
											</tr>
										<?php } ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php } else { ?>
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel">
						<div class="x_content">
							<div class="table-responsive">
								<table class="table table-hover table-bordered">
									<thead>
										<tr>
											<th>Claim Amount</th>
											<th>Total Number of Claims</th>
											<th>Number of Open Claims</th>
											<th>Number of Closed Claims</th>
											<th>Value of Open Claims</th>
											<th>Value of Closed Claims</th>
											<th>Eclaim Avg. Transfer Time</th>
											<th>Open Claims Pending Time</th>
											<th>Closed Claims Avg. Close Time</th>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($reports as $value) { ?>
											<tr>
												<td><?php echo $value['key']; ?></td>
												<td><?php echo $value['count']; ?></td>
												<td><?php echo $value['open']; ?></td>
												<td><?php echo $value['closed']; ?></td>
												<td><?php echo $value['total_open']; ?></td>
												<td><?php echo $value['total_closed']; ?></td>
												<td><?php echo $value['eclaim_tf_days']; ?></td>
												<td><?php echo $value['pending_days']; ?></td>
												<td><?php echo $value['close_days']; ?></td>
											</tr>
										<?php } ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>
	<?php } ?>
</div>
<script src="<?php echo base_url() ?>/assets/js/jquery.validate.min.js"></script>
<?php echo link_tag('assets/css/bootstrap-datepicker.css'); ?>
<script src="<?php echo base_url() ?>/assets/js/bootstrap-datetimepicker.js"></script>
<script>
	function is_examiner_test() {
		var v = $('input[name=is_examiner]:checked').val();
		if (v == 1) {
			$('#examiner_div').show();
		} else {
			$('#examiner_div').hide();
		}
	}
	$(document).ready(function() {
		is_examiner_test();
		$(".datepicker").datepicker({
			startDate: '-20y',
			endDate: '+0d',
		});
		$('input[name=is_examiner]').on('change', function() {
			is_examiner_test();
		});
	});
</script>