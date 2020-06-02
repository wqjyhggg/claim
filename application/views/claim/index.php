<div>
	<?php if (0 && $this->ion_auth->in_group(array(Users_model::GROUP_ADMIN, Users_model::GROUP_CLAIMER, Users_model::GROUP_EXAMINER))) { ?>
	<div class="page-title">
		<div class="title_left"><?php echo anchor("claim/create_claim", '<i class="fa fa-plus-circle"></i> Create New Claim', array("class"=>'btn btn-primary create_claim'))?></div>
	</div>
	<div class="clearfix"></div>
	<?php } ?>
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
					<?php echo form_open("", array('class'=>'form-horizontal', 'method'=>'get')); ?>
					<div class="row">
						<div class="form-group col-sm-2">
							<?php echo form_label ( 'Policy Number:', 'policy', array("class" => 'col-sm-12')); ?>
							<?php echo form_input ( "policy_match", $this->input->post_get("policy_match"), array("class" => "form-control",'placeholder' => 'Policy Number') ); ?>
						</div>
						<div class="form-group col-sm-2">
							<?php echo form_label ( 'Case Number:', 'case', array("class" => 'col-sm-12')); ?>
							<?php echo form_input ( "case_no", $this->input->post_get( "case_no" ), array("class" => "form-control", 'placeholder' => 'Case Number') );?>
						</div>
						<div class="form-group col-sm-2">
							<?php echo form_label ( 'Claim Number:', 'claim', array("class" => 'col-sm-12')); ?>
							<?php echo form_input ( "claim_no", $this->input->post_get( "claim_no" ), array("class" => "form-control", 'placeholder' => 'Claim Number') );?>
						</div>
						<div class="form-group col-sm-2">
							<?php echo form_label('Claim Created Date From:', 'created_from', array("class"=>'col-sm-12')); ?>
							<div class="input-group date">
								<?php echo form_input ( "created_from", $this->input->post_get( "created_from" ), array ("class" => "form-control datepicker", 'placeholder' => 'Created Date From') ); ?>
								<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
							</div>
						</div>
						<div class="form-group col-sm-2">
							<?php echo form_label('Claim Created Date To:', 'created_to', array("class"=>'col-sm-12')); ?>
							<div class="input-group date">
								<?php echo form_input ( "created_to", $this->input->post_get( "created_to" ), array ("class" => "form-control datepicker", 'placeholder' => 'Created Date To') ); ?>
								<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
							</div>
						</div>
						<div class="form-group col-sm-2">
							<?php echo form_label ( 'Claim Status:', 'status', array ("class" => 'col-sm-12') ); ?>
							<?php echo form_dropdown ( "status", $claim_status, $this->input->post_get( "status" ), array ("class" => 'form-control') );?>
						</div>
						<div class="clearfix"></div>
					</div>
					<div class="row">
						<!-- div class="form-group col-sm-3">
							<?php echo form_label('Products:', 'products', array("class"=>'col-sm-12')); ?>
							<?php array_unshift($products, '-- Product --'); ?>
							<?php echo form_dropdown ( "product_short", $products, $this->input->post_get( "product_short" ), array ("class" => 'form-control') );?>
						</div -->
						<input type="hidden" name="assign_to">
						<input type="hidden" name="case_manager">
						<!-- div class="form-group col-sm-3">
							<?php echo form_label('EAC:', 'eac', array("class"=>'col-sm-12')); ?>
							<select name="assign_to" class="form-control">
								<option value=""> -- Select EAC -- </option>
								<?php foreach ($eacs as $rc):?>
								<option value="<?php echo $rc['id']; ?>" <?php if ($rc['id'] == $this->input->post_get("assign_to")) { echo "selected"; } ?>><?php echo $rc['email']; ?></option>
								<?php endforeach; ?>
							</select>
						</div -->
						<!-- div class="form-group col-sm-3">
							<?php echo form_label('Case Manager:', 'case', array("class"=>'col-sm-12')); ?>
							<select name="case_manager" class="form-control">
								<option value=""> -- Select Manager -- </option>
								<?php foreach ($mamagers as $rc) :?>
								<option value="<?php echo $rc['id']; ?>" <?php if ($rc['id'] == $this->input->post_get("case_manager")) { echo "selected"; } ?>><?php echo $rc['email']; ?></option>
								<?php endforeach; ?>
							</select>
						</div -->
						<div class="form-group col-sm-3">
							<?php echo form_label('Examiner:', 'claim_examiner', array("class"=>'col-sm-12')); ?>
							<select name="claim_examiner" class="form-control">
								<option value=""> -- Select Examiner -- </option>
								<?php foreach ($examiners as $rc) :?>
								<option value="<?php echo $rc['id']; ?>" <?php if ($rc['id'] == $this->input->post_get("assign_to")) { echo "selected"; } ?>><?php echo $rc['email']; ?></option>
								<?php endforeach; ?>
							</select>
						</div>
						<div class="form-group col-sm-2">
							<?php echo form_label ( 'EClaim:', 'eclaim_sls', array ("class" => 'col-sm-12') ); ?>
							<?php echo form_dropdown ( "eclaim_sls", array(0 => '', 0 => 'No', 0 => 'Yes'), $this->input->post_get( "eclaim_sls" ), array ("class" => 'form-control') );?>
						</div>
						<div class="col-sm-3">
							<label class="col-sm-12">&nbsp;</label>
							<button class="btn btn-primary" name="filter" value="policy">Search</button>
							<a href="javascript:void(0)" class="btn btn-info more_filters">More Filter</a>
						</div>
						<div class="clearfix"></div>
					</div>
					<div class="row more_items" style="display:none">
						<div class="form-group col-sm-3">
							<?php echo form_label ( 'Last / First Nmae:', 'name', array ("class" => 'col-sm-12')); ?>
							<?php echo form_input ( "lastname", $this->input->post_get("lastname"), array("class" => "form-control", 'placeholder' => 'Last Name') );?>
						</div>
						<div class="form-group col-sm-3">
							<?php echo form_label ( 'Arrival Date:', 'arrival_date', array ("class" => 'col-sm-12')); ?>
							<div class="input-group date">
								<?php echo form_input ( "arrival_date", $this->input->post_get( "arrival_date" ), array ("class" => "form-control datepicker",'placeholder' => 'Arrival Date From') ); ?>
								<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
							</div>
						</div>
						<div class="form-group col-sm-3">
							<?php echo form_label ( 'Effective Date:', 'effective_date', array ("class" => 'col-sm-12')); ?>
							<div class="input-group date">
								<?php echo form_input ( "effective_date", $this->input->post_get( "effective_date" ), array ("class" => "form-control datepicker", 'placeholder' => 'Effective Date From') ); ?>
								<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
							</div>
						</div>
						<div class="form-group col-sm-3">
							<?php echo form_label ( 'Expiry Date:', 'expiry_date', array ("class" => 'col-sm-12')); ?>
							<div class="input-group date">
								<?php echo form_input ( "expiry_date", $this->input->post_get( "expiry_date" ), array ("class" => "form-control datepicker", 'placeholder' => 'Expiry Date From') ); ?>
								<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
							</div>
						</div>
						<div class="clearfix"></div>
					</div>
						
					<div class="row more_items" style="display:none">
						<div class="form-group col-sm-3">
							<?php echo form_input ( "firstname", $this->input->post_get("firstname"), array("class" => "form-control", 'placeholder' => 'First Name') ); ?>
						</div>
						<div class="form-group col-sm-3">
							<div class="input-group date">
								<?php echo form_input ( "arrival_date2", $this->input->post_get( "arrival_date2" ), array ("class" => "form-control datepicker", 'placeholder' => 'Arrival Date To') ); ?>
								<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
							</div>
						</div>
						<div class="form-group col-sm-3">
							<div class="input-group date">
								<?php echo form_input ( "effective_date2", $this->input->post_get( "effective_date2" ), array ("class" => "form-control datepicker", 'placeholder' => 'Effective Date To') ); ?>
								<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
							</div>
						</div>
						<div class="form-group col-sm-3">
							<div class="input-group date">
								<?php echo form_input ( "expiry_date2", $this->input->post_get( "expiry_date2" ), array ("class" => "form-control datepicker", 'placeholder' => 'Expiry Date To') ); ?>
								<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
							</div>
						</div>
						<div class="clearfix"></div>
					</div>
					<?php echo form_close(); ?>
					<!-- search filter end -->
				</div><!-- x_content -->
				
				<?php if(!empty($policies)): ?>
				<div class="x_title">
					<h2>Plan Search Result<small></small></h2>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<div class="table-responsive">
						<table class="table table-hover table-bordered">
							<thead>
								<tr>
									<th>Policy No</th>
									<th>Name</th>
									<th>Date of Birth</th>
									<th>Status</th>
									<th>Agent</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($policies as $key => $value): ?>
								<tr data='<?php echo $html_model->escapeQuote(json_encode($value)); ?>'>
									<td><?php echo $value['policy']; ?></td>
									<td><?php echo htmlspecialchars($value['firstname']." ".$value['lastname']); ?></td>
									<td><?php echo htmlspecialchars($value['birthday']); ?></td>
									<td><?php echo $policy_status[$value['status_id']]['name']; ?></td>
									<td><?php echo htmlspecialchars($value['agent_firstname']." ".$value['agent_lastname']); ?></td>
									<td><?php echo anchor("emergency_assistance/view_policy/" . $value['policy'], "Detail", array('class'=>'view-policy')); ?></td>
								</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
				<?php endif;?>
				<?php if (!empty($policies_error)) : ?>
				<center><?php echo heading($policies_error, 4); ?></center>
				<?php endif; ?>
				
				<?php if(!empty($cases)): ?>
				<div class="x_title">
					<h2>Case Search Result<small></small></h2>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<div class="table-responsive">
						<table class="table table-hover table-bordered">
							<thead>
								<tr>
									<th>Case number</th>
									<th>Create Date</th>
									<th>Place</th>
									<th>Reason</th>
									<th>Policy Number</th>
									<th>Insured Name</th>
									<th>DOB</th>
									<th>Assign to</th>
									<th>Case Manager</th>
									<th>Priority</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($cases as $key => $value): ?>
								<tr alt='<?php echo $value['id']; ?>' policy='<?php echo $value['policy_no'] ?>' case_no='<?php echo $value['case_no']; ?>'>
									<td><?php echo $value['case_no']; ?></td>
									<td><?php echo htmlspecialchars($value['created']); ?></td>
									<td><?php echo htmlspecialchars($value['province']); ?></td>
									<td><?php echo htmlspecialchars($value['reason']); ?></td>
									<td><?php echo htmlspecialchars($value['policy_no']); ?></td>
									<td><?php echo htmlspecialchars($value['insured_name']); ?></td>
									<td><?php echo htmlspecialchars($value['dob']); ?></td>
									<td><?php echo $value['assign_to_email']; ?></td>
									<td><?php echo $value['manager_email']; ?></td>
									<td><?php echo htmlspecialchars($value['priority']); ?></td>
									<!-- <td><?php echo anchor('emergency_assistance/create_claim?policy='.$value['policy_no'].'&case_no='.$value['case_no'], 'Detail'); ?></td> -->
									<td><?php echo anchor('emergency_assistance/edit_case/'.$value['id'].'?type=add_claim', 'Detail'); ?></td>
								</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
				<?php endif; ?>

				<?php if(!empty($claims)): ?>
				<!-- search results start -->
				<div class="x_title">
					<h2>Claim Search Result<small></small></h2>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
                  <div class="table-responsive">
						<table class="table table-hover table-bordered">
							<thead>
								<tr>
									<th title='Check for assign to claim examiner'><?php echo form_checkbox("selectall", 1, FALSE, "alt='Check for assign to claim examiner'"); ?></th>
									<th>Claim Number</th>
									<th>EClaim Number</th>
									<th>Policy Number</th>
									<th>First Name</th>
									<th>Last Name</th>
									<!-- th>Gender</th -->
									<th>Birth Date</th>
									<th>Claim Date</th>
									<th>Claim Amount</th>
									<th>Diagnosis</th>
									<th>Processing Status</th>
									<th>Assign To</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($claims as $key => $value): ?>
								<tr>
									<td title='Check for assign to claim examiner'><?php echo form_checkbox("claim", $value['id'], FALSE, "alt='Check for assign to claim examiner'"); ?></td>
									<td><?php echo $value['claim_no']; ?></td>
									<td><?php echo $value['eclaim_no']; ?></td>
									<td><?php echo htmlspecialchars($value['policy_no']); ?></td>
									<td><?php echo htmlspecialchars($value['insured_first_name']); ?></td>
									<td><?php echo htmlspecialchars($value['insured_last_name']); ?></td>
									<!-- td><?php echo $value['gender']; ?></td -->
									<td><?php echo htmlspecialchars($value['dob']); ?></td>
									<td><?php echo htmlspecialchars($value['created']); ?></td>
									<td><?php echo number_format($value['amount_claimed'], 2); ?></td>
									<td><?php echo htmlspecialchars($value['diagnosis']); ?></td>
									<td><?php echo $value['status']; ?></td>
									<td><?php echo $value['email']; ?></td>
									<?php if ($is_insurer) { ?>
									<td><?php echo anchor("claim/examine_claim/".$value['id'], "View"); ?></td>
									<?php } else { ?>
									<td><?php echo anchor("claim/claim_detail/".$value['id'], "View"); ?></td>
									<?php }?>
								</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
					<br />
					<?php if (! $this->ion_auth->in_group(array(Users_model::GROUP_INSURER))) { ?>
					<div class="row form-group">
						<div class="col-sm-12">
							<div class="col-sm-2">
								<button class="btn btn-primary show_button assign_to" disabled>Assign To <i class="fa fa-angle-double-right"></i></button>
							</div>
							<div class="col-sm-8 employees-section" style="display: none">
								<div class="col-sm-4">
									<select name="assign_user" class="form-control">
										<option value=""> -- Select examiner -- </option>
										<?php foreach ($examiners as $rc) { ?>
										<option value="<?php echo $rc['id']; ?>"><?php echo $rc['email']; ?></option>
										<?php } ?>
									</select>
								
									<?php echo $claim_examiner; ?>
								</div>
								<div class="col-sm-3">
									<button class="btn btn-primary pull-right save_assign" style="display: none"><i class="fa fa-check-circle-o"></i> Save Assign </button>
								</div>
							</div>
						</div>
					</div>
					<?php } ?>
               </div>
               <?php endif;?>

			</div><!-- x_panel -->
		</div><!-- col-md-12 col-sm-12 col-xs-12 -->
	</div><!-- row -->
