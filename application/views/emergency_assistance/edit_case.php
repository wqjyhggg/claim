<style>
.modal-lg {
    width: 75%;
}
</style>
<duv >
   <div class="page-title">
      <div class="title_left">
         <h3>Case Details</h3>
         <?php
         if(($this->ion_auth->is_claimsmanager() OR $this->ion_auth->is_claimexaminer()) and $this->input->get('type') == 'add_claim')
            echo anchor('claim/create_claim?policy='.$case_details['policy_no'].'&case_no='.$case_details['case_no'], '<i class="fa fa-plus-circle"></i> Create Claim', array("class"=>'btn btn-primary')) ?>   
      </div>
   </div>
   <div class="clearfix"></div>

   <!-- Policy search and List Section -->
   <div class="row">
      <?php echo $message; ?>
      <div class="col-md-12 col-sm-12 col-xs-12">
         <div class="x_panel">
            <div class="x_title">
               <h2>Edit Case<small></small></h2>
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
                     <?php echo anchor("emergency_assistance/search_provider", '<i class="fa fa-search"></i> Search Provider', array("class"=>'btn btn-primary search_provider')) ?>
                  </div>
                  <div class="form-group col-sm-4">
                     <?php 
                        echo form_label('Follow Up EAC:', 'assign_to', array("class"=>'col-sm-12'));
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
                  <div class="form-group col-sm-12">
                     <?php               
                     echo form_label('Medical Notes:', 'medical_notes', array("class"=>'col-sm-12'));  
                     echo form_textarea("medical_notes", $this->common_model->field_val("medical_notes", $case_details), array("class"=>"form-control", 'placeholder'=>'Medical Notes', 'style'=>'height:87px'));
                     echo form_error("medical_notes");
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
                     echo form_hidden('policy_info', $case_details['policy_info']);
                     ?>
                  </div> 
                  <div class="form-group col-sm-4">
                     <?php               
                     echo form_label('Insured Name:', 'insured_name', array("class"=>'col-sm-12'));  
                     ?>
                     <div class="form-group col-sm-6">
                        <?php
                        echo form_input("insured_firstname", $this->common_model->field_val("insured_firstname", $case_details), array("class"=>"form-control col-sm-6", 'placeholder'=>'Insured First Name'));
                        echo form_error("insured_firstname");
                        ?>
                     </div>
                     <div class="form-group col-sm-6">
                        <?php 
                        echo form_input("insured_lastname", $this->common_model->field_val("insured_lastname", $case_details), array("class"=>"form-control col-sm-6", 'placeholder'=>'Insured Last Name'));
                        echo form_error("insured_lastname");
                        ?>
                     </div>
                  </div> 

                  <div class="form-group col-sm-4">
                     <?php echo form_label('Insured Address:', 'insured_address', array("class"=>'col-sm-12'));   ?>
                     <div class="form-group col-sm-12">
                        <?php                
                        echo form_textarea("insured_address", $this->common_model->field_val("insured_address", $case_details), array("class"=>"form-control", 'placeholder'=>'Insured Address', 'style'=>"height:90px"));
                        echo form_error("insured_address");
                        ?>
                     </div>
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

                  <?php if($ref == 'manage'): ?>
                     <div class="form-group col-sm-12">
                        <h4>Reservers C$ <small></small></h4>
                        <?php echo form_label('Create Reservers:', 'reserve_amount', array("class"=>'col-sm-12'));   ?>
                        <div class="form-group col-sm-4">
                           <?php                
                           echo form_input("reserve_amount", $this->common_model->field_val("reserve_amount", $case_details), array("class"=>"form-control", 'placeholder'=>'Create Reservers'));
                           echo form_error("reserve_amount");
                           ?>
                        </div>
                     </div>
                  <?php endif;?>

                  <div class="col-sm-12">
                     <label class="col-sm-12">&nbsp;</label>
                     <button class="btn btn-primary">Save</button>
                     <button type="button" class="btn btn-primary create_intake_form" data-toggle="modal" data-target="#create_intake_form"><i class="fa fa-plus-circle"></i> Create InTakeForm</button>
                     <?php 
                     if($ref == 'manage')
                        echo anchor("emergency_assistance/case_management", "Cancel", array("class"=>'btn btn-info'));
                     else                        
                        echo anchor("emergency_assistance", "Cancel", array("class"=>'btn btn-info'));
                     if($ref == 'manage'):
                      ?>
                        <button type="button" class="btn btn-primary follow_up"  data-toggle="modal" data-target="#follow_reason">Follow Up <i class="fa fa-angle-double-right"></i></button>
                        <button type="button" class="btn btn-primary mark_inactive">Inactive</button>
                     <?php else:?>
                        <!-- put here email button -->
                        <button insured_address="<?php echo nl2br($case_details['insured_address']) ?>"
                           insured_lastname="<?php echo $case_details['insured_lastname'] ?>"
                           insured_name="<?php echo $case_details['insured_name'] ?>"
                           policy_no="<?php echo $case_details['policy_no'] ?>"
                           case_no="<?php echo $case_details['case_no'] ?>"
                           casemanager_name="<?php echo $case_details['case_manager_name'] ?>" class="btn btn-primary email_print" type="button"  data-toggle="modal" data-target="#print_template">Email/Print</button>

                     <?php endif; ?>
                  </div>                                          
               </div> 

               <?php if(!empty($intake_forms)):  ?>
               <h4 class="modal-title intake-heading" <?php if(empty($intake_forms)): ?> style="display:none"<?php endif; ?>>Intake Froms</h4>
               <div class="row intake-forms-list col-sm-12">
                  <?php 
                     $i = 0;
                     foreach ($intake_forms as $key => $value):
                        $i++;
                        ?>
                         <div class="col-sm-12 intake-forms">
                              <div class="col-sm-2">
                                 <div class="col-sm-12">
                                    <?php echo $i.". #".$value['user_id'] ?>
                                 </div>
                                 <div class="col-sm-12">
                                    <?php echo $value['created_by'] ?>
                                 </div>
                                 <div class="col-sm-12">
                                    <?php echo $value['created']; ?>
                                 </div>
                              </div>
                              <div class="col-sm-10">
                                 <div class="col-sm-12"><?php echo $value['notes'] ?></div>
                                 <div class="form-group col-sm-11 files">
                                    <br/>
                                    <?php 
                                    $files = $value['docs'] ? explode(",", $value['docs']) : array(); 
                                    if(!empty($files)):
                                       foreach ($files as $file):
                                          ?>
                                           <div class="col-sm-9" style="">
                                               <span class="file-label"><?php echo anchor("file/".$file . '__' . $value['id'], $file, array('target'=>'_blank')); ?></span>
                                               <?php echo anchor("file/" . $file . '__' . $value['id'], '<i class="fa fa-search row-link"></i>', array('target'=>'_blank', 'title'=>'Browse File')); ?>
                                               <?php echo anchor("download/" . $file . '__' . $value['id'], '<i class="fa fa-download row-link"></i>', array('title'=>'Download File')); ?>                                                     
                                           </div>
                                           <?php
                                       endforeach;
                                    endif;
                                    ?>
                                 </div>

                                 <div class="col-sm-1&quot;"><i class="fa fa-remove row-link remove-form pull-right" alt="<?php echo $value['id']; ?>"></i></div>   
                              </div>
                                                        
                         </div>  
                        <?php
                        endforeach;
                  ?>
               </div>
               <?php endif; ?>
               <?php echo form_close(); ?>
               <!-- search policy filter end -->
               <div class="clearfix"></div>
            </div>
         </div>
      </div>
   </div>
