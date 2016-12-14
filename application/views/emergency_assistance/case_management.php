<duv >
   <div class="page-title">
      <div class="title_left">
         <h3>Case Management</h3>         
      </div>
   </div>
   <div class="clearfix"></div>
   <?php echo $message; ?>

   <!-- Case search and List Section -->
   <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
         <div class="x_panel">
         <div class="x_title">
            <h2>Case Filter<small></small></h2>
            <div class="clearfix"></div>
         </div>
         <div class="x_content"> 

            <!-- search case filter start -->       
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
                  <div class="input-group date">
                     <?php 
                     echo form_input("created_from", $this->input->get("created_from"), array("class"=>"form-control datepicker", 'placeholder'=>'Create Date From'));
                     ?>
                     <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                  </div>
               </div>
               <div class="form-group col-sm-3">
                  <div class="input-group date">
                     <?php 
                     echo form_input("created_to", $this->input->get("created_to"), array("class"=>"form-control datepicker", 'placeholder'=>'Create Date To'));
                     ?>
                     <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                  </div>
               </div>

               <div class="form-group col-sm-3">
                  <?php 
                  echo form_input("insured_lastname", $this->input->get("insured_lastname"), array("class"=>"form-control", 'placeholder'=>'Insured Last Name'));
                  ?>
               </div>

               <div class="form-group col-sm-3">
                  <?php 
                  echo form_input("insured_firstname", $this->input->get("insured_firstname"), array("class"=>"form-control", 'placeholder'=>'Insured First Name'));
                  ?>
               </div>

               <div class="form-group col-sm-3">
                  <?php 
                  echo form_label('Priority:', 'priority_label', array("class"=>'col-sm-4')); 
                  ?>
                  <div class="form-group col-sm-6">
                     <?php
                     echo form_checkbox("priority", "HIGH", ($this->input->get("priority") == 'HIGH' ? TRUE : FALSE), array("id"=>'priority', 'class'=>'col-sm-1')); 
                     echo form_label('High', 'priority', array("class"=>'col-sm-10 pull-right', 'style'=>'margin-top: 3px;'));
                     ?>
                  </div>
               </div>
  
               <div class="col-sm-3">
                  <button class="btn btn-primary" name="filter" value="case">Search</button>
               </div>
            </div> 
            <?php echo form_close(); ?>
            <!-- search case filter end -->
            <div class="clearfix"><br/></div>

            <!-- search results start -->
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
                        </tr>
                     <?php endforeach; ?>
                     </tbody>
                  </table>
               </div>
               </br>
               <div class="row form-group">
                  <div class="col-sm-3">
                     <button class="btn btn-primary">Auto Assign</button>
                     <button class="btn btn-primary">Save Assign</button>
                     <button class="btn btn-primary">Assign To</button>
                     <button class="btn btn-primary">Follow Up</button>     
                     <button class="btn btn-primary">View/Edit Case</button>      
                     <button class="btn btn-primary">Set Inactive</button>      
                     <button class="btn btn-primary">Email/Print</button>   
                  </div>               
               </div>

               <?php else:?>
                  <center><?php echo heading("No record available", 4); ?></center>
               <?php endif;?>
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
$(document).on("click", ".row-link", function(){
   $(this).toggleClass("selected");

})
</script>