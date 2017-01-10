<duv >
   <div class="page-title">
      <div class="title_left">

         <?php echo anchor("claim/create_claim", '<i class="fa fa-plus-circle"></i> Create New Claim', array("class"=>'btn btn-primary')) ?>
         
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
                        <tr class="view-policy" data='<?php echo json_encode($value); ?>'>
                           <td><?php echo $value['policy']; ?></td>
                           <td><?php echo $value['plan_id']; ?></td>
                           <td><?php echo $value['firstname']." ".$value['lastname']; ?></td>
                           <td><?php echo date("d/d/Y", strtotime($value['birthday'])); ?></td>
                           <td><?php echo $policy_status['array'][$value['status_id']]; ?></td>
                           <td><?php echo date("d/d/Y", strtotime($value['effective_date'])); ?></td>
                           <td>Which data goes here</td>
                           <td><?php echo $value['agent_firstname']." ".$value['agent_lastname']; ?></td>
                           <td><?php echo anchor("emergency_assistance/view_policy", "Open"); ?></td>
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
                           <tr class="row-link" alt="<?php echo $value['id']; ?>" title="Click to View/Edit">
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
                              <td><?php echo anchor("emergency_assistance/create_case/".$value['id'], "Clone"); ?></td>
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

               <!-- search policy filter start -->       
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
               <!-- search policy filter end -->
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
                              <th>Detail</th>
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
                              <td><?php echo form_checkbox("selectall", $value['id']); ?></td>
                              <td><?php echo $value['id']; ?></td>
                              <td><?php echo $value['policy_no']; ?></td>
                              <td><?php echo $value['claim_no']; ?></td>
                              <td><?php echo $value['insured_first_name']; ?></td>
                              <td><?php echo $value['insured_last_name']; ?></td>
                              <td><?php echo $value['gender']; ?></td>
                              <td><?php echo $value['dob']; ?></td>
                              <td><?php echo $value['claim_date']; ?></td>
                              <td>0</td>
                              <td>0</td>
                              <td><?php echo anchor("case/detail/".$value['id'], "Detail"); ?></td>
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
   $(".row-link").click(function() {
      var id = $(this).attr("alt");
      window.location = "<?php echo base_url("emergency_assistance/edit_case/") ?>"+id;
   })
   $(".view-policy").click(function(){
      var data = $(this).attr("data");

      // insert data to dom element to save temporary
      localStorage.setItem("policy_data", data);

      // redirect it to view policy page
      window.location = "<?php echo base_url("emergency_assistance/view_policy") ?>";
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