</duv>

<?php if($ref <> 'manage'):?>
<!-- Email print doc content here -->
<div id="print_template" class="modal fade" role="dialog">
  <div class="modal-dialog  modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Print/email Template Letter</h4>
      </div>
      <?php 
         echo form_open_multipart("emergency_assistance/send_print_email", array("id"=>'send_print_email'));
       ?>
      <div class="modal-body">
          <div class="row">
            <div class="col-sm-6">
               <div>
                  <label for="mail_label" class="col-sm-2">Mail Addres:</label>    
                  <div class="form-group col-sm-6">
                     <input name="priority" value="HIGH" id="mail_address" class="col-sm-1" type="checkbox">
                     <label for="mail_address" class="col-sm-10 pull-right" style="margin-top: 3px;">Use same address with the policy</label>
                  </div>
               </div>
               <div>
                  <?php
                  echo form_label('To:', 'email', array("class"=>'col-sm-12'));
                  ?>
                  <div class="form-group col-sm-12">
                     <?php  
                     echo form_input("email", "", array("class"=>"form-control col-sm-6 form-group email required", 'placeholder'=>'Email Address'));
                     ?>
                  </div>
               </div>
            </div>
            <div class="form-group col-sm-12">

               <div class="form-group col-sm-3">
                  <?php               
                  echo form_label('Street No.:', 'street_no_email', array("class"=>'col-sm-12'));  
                  echo form_input("street_no_email", "", array("class"=>"form-control required", 'placeholder'=>'Street No.'));
                  echo form_error("street_no_email");
                  ?>
               </div> 
               <div class="form-group col-sm-3">
                  <?php               
                  echo form_label('Street Name.:', 'street_name_email', array("class"=>'col-sm-12'));  
                  echo form_input("street_name_email", "", array("class"=>"form-control required", 'placeholder'=>'Street Name.'));
                  echo form_error("street_name_email");
                  ?>
               </div> 
               <div class="form-group col-sm-3">
                  <?php               
                  echo form_label('City:', 'city_email', array("class"=>'col-sm-12'));  
                  echo form_input("city_email", "", array("class"=>"form-control required", 'placeholder'=>'City'));
                  echo form_error("city");
                  ?>
               </div> 

               <div class="form-group col-sm-3">
                  <?php 
                     echo form_label('Province:', 'province_email', array("class"=>'col-sm-12'));
                     echo $province2;
                     echo form_error("province_email"); 
                  ?>
               </div>

               <?php 
                  echo form_label('Select Template:', 'select_template', array("class"=>'col-sm-12'));
               ?>
               <div class="form-group col-sm-12">
                  <?php foreach($docs as $doc): ?>
                     <div class="select-doc col-sm-2" doc="<?php echo $doc['id'] ?>">
                        <i class="fa fa-file-word-o large"></i>
                        <?php echo $doc['name'] ?> 
                     </div>
                  <?php endforeach; ?>
               </div>
            </div>  
            <div class="form-group col-sm-12 docfiles">
               <?php foreach($docs as $doc): ?>
                  <div class="col-sm-12 doc-description doc-<?php echo $doc['id'] ?>" style="display:none">
                     <div class="col-sm-12 doc_title">
                        <?php echo heading($doc['name']); ?> 
                     </div>
                     <div class="col-sm-12 doc-desc">
                        <?php
                           // find and replace text
                           $find = array(
                              '{otc_logo}',
                              '{current_date}'
                              );
                           $replace = array(
                              img(array('src'=>'assets/img/otc.jpg','width'=>'90', 'height'=>'50')),
                              date("F d, Y")
                              );
                         echo str_replace($find, $replace, $doc['description']);
                        ?>
                     </div>                     
                  </div>
               <?php endforeach; ?>
            </div>
         </div>
      </div>
      <div class="modal-footer">
         <label class="col-sm-12">&nbsp;</label>
         <button type="button" class="btn btn-info preview-template" disabled>Preview</button>
         <button class="btn btn-primary email-intakeform" disabled >Email</button>
         <button type="button" class="btn btn-info print" disabled>Print</button>
         <button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
      </div>
      <?php echo form_close(); ?>
    </div>

  </div>
