<div>
	<div class="page-title">
		<div class="title_left">
			<h3>Case & CLaim Report</h3>
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
							<?php echo form_label('Scope:', 'scope', array ("class" => 'col-sm-12')); ?>
							<select name="scope" class="form-control">
								<option value="" <?php if (empty($this->input->get('scope'))) { echo "selected"; } ?>>Case & Claim</option>
								<option value="Case" <?php if ("Case" == $this->input->get('scope')) { echo "selected"; } ?>>Case Only</option>
								<option value="Claim" <?php if ("Claim" == $this->input->get('scope')) { echo "selected"; } ?>>Claim Only</option>
							</select>
						</div>
						<div class="form-group col-sm-3" style="display:none;" id="status_div">
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
							<?php echo form_input ( "agent_id", $this->input->get( "agent_id" ), array ("class" => "form-control", 'placeholder' => 'Agent ID') ); ?>
						</div>
						<div class="form-group col-sm-3">
							<?php echo form_label('Claim Date Type:', 'claim_date_type', array ("class" => 'col-sm-12')); ?>
							<select name="claim_date_type" class="form-control">
								<option value="e.date_of_service" <?php if ("e.date_of_service" == $this->input->get('claim_date_type')) { echo "selected"; } ?>>Date of Service</option>
								<option value="e.created" <?php if ("e.created" == $this->input->get('claim_date_type')) { echo "selected"; } ?>>Create Date</option>
								<option value="e.finalize_date" <?php if ("e.finalize_date" == $this->input->get('claim_date_type')) { echo "selected"; } ?>>Finalize Date</option>
							</select>
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
									<th>Birth Day</th>
									<th>Gender</th>
									<th>Days</th>
									<th>Address</th>
									<th>City</th>
									<th>Province</th>
									<th>Postal Code</th>
									<th>AgentID</th>
									<th>Coverage Code</th>
									<th>Deductible</th>
									<th>Entered Date</th>
									<th>Date of Service</th>
									<th>Finalize Date</th>
									<th>Invoice Status</th>
									<th>Gross Pending</th>
									<th>Reserve Amount</th>
									<th>Billed Amount</th>
									<th>Paid Amount</th>
									<th>Recovery</th>
									<th>Description of Service</th>
									<th>Pay to Name</th>
									<th>Decline Reason</th>
									<th>Claim Status</th>
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
									<td><?php echo $value['birth_day']; ?></td>
									<td><?php echo $value['gender']; ?></td>
									<td><?php echo $value['totaldays']; ?></td>
									<td><?php echo $value['street_address']; ?></td>
									<td><?php echo $value['city']; ?></td>
									<td><?php echo $value['province']; ?></td>
									<td><?php echo $value['post_code']; ?></td>
									<td><?php echo $value['agent_id']; ?></td>
									<td><?php echo isset($value['coverage_code']) ? $value['coverage_code'] : ''; ?></td>
									<td><?php echo sprintf("%0.2f", (isset($value['amt_deductible']) ? $value['amt_deductible'] : 0)); ?></td>
									<td><?php echo substr($value['created'], 0, 10); ?></td>
									<td><?php echo $value['date_of_service']; ?></td>
									<td><?php echo isset($value['finalize_date']) ? $value['finalize_date'] : ''; ?></td>
									<td><?php echo $value['status']; ?></td>
									<td><?php echo sprintf("%0.2f", (isset($value['reserve_amount']) ? $value['reserve_amount'] : 0)); ?></td>
									<td><?php echo sprintf("%0.2f", (isset($value['reserve_amount']) ? $value['reserve_amount'] : 0)); ?></td>
									<td><?php echo sprintf("%0.2f", (isset($value['amount_billed']) ? $value['amount_billed'] : 0)); ?></td>
									<td><?php echo sprintf("%0.2f", $value['amt_payable']); ?></td>
									<td><?php echo sprintf("%0.2f", $value['recovery_amt']); ?></td>
									<td><?php echo isset($value['service_description']) ? $value['service_description'] : ''; ?></td>
									<td><?php echo isset($value['pay_to']) ? $value['pay_to'] : ''; ?></td>
									<td><?php echo ($value['status'] == 'D') ? $value['reason'] : ''; ?></td>
									<td><?php echo $value['status2']; ?></td>
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
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td><?php echo sprintf("%0.2f", $t_reserve_amount); ?></td>
									<td></td>
									<td><?php echo sprintf("%0.2f", $t_amount_billed); ?></td>
									<td><?php echo sprintf("%0.2f", $t_amt_payable); ?></td>
									<td><?php echo sprintf("%0.2f", $t_recovery_amt); ?></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
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
function scope_change() {
	var sls = $("select[name=scope]").val();
	if (sls == 'Claim') {
		$('#status_div').show();
	} else {
		$('#status_div').hide();
	}
}

$(document).ready(function() {
	$(".datepicker").datepicker({
		format: "yyyy-mm-dd",
		//viewMode: "months", 
	    //minViewMode: "months",
	    //endDate: '+0m'
		endDate: '+0d'
    });
    
	$("select[name=scope]").change(scope_change);
	scope_change();
});
</script>