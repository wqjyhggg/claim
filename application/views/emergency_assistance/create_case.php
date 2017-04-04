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
              <?php echo form_open_multipart("", array('class'=>'form-horizontal')); ?>

               <h4>Case Basic Info option<small></small></h4>
                <div class="row">
                  <div class="form-group col-sm-4">
                     <?php 
                        echo form_label('Case Number:', 'case_no', array("class"=>'col-sm-12'));  
                        ?>
                        <div class="form-group col-sm-12">
                           #######
                        </div>
                        <?php
                        echo form_error("case_no");
                     ?>
                  </div>
                  <div class="form-group col-sm-4">
                     <?php echo form_label('Create Date:', 'created', array("class"=>'col-sm-12')); ?>
                     <div class="form-group col-sm-12">
                        <?php echo date("Y-m-d"); ?>
                     </div>
                  </div>              
                  <!-- <div class="form-group col-sm-4">
                     <?php      
                     echo form_label('Create By:', 'created_by', array("class"=>'col-sm-12'));        
                     echo form_input("created_by", $this->common_model->field_val("created_by"), array("class"=>"form-control", 'placeholder'=>'Create By'));
                     echo form_error("created_by");
                     ?>
                  </div>  -->
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
                        echo $country;
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
                     <?php echo anchor("emergency_assistance/search_provider", '<i class="fa fa-search"></i> Search Provider', array("class"=>'btn btn-primary search_provider', 'target'=>'_blank')) ?>
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
                  <div class="clearfix"></div>
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
                        echo form_label('Place of Call:', 'place_of_call', array("class"=>'col-sm-12'));
                     	echo form_input("place_of_call", $this->common_model->field_val("place_of_call", $case_details), array("class"=>"form-control", 'placeholder'=>'Place of Call'));
                        echo form_error("place_of_call");
                     ?>
                  </div>
                  <div class="form-group col-sm-4">
                     <?php echo form_label('Incident Date:', 'incident_date', array("class"=>'col-sm-12')); ?>
                     <div class="input-group date">
                     <?php echo form_input("incident_date", $this->common_model->field_val("incident_date", $case_details), array("class"=>"form-control datepicker", 'placeholder'=>'Incident Date')); ?>
                     <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                     </div>
                     <?php echo form_error("incident_date"); ?>
                  </div>
                  <div class="form-group col-sm-4">
                     <?php 
                        echo form_label('Country:', 'country2', array("class"=>'col-sm-12'));
                        echo $country2;
                        echo form_error("country2");
                     ?>
                  </div>                              
               </div>



               <h4 class="hospital_info">Doctor Info/Hospital Info</h4>
				<div class="row inpationdocinfo">
					<label class="form-group col-sm-12">Inpatient Info</label>
					<div class="form-group col-sm-4">
						<?php echo form_label('Addmission Date:', 'addmission_date', array("class"=>'col-sm-12'));   ?>
						<div class="input-group date">
                        	<?php                
                        		echo form_input("addmission_date", $this->common_model->field_val("addmission_date", $case_details), array("class"=>"form-control datepicker", 'placeholder'=>'Addmission Date'));
                        	?>
                        	<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                        </div>
                        <?php echo form_error("addmission_date"); ?>
					</div> 
					<div class="form-group col-sm-4">
						<?php echo form_label('Discharge Date:', 'discharge_date', array("class"=>'col-sm-12'));   ?>
						<div class="input-group date">
                        	<?php                
                        		echo form_input("discharge_date", $this->common_model->field_val("discharge_date", $case_details), array("class"=>"form-control datepicker", 'placeholder'=>'Discharge Date'));
                        	?>
                        	<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                        </div>
                        <?php echo form_error("discharge_date"); ?>
					</div> 
					<div class="form-group col-sm-4">
						<?php
							echo form_label('Room Number:', 'room_number', array("class"=>'col-sm-12'));
							echo form_input("room_number", $this->common_model->field_val("room_number", $case_details), array("class"=>"form-control", 'placeholder'=>'Room Number'));
							echo form_error("room_number");
						?>
					</div> 
					<div class="form-group col-sm-4">
						<?php
							echo form_label('Account Number:', 'account_number', array("class"=>'col-sm-12'));
							echo form_input("account_number", $this->common_model->field_val("account_number", $case_details), array("class"=>"form-control", 'placeholder'=>'Account Number'));
							echo form_error("account_number");
						?>
					</div> 
					<div class="form-group col-sm-4">
						<?php
							echo form_label('Hospital Charge:', 'hospital_charge', array("class"=>'col-sm-12'));
							echo form_input("hospital_charge", $this->common_model->field_val("hospital_charge", $case_details), array("class"=>"form-control", 'placeholder'=>'Hospital Charge'));
							echo form_error("hospital_charge");
						?>
					</div> 
					<div class="form-group col-sm-4">
						<?php
							echo form_label('Currency:', 'inpatient_currency', array("class"=>'col-sm-12'));
							echo $inpatient_currency;
							echo form_error("inpatient_currency");
						?>
					</div> 
				</div> 
				<div class="row">
					<label class="form-group col-sm-12 doctor_info">Home Doctor Info</label>
					<div class="form-group col-sm-4">
						<?php
							echo form_label('First Name:', 'doctor_first_name', array("class"=>'col-sm-12'));
							echo form_input("doctor_first_name", $this->common_model->field_val("doctor_first_name", $case_details), array("class"=>"form-control", 'placeholder'=>'First Name'));
							echo form_error("doctor_first_name");
						?>
					</div> 
					<div class="form-group col-sm-4">
						<?php
							echo form_label('Last Name:', 'doctor_last_name', array("class"=>'col-sm-12'));
							echo form_input("doctor_last_name", $this->common_model->field_val("doctor_last_name", $case_details), array("class"=>"form-control", 'placeholder'=>'Last Name'));
							echo form_error("doctor_last_name");
						?>
					</div> 
					<div class="form-group col-sm-4">
						<?php
							echo form_label('Country:', 'doctor_country', array("class"=>'col-sm-12'));
							echo $doctor_country;
							echo form_error("doctor_country");
						?>
					</div> 
					<div class="form-group col-sm-4">
						<?php
							echo form_label('Province:', 'doctor_province', array("class"=>'col-sm-12'));
							echo $doctor_province;
							echo form_error("doctor_province");
						?>
					</div> 
					<div class="form-group col-sm-4">
						<?php
							echo form_label('Address:', 'doctor_address', array("class"=>'col-sm-12'));
							echo form_input("doctor_address", $this->common_model->field_val("doctor_address", $case_details), array("class"=>"form-control", 'placeholder'=>'Address'));
							echo form_error("doctor_address");
						?>
					</div> 
					<div class="form-group col-sm-4">
						<?php
							echo form_label('City:', 'doctor_city', array("class"=>'col-sm-12'));
							echo form_input("doctor_city", $this->common_model->field_val("doctor_city", $case_details), array("class"=>"form-control", 'placeholder'=>'City'));
							echo form_error("doctor_city");
						?>
					</div> 
					<div class="form-group col-sm-4">
						<?php
							echo form_label('Post Code:', 'doctor_post_code', array("class"=>'col-sm-12'));
							echo form_input("doctor_post_code", $this->common_model->field_val("doctor_post_code", $case_details), array("class"=>"form-control", 'placeholder'=>'Post Code'));
							echo form_error("doctor_post_code");
						?>
					</div> 
					<div class="form-group col-sm-4">
						<?php
							echo form_label('Phone Number:', 'doctor_phone', array("class"=>'col-sm-12'));
							echo form_input("doctor_phone", $this->common_model->field_val("doctor_phone", $case_details), array("class"=>"form-control", 'placeholder'=>'Phone Number'));
							echo form_error("doctor_phone");
						?>
					</div> 
				</div> 
				<div class="row outpationdocinfo">
					<label class="form-group col-sm-12">Outpatient Info / Hospital Info</label>
					<div class="form-group col-sm-4">
						<?php
							echo form_label('Provider:', 'outpatient_provider', array("class"=>'col-sm-12'));
							echo form_input("outpatient_provider", $this->common_model->field_val("outpatient_provider", $case_details), array("class"=>"form-control", 'placeholder'=>'Provider'));
							echo form_error("outpatient_provider");
						?>
					</div> 
					<div class="form-group col-sm-4">
						<?php
							echo form_label('Federal tax ID#:', 'outpatient_federal_tax', array("class"=>'col-sm-12'));
							echo form_input("outpatient_federal_tax", $this->common_model->field_val("outpatient_federal_tax", $case_details), array("class"=>"form-control", 'placeholder'=>'Federal tax ID Number'));
							echo form_error("outpatient_federal_tax");
						?>
					</div> 
					<div class="form-group col-sm-4">
						<?php
							echo form_label('Facility:', 'outpatient_facility', array("class"=>'col-sm-12'));
							echo form_input("outpatient_facility", $this->common_model->field_val("outpatient_facility", $case_details), array("class"=>"form-control", 'placeholder'=>'Facility'));
							echo form_error("outpatient_facility");
						?>
					</div> 
					<div class="form-group col-sm-4">
						<?php
							echo form_label('Physician:', 'outpatient_physician', array("class"=>'col-sm-12'));
							echo form_input("outpatient_physician", $this->common_model->field_val("outpatient_physician", $case_details), array("class"=>"form-control", 'placeholder'=>'Physician'));
							echo form_error("outpatient_physician");
						?>
					</div> 
					<div class="form-group col-sm-4">
						<?php
							echo form_label('Address 1:', 'outpatient_address1', array("class"=>'col-sm-12'));
							echo form_input("outpatient_address1", $this->common_model->field_val("outpatient_address1", $case_details), array("class"=>"form-control", 'placeholder'=>'Address 1'));
							echo form_error("outpatient_address1");
						?>
					</div> 
					<div class="form-group col-sm-4">
						<?php
							echo form_label('Address 2:', 'outpatient_address2', array("class"=>'col-sm-12'));
							echo form_input("outpatient_address2", $this->common_model->field_val("outpatient_address2", $case_details), array("class"=>"form-control", 'placeholder'=>'Address 2'));
							echo form_error("outpatient_address2");
						?>
					</div> 
					<div class="form-group col-sm-4">
						<?php
							echo form_label('City:', 'outpatient_city', array("class"=>'col-sm-12'));
							echo form_input("outpatient_city", $this->common_model->field_val("outpatient_city", $case_details), array("class"=>"form-control", 'placeholder'=>'City'));
							echo form_error("outpatient_city");
						?>
					</div> 
					<div class="form-group col-sm-4">
						<?php
							echo form_label('Province:', 'outpatient_province', array("class"=>'col-sm-12'));
							echo $outpatient_province;
							echo form_error("outpatient_province");
						?>
					</div> 
					<div class="form-group col-sm-4">
						<?php
							echo form_label('Country:', 'outpatient_country', array("class"=>'col-sm-12'));
							echo $outpatient_country;
							echo form_error("outpatient_country");
						?>
					</div> 
					<div class="form-group col-sm-4">
						<?php
							echo form_label('Post Code:', 'outpatient_post_code', array("class"=>'col-sm-12'));
							echo form_input("outpatient_post_code", $this->common_model->field_val("outpatient_post_code", $case_details), array("class"=>"form-control", 'placeholder'=>'Post Code'));
							echo form_error("outpatient_post_code");
						?>
					</div> 
					<div class="form-group col-sm-4">
						<?php
							echo form_label('Phone:', 'outpatient_phone', array("class"=>'col-sm-12'));
							echo form_input("outpatient_phone", $this->common_model->field_val("outpatient_phone", $case_details), array("class"=>"form-control", 'placeholder'=>'Phone Number'));
							echo form_error("outpatient_phone");
						?>
					</div> 
					<div class="form-group col-sm-4">
						<?php
							echo form_label('FAX:', 'outpatient_fax', array("class"=>'col-sm-12'));
							echo form_input("outpatient_fax", $this->common_model->field_val("outpatient_fax", $case_details), array("class"=>"form-control", 'placeholder'=>'Fax Number'));
							echo form_error("outpatient_fax");
						?>
					</div> 
				</div> 
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
                     echo form_checkbox("third_party_recovery", "Y", $this->common_model->field_val("third_party_recovery", $case_details), array('style'=>'margin-left: 12px;'));
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
                     echo form_input("policy_no", ($this->common_model->field_val("policy_no", $case_details)?$this->common_model->field_val("policy_no", $case_details):$this->input->get("policy")), array("class"=>"form-control", 'placeholder'=>'Policy Number'));
                     echo form_error("policy_no");
                     echo form_hidden("policy_info");
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
                     <?php echo form_label('Day of Birth:', 'dob', array("class"=>'col-sm-12'));   ?>
                     <div class="input-group date">
                        <?php                
                        echo form_input("dob", $this->common_model->field_val("dob", $case_details), array("class"=>"form-control datepicker", 'placeholder'=>'Day of Birth'));
                        ?>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                     </div>
                        <?php echo form_error("dob"); ?>
                  </div> 
                  <div class="clearfix"></div>
                  <div class="form-group col-sm-4">
                     <?php echo form_label('Insured Address:', 'insured_address', array("class"=>'col-sm-12'));   ?>
                     <div class="form-group col-sm-12">
                        <?php                
                        echo form_textarea("insured_address", $this->common_model->field_val("insured_address", $case_details), array("class"=>"form-control", 'placeholder'=>'Insured Address', 'style'=>"height:90px"));
                        echo form_error("insured_address");
                        ?>
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
                     <button class="btn btn-primary">Save</button>
                     <button type="button" class="btn btn-primary create_intake_form" data-toggle="modal" data-target="#create_intake_form"><i class="fa fa-plus-circle"></i> Create InTakeForm</button>
                     <?php echo anchor("emergency_assistance", "Cancel", array("class"=>'btn btn-info')); ?>
                  </div>                                          
               </div>

               <!-- Intake Forms List Section -->
               <br/>
               <h4 class="modal-title intake-heading" style="display:none">Intake Froms</h4>
               <div class="row intake-forms-list col-sm-12">

               </div>
               <input type="hidden" name="no_of_form" value="0"/> <!-- used to knnow how many forms added in this page -->
               <!-- end intake forms list  -->

               <?php echo form_close(); ?>
               <!-- search policy filter end -->
               <div class="clearfix"></div>
            </div>
         </div>
      </div>
   </div>
