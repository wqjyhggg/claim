<duv class-"main-div"="">
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
              <?php echo form_open("", array('class'=>'form-horizontal', 'method'=>'get')); ?>

               <h4>Case Basic Info option<small></small></h4>
                <div class="row">
                  <div class="form-group col-sm-4">
                     <?php 
                        echo form_label('Case Number:', 'case_no', array("class"=>'col-sm-12'));                               
                        echo form_input("case_no", $this->input->post("case_no"), array("class"=>"form-control", 'placeholder'=>'Case Number'));
                     ?>
                  </div>
                  <div class="form-group col-sm-4">
                     <?php echo form_label('Create Date:', 'created', array("class"=>'col-sm-12'));   ?>
                     <div class="input-group date">
                        <?php                
                        echo form_input("created", date("Y-m-d H:i:s"), array("class"=>"form-control", 'placeholder'=>'Create Date'));
                        ?>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                     </div>
                  </div>              
                  <div class="form-group col-sm-4">
                     <?php      
                     echo form_label('Create By:', 'created_by', array("class"=>'col-sm-12'));        
                     echo form_input("created_by", $this->input->post("created_by"), array("class"=>"form-control", 'placeholder'=>'Create By'));
                     ?>
                  </div> 
               </div> 
             
               <h4>Visiting Address<small></small></h4>
               <div class="row">
                  <div class="form-group col-sm-4">
                     <?php               
                     echo form_label('Street No.:', 'street_no', array("class"=>'col-sm-12'));  
                     echo form_input("street_no", $this->input->post("street_no"), array("class"=>"form-control", 'placeholder'=>'Street No.'));
                     ?>
                  </div> 
                  <div class="form-group col-sm-4">
                     <?php               
                     echo form_label('Street Name.:', 'street_name', array("class"=>'col-sm-12'));  
                     echo form_input("street_name", $this->input->post("street_name"), array("class"=>"form-control", 'placeholder'=>'Street Name.'));
                     ?>
                  </div> 
                  <div class="form-group col-sm-4">
                     <?php               
                     echo form_label('City:', 'city', array("class"=>'col-sm-12'));  
                     echo form_input("city", $this->input->post("city"), array("class"=>"form-control", 'placeholder'=>'City'));
                     ?>
                  </div> 

                  <div class="form-group col-sm-4">
                     <?php 
                        echo form_label('Province:', 'province', array("class"=>'col-sm-12'));                  
                        $province = array(""=>'--Select Province--');
                        echo form_dropdown("province", $province, $this->input->get("province"), array("class"=>'form-control'));
                     ?>
                  </div>
                  <div class="form-group col-sm-4">
                     <?php 
                        echo form_label('Country:', 'country', array("class"=>'col-sm-12'));                  
                        $country = array(""=>'--Select Country--');
                        echo form_dropdown("country", $country, $this->input->get("country"), array("class"=>'form-control'));
                     ?>
                  </div>
                  <div class="form-group col-sm-2">
                     <?php               
                     echo form_label('Post Code:', 'post_code', array("class"=>'col-sm-12'));  
                     echo form_input("post_code", $this->input->post("post_code"), array("class"=>"form-control", 'placeholder'=>'Post Code'));
                     ?>
                  </div>       
                  <div class="col-sm-2">
                     <label class="col-sm-12">&nbsp;</label>
                     <?php echo anchor("emergency_assistance/search_provider", '<i class="fa fa-search"></i> Search Provider', array("class"=>'btn btn-primary')) ?>
                  </div>
                  <div class="form-group col-sm-4">
                     <?php 
                        echo form_label('Assign To:', 'assign_to', array("class"=>'col-sm-12'));                  
                        $assign_to = array(""=>'--Assign To--');
                        echo form_dropdown("assign_to", $assign_to, $this->input->get("assign_to"), array("class"=>'form-control'));
                     ?>
                  </div>
                  <div class="form-group col-sm-4">
                     <?php 
                        echo form_label('Reason:', 'reason', array("class"=>'col-sm-12'));                  
                        $reason = array(""=>'--Select Reason--');
                        echo form_dropdown("reason", $reason, $this->input->get("reason"), array("class"=>'form-control'));
                     ?>
                  </div>               
               </div>

               <h4>Caller Info<small></small></h4>
               <div class="row">
                  <div class="form-group col-sm-4">
                     <?php               
                     echo form_label('First Name:', 'first_name', array("class"=>'col-sm-12'));  
                     echo form_input("first_name", $this->input->post("first_name"), array("class"=>"form-control", 'placeholder'=>'First Name'));
                     ?>
                  </div> 
                  <div class="form-group col-sm-4">
                     <?php               
                     echo form_label('Last Name.:', 'last_name', array("class"=>'col-sm-12'));  
                     echo form_input("last_name", $this->input->post("last_name"), array("class"=>"form-control", 'placeholder'=>'Last Name.'));
                     ?>
                  </div> 
                  <div class="form-group col-sm-4">
                     <?php               
                     echo form_label('Phone Number:', 'phone_number', array("class"=>'col-sm-12'));  
                     echo form_input("phone_number", $this->input->post("phone_number"), array("class"=>"form-control", 'placeholder'=>'Phone Number'));
                     ?>
                  </div> 
                  <div class="form-group col-sm-4">
                     <?php               
                     echo form_label('Email:', 'email', array("class"=>'col-sm-12'));  
                     echo form_input("email", $this->input->post("email"), array("class"=>"form-control", 'placeholder'=>'Email'));
                     ?>
                  </div> 

                  <div class="form-group col-sm-4">
                     <?php 
                        echo form_label('Relationship:', 'relations', array("class"=>'col-sm-12'));                  
                        $relations = array(""=>'--Select Relationship--');
                        echo form_dropdown("relations", $relations, $this->input->get("relations"), array("class"=>'form-control'));
                     ?>
                  </div>
                  <div class="form-group col-sm-4">
                     <?php 
                        echo form_label('Country:', 'country', array("class"=>'col-sm-12'));                  
                        $country = array(""=>'--Select Country--');
                        echo form_dropdown("country", $country, $this->input->get("country"), array("class"=>'form-control'));
                     ?>
                  </div>                              
               </div>



               <h4>Doctor Info/Hospital Info<small></small></h4>
               <div class="row">
                  <div class="form-group col-sm-4">
                     <?php               
                     echo form_label('Main Diagnosis:', 'diagnosis', array("class"=>'col-sm-12'));  
                     echo form_input("diagnosis", $this->input->post("diagnosis"), array("class"=>"form-control", 'placeholder'=>'Main Diagnosis'));
                     ?>
                  </div> 
                  <div class="form-group col-sm-4">
                     <?php               
                     echo form_label('Treatment:', 'treatment', array("class"=>'col-sm-12'));  
                     echo form_input("treatment", $this->input->post("treatment"), array("class"=>"form-control", 'placeholder'=>'Treatment'));
                     ?>
                  </div> 
                  <div class="form-group col-sm-4">
                     <?php               
                     echo form_label('Third Party Recovery:', 'third_party_recovery', array("class"=>'col-sm-12'));  
                     echo form_checkbox("third_party_recovery", "Y", $this->input->post("third_party_recovery"), array());
                     ?>
                  </div>                                             
               </div> 


               <h4>Assistance Client Info<small></small></h4>
               <div class="row">
                  <div class="form-group col-sm-4">
                     <?php               
                     echo form_label('Policy Number:', 'policy_no', array("class"=>'col-sm-12'));  
                     echo form_input("policy_no", $this->input->post("policy_no"), array("class"=>"form-control", 'placeholder'=>'Policy Number'));
                     ?>
                  </div> 
                  <div class="form-group col-sm-4">
                     <?php               
                     echo form_label('Insured Name:', 'insured_name', array("class"=>'col-sm-12'));  
                     echo form_input("insured_name", $this->input->post("insured_name"), array("class"=>"form-control", 'placeholder'=>'Insured Name'));
                     ?>
                  </div> 
                  <div class="form-group col-sm-4">
                     <?php echo form_label('Day of Birth:', 'dob', array("class"=>'col-sm-12'));   ?>
                     <div class="input-group date">
                        <?php                
                        echo form_input("dob", date("Y-m-d H:i:s"), array("class"=>"form-control", 'placeholder'=>'Day of Birth'));
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
                        $case_manager = array(""=>'--Select Case Manager--');
                        echo form_dropdown("case_manager", $case_manager, $this->input->get("case_manager"), array("class"=>'form-control'));
                     ?>
                  </div> 
                  <div class="form-group col-sm-4">
                     <?php 
                        echo form_label('Priority:', 'priority', array("class"=>'col-sm-12'));                  
                        $priority = array(
                           ""=>'--Select Priority--',
                           "HIGH"=>'High',
                           "Normal"=>'Normal',
                           "LOW"=>'Low'
                           );
                        echo form_dropdown("priority", $priority, $this->input->get("priority"), array("class"=>'form-control'));
                     ?>
                  </div>
                  <div class="col-sm-4">
                     <label class="col-sm-12">&nbsp;</label>
                     <button class="btn btn-primary">Save</button>
                     <button class="btn btn-info">Cancel</button>
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
        startDate: '-5y',
        endDate: '+2y',
    });
})
$(document).on("click",".more_filters", function(){
   $(".more_items").toggle();
})
</script>