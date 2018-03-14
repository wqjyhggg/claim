<div>
	<div class="page-title">
		<div class="title_left">
			<h3>CLaim Recovery Report</h3>
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
						<div class="form-group col-sm-3">
							<?php echo form_label('Status:', 'status', array ("class" => 'col-sm-12')); ?>
							<select name="status" class="form-control">
								<option value="">-- Select Status --</option>
								<?php foreach ($statuses as $key => $val) { ?>
								<option value="<?php echo $key; ?>" <?php if ($key == $this->input->get('status')) { echo "selected"; } ?>><?php echo $val; ?></option>
								<?php } ?>
							</select>
						</div>
						<div class="clearfix"><br /></div>
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
						</div>
						<div class="form-group col-sm-3">
							<label class="col-sm-12">&nbsp;</label>
							<button class="btn btn-primary" name="filter" value="1">Search</button>
							<?php echo anchor($export_url, 'Export', array('title'=>'Export', 'class' => 'btn btn-primary')); ?>
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
									<th>Claim No.</th>
									<th>Invoice</th>
									<th>Provider Name</th>
									<th>Policy</th>
									<th>Client Last Name</th>
									<th>Client First Name</th>
									<th>Days</th>
									<th>Entered Date</th>
									<th>Date of Service</th>
									<th>Pay Date</th>
									<th>Invoice Status</th>
									<th>Billed Amount</th>
									<th>Paid Amount</th>
									<th>Gross Pending</th>
									<th>Recovery</th>
								</tr>
							</thead>
							<tbody>
								<?php $t_amount_billed = $t_amt_payable = $t_recovery_amt = $t_reserve_amount = 0; ?>
								<?php foreach ( $records as $key => $value ) { ?>
								<?php 	$t_amount_billed += $value['amount_billed']; $t_amt_payable += $value['amt_payable']; $t_recovery_amt += $value['recovery_amt']; $t_reserve_amount += $value['reserve_amount']; ?>
								<tr>
									<td><?php echo $value['claim_no']; ?></td>
									<td><?php echo $value['invoice']; ?></td>
									<td><?php echo $value['provider_name']; ?></td>
									<td><?php echo $value['policy_no']; ?></td>
									<td><?php echo $value['last_name']; ?></td>
									<td><?php echo $value['first_name']; ?></td>
									<td><?php echo $value['totaldays']; ?></td>
									<td><?php echo substr($value['created'], 0, 10); ?></td>
									<td><?php echo $value['date_of_service']; ?></td>
									<td><?php echo $value['pay_date']; ?></td>
									<td><?php echo $value['status']; ?></td>
									<td><?php echo sprintf("%0.2f", $value['amount_billed']); ?></td>
									<td><?php echo sprintf("%0.2f", $value['amt_payable']); ?></td>
									<td><?php echo sprintf("%0.2f", $value['reserve_amount']); ?></td>
									<td><?php echo sprintf("%0.2f", $value['recovery_amt']); ?></td>
								</tr>
								<?php } ?>
								<tr>
									<td><b>Total</b></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td><?php echo sprintf("%0.2f", $t_amount_billed); ?></td>
									<td><?php echo sprintf("%0.2f", $t_amt_payable); ?></td>
									<td><?php echo sprintf("%0.2f", $t_reserve_amount); ?></td>
									<td><?php echo sprintf("%0.2f", $t_recovery_amt); ?></td>
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
    
	$("select[name=scope]").change(scope_change);
	scope_change();
});
</script>