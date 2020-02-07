<?php $this->load->model('expenses_model'); ?>
<div>
	<div class="page-title">
		<div class="title_left"><h3>Payments</h3></div>
	</div>
	<div class="clearfix"></div>
	
	<!-- Product List Section -->
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<?php echo $message; ?>
				<div class="x_title">
					<button type="button" class="btn btn-primary" name="search_claim"><i class="fa fa-search"></i> Search Payable Items</button>
					<?php echo anchor("claim/export".$export_para, '<i class="fa fa-download"></i> Export', array("class"=>'btn btn-primary pull-right')); ?>
					<?php echo anchor("claim/import", '<i class="fa fa-upload"></i> Import', array("class"=>'btn btn-primary pull-right')); ?>
				</div>
				<div class="x_content">
					<!-- search claim filter start --> 
					<?php echo form_open("", array('class'=>'form-horizontal', 'method'=>'get', 'id'=>'search_claim', 'style'=>'display:none')); ?>
					<div class="row">
						<div class="form-group col-sm-4">
							<?php echo form_label('Approved Date From:', 'last_update_from', array("class"=>'col-sm-12')); ?>
							<div class="input-group date">
								<?php echo form_input("last_update_from", $this->input->get("last_update_from"), array("class" => "form-control datepicker", 'placeholder' => 'Approved Date From')); ?>
								<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
							</div>
						</div>
						<div class="form-group col-sm-4">
							<?php echo form_label('Approved Date To:', 'last_update_to', array("class"=>'col-sm-12')); ?>
							<div class="input-group date">
								<?php echo form_input("last_update_to", $this->input->get("last_update_to"), array("class" => "form-control datepicker", 'placeholder' => 'Approved Date To')); ?>
								<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
							</div>
						</div>
						<div class="form-group col-sm-4">
							<?php echo form_label('Claim Number:', 'claim_no_claim', array("class" => 'col-sm-12')); ?>
							<?php echo form_input("claim_no_claim", $this->input->get("claim_no_claim"), array("class" => "form-control", 'placeholder' => 'Claim Number')); ?>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-sm-4">
							<?php echo form_label('Created Date From:', 'created_from', array("class"=>'col-sm-12')); ?>
							<div class="input-group date">
								<?php echo form_input("created_from", $this->input->get("created_from"), array("class" => "form-control datepicker", 'placeholder' => 'Created Date From')); ?>
								<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
							</div>
						</div>
						<div class="form-group col-sm-4">
							<?php echo form_label('Created Date To:', 'created_to', array("class"=>'col-sm-12')); ?>
							<div class="input-group date">
								<?php echo form_input("created_to", $this->input->get("created_to"), array("class" => "form-control datepicker", 'placeholder' => 'Created Date To')); ?>
								<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
							</div>
						</div>
						<div class="col-sm-4">
							<label class="col-sm-12">&nbsp;</label>
							<button class="btn btn-primary" name="filter" value="claim">Display Claim</button>
						</div>
					</div>
					<?php echo form_close(); ?>
					<!-- search claim filter end -->
					<div class="clearfix"><br /></div>

					<div class="table-responsive">
						<?php if (! empty($claims)) { ?>
                        <table class="table table-hover table-bordered">
							<thead>
								<tr>
									<th>Claim No</th>
									<th>Policy No</th>
									<th>Insured Name</th>
									<th>Total Claimed</th>
									<th>Total Paid</th>
									<th>Total Received</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($claims as $key => $value): ?>
								<tr class="select_claim row-link" data='<?php echo json_encode($value) ?>' alt="<?php echo $value['claim_id']; ?>" case_no="<?php echo $value['case_no']; ?>" status="<?php echo $value['status']; ?>">
									<td><?php echo $value['claim_no']; ?></td>
									<td><?php echo $value['policy_no']; ?></td>
									<td><?php echo $value['insured_first_name'].' '.$value['insured_last_name']; ?></td>
									<td><?php echo $value['amount_claimed']?$value['amount_claimed']:0; ?></td>
									<td><?php echo $value['amount_client_paid']?$value['amount_client_paid']:0; ?></td>
									<td><?php echo $value['amt_received']?$value['amt_received']:0; ?></td>
								</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
						<?php } ?>
						<?php echo $pagination; ?>
					</div>

					<div class="table-responsive">
						<h4>Claim Items</h4>
						<div class="row">
							<div class="table-responsive claim_payment_items">
								<center><?php echo heading("No record available", 4); ?></center>
							</div>
						</div>
					</div>

					<div class="payee_section" style="display: none">
						<?php echo form_open("claim/confirm_payment", array('class'=>'form-horizontal', 'method'=>'post', 'id'=>'confirm_payment')); echo form_hidden('claim_id')?>
						<div class="row">
							<div class="col-sm-12 payees_items">
								<div class="payee-data"></div>
							</div>
						</div>
						<div class="row" style="margin-top: 20px">
							<div class="col-sm-2 confirm_button">
								<input class="btn btn-primary" name="Confirm_Payment" value="Confirm Payment" type="submit" disabled="disabled">
							</div>
							<div class="col-sm-1">
								<?php echo anchor("claim", "Cancel", array("class"=>'btn btn-primary')); ?>
							</div>
							<div class="col-sm-2 close_button">
								<input class="btn btn-primary" name="Close_Claim" value="Close Claim" type="button" disabled="disabled">
							</div>
						</div>
						<?php echo form_close(); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- End List Section -->