</duv>

<!-- Create Intake Form Modal -->
<div id="create_intake_form" class="modal fade" role="dialog">
  <div class="modal-dialog  modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Create Intake Form</h4>
      </div>
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
                  echo form_textarea("intake_notes", $this->input->post("intake_notes"), array("class"=>"form-control", 'placeholder'=>'Intake Notes', 'style'=>"height:100px"));
                  echo form_error("intake_notes");
               ?>
            </div>
            <div class="form-group col-sm-12 files">

            </div>
         </div>
      </div>
      <div class="modal-footer">
         <label class="col-sm-12">&nbsp;</label>
         <button class="btn btn-primary save-intakeform">Save</button>
         <a href="javascript:void(0)" class="btn btn-primary multiupload">Upload Attached</a>
         <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<!-- end intake form model here -->

<div style="display:none">
   <div id="products">
      <?php echo $products; ?>
   </div>
</div>

<?php echo link_tag('assets/css/bootstrap-datepicker.css'); ?>
<script src="<?php echo base_url() ?>/assets/js/bootstrap-datetimepicker.js"></script>
<script>
function page_info_adjust() {
	if ($("select[name=reason]").val() == 'Outpatient') {
		$(".hospital_info").text("Doctor Info");
		$(".doctor_info").text("Home Doctor Info");
		$(".outpationdocinfo").show();
		$(".inpationdocinfo").hide();
	} else if ($("select[name=reason]").val() == 'Inpatient') {
		$(".outpationdocinfo").hide();
		$(".inpationdocinfo").show();
		$(".hospital_info").text("Hospital Info");
		$(".doctor_info").text("Attending Physician");
	} else {
		$(".outpationdocinfo").hide();
		$(".inpationdocinfo").show();
		$(".hospital_info").text("Doctor Info/Hospital Info");
		$(".doctor_info").text("Attending Physician");
	}
}