</div>

<?php echo link_tag('assets/css/bootstrap-datepicker.css'); ?>
<script src="<?php echo base_url() ?>/assets/js/bootstrap-datetimepicker.js"></script>
<script>
var employee_id;
$(document).ready(function() {
	$(".datepicker").datepicker({
		startDate: '-105y',
		endDate: '+2y',
	});

   // create claim once user clicked on case
   $(".create_claim").click(function(e) {
      e.preventDefault();
      var id = $(this).attr("alt");
      var case_no = $("input[name=select_case]:checked").parent('td').parent('tr').attr("case_no");
      var policy_no = $("input[name=select_case]:checked").parent('td').parent('tr').attr("policy");
      var policy_no_1 = $("input[name=select_claim]:checked").val();

      var href = $(this).attr('href');
      if(case_no || policy_no)
         window.location = href+"?case_no="+case_no+"&policy="+policy_no;
      else if(policy_no_1)
         window.location = href+"?policy="+policy_no_1;
      else
         window.location = href;
   })

   $("input[name=select_case]").click(function(){

      // unset all selections
      if($(this).is(":checked")){
         $("input[name=select_case]").prop("checked",false);
         $(this).prop("checked", true);
      }
   })
   
   $("input[name=select_claim]").click(function(){

      // unset all selections
      if($(this).is(":checked")){
         $("input[name=select_claim]").prop("checked",false);
         $(this).prop("checked", true);
      }
   })

   // create claim once user clicked on policy
   $(".view-policy").click(function(e){
      e.preventDefault();
      var data = $(this).parent('td').parent('tr').attr("data");
      // insert data to dom element to save temporary
      localStorage.setItem("policy_data", data);
      // redirect it to view policy page
      var href = $(this).attr('href');
      window.location = href;
   })
})

