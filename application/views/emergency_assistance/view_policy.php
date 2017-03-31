

<duv >
   <div class="page-title">
      <?php
      if($this->input->get('type') == 'add_claim')
         echo anchor("claim/create_claim?policy=", '<i class="fa fa-plus-circle"></i> New Claim', array("class"=>'btn btn-primary new_claim')) 
      ?>

      <?php echo anchor("emergency_assistance/create_case", '<i class="fa fa-plus-circle"></i> New Case', array("class"=>'btn btn-primary')) ?>

      <?php /* echo anchor("emergency_assistance/create_policy", '<i class="fa fa-plus-circle"></i> New Policy', array("class"=>'btn btn-primary')) */ ?>

      <?php echo anchor("emergency_assistance/create_provider", '<i class="fa fa-plus-circle"></i> New Provider', array("class"=>'btn btn-primary')) ?>

      <a class="btn btn-primary pull-right" onclick="window.history.back()"><i class="fa fa-arrow-left"></i> Back</a>      
   </div>
   <div class="clearfix"></div>
   <!-- Policy search and List Section -->
   <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
         <div class="x_panel">
            <div class="x_title">
               <h2>Policy Details<small></small></h2>
               <div class="clearfix"></div>
            </div>
            <div class="x_content">
               <?php //echo form_open("", array('class'=>'form-horizontal', 'method'=>'post')); ?>
               <div class="row" style="margin-bottom:15px;">
                  <div class="form-group col-sm-3">
                     <label><span>Policy No: </span><span class="policy"></span></label>
                  </div>
                  <div class="form-group col-sm-3">
                     <label style="text-transform: capitalize;"><span>By Agent: </span><span class="agent_firstname"></span> <span class="agent_lastname"></span></label>
                  </div>
               </div>
               <div class="row">
                  <div class="col-sm-12">
                     <fieldset>
                        <legend>Travel Dates</legend>
                        <div class="row">
                           <div class="form-group col-sm-3">
		                      <label><span>Apply Date : </span></label> <span class="apply_date"></span>
                           </div>
                           <div class="form-group col-sm-3">
		                      <label><span>Arrival Date : </span></label> <span class="arrival_date"></span>
                           </div>
                           <div class="form-group col-sm-3">
		                      <label><span>Effective Date : </span></label> <span class="effective_date"></span>
                           </div>
                           <div class="form-group col-sm-3">
		                      <label><span>Expiry Date : </span></label> <span class="expiry_date"></span>
                           </div>
                        </div>
                        <div class="row">
                           <div class="form-group col-sm-3">
		                      <label><span>Days : </span></label> <span class="totaldays"></span>
                           </div>
                        </div>
                     </fieldset>
                  </div>
               </div>
               <br>
               <div class="row">
                  <div class="col-sm-12">
                     <fieldset>
                        <legend>Insurable Information</legend>
                        <div class="row">
                           <div class="form-group col-sm-3">
		                      <label><span>Beneficiary : </span></label> <span class="beneficiary"></span>
                           </div>
                           <div class="form-group col-sm-3">
		                      <label><span>Sum Insured : </span></label> $<span class="sum_insured"></span>
                           </div>
                           <div class="form-group col-sm-3">
		                      <label><span>Deductible Amount : </span></label> $<span class="deductible_amount"></span>
                           </div>
                        </div>
                        <div class="row">
                           <div class="form-group col-sm-3">
		                      <label><span>Student ID : </span></label> <span class="student_id"></span>
                           </div>
                           <div class="form-group col-sm-3">
		                      <label><span>School Name : </span></label> <span class="institution"></span>
                           </div>
                           <div class="form-group col-sm-3">
		                      <label><span>School Address : </span></label> <span class="institution_addr"></span>
                           </div>
                           <div class="form-group col-sm-3">
		                      <label><span>School Phone : </span></label> <span class="institution_phone"></span>
                           </div>
                        </div>
                     </fieldset>
                  </div>
               </div>
               <br>
               <div class="row">
                  <div class="col-sm-12">
                     <fieldset>
                        <legend>Insurable Members</legend>
                        <div class="row">
                           <div class="form-group col-sm-3">
		                      <label><span>Name : </span></label> <span class="firstname"></span> <span class="lastname"></span>
                           </div>
                           <div class="form-group col-sm-3">
		                      <label><span>Birth Date : </span></label> <span class="birthday"></span>
                           </div>
                          <div class="form-group col-sm-3">
		                      <label><span>Gender : </span></label> <span class="gender"></span>
                           </div>
                          <div class="form-group col-sm-3">
		                      <span class="creates"></span>
                           </div>
                        </div>
                        <div class="row" id='moremembers'>
                        </div>
                     </fieldset>
                  </div>
               </div>
               <br>
               <div class="row">
                  <div class="col-sm-12">
                     <fieldset>
                        <legend>Address</legend>
                        <div class="row">
                          <div class="form-group col-sm-3">
		                     <label><span>Street# : </span></label> <span class="street_number"></span>
                          </div>
                          <div class="form-group col-sm-3">
		                     <label><span>Street Name : </span></label> <span class="street_name"></span>
                          </div>
                          <div class="form-group col-sm-3">
		                     <label><span>Suite# : </span></label> <span class="suite_number"></span>
                          </div>
                          <div class="form-group col-sm-3">
		                     <label><span>City : </span></label> <span class="city"></span>
                          </div>
                        </div>
                        <div class="row">
                          <div class="form-group col-sm-3">
		                     <label><span>Province : </span></label> <span class="province2"></span>
                          </div>
                          <div class="form-group col-sm-3">
		                     <label><span>Country : </span></label> <span class="country2"></span>
                          </div>
                          <div class="form-group col-sm-3">
		                     <label><span>Postcode : </span></label> <span class="postcode"></span>
                          </div>
                        </div>
                        <div class="row">
                          <div class="form-group col-sm-3">
		                     <label><span>Phone1 : </span></label> <span class="phone1"></span>
                          </div>
                          <div class="form-group col-sm-3">
		                     <label><span>Phone2 : </span></label> <span class="phone2"></span>
                          </div>
                        </div>
                     </fieldset>
                  </div>
               </div>
               <br>
               <div class="row">
                  <div class="col-sm-12">
                     <fieldset>
                        <legend>Contact</legend>
                        <div class="row">
                          <div class="form-group col-sm-3">
		                     <label><span>Email : </span></label> <span class="contact_email"></span>
                          </div>
                          <div class="form-group col-sm-3">
		                     <label><span>Phone : </span></label> <span class="contact_phone"></span>
                          </div>
                          <div class="form-group col-sm-3">
		                     <label><span>Residence : </span></label> <span class="residence"></span>
                          </div>
                        </div>
                     </fieldset>
                  </div>
               </div>
               <br>  
               <div class="row">
                  <div class="col-sm-12">
                  </div>
               </div>
               </form>
            </div>
         </div>
      </div>
   </div>
