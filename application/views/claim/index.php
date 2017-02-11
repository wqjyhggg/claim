<duv >
   <div class="page-title">
      <div class="title_left">

         <?php echo anchor("claim/create_claim", '<i class="fa fa-plus-circle"></i> Create New Claim', array("class"=>'btn btn-primary create_claim')) ?>
         
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
                     echo form_label('Our Product:', 'product_short', array("class"=>'col-sm-12'));                  
                     echo $products;
                  ?>
               </div>
               <div class="form-group col-sm-3">
                  <?php
                  echo form_label('Policy Number:', 'policy', array("class"=>'col-sm-12'));                  
                  echo form_input("policy", $this->input->get("policy"), array("class"=>"form-control", 'placeholder'=>'Policy Number'));
                  ?>
               </div>               
               <div class="col-sm-3">
                  <label class="col-sm-12">&nbsp;</label>
                  <button class="btn btn-primary"  name="filter" value="policy">Search</button>
                  <a href="javascript:void(0)" class="btn btn-info more_filters">More Filter</a>
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
            <div class="row more_items" style="display:none">
               <div class="form-group col-sm-3">
                  <?php                 
                     $policy = array(""=>'--Select Policy Status--');
                     echo $policy_status['dropdown'];
                  ?>
               </div>
               <div class="form-group col-sm-3">
                  <?php               
                     echo $province;
                  ?>
               </div>
               <div class="form-group col-sm-3">
                  <?php             
                     echo $country;
                  ?>
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
                     <thead>
                        <tr>
                           <td></td>
                           <th>Policy No</th>
                           <th>ID</th>
                           <th>Name</th>
                           <th>Date of Birth</th>
                           <th>Status</th>
                           <th>Effect Date</th>
                           <th>User</th>
                           <th>Agent</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php foreach ($policies as $key => $value): ?>
                        <tr data = '<?php echo json_encode($value); ?>'>
                           <td><?php echo form_checkbox('select_claim', $value['policy']); ?></td>
                           <td><?php echo $value['policy']; ?></td>
                           <td><?php echo $value['plan_id']; ?></td>
                           <td><?php echo $value['firstname']." ".$value['lastname']; ?></td>
                           <td><?php echo date("d/d/Y", strtotime($value['birthday'])); ?></td>
                           <td><?php echo $policy_status['array'][$value['status_id']]; ?></td>
                           <td><?php echo date("d/d/Y", strtotime($value['effective_date'])); ?></td>
                           <td>Which data goes here</td>
                           <td><?php echo $value['agent_firstname']." ".$value['agent_lastname']; ?></td>
                           <td><?php echo anchor("emergency_assistance/view_policy?type=add_claim", "Open", array('class'=>'view-policy')); ?></td>
                        </tr>
                        <?php endforeach; ?>
                     </tbody>
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
                     echo form_input("policy_no", $this->input->get("policy_no"), array("class"=>"form-control", 'placeholder'=>'Policy No'));
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
                     <?php                 
                        echo $eacmanagers;
                     ?>
                  </div>
                  <div class="form-group col-sm-3">
                     <?php                 
                        echo $casemamager;
                     ?>
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
                              <th></th>
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
                           <tr alt='<?php echo $value['id']; ?>' policy='<?php echo $value['policy_no'] ?>'  case_no='<?php echo $value['case_no']; ?>'>
                              <td class='row-link' title='Click to add claim'><?php echo form_checkbox('select_case'); ?></td>
                              <td><?php echo $value['case_no']; ?></td>
                              <td><?php echo $value['created']; ?></td>
                              <td><?php echo $value['province']; ?></td>
                              <td><?php echo $value['reason']; ?></td>
                              <td><?php echo $value['policy_no']; ?></td>
                              <td><?php echo $value['insured_name']; ?></td>
                              <td><?php echo $value['dob']; ?></td>
                              <td><?php echo $value['assign_to_name']; ?></td>
                              <td><?php echo $value['case_manager_name']; ?></td>
                              <td><?php echo $value['priority']; ?></td>
                              <!-- <td><?php echo anchor('emergency_assistance/create_claim?policy='.$value['policy_no'].'&case_no='.$value['case_no'], 'Detail'); ?></td> -->
                              <td><?php echo anchor('emergency_assistance/edit_case/'.$value['id'].'?type=add_claim', 'Detail'); ?></td>
                           </tr>
                        <?php endforeach; ?>
                        </tbody>
                     </table>
                  </div>
                  <?php else:?>
                     <center><?php echo heading('No record available', 4); ?></center>
                  <?php endif;?>
               </div>
               <!-- End Search List Section -->
               <?php endif;?>
            </div>
         </div>
      </div>
   </div>

   <!-- claim search and List Section -->
   <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
         <div class="x_panel">
            <div class="x_title">
               <h2>Claim<small></small></h2>
               <div class="clearfix"></div>
            </div>
            <div class="x_content"> 

               <!-- search claim filter start -->       
               <?php echo form_open("", array('class'=>'form-horizontal', 'method'=>'get')); ?>           
               <div class="row">           
                  <div class="form-group col-sm-3">
                     <?php       
                     echo form_label('Last Name:', 'lastname_claim', array("class"=>'col-sm-12'));    
                     echo form_input("lastname_claim", $this->input->get("lastname_claim"), array("class"=>"form-control", 'placeholder'=>'Last Name'));
                     ?>
                  </div> 
                  <div class="form-group col-sm-3">
                     <?php 
                     echo form_label('First Name:', 'firstname_claim', array("class"=>'col-sm-12'));               
                     echo form_input("firstname_claim", $this->input->get("firstname_claim"), array("class"=>"form-control", 'placeholder'=>'First Name'));
                     ?>
                  </div> 
                  <div class="form-group col-sm-3">
                     <?php
                     echo form_label('Policy Number:', 'policy_claim', array("class"=>'col-sm-12'));                  
                     echo form_input("policy_claim", $this->input->get("policy_claim"), array("class"=>"form-control", 'placeholder'=>'Policy Number'));
                     ?>
                  </div>  
                  <div class="form-group col-sm-3">
                     <?php
                     echo form_label('Claim Number:', 'claim_no_claim', array("class"=>'col-sm-12'));                  
                     echo form_input("claim_no_claim", $this->input->get("claim_no_claim"), array("class"=>"form-control", 'placeholder'=>'Claim Number'));
                     ?>
                  </div>  
                  <div class="form-group col-sm-3">
                     <?php 
                        echo form_label('Our Product:', 'product_short', array("class"=>'col-sm-12'));                  
                        echo $products;
                     ?>
                  </div>
                  <div class="form-group col-sm-3">
                     <?php echo form_label('Claim Date From:', 'claim_date_from', array("class"=>'col-sm-12')); ?>
                     <div class="input-group date">
                        <?php    
                        echo form_input("claim_date_from", $this->input->get("claim_date_from"), array("class"=>"form-control datepicker", 'placeholder'=>'Claim Date From'));
                        ?>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                     </div>
                  </div>
                  <div class="form-group col-sm-3">
                     <?php echo form_label('Claim Date To:', 'claim_date_to', array("class"=>'col-sm-12')); ?>
                     <div class="input-group date">
                        <?php 
                        echo form_input("claim_date_to", $this->input->get("claim_date_to"), array("class"=>"form-control datepicker", 'placeholder'=>'Claim Date To'));
                        ?>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                     </div>
                  </div>
                  <div class="col-sm-3">
                     <label class="col-sm-12">&nbsp;</label>
                     <button class="btn btn-primary" name="filter" value="claim">Display Claim</button>
                  </div>
               </div> 
               <?php echo form_close(); ?>
               <!-- search claim filter end -->
               <div class="clearfix"><br/></div>

               <?php if($this->input->get("filter") == 'claim'): ?>
               <!-- search results start -->
               <div class="x_title">
                  <h2>Search Result<small></small></h2>
                  <div class="clearfix"></div>
               </div>
               <div class="x_content">
                  <?php if(!empty($claims)): ?>
                  <div class="table-responsive">
                     <table class="table table-hover table-bordered">
                        <thead>
                           <tr>
                              <th><?php echo form_checkbox("selectall", 1); ?></th>
                              <th>ID</th>
                              <th>Policy Number</th>
                              <th>Claim Number</th>
                              <th>First Name</th>
                              <th>Last Name</th>
                              <th>Gender</th>
                              <th>Birth Date</th>
                              <th>Claim Date</th>
                              <th>Claim Amount</th>
                              <th>Assign To</th>
                              <th>Status</th>                           
                           </tr>
                        </thead>
                        <tbody>
                           <?php foreach ($claims as $key => $value): ?>
                           <tr>
                              <td><?php echo form_checkbox("claim", $value['id']); ?></td>
                              <td><?php echo $value['id']; ?></td>
                              <td><?php echo $value['policy_no']; ?></td>
                              <td><?php echo $value['claim_no']; ?></td>
                              <td><?php echo $value['insured_first_name']; ?></td>
                              <td><?php echo $value['insured_last_name']; ?></td>
                              <td><?php echo $value['gender']; ?></td>
                              <td><?php echo $value['dob']; ?></td>
                              <td><?php echo $value['claim_date']; ?></td>
                              <td>0</td>
                              <td><?php echo $value['claim_examiner']; ?></td>
                              <td><?php echo anchor("claim/claim_detail/".$value['id'], "Detail"); ?></td>
                           </tr>
                        <?php endforeach; ?>
                        </tbody>
                     </table>
                  </div>
                  <br/>
                  <div class="row form-group">
                     <div class="col-sm-12">
                        <div class="col-sm-2">
                              <button class="btn btn-primary show_button assign_to" disabled>Assign To <i class="fa fa-angle-double-right"></i> </button>
                        </div>
                        <div class="col-sm-8 employees-section" style="display:none">
                           <div class="col-sm-4">
                              <?php echo $claim_examiner; ?>
                           </div>

                           <div class="col-sm-3">
                              <button class="btn btn-primary pull-right save_assign" style="display:none" ><i class="fa fa-check-circle-o"></i> Save Assign</button> 
                           </div>   
                        </div>  
                     </div>
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
   </div>
</duv>

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
      window.location = "<?php echo base_url("emergency_assistance/view_policy?type=add_claim") ?>";
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
if(!empty($params))
   foreach ($params as $key => $value)
      if($key <> 'product_short' && $key <> 'policy' && $key <> 'filter' && $key <> 'key')
         if($value)
            $display = 1;
if($display):
?>
   $(".more_items").show();
<?php endif; ?>
$(document).on("click",".more_filters", function(){
   $(".more_items").toggle();
})
</script>