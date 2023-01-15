<div>
	<?php echo $message; ?>
	
	<!-- Policy search and List Section -->
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Filters<small></small></h2>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<!-- search filter start -->
					<?php echo form_open("eclaim/index", array('class'=>'form-horizontal', 'method'=>'get')); ?>
					<div class="row">
                        <div class="form-group col-sm-3">
							<?php echo form_label ( 'Eclaim No:', 'Eclaim number', array("class" => 'col-sm-12')); ?>
							<?php echo form_input ( "eclaim_no", $this->input->post_get("eclaim_no"), array("class" => "form-control",'placeholder' => 'Eclaim ID') ); ?>
						</div>
						<div class="form-group col-sm-3">
							<?php echo form_label ( 'Policy Number:', 'policy', array("class" => 'col-sm-12')); ?>
							<?php echo form_input ( "policy_no", $this->input->post_get("policy_no"), array("class" => "form-control",'placeholder' => 'Policy Number') ); ?>
						</div>
						<div class="form-group col-sm-3">
							<?php echo form_label('Created From:', 'created_from', array("class"=>'col-sm-12')); ?>
							<div class="input-group date">
								<?php echo form_input ( "created_from", $this->input->post_get( "created_from" ), array ("class" => "form-control datepicker", 'placeholder' => 'Created From') ); ?>
								<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
							</div>
						</div>
						<div class="form-group col-sm-3">
							<?php echo form_label('Created To:', 'created_to', array("class"=>'col-sm-12')); ?>
							<div class="input-group date">
								<?php echo form_input ( "created_to", $this->input->post_get( "created_to" ), array ("class" => "form-control datepicker", 'placeholder' => 'Created To') ); ?>
								<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
							</div>
						</div>
						<div class="clearfix"></div>
					</div>
					<div class="row">
						<div class="form-group col-sm-3">
							<?php echo form_label ( 'Claim No:', 'claim_no', array ("class" => 'col-sm-12')); ?>
							<?php echo form_input ( "claim_no", $this->input->post_get("claim_no"), array("class" => "form-control", 'placeholder' => 'Claim No') );?>
						</div>
                        <div class="form-group col-sm-3">
							<?php echo form_label ( 'First Name:', 'first_name', array ("class" => 'col-sm-12')); ?>
							<?php echo form_input ( "insured_first_name", $this->input->post_get("insured_first_name"), array("class" => "form-control", 'placeholder' => 'First Name') );?>
						</div>
						<div class="form-group col-sm-3">
							<?php echo form_label ( 'Last Name:', 'last_name', array ("class" => 'col-sm-12')); ?>
							<?php echo form_input ( "insured_last_name", $this->input->post_get("insured_last_name"), array("class" => "form-control", 'placeholder' => 'Last Name') );?>
						</div>
						<div class="form-group col-sm-3">
							<?php echo form_label ( 'Status:', 'status', array ("class" => 'col-sm-12') ); ?>
							<?php echo form_dropdown ( "status", array(0 => "-- Select Status --", 1 => "Received", 2 => "Transferred", 3 => "Refused"), $this->input->post_get( "status" ), array ("class" => 'form-control') );?>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-3">
							<?php echo form_label('Date of Birth:', 'Date of Birth', array("class"=>'col-sm-12')); ?>
							<div class="input-group date">
								<?php echo form_input ( "cdob", $this->input->post_get( "cdob" ), array ("class" => "form-control datepicker", 'placeholder' => 'Date of Birth') ); ?>
								<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
							</div>
						</div>
						<div class="col-sm-3">
							<label class="col-sm-12">&nbsp;</label>
						</div>
						<div class="col-sm-3">
							<label class="col-sm-12">&nbsp;</label>
						</div>
						<div class="col-sm-3">
							<label class="col-sm-12">&nbsp;</label>
							<button class="btn btn-primary" name="filter" value="eclaim">Search</button>
						</div>
						<div class="clearfix"></div>
					</div>
					<?php echo form_close(); ?>
					<!-- search filter end -->
				</div><!-- x_content -->
            </div><!-- x_panel -->
            <div class="x_panel">
				<div class="x_title">
					<div class="row">
						<div class="form-group col-sm-3">
							<h2>Eclaim Search Result<small></small></h2>
						</div>
						<div class="form-group col-sm-3 text-right">
							Assign To
						</div>
						<div class="form-group col-sm-3">
							<?php echo form_dropdown ( "assign_user", $assign_users, 0, array ("class" => 'form-control', "id" => 'assign_user') );?>
						</div>
						<div class="form-group col-sm-3">
							<button class="btn btn-primary" id="Assign">Assign</button>
						</div>
					<div class="clearfix"></div>
				</div>
                <div class="x_content">
                    <div class="table-responsive">
						<table class="table table-hover table-bordered">
							<thead>
								<tr>
									<th><?php echo form_checkbox("selectall", 1, FALSE); ?></th>
                                    <th>RefID</th>
									<th>Policy</th>
									<th>Claim No</th>
									<th>Assign to</th>
									<th>First Name</th>
									<th>Last Name</th>
									<th>Status</th>
									<th>Birth Date</th>
									<th>Create Date</th>
									<th>Amount</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($eclaims as $key => $value): ?>
								<tr data-id="<?php echo $value['id']; ?>">
									<td><?php echo form_checkbox("assign_id", $value['id'], FALSE); ?></td>
									<td><?php echo $value['eclaim_no']; ?></td>
									<td><a href="<?php echo $policy_detail_url.$value['policy_no']; ?>" target="_blank"><?php echo $value['policy_no']; ?></a></td>
									<td><?php echo $value['claim_no']; ?></td>
									<td><?php echo empty($assign_users[$value['processed_by']])?"":$assign_users[$value['processed_by']]; ?></td>
									<td><?php echo htmlspecialchars($value['insured_first_name']); ?></td>
									<td><?php echo htmlspecialchars($value['insured_last_name']); ?></td>
									<td><?php echo (($value['status']==2)?'Transferred':(($value['status']==3)?'Refused':'Received')); ?></td>
									<td><?php echo htmlspecialchars($value['dob']); ?></td>
									<td><?php echo htmlspecialchars($value['created']); ?></td>
									<td><?php echo floatval($value['amount']); ?></td>
									<td><?php echo anchor("eclaim/detail/".$value['id'], "View"); ?></td>
								</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
                        <?php echo $pagination; ?>
					</div>
                </div>
			</div><!-- x_panel -->
		</div><!-- col-md-12 col-sm-12 col-xs-12 -->
	</div><!-- row -->
