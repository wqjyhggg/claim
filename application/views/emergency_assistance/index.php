<duv class-"main-div"="">
   <div class="page-title">
      <div class="title_left">
         <h3>View Edit Emergency Assistance Case</h3>
      </div>
   </div>
   <div class="clearfix"></div>

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
                     echo form_label('Our Product:', 'product', array("class"=>'col-sm-12'));                  
                     $product = array(""=>'--Select Product--');
                     echo form_dropdown("product", $product, $this->input->get("product"), array("class"=>'form-control'));
                  ?>
               </div>
               <div class="form-group col-sm-3">
                  <?php
                  echo form_label('Policy Number:', 'policy_no', array("class"=>'col-sm-12'));                  
                  echo form_input("policy_no", $this->input->get("policy_no"), array("class"=>"form-control", 'placeholder'=>'Search by email and name'));
                  ?>
               </div>               
               <div class="col-sm-3">
                  <label class="col-sm-12">&nbsp;</label>
                  <button class="btn btn-primary">Search</button>
                  <a href="javascript:void(0)" class="btn btn-info more_filters">More Filter</a>
               </div>
            </div>            
            <div class="row more_items" style="display:none">               
               <div class="form-group col-sm-3">
                  <?php          
                  echo form_input("last_name", $this->input->get("last_nane"), array("class"=>"form-control", 'placeholder'=>'Last Name'));
                  ?>
               </div> 
               <div class="form-group col-sm-3">
                  <?php               
                  echo form_input("first_name", $this->input->get("first_name"), array("class"=>"form-control", 'placeholder'=>'First Name'));
                  ?>
               </div> 
               <div class="form-group col-sm-3">
                  <div class="input-group date">
                     <?php 
                     echo form_input("birthday_from", $this->input->get("birthday_from"), array("class"=>"form-control datepicker", 'placeholder'=>'Birthdate From'));
                     ?>
                     <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                  </div>
               </div>
               <div class="form-group col-sm-3">
                  <div class="input-group date">
                     <?php 
                     echo form_input("birthday_to", $this->input->get("birthday_to"), array("class"=>"form-control datepicker", 'placeholder'=>'Birthdate To'));
                     ?>
                     <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                  </div>
               </div>
            </div> 
          
            <div class="row more_items" style="display:none">                  
               <div class="form-group col-sm-3">
                  <?php          
                  echo form_input("agent_school", $this->input->get("agent_school"), array("class"=>"form-control", 'placeholder'=>'Agent/School Name'));
                  ?>
               </div> 
               <div class="form-group col-sm-3">
                  <?php               
                  echo form_input("id", $this->input->get("id"), array("class"=>"form-control", 'placeholder'=>'ID'));
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
                     echo form_input("application_from", $this->input->get("application_from"), array("class"=>"form-control datepicker", 'placeholder'=>'Application Date From'));
                     ?>
                     <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                  </div>
               </div>
               <div class="form-group col-sm-3">
                  <div class="input-group date">
                     <?php 
                     echo form_input("arrival_from", $this->input->get("arrival_from"), array("class"=>"form-control datepicker", 'placeholder'=>'Arrival Date From'));
                     ?>
                     <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                  </div>
               </div>
               <div class="form-group col-sm-3">
                  <div class="input-group date">
                     <?php 
                     echo form_input("effective_from", $this->input->get("effective_from"), array("class"=>"form-control datepicker", 'placeholder'=>'Effective Date From'));
                     ?>
                     <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                  </div>
               </div>
               <div class="form-group col-sm-3">
                  <div class="input-group date">
                     <?php 
                     echo form_input("expiry_from", $this->input->get("expiry_from"), array("class"=>"form-control datepicker", 'placeholder'=>'Expiry Date From'));
                     ?>
                     <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                  </div>
               </div>
            </div>

            <div class="row more_items" style="display:none"> 
               <div class="form-group col-sm-3">
                  <div class="input-group date">
                     <?php 
                     echo form_input("application_to", $this->input->get("application_to"), array("class"=>"form-control datepicker", 'placeholder'=>'Application Date To'));
                     ?>
                     <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                  </div>
               </div>
               <div class="form-group col-sm-3">
                  <div class="input-group date">
                     <?php 
                     echo form_input("arrival_to", $this->input->get("arrival_to"), array("class"=>"form-control datepicker", 'placeholder'=>'Arrival Date To'));
                     ?>
                     <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                  </div>
               </div>
               <div class="form-group col-sm-3">
                  <div class="input-group date">
                     <?php 
                     echo form_input("effective_to", $this->input->get("effective_to"), array("class"=>"form-control datepicker", 'placeholder'=>'Effective Date To'));
                     ?>
                     <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                  </div>
               </div>
               <div class="form-group col-sm-3">
                  <div class="input-group date">
                     <?php 
                     echo form_input("expiry_to", $this->input->get("expiry_to"), array("class"=>"form-control datepicker", 'placeholder'=>'Expiry Date To'));
                     ?>
                     <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                  </div>
               </div>
            </div>
            <div class="row more_items" style="display:none">
               <div class="form-group col-sm-3">
                  <?php                 
                     $policy = array(""=>'--Select Policy Status--');
                     echo form_dropdown("policy", $policy, $this->input->get("policy"), array("class"=>'form-control'));
                  ?>
               </div>
               <div class="form-group col-sm-3">
                  <?php               
                     $privince = array(""=>'--Select Province--');
                     echo form_dropdown("privince", $privince, $this->input->get("privince"), array("class"=>'form-control'));
                  ?>
               </div>
               <div class="form-group col-sm-3">
                  <?php             
                     $country = array(""=>'--Select Country--');
                     echo form_dropdown("country", $country, $this->input->get("country"), array("class"=>'form-control'));
                  ?>
               </div>
            </div>
            <?php echo form_close(); ?>
            <!-- search policy filter end -->
            <div class="clearfix"><br/></div>

            <!-- search results start -->
            <div class="x_title">
               <h2>Search Result<small></small></h2>
               <div class="clearfix"></div>
            </div>
            <div class="x_content">
               <div class="table-responsive">
                  <table class="table table-hover table-bordered">
                     <thead>
                        <tr>
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
                        <tr>
                           <td>JF00001</td>
                           <td>1111</td>
                           <td>Tony</td>
                           <td>09/11/2005</td>
                           <td>Paid</td>
                           <td>09/11/2005</td>
                           <td>Nick</td>
                           <td>JF</td>
                           <td>Open</td>
                        </tr>
                     </tbody>
                  </table>
               </div>
            </div>
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
                     echo form_input("create_date", $this->input->get("create_date"), array("class"=>"form-control datepicker", 'placeholder'=>'Create Date'));
                     ?>
                     <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                  </div>
               </div>

               <div class="form-group col-sm-3">
                  <?php                 
                     $assign_to = array(""=>'--Assign To--');
                     echo form_dropdown("assign_to", $assign_to, $this->input->get("assign_to"), array("class"=>'form-control'));
                  ?>
               </div>
               <div class="form-group col-sm-3">
                  <?php                 
                     $case_manager = array(""=>'--Case Manager--');
                     echo form_dropdown("case_manager", $case_manager, $this->input->get("case_manager"), array("class"=>'form-control'));
                  ?>
               </div>          
               <div class="col-sm-3">
                  <button class="btn btn-primary">Search</button>
               </div>
            </div> 
            <?php echo form_close(); ?>
            <!-- search policy filter end -->
            <div class="clearfix"><br/></div>

            <!-- search results start -->
            <div class="x_title">
               <h2>Search Result<small></small></h2>
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
                        <tr>
                           <td>0000001</td>
                           <td>2016-09-09</td>
                           <td>Toronto</td>
                           <td>Traffic accident</td>
                           <td>JF00001</td>
                           <td>Wo</td>
                           <td>2001-09-11</td>
                           <td>EAC0001</td>
                           <td>CM0001</td>
                           <td>High</td>
                           <td><a>Clone</a></td>
                        </tr>
                     </tbody>
                  </table>
               </div>
            </div>
            <!-- End Search List Section -->
         </div>
      </div>
   </div>
</duv>

<?php echo link_tag('assets/css/bootstrap-datepicker.css'); ?>
<script src="<?php echo base_url() ?>/assets/js/bootstrap-datetimepicker.js"></script>
<script>
$(document).ready(function() {
   $(".datepicker").datepicker({
        startDate: '-5y',
        endDate: '+2y',
    });
})
$(document).on("click",".more_filters", function(){
   $(".more_items").toggle();
})
</script>