</duv>
<?php echo link_tag('assets/css/bootstrap-datepicker.css'); ?>
<script src="<?php echo base_url() ?>/assets/js/bootstrap-datetimepicker.js"></script>
<script>
$(document).ready(function() {
	$(".datepicker").datepicker({
		startDate: '-105y',
		endDate: '+2y',
	});

	// get temporary data
	var data = localStorage.getItem("policy_data");
	data = $.parseJSON(data);

	// place all values to input fields
	var htm  = '<a href="<?php echo base_url("claim/create_claim?policy="); ?>' + data.policy + '&firstname=' + data.firstname + '&lastname=' + data.lastname + '&birthday=' + data.birthday + '&gender=' + data.gender + '" class="btn btn-primary">New Claim</a>';
	htm += '<a href="<?php echo base_url("emergency_assistance/create_case?policy="); ?>' + data.policy + '&firstname=' + data.firstname + '&lastname=' + data.lastname + '&birthday=' + data.birthday + '&gender=' + data.gender + '" class="btn btn-primary">New Case</a>';
	$(".creates").html(htm);
	$.each(data, function( index, value ) {
		if (index == 'family') {
			var html = '';
			$.each(value, function (idx, val) {
				html +='<div class="form-group col-sm-3">';
				html +='<label><span>Name : </span></label> <span>' + val.firstname + '<span> <span>' + val.lastname + '</span>';
				html +='</div>';
				html +='<div class="form-group col-sm-3">';
				html +='<label><span>Birth Date : </span></label> <span>' + val.birthday + '<span>';
				html +='</div>';
				html +='<div class="form-group col-sm-3">';
				html +='<label><span>Gender : </span></label> <span>' + val.gender + '<span>';
				html +='</div>';
				html +='<div class="form-group col-sm-3">';
				html += '<a href="<?php echo base_url("claim/create_claim?policy="); ?>' + data.policy + '&firstname=' + val.firstname + '&lastname=' + val.lastname + '&birthday=' + val.birthday + '&gender=' + val.gender + '" class="btn btn-primary">New Claim</a>';
				html += '<a href="<?php echo base_url("emergency_assistance/create_case?policy="); ?>' + data.policy + '&firstname=' + val.firstname + '&lastname=' + val.lastname + '&birthday=' + val.birthday + '&gender=' + val.gender + '" class="btn btn-primary">New Case</a>';
				html +='</div>';
			});
			$('#moremembers').html(html);
		} else {
			$("."+index).text(value);
		}
	});
})
</script>