</div>
<!-- end here --> 
<?php endif;?>   

<!-- follow up model window here -->
<div id="follow_reason" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Follow up case</h4>
      </div>
      <?php 
         echo form_open_multipart("emergency_assistance/follow_up_cases", array("id"=>'follow_up_cases'));
       ?>
      <div class="modal-body">
          <div class="row">
            <div class="col-sm-12">
               <div>
                  <?php
                  echo form_label('Please Enter The Reason:', 'notes', array("class"=>'col-sm-12'));
                  ?>
                  <div class="col-sm-12">
                     <?php  
                     echo form_textarea("notes", "", array("class"=>"form-control col-sm-6 form-group required", 'placeholder'=>'Please Enter The Reason'));
                     ?>
                  </div>
                  <div class="col-sm-12 follow-section">
                     <?php foreach ($employee_shift as $key => $value): ?>
                        <div class="col-sm-4">
                           <fieldset>
                              <legend><?php echo $value; ?></legend>
                              <?php
                                 $list = "employees_".$key; 
                                 echo $$list;
                               ?>
                           </fieldset>
                           <div class="clearfix"><br/></div>
                        </div>
                     <?php endforeach; ?>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="modal-footer">
         <label class="col-sm-12">&nbsp;</label>
         <button class="btn btn-info complete-follow">Follow Up</button>
         <button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
      </div>
      <?php echo form_close(); ?>
    </div>

  </div>
