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
					<button type="button" class="btn btn-primary pull-right" name="import_items"><i class="fa fa-upload"></i> Import</button>
					<?php echo anchor("claim/export".$export_para, '<i class="fa fa-download"></i> Export', array("class"=>'btn btn-primary pull-right')); ?>
				</div>
				<div class="x_content">
					<?php echo form_open_multipart("claim/import", array('class'=>'form-horizontal', 'method'=>'post', 'id'=>'import_items', 'style'=>'display:none')); ?>
					<div class="row">
						<div class="form-group col-sm-4">
							<?php echo form_label('Select csv file to upload:', 'items_file', array("class"=>'col-sm-12')); ?>
						</div>
						<div class="form-group col-sm-4">
							<?php echo form_upload("csv_file"); ?>
						</div>
						<div class="col-sm-4">
							<button class="btn btn-primary" name="filter" value="claim">Upload</button>
						</div>
					</div>
					<div class="clearfix"><br /></div>
					<?php echo form_close(); ?>

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
							<?php echo form_label('Claim Number:', 'claim_no', array("class" => 'col-sm-12')); ?>
							<?php echo form_input("claim_no", $this->input->get("claim_no"), array("class" => "form-control", 'placeholder' => 'Claim Number')); ?>
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
							<?php echo form_label('Product:', 'product_short', array("class"=>'col-sm-12')); ?>
							<select name="product_short" class="form-control">
								<option value="">--Select Product--</option>
								<?php foreach ($products as $key => $val): ?>
								<option value="<?php echo $key; ?>" <?php if ($key == $this->input->get("product_short")) { echo "selected"; } ?>><?php echo $val; ?></option>
								<?php endforeach; ?>
							</select>
						
							<label class="col-sm-12">&nbsp;</label>
							<button class="btn btn-primary" name="filter" value="claim">Display Claim</button>
						</div>
					</div>
					<?php echo form_close(); ?>
					<!-- search claim filter end -->
					<div class="clearfix"><br /></div>

					<h4>Claim Items</h4>
					<div class="row">
						<div class="table-responsive claim_payment_items">
							<?php if (! empty($items)) { ?>
							<table class="table table-hover table-bordered">
								<thead>
									<tr>
										<th><?php echo form_checkbox("item_all", 'all', false, array('id' => 'item_all')); ?></th>
										<th>No.</th>
										<th>Claim No.</th>
										<th>Claim Item No.</th>
										<th>Invoice No.</th>
										<th>Service Date</th>
										<th>Coverage</th>
										<!-- th>Diagnosis</th -->
										<th>Amt Claimed</th>
										<th>Amt Payable</th>
										<th>Amt Deductible</th>
										<th>Pay To</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($items as $item) { ?>
									<tr>
										<td><?php echo form_checkbox("item_id", '', false, array("class" => "item_id", 'data-id' => $item['id'])); ?></td>
										<td><?php echo $item['id']; ?></td>
										<td><?php echo $item['claim_no']; ?></td>
										<td><?php echo $item['claim_item_no']; ?></td>
										<td><?php echo $item['invoice']; ?></td>
										<td><?php echo $item['date_of_service']; ?></td>
										<td><?php echo $item['coverage_code']; ?></td>
										<!-- td><?php echo $item['diagnosis']; ?></td -->
										<td><?php echo $item['amount_claimed']; ?></td>
										<td><?php echo $item['amt_payable']; ?></td>
										<td><?php echo $item['amt_deductible']; ?></td>
										<td><?php echo $item['pay_to']; ?></td>
									</tr>
									<?php } ?>
								</tbody>
							</table>
							<?php echo $pagination; ?>
							<?php } else { ?>
							<center><?php echo heading("No record available", 4); ?></center>
							<?php } ?>
						</div>
					</div>

					<div class="pay_section">
						<div class="row" style="margin-top: 20px; display:none;">
							<div class="col-sm-2 confirm_button">
								<input class="btn btn-primary" name="Confirm_Payment" value="Confirm Payment" id="confirm_payment" disabled="disabled">
							</div>
						</div>
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
		startDate: '-105y',
		endDate: '+2y',
	});
});
<?php if (! empty($this->input->get())) { ?>
	$("#search_claim").show(); 
<?php } ?>
$(document).on("click", "button[name=search_claim]", function(){
	$("#search_claim").slideToggle("slow");
	$("#import_items").hide();
})
.on("click", "button[name=import_items]", function(e){
	$("#import_items").slideToggle("slow");
	$("#search_claim").hide();
})
.on("change", "#item_all", function(e){
	var ds = $("#item_all").is(':checked');
	$(".item_id").each(function() {
		$(this).prop("checked", ds );
	});

	if (ds) {
		if ($('#confirm_payment').is(':disabled')) {
			$('#confirm_payment').prop( "disabled", false );
		}
	} else {
		if (! $('#confirm_payment').is(':disabled')) {
			$('#confirm_payment').prop( "disabled", true );
		}
	}
})
.on("change", ".item_id", function(e){
	var ds = true;
	$(".item_id").each(function() {
		if ($(this).is(':checked')) {
			ds = false;
		}
	});

	if (ds) {
		if (! $('#confirm_payment').is(':disabled')) {
			$('#confirm_payment').prop( "disabled", true );
		}
	} else {
		if ($('#confirm_payment').is(':disabled')) {
			$('#confirm_payment').prop( "disabled", false );
		}
	}
})
// once user clicked over confirm payment button
.on("click", "#confirm_payment", function(e){
	e.preventDefault();
	
	if(!confirm('Are you sure you want to confirm payment for this claim?')){
		return false;
	}
	
	// get all items for these same payees
	var items = [];
	$(".item_id").each(function() {
		if ($(this).is(':checked')) {
			items.push($(this).attr('data-id'));
		}
	});

	var items = items.join(",");
	// confirm payment code goes here.
	$.ajax({
		url: "<?php echo base_url("claim/confirm_payment") ?>" + "/" + items,
		method: "get",
		//dataType:"json",
		beforeSend: function(){
			$(".main_container").addClass("csspinner load1");
		},
		success: function(result) {
			window.location.reload();
		}
	})
})

</script>