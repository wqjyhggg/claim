<div>
	<div class="page-title">
		<div class="title_left">
			<h3>Claims</h3>
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
							<?php echo form_label('Products:', 'product_short', array ("class" => 'col-sm-12')); ?>
							<select name="product_short" class="form-control">
								<option value="">-- Select Products --</option>
								<?php foreach ($products as $key => $val) { ?>
								<option value="<?php echo $key; ?>" <?php if ($key == $this->input->get('product_short')) { echo "selected"; } ?>><?php echo /* $val */$key; ?></option>
								<?php } ?>
							</select>
						</div>
						<div class="form-group col-sm-3">
							<?php echo form_label('Agent ID:', 'agent_id', array ("class" => 'col-sm-12')); ?>
							<select name="agent_id" class="form-control">
								<option value="">-- Select Agent ID --</option>
								<?php foreach ($agents as $val) { ?>
								<option value="<?php echo $val['agent_id']; ?>" <?php if ($val['agent_id'] == $this->input->get('agent_id')) { echo "selected"; } ?>><?php echo $val['agent_id']; ?></option>
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
					<?php if(!empty($records)): ?>
						<table class="table table-hover table-bordered">
							<thead>
								<tr>
									<th>Month</th>
									<th>Writen Premium</th>
									<th>Earned Premium</th>
									<th>Billed Amount</th>
									<th>Paid Amount</th>
									<th>Recovery Amount</th>
								</tr>
							</thead>
							<tbody>
								<?php $t_writen = $t_earned = $t_billed = $t_paid = $t_recovery = 0; ?>
								<?php foreach($records as $key => $value ) { ?>
								<?php $t_writen += $value['writen']; $t_earned += $value['earned']; $t_billed += $value['billed']; $t_paid += $value['paid']; $t_recovery += $value['recovery']; ?>
								<tr>
									<td><?php echo $key; ?></td>
									<td>$<?php echo number_format($value['writen'], 2); ?></td>
									<td>$<?php echo number_format($value['earned'], 2); ?></td>
									<td>$<?php echo number_format($value['billed'], 2); ?></td>
									<td>$<?php echo number_format($value['paid'], 2); ?></td>
									<td>$<?php echo number_format($value['recovery'], 2); ?></td>
								</tr>
								<?php } ?>
								<tr>
									<td><b>Total</b></td>
									<td>$<?php echo number_format($t_writen, 2); ?></td>
									<td>$<?php echo number_format($t_earned, 2); ?></td>
									<td>$<?php echo number_format($t_billed, 2); ?></td>
									<td>$<?php echo number_format($t_paid, 2); ?></td>
									<td>$<?php echo number_format($t_recovery, 2); ?></td>
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
		format: "yyyy-mm",
		viewMode: "months", 
	    minViewMode: "months",
	    endDate: '+0m'
    });
});
</script>