</div>
<!-- follow up model end here -->

<!-- Create Intake Form Modal -->
<div id="create_intake_form" class="modal fade" role="dialog">
  <div class="modal-dialog  modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Create Intake Form</h4>
      </div>
      <?php 
         echo form_open_multipart("emergency_assistance/create_intakeform", array("id"=>'create_intakeform'));
         echo form_hidden("case_id", $case_id);
       ?>
      <div class="modal-body">
          <div class="row">
            <div class="form-group col-sm-6">
               <?php 
                  echo form_label('Intake Form #:', 'form_id', array("class"=>'col-sm-12'));
               ?>
               <div class="form-group col-sm-12">
                  ####
               </div>
            </div>              
            <div class="form-group col-sm-6">
               <?php      
               echo form_label('Create Date:', 'create_date', array("class"=>'col-sm-12')); 
               ?>
               <div class="form-group col-sm-12">
                  <?php       
                  echo date("Y-m-d");
                  ?>
               </div>
            </div>
            <div class="form-group col-sm-12">
               <?php 
                  echo form_label('Intake Notes:', 'intake_notes', array("class"=>'col-sm-12'));
                  echo form_textarea("intake_notes", $this->input->post("intake_notes"), array("class"=>"form-control required", 'placeholder'=>'Intake Notes', 'style'=>"height:100px"));
                  echo form_error("intake_notes");
               ?>
            </div>
            <div class="form-group col-sm-12 files">

            </div>
         </div>
      </div>
      <div class="modal-footer">
         <label class="col-sm-12">&nbsp;</label>
         <button class="btn btn-primary save-intakeform" type="submit">Save</button>
         <a href="javascript:void(0)" class="btn btn-primary multiupload">Upload Attached</a>
         <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
      </div>
      <?php echo form_close(); ?>
    </div>

  </div>
</div>
<!-- end intake form model here -->

