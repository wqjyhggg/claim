<div>
	<div class="page-title">
		<div class="title_left">
			<h3>Claim Summary Report</h3>
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
							<?php echo form_label('Status Group:', 'status_group', array ("class" => 'col-sm-12')); ?>
							<select name="status_group" class="form-control">
								<option value="Paid">Paid, Declined</option>
								<option value="Unpaid">Received, Approved, Pending</option>
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
									<th>Claim Number</th>
									<th>Claim Type</th>
									<th>Status</th>
									<th>Policy Number</th>
									<th>Product</th>
									<th>Policy Date</th>
									<th>Agent ID </th>
									<th>Coverage Code</th>
									<th>Entered Date</th>
									<th>Incident Date</th>
									<th>Incident Country </th>
									<th>Payment Date/ Void Date</th>
									<th>Payee Name</th>
									<th>Payee Address</th>
									<th>Payee Country</th>
									<th>Payee Province</th>
									<th>Payee Type</th>
									<th>Provider Name</th>
									<th>Provider Address </th>
									<th>Provider Country</th>
									<th>Provider Province</th>
									<th>Payment Method</th>
									<th>Cheque Number</th>
									<th>Total Claim Amount</th>
									<th>Discount Amount</th>
									<th>Denied Amount</th>
									<th>Deductible Amount</th>
									<th>Net Claim Paid amount</th>
									<th>Payment Currency</th>
									<th>Invoice Currency </th>
									<th>Network Fees</th>
									<th>Network Provider</th>
									<th>Recovery Amount</th>
									<th>Void amount</th>
									<th>Void Reason </th>
									<th>Deny Reason</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach($records as $key => $value ) { ?>
								<tr>
									<td><?php echo $value['claim_no']; ?></td>
									<td><?php echo $value['claim']['exinfo_type']; /*top_baggage, top_trip, top_medical*/ ?></td>
									<td><?php echo $value['status']; /*Received Paid Approved Declined Duplicated Pending*/ ?></td>
									<td><?php echo $value['claim']['policy_no']; ?></td>
									<td><?php echo $value['claim']['product_short']; ?></td>
									<td><?php echo $value['claim']['apply_date']; ?></td>
									<td><?php echo $value['claim']['agent_id']; ?></td>
									<td><?php echo $value['created']; ?></td>
									<td><?php echo $value['claim']['date_symptoms']; /*Incident Date*/?></td>
									<td>N/A<?php /* echo $value['claim']['country_symptoms']; /*Incident Country XXXXXXXXXXXXXXXXXXXXX no input place */ ?></td>
									<td><?php echo $value['pay_date']; /*Payment Date/ Void Date*/ ?></td>
									<td><?php echo ($value['payeearr'] ? $value['payeearr']['payee_name'] : ''); /* Payee Name */ ?></td>
									<td><?php echo ($value['payeearr'] ? $value['payeearr']['address'] : ''); /* Payee Address */ ?></td>
									<td><?php echo ($value['payeearr'] ? $value['payeearr']['country'] : ''); /* Payee Country */ ?></td>
									<td><?php echo ($value['payeearr'] ? $value['payeearr']['province'] : ''); /* Payee Province */ ?></td>
									<td><?php echo ($value['third_party_payee'] ? 'Business' : 'Private'); /* Payee Type */ ?></td>

									<td><?php echo isset($value['provider']['name']) ? $value['provider']['name'] : ''; /*Provider Name*/?></td>
									<td><?php echo isset($value['provider']['address']) ? $value['provider']['address'] : ''; /*Provider Address*/?></td>
									<td><?php echo isset($value['provider']['country']) ? $value['provider']['country'] : ''; /*Provider Country*/?></td>
									<td><?php echo isset($value['provider']['province']) ? $value['provider']['province'] : ''; /*Provider Province*/?></td>
									<td><?php echo ($value['payeearr'] ? $value['payeearr']['payment_type'] : ''); /* Payment Method */ ?></td>
									<td><?php echo $value['cheque']; /* Cheque Number for claim items */?></td>

									<td>$<?php echo number_format($value['amount_claimed'], 2); /*Total Claim Amount*/ ?></td>
									<td>$<?php echo number_format(0, 2); /*Discount Amount Add in items discount_amount XXXXXXXXXXXXXXXXX */?></td>
									<td>$<?php echo number_format($value['amount_claimed'] - $value['amt_payable'], 2); /*Denied Amount : claimed - payable */?></td>
									<td>$<?php echo number_format($value['amt_deductible'], 2); /*Deductible Amount*/?></td>
									<td>$<?php echo number_format($value['amt_payable'], 2); /*Net Claim Paid Amount*/?></td>
									<td><?php echo 'CAD'; /*Payment Currency CAD only */ ?></td>
									<td><?php echo $value['currency']; /*Invoice Currency*/ ?></td>
									<td>$<?php echo ($value['provider_type'] ? number_format($value['provider']['network_fee'], 2) : 0); /*Network Fees */?></td>
									<td><?php echo isset($value['provider']['name']) ? $value['provider']['name'] : ''; /*Network Provider */ ?></td>
									<td>$<?php echo number_format($value['recovery_amt'], 2); /* Recovery amount XXXXXXXXXXXXXXX no input place */?></td>
									<td>$<?php echo number_format($value['amount_claimed'], 2); /*Void amount  Duplicated / Void XXXXXXXXXXXXXXXXX */?></td>
									<td><?php echo $value['reason']; /*Void Reason*/ ?></td>
									<td><?php echo $value['reason_other']; /*Deny Reason*/ ?></td>
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
		format: "yyyy-mm",
		viewMode: "months", 
	    minViewMode: "months",
	    endDate: '+0m'
    });
});
</script>