</div>

<?php echo link_tag('assets/css/bootstrap-datepicker.css'); ?>
<script src="<?php echo base_url() ?>/assets/js/bootstrap-datetimepicker.js"></script>
<script>
$(document).ready(function() {
	$(".datepicker").datepicker({
		startDate: '-105y',
		endDate: '+2y',
	});
}).on("click", "input[name=selectall]", function(){                                   // select all checkboxes script
   if ($(this).is(":checked")) {                                                          // check user click check or uncheck tickbox
      $("input[name=assign_id]").prop("checked", true);
   } else {
      $("input[name=assign_id]").prop("checked", false);
   }
}).on("click", "#Assign",  function(e){                // enable disable buttons
	e.preventDefault();
	var dt = new FormData();
	console.log("SSSSSS",$("#assign_user").val()); //XXXXXXXXXXXXXXX
	dt.append('assign_id', $("#assign_user").val());
	$("input[name=assign_id]").forEach(function(el){
		console.log("SSSSS111S", el.checked, el.value); //XXXXXXXXXXXXXXX
		if (el.checked) {
			dt.append('eclaimids[]', el.value);
    	}
	});
	$.ajax({
		url: "<?php echo base_url("eclaim/assign_to") ?>",
		method: "post",
		dataType:"json",
		data: dt,
		success: function(result) {
			console.log("RRRRRR",result);
			// window.location.reload();
		}
	});
})
</script>