<?php echo link_tag('assets/css/bootstrap-datepicker.css'); ?>
<script src="<?php echo base_url() ?>/assets/js/bootstrap-datetimepicker.js"></script>
<script src="<?php echo base_url() ?>/assets/js/jQuery.print.js"></script>
<script src="<?php echo base_url() ?>/assets/js/jquery.validate.min.js"></script>
<script>
   var employee_id;
   $(document).ready(function() {
      $("#create_intakeform").validate();
      $(".datepicker").datepicker({
           startDate: '-117y',
           endDate: '+0y',
       });

      $("select[name=reason]").change(function(){
         if($(this).val() == 'Outpatient')
            $(".hospital_info").text("Doctor Info");
         else if($(this).val() == 'Inpatient')
            $(".hospital_info").text("Hospital Info");
         else
            $(".hospital_info").text("Doctor Info/Hospital Info");
      })
   })

   // once auto file clicked
   .on("change","input[type=file]", function(){

      // validate file extension
      var ext = $(this).val().split('.').pop().toLowerCase();
      if($.inArray(ext, ['pdf']) == -1) {
          alert('invalid extension! Please attach only pdf file.');
          $(this).val('');
          return false;
      }

      // display file name and delete button
      $(this).next("span.file-label").text($(this).val()).parent("div.col-sm-9").show();
   })

   // custom script for multi file upload
   .on("click",".multiupload", function(){
      var count = $("input[type=file]").length;

      // count no of intake forms
      var no_of_form = $(".intake-forms").length + 1;

      // add new file here
      $(".modal-body .files").append('<div class="col-sm-9" style="display:none"><input style="display:none" type="file" name="files[]" id="file'+(count+1)+'" accept="pdf" /><span class="file-label"></span> <i class="fa fa-trash row-link" id="'+(count+1)+'"></i></div>');

      // place trigger clicked once file append in files class
      $('#file'+(count+1)).trigger("click");
   })

   // delete intake form
   .on("click",".fa.fa-remove.row-link.remove-form.pull-right", function(){
      var id = $(this).attr("alt");

      if(confirm('Are you sure you want to delete? '))
      {
         // remove form area instant to make it visible fast
         $(this).parent("div").parent("div").parent("div.intake-forms").remove();

         $.ajax({
            url: "<?php echo base_url("emergency_assistance/deleteform/") ?>"+id,
            method: "get"
         })
      } else {
         return false;
      }
   })

   // clicking on save assign button
   .on("click", ".mark_inactive", function(){

      if(!confirm("Are you sure you want to inactive case?"))
         return false;

      // selected cases 
      var cases = [];
      $("input[name=case]:checked").each(function(){
         cases.push($(this).val());
      })
      var cases = cases.join(",");

      // assign cases to emc manager here
      $.ajax({
         url: "<?php echo base_url("emergency_assistance/mark_inactive") ?>",
         method: "post",
         data:{cases:"<?php echo $case_id; ?>"},
         beforeSend: function(){
            $(".right_col").addClass("csspinner load1");
         },
         success: function() {
            window.location = "<?php echo base_url("emergency_assistance/case_management") ?>";
         }
      })
   })

   // show email/print function
   .on("click", ".select-doc", function(){                                              
      
      // hide all doc files here
      $(".doc-description").hide(); 
      $(".select-doc").removeClass("active");

      // get doc if
      var id = $(this).attr("doc");
      $(this).addClass("active");

      // show related doc file
      $(".doc-"+id).show();

      // get selected case details object
      var obj = $(".email_print");

      // replace string from casemanager name etc
      var str = $(".doc-"+id+"  .doc-desc").html();
      str = str.replace(/{insured_name}/gi, obj.attr("insured_name"))
      .replace("{insured_address}", obj.attr("insured_address"))
      .replace("{insured_lastname}", obj.attr("insured_lastname"))
      .replace("{policy_no}", obj.attr("policy_no"))
      .replace("{case_no}", obj.attr("case_no"))
      .replace("{policy_coverage_info}", "{policy_coverage_info}")
      .replace("{casemanager_name}", obj.attr("casemanager_name"));

      $(".doc-"+id+" .doc-desc").html(str);

      // reset all edit//preview section
      $(".preview-template").text("Preview").removeClass("active-preview");

      // enable disable buttons
      $(".print").attr("disabled", "disabled");
      $(".preview-template, .email-intakeform").removeAttr("disabled");
   })

   // preview template script 
   .on("click", ".preview-template", function(){
      // get selected doc
      $(this).toggleClass("active-preview");
      var doc_id = $(".select-doc.active").attr("doc");
      if($(this).hasClass("active-preview"))
      {
         $(this).text("Edit Template");
         var $outer = $(".doc-"+doc_id+" .outer-text input, .doc-"+doc_id+" .outer-text textarea, .doc-"+doc_id+" .select-product select");
         $outer.each(function(){
            var text = $.trim($(this).val());

            $(this).parent("p,span").html(text.replace(/\n/g, "<br>"));
            $(this).remove();
         });

         // enable print button
         $(".print").removeAttr("disabled");
      }
      else
      {
         $(this).text("Preview");
         var $outer = $(".outer-text");
         $outer.each(function(){
            var text = $.trim($(this).html()).replace(/<br>/g, "\n");

            $(this).empty();
            if(!$(this).hasClass("area"))
               $(this).append("<input class='outer-text' value='" + text + "'></input>");
            else        
               $(this).append("<textarea  style='width:100%' rows='6'>"+ text +"</textarea>");
         });

         // for the products list
         var $outer_select = $(".select-product");
         $outer_select.each(function(){
            var text = $.trim($(this).text());

            $(this).empty();
            $(this).append($("#products").html()).children("select").val(text);
         });

         // disable print button
         $(".print").attr("disabled", "disabled");
      }
      
   })

   // print button script here
   .on("click", ".print", function(){
      var doc_id = $(".select-doc.active").attr("doc");
      $(".doc-"+doc_id).print({
           globalStyles: false,
           mediaPrint: true,
           iframe: true,
           noPrintSelector: ".avoid-this",
       });
   })

   // send email print to recepient email:-
   .on("submit", "#send_print_email", function(e){
      e.preventDefault();
      var doc_id = $(".select-doc.active").attr("doc");
      var template = $(".doc-"+doc_id).children("div.doc-desc").html();
      if($(this).valid()) 
      {
         $.ajax({
            url: "<?php echo base_url("emergency_assistance/send_print_email") ?>",
            method: "post",
            data:{
               email:$("input[name=email]").val(), 
               street_no:$("input[name=street_no_email]").val(), 
               street_name:$("input[name=street_name_email]").val(), 
               city:$("input[name=city_email]").val(), 
               province:$("select[name=province_email]").val(), 
               template:template,
               case_id: "<?php echo $case_id; ?>",
               doc: $(".select-doc.active").text()
            },
            beforeSend: function(){
               $(".modal-content").addClass("csspinner load1");
            },
            success: function() {
               window.location.reload();
            }
         })
      }
   })

   // once user clicked on same with policy button
   .on("click", "#mail_address", function(){

      // get local data
      var data = $.parseJSON($("input[name=policy_info]").val());
      if($(this).is(":checked"))
      {
         // fill all json values to address fields
         $("input[name=street_no_email]").val(data[0].street_number);
         $("input[name=street_name_email]").val(data[0].street_name);
         $("input[name=city_email]").val(data[0].city);
         $("select[name=province_email]").val(data[0].province2);
      }
      else
      {
         $("input[name=street_no_email],input[name=street_name_email],input[name=city_email],select[name=province_email]").val("");
      }
   })

   // set validation on emc select list
   .on("change", "select[name=assign_to_follow]", function(){

      var val = $(this).val();
      $("select").val("");
      $(this).val(val);

      // set selected employee
      employee_id = val;
   })