$(document).ready(function() {
      $(".datepicker").datepicker({
           startDate: '-117y',
           endDate: '+0y',
       });

      $("select[name=reason]").change(page_info_adjust);

      page_info_adjust();
   })

   // once user click over save intake form, we are just hold every value untill case is not submitted
   $(document).on("click", '.save-intakeform', function(){

      // check notes field filled or not
      if(!$("textarea[name=intake_notes]").val())
      {
         alert("Please add intake notes first.")
         return false;
      }

      // count no of intake forms
      var count = $(".intake-forms").length + 1;

      // place no of form in hidden field 
      $("input[name=no_of_form]").val(count);

      // get notes and files
      var notes = $("textarea[name=intake_notes]").val();
      var files = $(".modal-body .files").clone();

      // generate html data
      var html = '<div class="col-sm-12 intake-forms"><div class="col-sm-2"><div class="col-sm-12">'+count+'. #<?php echo $this->ion_auth->user()->row()->id; ?></div><div class="col-sm-12"><?php echo $this->ion_auth->user()->row()->first_name; ?></div><div class="col-sm-12"><?php echo date("Y-m-d H:i:s"); ?></div></div><div class="col-sm-10"><div class=col-sm-12"><input type="hidden" name="notes_'+count+'" value="'+notes+'" />' + notes + '</div><div id="intake-files-'+count+'" class="form-group col-sm-11"></div><div class="col-sm-1&quot;"><i class="fa fa-remove row-link remove-form pull-right"></i></div></div></div>';

      // place every value to intake display area
      $(".intake-forms-list").append(html);

      // set clone files to that area
      $("#intake-files-"+count).html(files);

      // close model popup
      $('#create_intake_form').modal('hide');

      // save intake heading
      $(".intake-heading").show()
   })

   // get  policy information here
   .on("change", "input[name=policy_no]", function(){
      $.ajax({
         url: "<?php echo base_url("emergency_assistance/get_policy_info"); ?>",
         method:"get",
         data:{policy:$(this).val()},
         dataType: "json",
         beforeSend: function(){
            $(".nav-m22d").addClass("csspinner load1");
         },
         success: function(data){
            if(typeof data.plan_list != "undefined" && data.plan_list.length)
            {
               localStorage.setItem("policy_data", JSON.stringify(data.plan_list));
               $("input[name=policy_info]").val(JSON.stringify(data.plan_list));
               
               $("input[name=insured_firstname]").val((data.plan_list[0].firstname));
               $("input[name=insured_lastname]").val((data.plan_list[0].lastname));
               $("textarea[name=insured_address]").val(data.plan_list[0].street_number+" "+data.plan_list[0].street_name);
               $("input[name=dob]").val((data.plan_list[0].birthday));  
            }
            else{
               alert("Sorry, policy information does not exists, please check policy no and try again");               
               $("input[name=policy_no]").val("");
            }
            $(".nav-m22d").removeClass("csspinner load1");
         }
      })
   })

   // custom script for multi file upload
   $(document).on("click",".multiupload", function(){
      var count = $("input[type=file]").length;

      // count no of intake forms
      var no_of_form = $(".intake-forms").length + 1;

      // add new file here
      $(".modal-body .files").append('<div class="col-sm-9" style="display:none"><input style="display:none" type="file" name="files_'+no_of_form+'[]" id="file'+(count+1)+'" /><span class="file-label"></span> <i class="fa fa-trash row-link" id="'+(count+1)+'"></i></div>');

      // place trigger clicked once file append in files class
      $('#file'+(count+1)).trigger("click");
   })

   // delete files
   .on("click",".fa-trash", function(){
      $(this).parent("div").remove();
      $("#file"+$(this).attr("id")).remove();
   })


   // delete intake-form
   .on("click",".fa-remove", function(){
      $(this).parent("div").parent("div").parent("div.intake-forms").remove();
      var count = $(".intake-forms").length;
      if(!count) {
         // remove intake heading from here
         $(".intake-heading").hide();
      }
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

   // reset form fields
   .on("click", ".create_intake_form", function() {

      // reset intake forms field
      $("textarea[name=intake_notes]").val("");
      $(".modal-body .files").html("");
   })

   .on("click", '.search_provider', function(e){
      e.preventDefault();
      var href = $(this).attr("href")+"?street_no="+$("input[name=street_no]").val()+"&street_name="+$("input[name=street_name]").val()+"&city="+$("input[name=city]").val()+"&province="+$("select[name=province]").val()+"&country="+$("select[name=country2]").val()+"&post_code="+$("input[name=post_code]").val()+"";

      $(this).target = "_blank";
      window.open(href, "Search Providers", "width=1250,height=600"); 
   })

 <?php
   if($this->input->get('policy'))
   {
      ?>
      $.ajax({
         url: "<?php echo base_url("emergency_assistance/get_policy_info"); ?>",
         method:"get",
         data:{policy:"<?php echo $this->input->get('policy'); ?>"},
         dataType: "json",
         beforeSend: function(){
            $(".nav-m22d").addClass("csspinner load1");
         },
         success: function(data){
            if(typeof data.plan_list != "undefined" && data.plan_list.length)
            {
               localStorage.setItem("policy_data", JSON.stringify(data.plan_list));
               $("input[name=policy_info]").val(JSON.stringify(data.plan_list));

               $("input[name=insured_firstname]").val(<?php if ($this->input->get('firstname')) { echo "'".$this->input->get('firstname')."'"; } else { ?>(data.plan_list[0].firstname)<?php } ?>);
               $("input[name=insured_lastname]").val(<?php if ($this->input->get('lastname')) { echo "'".$this->input->get('lastname')."'"; } else { ?>(data.plan_list[0].lastname)<?php } ?>);
               $("textarea[name=insured_address]").val(data.plan_list[0].street_number+" "+data.plan_list[0].street_name);
               $("input[name=dob]").val(<?php if ($this->input->get('birthday')) { echo "'".$this->input->get('birthday')."'"; } else { ?>(data.plan_list[0].birthday)<?php } ?>);  

            }
            else{
               alert("Sorry, policy information does not exists, please check policy no and try again");
               $(this).val("");
            }
            $(".nav-m22d").removeClass("csspinner load1");
         }
      })
      <?php
   }
   ?>


</script>