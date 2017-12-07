<duv >
   <div class="page-title">
      <div class="title_left">
         <h3>View Edit Emergency Assistance Case</h3>
			<?php
				echo anchor("emergency_assistance/create_case", '<i class="fa fa-plus-circle"></i> New Case', array("class"=>'btn btn-primary create_case'));
         		if ($this->ion_auth->in_group(array(Users_model::GROUP_ADMIN, Users_model::GROUP_MANAGER, Users_model::GROUP_EXAMINER))) {
         			echo anchor("emergency_assistance/create_provider", '<i class="fa fa-plus-circle"></i> New Provider', array("class"=>'btn btn-primary'));
         		}
         	?>
      </div>
   </div>
   <div class="clearfix"></div>
   <?php echo $message; ?>

   <!-- Policy search and List Section -->
   <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
         <div class="x_panel">

         <div class="x_title">
            <h2>Policy Filter<small></small></h2>
            <div class="clearfix"></div>
         </div>
         <div class="x_content"> 

            <!-- search policy filter start -->       
           <?php echo form_open("", array('class'=>'form-horizontal', 'method'=>'get')); ?>
             <div class="row">
               <div class="form-group col-sm-3">
                  <?php
                  echo form_label('Policy Number:', 'policy_match', array("class"=>'col-sm-12'));                  
                  echo form_input("policy_match", $this->input->get("policy_match"), array("class"=>"form-control", 'placeholder'=>'Policy Number'));
                  ?>
               </div>               
               <div class="col-sm-5">
                  <label class="col-sm-12">&nbsp;</label>
                  <button class="btn btn-primary"  name="filter" value="policy">Search</button>
                  <a href="javascript:void(0)" class="btn btn-info more_filters">More Filter</a>
                  <?php echo anchor("emergency_assistance", 'Reset', array("class"=>'btn btn-primary')) ?>
               </div>
            </div>            
            <div class="row more_items" style="display:none">               
               <div class="form-group col-sm-3">
                  <?php          
                  echo form_input("lastname", $this->input->get("lastname"), array("class"=>"form-control", 'placeholder'=>'Last Name'));
                  ?>
               </div> 
               <div class="form-group col-sm-3">
                  <?php               
                  echo form_input("firstname", $this->input->get("firstname"), array("class"=>"form-control", 'placeholder'=>'First Name'));
                  ?>
               </div> 
               <div class="form-group col-sm-3">
                  <div class="input-group date">
                     <?php 
                     echo form_input("birthday", $this->input->get("birthday"), array("class"=>"form-control datepicker", 'placeholder'=>'Birthdate From'));
                     ?>
                     <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                  </div>
               </div>
               <div class="form-group col-sm-3">
                  <div class="input-group date">
                     <?php 
                     echo form_input("birthday2", $this->input->get("birthday2"), array("class"=>"form-control datepicker", 'placeholder'=>'Birthdate To'));
                     ?>
                     <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                  </div>
               </div>
            </div> 
          
            <div class="row more_items" style="display:none">                  
               <div class="form-group col-sm-3">
                  <?php          
                  echo form_input("institution", $this->input->get("institution"), array("class"=>"form-control", 'placeholder'=>'Agent/School Name'));
                  ?>
               </div> 
               <div class="form-group col-sm-3">
                  <?php               
                  echo form_input("plan_id", $this->input->get("plan_id"), array("class"=>"form-control", 'placeholder'=>'ID'));
                  ?>
               </div>
               <div class="form-group col-sm-3">
                  <?php               
                  echo form_input("case_no", $this->input->get("case_no"), array("class"=>"form-control", 'placeholder'=>'Case Number'));
                  ?>
               </div>
            </div>

            <div class="row more_items" style="display:none"> 
               <div class="form-group col-sm-3">
                  <div class="input-group date">
                     <?php 
                     echo form_input("apply_date", $this->input->get("apply_date"), array("class"=>"form-control datepicker", 'placeholder'=>'Application Date From'));
                     ?>
                     <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                  </div>
               </div>
               <div class="form-group col-sm-3">
                  <div class="input-group date">
                     <?php 
                     echo form_input("arrival_date", $this->input->get("arrival_date"), array("class"=>"form-control datepicker", 'placeholder'=>'Arrival Date From'));
                     ?>
                     <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                  </div>
               </div>
               <div class="form-group col-sm-3">
                  <div class="input-group date">
                     <?php 
                     echo form_input("effective_date", $this->input->get("effective_date"), array("class"=>"form-control datepicker", 'placeholder'=>'Effective Date From'));
                     ?>
                     <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                  </div>
               </div>
               <div class="form-group col-sm-3">
                  <div class="input-group date">
                     <?php 
                     echo form_input("expiry_date", $this->input->get("expiry_date"), array("class"=>"form-control datepicker", 'placeholder'=>'Expiry Date From'));
                     ?>
                     <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                  </div>
               </div>
            </div>

            <div class="row more_items" style="display:none"> 
               <div class="form-group col-sm-3">
                  <div class="input-group date">
                     <?php 
                     echo form_input("apply_date2", $this->input->get("apply_date2"), array("class"=>"form-control datepicker", 'placeholder'=>'Application Date To'));
                     ?>
                     <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                  </div>
               </div>
               <div class="form-group col-sm-3">
                  <div class="input-group date">
                     <?php 
                     echo form_input("arrival_date", $this->input->get("arrival_date"), array("class"=>"form-control datepicker", 'placeholder'=>'Arrival Date To'));
                     ?>
                     <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                  </div>
               </div>
               <div class="form-group col-sm-3">
                  <div class="input-group date">
                     <?php 
                     echo form_input("effective_date2", $this->input->get("effective_date2"), array("class"=>"form-control datepicker", 'placeholder'=>'Effective Date To'));
                     ?>
                     <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                  </div>
               </div>
               <div class="form-group col-sm-3">
                  <div class="input-group date">
                     <?php 
                     echo form_input("expiry_date2", $this->input->get("expiry_date2"), array("class"=>"form-control datepicker", 'placeholder'=>'Expiry Date To'));
                     ?>
                     <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                  </div>
               </div>
            </div>
            <?php echo form_close(); ?>
            <!-- search policy filter end -->
            <div class="clearfix"><br/></div>


            <?php if($this->input->get("filter") == 'policy'): ?>
            <!-- search results start -->
            <div class="x_title">
               <h2>Search Result<small></small></h2>
               <div class="clearfix"></div>
            </div>
            <div class="x_content">
               <?php if(!empty($policies)): ?>
               <div class="table-responsive">
                  <table class="table table-hover table-bordered">
                     <?php if(($this->input->get("lastname") or $this->input->get("firstname")) and !$this->input->get("result")): ?>
                        <thead>
                           <tr>
                              <th>First Name</th>
                              <th>Last Name</th>
                              <th>Date of Birth</th>
                              <th>Gender</th>
                              <th>Action</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php foreach ($policies as $key => $value): ?>
                              <tr class="view-policies" data='<?php echo json_encode($value); ?>'>
                                 <td><?php echo $value['firstname']; ?></td>
                                 <td><?php echo $value['lastname']; ?></td>
                                 <td><?php echo $value['birthday']; ?></td>
                                 <td><?php echo $value['gender']; ?></td>
                                 <td class="policies"><?php echo anchor("emergency_assistance/?result=policy&filter=policy&lastname=".$value['lastname']."&firstname=".$value['firstname'], "View Policies"); ?></td>
                              </tr>
                           <?php endforeach; ?>
                        </tbody>
                     <?php else:?>
                        <thead>
                           <tr>
                              <th></th>
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
                           <tr class="view-policy" <?php if (!empty($value['has_claim'])) { ?>style='background-color:#efc7c7' <?php } ?> data='<?php echo json_encode($value); ?>'>
                              <td><?php echo form_checkbox('select_policy', $value['policy']); ?></td>
                              <td><?php echo $value['policy']; ?></td>
                              <td><?php echo $value['firstname']." ".$value['lastname']; ?></td>
                              <td><?php echo $value['birthday']; ?></td>
                              <td><?php echo $policy_status['array'][$value['status_id']]; ?></td>
                              <td><?php echo $value['agent_firstname']." ".$value['agent_lastname']; ?></td>
                              <td><?php echo anchor("emergency_assistance/view_policy/" . $value['policy'], "Open"); ?></td>
                           </tr>
                           <?php endforeach; ?>
                        </tbody>
                     <?php endif; ?>
                  </table>
               </div>               
               <?php else:?>
                  <center><?php echo heading("No record available", 4); ?></center>
               <?php endif;?>
            </div>
            <?php endif; ?>
            <!-- End Search List Section -->
         </div>
      </div>
   </div>
   </div>




   <!-- Case search and List Section -->
   <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
         <div class="x_panel">
         <div class="x_title">
            <h2>Case Filter<small></small></h2>
            <div class="clearfix"></div>
         </div>
         <div class="x_content"> 

            <!-- search policy filter start -->       
           <?php echo form_open("", array('class'=>'form-horizontal', 'method'=>'get')); ?>           
            <div class="row">           
               <div class="form-group col-sm-3">
                  <?php               
                  echo form_input("case_no", $this->input->get("case_no"), array("class"=>"form-control", 'placeholder'=>'Case No'));
                  ?>
               </div>     
               <div class="form-group col-sm-3">
                  <?php          
                  echo form_input("policy_no", $this->input->get("policy_no"), array("class"=>"form-control", 'placeholder'=>'Policy Number'));
                  ?>
               </div> 
               <div class="form-group col-sm-3">
                  <?php 
                  echo form_input("client_user_name", $this->input->get("client_user_name"), array("class"=>"form-control", 'placeholder'=>'Client User Name'));
                  ?>
               </div>
               <div class="form-group col-sm-3">
                  <div class="input-group date">
                     <?php 
                     echo form_input("created", $this->input->get("created"), array("class"=>"form-control datepicker", 'placeholder'=>'Create Date'));
                     ?>
                     <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                  </div>
               </div>

               <div class="form-group col-sm-3">
					<select name="manager_id" class="form-control">
						<option value=""> -- Select Manage -- </option>
						<?php foreach ($managers as $rc):?>
						<option value="<?php echo $rc['id']; ?>" <?php if ($rc['id'] == $manager_id) { echo "selected"; } ?>><?php echo $rc['email']; ?></option>
						<?php endforeach; ?>
					</select>
               </div>
               <div class="col-sm-3">
                  <button class="btn btn-primary" name="filter" value="case">Search</button>
               </div>
            </div> 
            <?php echo form_close(); ?>
            <!-- search policy filter end -->
            <div class="clearfix"><br/></div>

            <?php if($this->input->get("filter") == 'case'): ?>
            <!-- search results start -->
            <div class="x_title">
               <h2>Search Result<small></small></h2>
               <div class="clearfix"></div>
            </div>
            <div class="x_content">
               <?php if(!empty($cases)): ?>
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
                           <th>Last Update</th>                           
                        </tr>
                     </thead>
                     <tbody>
                     <?php foreach ($cases as $key => $value): ?>
                        <tr class="row-link" alt="<?php echo $value['id']; ?>" title="Click to View/Edit">
                           <td><?php echo $value['case_no']; ?></td>
                           <td><?php echo $value['created']; ?></td>
                           <td><?php echo $value['province']; ?></td>
                           <td><?php echo $value['reason']; ?></td>
                           <td><?php echo $value['policy_no']; ?></td>
                           <td><?php echo $value['insured_name']; ?></td>
                           <td><?php echo $value['dob']; ?></td>
                           <td><?php echo $value['assign_to_email']; ?></td>
                           <td><?php echo $value['manager_email']; ?></td>
                           <td><?php echo $value['priority']; ?></td>
                           <td><?php echo anchor("emergency_assistance/edit_case/".$value['id'], "Detail"); ?></td>
                           <td><?php echo date('Y-m-d h:i a', strtotime($value['last_update'])); ?></td>
                        </tr>
                     <?php endforeach; ?>
                     </tbody>
                  </table>
               </div>
               <?php else:?>
                  <center><?php echo heading("No record available", 4); ?></center>
               <?php endif;?>
            </div>
            <!-- End Search List Section -->
            <?php endif;?>
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
   $(".row-link").click(function() {
      var id = $(this).attr("alt");
      window.location = "<?php echo base_url("emergency_assistance/edit_case/") ?>"+id;
   })
   $(".view-policy").click(function(){
      var data = $(this).attr("data");

      // insert data to dom element to save temporary
      localStorage.setItem("policy_data", data);

      var ddata = jQuery.parseJSON(data);

      // redirect it to view policy page
      window.location = "<?php echo base_url("emergency_assistance/view_policy") ?>" + "/" + ddata.policy;
   })
   $(".view-policies").click(function(){
      var data = $(this).attr("data");

      // redirect it to view policy page
      window.location = $(this).children("td.policies").children("a").attr("href");
   })

   // create claim once user clicked on case
   $(".create_case").click(function(e) {
      e.preventDefault();
      var id = $(this).attr("alt");
      var policy_no = $("input[name=select_policy]:checked").val();

      var href = $(this).attr('href');
      if(policy_no)
         window.location = href+"?policy="+policy_no;
      else
         window.location = href;
   })

   $("input[name=select_policy]").click(function(e){
      e.stopPropagation()

      // unset all selections
      if($(this).is(":checked")){
         $("input[name=select_policy]").prop("checked",false);
         $(this).prop("checked", true);
      }
   })

})


// to make to check hidden filters to show
<?php
$display = 0;
if (!empty($params)) {
	foreach ($params as $key => $value) {
		if ($key <> 'product_short' && $key <> 'policy_match' && $key <> 'policy' && $key <> 'filter' && $key <> 'key') {
			if(!empty($value)) {
				$display = 1;
			}
		}
	}
}
if($display) {
?>
   $(".more_items").show();
<?php } ?>
$(document).on("click",".more_filters", function(){
   $(".more_items").toggle();
})
</script>