// clicking on follow button
.on("submit", "#follow_up_cases", function(e){                                            
   
   // prevent form to submit
   e.preventDefault();


   if($(this).valid())
   {

      // check if employee selected or not
      if(!employee_id)
      {
         alert("Please select emc user first.");
         return false;
      }

      // assign emc user to selected cases 
      var cases = [];
      $("input[name=case]:checked").each(function(){
         cases.push($(this).val());
      })
      var cases = cases.join(",");

      // assign cases to emc manager here
      $.ajax({
         url: "<?php echo base_url("emergency_assistance/follow_up_cases") ?>",
         method: "post",
         data:{cases:"<?php echo $case_id; ?>", employee_id: employee_id, notes: $("textarea[name=notes]").val() },
         beforeSend: function(){
            $(".modal-dialog").addClass("csspinner load1");
         },
         success: function() {
            window.location.reload();
         }
      })
   }
})

.on("click", '.search_provider', function(e){
   e.preventDefault();
   var href = $(this).attr("href")+"?street_no="+$("input[name=street_no]").val()+"&street_name="+$("input[name=street_name]").val()+"&city="+$("input[name=city]").val()+"&province="+$("select[name=province]").val()+"&country="+$("select[name=country2]").val()+"&post_code="+$("input[name=post_code]").val()+"";

   $(this).target = "_blank";
   window.open(href,"Search Providers", "width=1250,height=600"); 
})

// create input boxes where requirement need
var $outer = $(".outer-text");
$outer.each(function(){
   var text = $.trim($(this).text());

   $(this).empty();
   if(!$(this).hasClass("area"))
      $(this).append("<input class='outer-text' value='" + text + "'></input>");
   else        
      $(this).append("<textarea  style='width:100%' rows='6' value=''>"+ text +"</textarea>");
});

var $outer_select = $(".select-product");
$outer_select.each(function(){
   var text = $.trim($(this).text());

   $(this).empty();
   $(this).append($("#products").html());
});


</script>