</div>

<div style="display: none">
	<div class="payee-buffer">
		<div class="row" style="border: 1px solid rgb(204, 204, 204); padding: 10px; margin-bottom: 9px">
			<div class="col-sm-12">
				<div class="col-sm-2">
					<?php echo form_radio("payment_type", "cheque", TRUE, array('class' => 'setpremium')); ?>
					<?php echo form_label('Cheque:', 'Cheque'); ?>
				</div>
				<div class="col-sm-2">
					<?php echo form_radio("payment_type", "email transfer", FALSE, array('class' => 'setpremium')); ?>
					<?php echo form_label('Email Transfer', 'Email Transfer'); ?>
				</div>
			</div>
			<br />
			<div class="col-sm-3 wire_transfer_section" style="display: none">
				<?php echo form_label('Email Transfer:', 'Email Transfer', array("class" => 'col-sm-12')); ?>
				<?php echo form_input("payees[bank][]", $this->input->post("bank"), array("class" => "form-control", 'placeholder' => 'Email Transfer')); ?>
			</div>
			<div class="col-sm-3 cheque_section wire_transfer_section">
				<?php echo form_label('Payee Name:', 'Payee Name', array("class" => 'col-sm-12')); ?>
				<?php echo form_input("payees[payee_name][]", $this->input->post("payee_name"), array("class" => "form-control", 'placeholder' => 'Payee Name')); ?>
			</div>
			<div class="col-sm-3" style="display: none">
				<?php echo form_label('Account#:', 'Account', array("class" => 'col-sm-12')); ?>
				<?php echo form_input("payees[account_cheque][]", $this->input->post("account_cheque"), array("class" => "form-control", 'placeholder' => 'Account#')); ?>
			</div>
			<div class="col-sm-3 cheque_section">
				<?php echo form_label('Address:', 'Address', array("class" => 'col-sm-12')); ?>
				<?php echo form_input("payees[address][]", $this->input->post("address"), array("class" => "form-control", 'placeholder' => 'Address')); ?>
			</div>
			<div class="col-sm-3">
				<label class='col-sm-12'>&nbsp;</label> <i class="col-sm-3 fa fa-trash row-link remove-payee"></i>
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
});
<?php if (! empty($this->input->get())) { ?>
	$("#search_claim").show(); 
<?php } ?>
$(document).on("click", "button[name=search_claim]", function(){
	$("#search_claim").slideToggle("slow");
})
.on("click", ".add_payee", function() {
	var html = $(".payee-buffer").html();
	var length = $(".payee-data .row").length;

	html = html.replace(/payment_type/g, "payment_type_"+(length+1));
	$(".payee-data").append(html);
})
.on("click", ".remove-payee", function() {
	if(confirm('Are you sure you want to remove payee?')){
		$(this).parent("div").parent("div").remove();

		var payee_id = $(this).parent("div").parent("div").find("input[name='payees[id][]']").val();
		if (payee_id){
			$.ajax({
				url: "<?php echo base_url("claim/delete_payee/") ?>"+payee_id,
				method: "get"
			})
		}
	}
	
	$count = 0;
	$(".payee-data .row").map(function(){
		$count++;
		$(this).find('input[name^=payment_type]').attr('name', 'payment_type_'+$count);
	})
})
// when clicked on claim item history section
.on('click', ".select_payees", function(){
	var claim_id = $(this).attr('alt');
	var discount = $(this).attr('discount');
	var pay_to = $(this).attr('pay_to');
	var status = $(this).attr('status');
	var amt_payable = 0;

	$("tr[pay_to='"+pay_to+"']").each(function(){
		amt_payable += parseFloat($(this).attr('amt_payable'));
	})

	// enable payee section
	$(".payee_section").slideDown();
	
	// settings for activate listing
	$(".select_payees").removeClass('active-green');
	$(this).addClass('active-green');
	$("tr[pay_to='"+pay_to+"']").addClass('active-green');
	
	if(status == 'paid'){
		$("input[name=Confirm_Payment]").attr('disabled', 'disabled');
	} else if(status == 'closed'){
		$("input[name=Confirm_Payment]").removeAttr('disabled');
	} else{
		$("input[name=Confirm_Payment]").removeAttr('disabled');
	}

	// get claimed items here
	$.ajax({
		url: "<?php echo base_url("claim/select_payees") ?>",
		method: "post",
		data:{
			claim_id:claim_id, 
			pay_to:pay_to
		},
		dataType:"json",
		beforeSend: function(){
			$(".main_container").addClass("csspinner load1");
		},
		success: function(result) {
			// place data table to releted section
			$(".payee-data").html(result.payees)
			
			// place claim id
			$("input[name=claim_id]").val(claim_id);
			
			// remove loader function
			$(".main_container").removeClass("csspinner load1");
			
			// place amount to payment field
			$("input[name='payees[payment][]']").val(amt_payable);
			$("input[name='payees[old_amount][]']").val(amt_payable);
			
			
			// enable disable confirm payment and close claim operation
			if(result.status == 'paid'){
				$("input[name=Confirm_Payment]").attr('disabled', 'disabled');
				$("input[name=Close_Claim]").removeAttr('disabled');
			} else if(result.status == 'closed'){
				$("input[name=Confirm_Payment], input[name=Close_Claim]").attr('disabled', 'disabled');
			}
			
			$(".payees_items").show();
		}
	})
})

