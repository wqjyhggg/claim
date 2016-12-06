<duv >
   <div class="page-title">
      <div class="title_left">
         <h3>Create Case</h3>         
      </div>
   </div>
   <div class="clearfix"></div>

   <!-- Policy search and List Section -->
   <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
         <div class="x_panel">
            <div class="x_title">
               <h2>Case Details<small></small></h2>
               <div class="clearfix"></div>
            </div>
            <div class="x_content"> 

               <!-- search policy filter start -->       
              <?php echo form_open("", array('class'=>'form-horizontal')); ?>

               <h4>Case Basic Info option<small></small></h4>
                <div class="row">
                  <div class="form-group col-sm-4">
                     <?php 
                        echo form_label('Case Number:', 'case_no', array("class"=>'col-sm-12'));  
                        ?>
                        <div class="form-group col-sm-12">
                           <?php echo $case_details['case_no']; ?>
                        </div>
                        <?php
                        echo form_error("case_no");
                     ?>
                  </div>
                  <div class="form-group col-sm-4">
                     <?php echo form_label('Create Date:', 'created', array("class"=>'col-sm-12')); ?>
                     <div class="form-group col-sm-12">
                        <?php echo date("Y-m-d", strtotime($case_details['created'])); ?>
                     </div>
                  </div> 
                  <div class="form-group col-sm-4">
                     <?php echo form_label('Created By:', 'created_by', array("class"=>'col-sm-12')); ?>
                     <div class="form-group col-sm-12">
                        <?php echo $case_details['created_by']; ?>
                     </div>
                  </div>
               </div> 
             
               <h4>Visiting Address<small></small></h4>
               <div class="row">
                  <div class="form-group col-sm-4">
                     <?php               
                     echo form_label('Street No.:', 'street_no', array("class"=>'col-sm-12'));  
                     echo form_input("street_no", $this->common_model->field_val("street_no", $case_details), array("class"=>"form-control", 'placeholder'=>'Street No.'));
                     echo form_error("street_no");
                     ?>
                  </div> 
                  <div class="form-group col-sm-4">
                     <?php               
                     echo form_label('Street Name.:', 'street_name', array("class"=>'col-sm-12'));  
                     echo form_input("street_name", $this->common_model->field_val("street_name", $case_details), array("class"=>"form-control", 'placeholder'=>'Street Name.'));
                     echo form_error("street_name");
                     ?>
                  </div> 
                  <div class="form-group col-sm-4">
                     <?php               
                     echo form_label('City:', 'city', array("class"=>'col-sm-12'));  
                     echo form_input("city", $this->common_model->field_val("city", $case_details), array("class"=>"form-control", 'placeholder'=>'City'));
                     echo form_error("city");
                     ?>
                  </div> 

                  <div class="form-group col-sm-4">
                     <?php 
                        echo form_label('Province:', 'province', array("class"=>'col-sm-12'));
                        echo $province;
                        echo form_error("province");
                     ?>
                  </div>
                  <div class="form-group col-sm-4">
                     <?php 
                        echo form_label('Country:', 'country', array("class"=>'col-sm-12'));
                        echo $country2;
                        echo form_error("country");
                     ?>
                  </div>
                  <div class="form-group col-sm-2">
                     <?php               
                     echo form_label('Post Code:', 'post_code', array("class"=>'col-sm-12'));  
                     echo form_input("post_code", $this->common_model->field_val("post_code", $case_details), array("class"=>"form-control", 'placeholder'=>'Post Code'));
                     echo form_error("post_code");
                     ?>
                  </div>       
                  <div class="col-sm-2">
                     <label class="col-sm-12">&nbsp;</label>
                     <?php echo anchor("emergency_assistance/search_provider", '<i class="fa fa-search"></i> Search Provider', array("class"=>'btn btn-primary')) ?>
                  </div>
                  <div class="form-group col-sm-4">
                     <?php 
                        echo form_label('Assign To:', 'assign_to', array("class"=>'col-sm-12'));
                        echo $eacmanagers;
                        echo form_error("assign_to");
                     ?>
                  </div>
                  <div class="form-group col-sm-4">
                     <?php 
                        echo form_label('Reason:', 'reason', array("class"=>'col-sm-12'));
                        echo $reasons;
                        echo form_error("reason");
                     ?>
                  </div>               
               </div>

               <h4>Caller Info<small></small></h4>
               <div class="row">
                  <div class="form-group col-sm-4">
                     <?php               
                     echo form_label('First Name:', 'first_name', array("class"=>'col-sm-12'));  
                     echo form_input("first_name", $this->common_model->field_val("first_name", $case_details), array("class"=>"form-control", 'placeholder'=>'First Name'));
                     echo form_error("first_name");
                     ?>
                  </div> 
                  <div class="form-group col-sm-4">
                     <?php               
                     echo form_label('Last Name.:', 'last_name', array("class"=>'col-sm-12'));  
                     echo form_input("last_name", $this->common_model->field_val("last_name", $case_details), array("class"=>"form-control", 'placeholder'=>'Last Name.'));
                     echo form_error("last_name");
                     ?>
                  </div> 
                  <div class="form-group col-sm-4">
                     <?php               
                     echo form_label('Phone Number:', 'phone_number', array("class"=>'col-sm-12'));  
                     echo form_input("phone_number", $this->common_model->field_val("phone_number", $case_details), array("class"=>"form-control", 'placeholder'=>'Phone Number'));
                     echo form_error("phone_number");
                     ?>
                  </div> 
                  <div class="form-group col-sm-4">
                     <?php               
                     echo form_label('Email:', 'email', array("class"=>'col-sm-12'));  
                     echo form_input("email", $this->common_model->field_val("email", $case_details), array("class"=>"form-control", 'placeholder'=>'Email'));
                     echo form_error("email");
                     ?>
                  </div>
                  <div class="form-group col-sm-4">
                     <?php 
                        echo form_label('Relationship:', 'relations', array("class"=>'col-sm-12'));
                        echo $relations;
                        echo form_error("relations");
                     ?>
                  </div>
                  <div class="form-group col-sm-4">
                     <?php 
                        echo form_label('Country:', 'country2', array("class"=>'col-sm-12'));
                        echo $country;
                        echo form_error("country2");
                     ?>
                  </div>                              
               </div>



               <h4 class="hospital_info">Doctor Info/Hospital Info</h4>
               <div class="row">
                  <div class="form-group col-sm-4">
                     <?php               
                     echo form_label('Main Diagnosis:', 'diagnosis', array("class"=>'col-sm-12'));  
                     echo form_input("diagnosis", $this->common_model->field_val("diagnosis", $case_details), array("class"=>"form-control", 'placeholder'=>'Main Diagnosis'));
                     echo form_error("diagnosis");
                     ?>
                  </div> 
                  <div class="form-group col-sm-4">
                     <?php               
                     echo form_label('Treatment:', 'treatment', array("class"=>'col-sm-12'));  
                     echo form_input("treatment", $this->common_model->field_val("treatment", $case_details), array("class"=>"form-control", 'placeholder'=>'Treatment'));
                     echo form_error("treatment");
                     ?>
                  </div> 
                  <div class="form-group col-sm-4">
                     <?php               
                     echo form_label('Third Party Recovery:', 'third_party_recovery', array("class"=>'col-sm-12'));  
                     echo form_checkbox("third_party_recovery", "Y", $this->common_model->field_val("third_party_recovery", $case_details), array());
                     echo form_error("third_party_recovery");
                     ?>
                  </div>                                             
               </div> 

               <h4>Assistance Client Info<small></small></h4>
               <div class="row">
                  <div class="form-group col-sm-4">
                     <?php               
                     echo form_label('Policy Number:', 'policy_no', array("class"=>'col-sm-12'));  
                     echo form_input("policy_no", $this->common_model->field_val("policy_no", $case_details), array("class"=>"form-control", 'placeholder'=>'Policy Number'));
                     echo form_error("policy_no");
                     ?>
                  </div> 
                  <div class="form-group col-sm-4">
                     <?php               
                     echo form_label('Insured Name:', 'insured_name', array("class"=>'col-sm-12'));  
                     echo form_input("insured_name", $this->common_model->field_val("insured_name", $case_details), array("class"=>"form-control", 'placeholder'=>'Insured Name'));
                     echo form_error("insured_name");
                     ?>
                  </div> 
                  <div class="form-group col-sm-4">
                     <?php echo form_label('Day of Birth:', 'dob', array("class"=>'col-sm-12'));   ?>
                     <div class="input-group date">
                        <?php                
                        echo form_input("dob", $this->common_model->field_val("dob", $case_details), array("class"=>"form-control datepicker", 'placeholder'=>'Day of Birth'));
                        echo form_error("dob");
                        ?>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                     </div>
                  </div>                                              
               </div> 


               <h4>Assign Case Manager<small></small></h4>
               <div class="row">               
                  <div class="form-group col-sm-4">
                     <?php 
                        echo form_label('Case Manager:', 'case_manager', array("class"=>'col-sm-12'));
                        echo $casemamager;
                        echo form_error("case_manager");
                     ?>
                  </div> 
                  <div class="form-group col-sm-4">
                     <?php 
                        echo form_label('Priority:', 'priority', array("class"=>'col-sm-12'));                  
                        $priority = array(
                           ""=>'--Select Priority--',
                           "HIGH"=>'High',
                           "Normal"=>'Normal',
                           );
                        echo form_dropdown("priority", $priority, $this->common_model->field_val("priority", $case_details), array("class"=>'form-control'));
                        echo form_error("priority");
                     ?>
                  </div>
                  <div class="col-sm-4">
                     <label class="col-sm-12">&nbsp;</label>
                     <button class="btn btn-primary">Update</button>
                     <?php echo anchor("emergency_assistance", "Cancel", array("class"=>'btn btn-info')); ?>
                  </div>                                          
               </div> 

               <?php echo form_close(); ?>
               <!-- search policy filter end -->
               <div class="clearfix"></div>
            </div>
         </div>
      </div>
   </div>

   <!-- Intake Forms List Section -->
   <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
         <!-- search results start -->
         <div class="x_title">
            <h2>Intake From List<small></small></h2> 
            <?php echo anchor("emergency_assistance/create_intakeform", '<i class="fa fa-plus-circle"></i> Create InTake Form', array("class"=>'btn btn-info')) ?>
            <div class="clearfix"></div>
         </div>
         <div class="x_content">
            <div class="table-responsive">
               <table class="table table-hover table-bordered">
                  <thead>
                     <tr>
                        <th>#</th>
                        <th>Create Date</th>
                        <th>Create By</th>
                        <th>Edit</th>                     
                     </tr>
                  </thead>
                  <tbody>
                     <tr>
                        <td>1</td>
                        <td>26-11-2015 10:00 am</td>
                        <td> Ron </td>
                        <td>Edit</td>
                     </tr>
                     <tr>
                        <td>2</td>
                        <td>26-11-2015 05:00 pm</td>
                        <td> Ron </td>
                        <td>Edit</td>
                     </tr>
                  </tbody>
               </table>
            </div>
         </div>
         <!-- End List -->
      </div>
   </div>
</duv>

<?php echo link_tag('assets/css/bootstrap-datepicker.css'); ?>
<script src="<?php echo base_url() ?>/assets/js/bootstrap-datetimepicker.js"></script>
<script>
$(document).ready(function() {
   $(".datepicker").datepicker({
        startDate: '-117y',
        endDate: '+0y',
    });

   $("select[name=reason]").change(function(){
      if($(this).val() == 'Outpatient')
         $(".hospital_info").text("Doctor Info");
      else if($(this).val() == 'Other')
         $(".hospital_info").text("Doctor Info/Hospital Info");
      else
         $(".hospital_info").text("Hospital Info");
   })
})
</script>