.on("change", "select[name=assign_user]", function(){                                  // assign value of claim examiner to employee_id 
   var val = $(this).val();
   employee_id = val;                                                                  // set selected employee
})

.on("click", "input[name=selectall]",  function(){                                     // select all checkboxes script

   if($(this).is(":checked"))                                                          // check user click check or uncheck tickbox
      $("input[name=claim]").prop("checked", true);
   else
      $("input[name=claim]").prop("checked", false);
})
.on("click", "input[name=claim], input[name=selectall]",  function(e){                 // enable disable buttons

   e.stopPropagation();
   var length = $("input[name=claim]:checked").length;
   if(length)
   {
      $(".show_button").removeAttr("disabled");
      if(length > 1)
          $(".view_edit, .email_print").attr("disabled", "disabled");
   }
   else
   {
      $(".show_button").attr("disabled", "disabled");
      $(".employees-section").hide();
   }
})
.on("click", ".assign_to", function(){                                                 // on clicked assign to button
   $(".employees-section, .save_assign").show();
})
.on("click", ".save_assign", function(){                                               // clicking on save assign button
   
   // check if employee selected or not
   if(!employee_id)
   {
      alert("Please select claim examiner first.");
      return false;
   }

   // assign claim examiner user to selected claim 
   var claim = [];
   $("input[name=claim]:checked").each(function(){
      claim.push($(this).val());
   })
   var claim = claim.join(",");

   // assign claim to emc manager here
   $.ajax({
      url: "<?php echo base_url("claim/assign_claim") ?>",
      method: "post",
      data:{claim:claim, employee_id: employee_id},
      beforeSend: function(){
         $(".right_col").addClass("csspinner load1");
      },
      success: function() {
         window.location.reload();
      }
   })
})

// to make to check hidden filters to show
<?php
$display = 0;
if (! empty ( $params ))
	foreach ( $params as $key => $value )
		if ($key != 'product_short' && $key != 'policy' && $key != 'filter' && $key != 'key')
			if ($value)
				$display = 1;
if ($display) :
	?>
   $(".more_items").show();
<?php endif; ?>
$(document).on("click",".more_filters", function(){
   $(".more_items").toggle();
})
</script>