// once user clicked over confirm payment button
.on("submit", "#confirm_payment", function(e){
	e.preventDefault();
	
	var claim_id = $(".select_payees.active-green").attr('alt');
	
	if(!confirm('Are you sure you want to confirm payment for this claim?')){
		return false;
	}
	
	// get all items for these same payees
	var items = [];
	$(".select_payees.active-green").each(function(){
		items.push($(this).attr('item_id'));
	})
	var items = items.join(",");
	// confirm payment code goes here.
	$.ajax({
		url: $(this).attr("action")+"/<?php echo Expenses_model::EXPENSE_STATUS_Paid; ?>/"+items,
		method: "post",
		data:$(this).serialize(),
		dataType:"json",
		beforeSend: function(){
			$(".main_container").addClass("csspinner load1");
		},
		success: function(result) {
			window.location.reload();
		}
	})
})

// once user clicked over close claim button
.on("click", "input[name=Close_Claim]", function(e){
	e.preventDefault();

	var claim_id = $(".select_claim.active-green").attr('alt');

	if(!confirm('Are you sure you want to close this claim?')){
		return false;
	}
	
	// confirm payment code goes here.
	$.ajax({
		url: "<?php echo base_url('claim/close_claim'); ?>",
		method: "post",
		data:{
			claim_id:claim_id
		},
		dataType:"json",
		beforeSend: function(){
			$(".main_container").addClass("csspinner load1");
		},
		success: function(result) {
			window.location.reload();
		}
	})
})

 // once user select pay type
.on("click", "input[name^=payment_type]", function(){
	var element = $(this).parent("div").parent("div").parent("div");
	if($(this).val() == 'cheque'){
		element.find(".wire_transfer_section").hide();
		element.find(".cheque_section").show();
	} else {
		element.find(".cheque_section").hide();
		element.find(".wire_transfer_section").show();
	}
})

 // when clicked on claim item history section
.on('click', ".select_claim", function(){
	var claim_id = $(this).attr('alt');
	var case_no = $(this).attr('case_no');
	var status = $(this).attr('status');
	
	$(".payees_items").hide();
	if (status == 'paid') {
		$(".payee_section").show();
		$("input[name=Close_Claim]").removeAttr('disabled');
	} else {
		$("input[name=Confirm_Payment], input[name=Close_Claim]").attr('disabled', 'disabled');
		$(".payee_section").hide();
	}
	
	// settings for activate listing
	$(".select_claim").removeClass('active-green');
	$(this).addClass('active-green');
	
	// get claimed items here
	$.ajax({
		url: "<?php echo base_url("claim/claim_payment_items") ?>",
		method: "post",
		data:{
			claim_id:claim_id,
			case_no:case_no,
		},
		dataType:"json",
		beforeSend: function(){
			$(".main_container").addClass("csspinner load1");
		},
		success: function(result) {
			// place data table to releted section
			$(".claim_payment_items").html(result.claim_payment_items)
			$(".main_container").removeClass("csspinner load1");
			$(".case_info").html(result.case_info)
			$(".policy_info").html(result.policy_info)
		}
	})
})
</script>