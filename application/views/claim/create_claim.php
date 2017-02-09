<duv >
   <div class="page-title">
      <div class="title_left">
         <h3>New Claim</h3>
      </div>
   </div>
   <div class="clearfix"></div>
   <!-- Policy search and List Section -->
   <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
         <div class="x_panel">
            <div class="x_title">
               <h2>CLAIMANT INFORMATION<small></small></h2>
               <div class="clearfix"></div>
            </div>
            <div class="x_content">
               <?php echo form_open_multipart("", array('class'=>'form-horizontal', 'method'=>'post', 'onsubmit'=>'return validate()')); ?>
               <div class="row" style="margin-bottom:15px;">
                  <div class="form-group col-sm-3">
                     <?php 
                        echo form_label('Insured First Name:', 'insured_first_name', array("class"=>'col-sm-12'));                            
                        echo form_input("insured_first_name", $this->input->post("insured_first_name"), array("class"=>"form-control", 'placeholder'=>'Insured First Name'));
                        echo form_error("insured_first_name");
                     ?>
                  </div>
                  <div class="col-sm-3">
                     <?php 
                        echo form_label('Insured Last Name:', 'insured_last_name', array("class"=>'col-sm-12'));                            
                        echo form_input("insured_last_name", $this->input->post("insured_last_name"), array("class"=>"form-control", 'placeholder'=>'Insured Last Name'));
                     ?>
                  </div>
                  <div class="col-sm-3">
                     <div class="col-sm-4">
                        <?php 
                        echo form_label('&nbsp;', 'gender', array("class"=>'col-sm-12'));
                        echo form_radio("gender", "male", $this->input->post("gender"), array('class'=>'setpremium')); ?>  Male
                     </div>
                     <div class="col-sm-5">
                        <?php 
                        echo form_label('&nbsp;', 'gender', array("class"=>'col-sm-12'));
                        echo form_radio("gender", "female", $this->input->post("gender"), array('class'=>'setpremium')); ?>  Female
                     </div>
                  </div>
                  <div class="col-sm-3">
                     <?php 
                        echo form_label('ID', 'id', array("class"=>'col-sm-12'));
                        echo form_input("personal_id", $this->input->post("personal_id"), array("class"=>"form-control", 'placeholder'=>'ID'));
                        echo form_error("personal_id");
                     ?>
                  </div>
               </div>

               <div class="row">
                  <div class="form-group col-sm-3">
                     <?php echo form_label('Date of Birth:', 'dob', array("class"=>'col-sm-12'));   ?>
                     <div class="input-group date">
                        <?php                
                        echo form_input("dob", $this->input->post("dob"), array("class"=>"form-control datepicker", 'placeholder'=>'Date of Birth'));
                        ?>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                     </div>
                     <?php echo form_error("dob"); ?>
                  </div>
                  <div class="form-group col-sm-3">
                     <?php 
                        echo form_label('Policy#:', 'policy_no', array("class"=>'col-sm-12'));                            
                        echo form_input("policy_no", ($this->input->post("policy_no")?$this->input->post("policy_no"):$this->input->get("policy")), array("class"=>"form-control", 'placeholder'=>'Policy#'));
                        echo form_error("policy_no");
                        echo form_hidden("policy_info");
                     ?>
                  </div>
                  <div class="form-group col-sm-3">
                     <?php 
                        echo form_label('Case No#:', 'case_no', array("class"=>'col-sm-12'));                            
                        echo form_input("case_no", ($this->input->post("case_no")?$this->input->post("case_no"):$this->input->get("case_no")), array("class"=>"form-control", 'placeholder'=>'Case No#'));
                        echo form_error("case_no");
                     ?>
                  </div>
                  <div class="form-group col-sm-3">
                     <?php 
                        echo form_label('School Name:', 'school_name', array("class"=>'col-sm-12'));                            
                        echo form_input("school_name", $this->input->post("school_name"), array("class"=>"form-control", 'placeholder'=>'School Name'));
                        echo form_error("school_name");
                     ?>
                  </div>
                  <div class="form-group col-sm-3">
                     <?php 
                        echo form_label('Group ID:', 'group_id', array("class"=>'col-sm-12'));                            
                        echo form_input("group_id", $this->input->post("group_id"), array("class"=>"form-control", 'placeholder'=>'Group ID'));
                        echo form_error("group_id");
                     ?>
                  </div>
               </div>
               <div class="row">
                  <div class="form-group col-sm-3">
                     <?php echo form_label('Enroll Date:', 'apply_date', array("class"=>'col-sm-12'));   ?>
                     <div class="input-group date">
                        <?php                
                        echo form_input("apply_date", $this->input->post("apply_date"), array("class"=>"form-control datepicker", 'placeholder'=>'Enroll Date'));
                        ?>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                     </div>
                  </div>
                  <div class="form-group col-sm-3">
                     <?php echo form_label('Arrival Date in Canada:', 'arrival_date', array("class"=>'col-sm-12'));   ?>
                     <div class="input-group date">
                        <?php                
                        echo form_input("arrival_date", $this->input->post("arrival_date"), array("class"=>"form-control datepicker", 'placeholder'=>'Arrival Date in Canada'));
                        ?>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                     </div>
                  </div>
                  <div class="form-group col-sm-3">
                     <?php 
                        echo form_label('Full Name of Guardian if applicable:', 'guardian_name', array("class"=>'col-sm-12'));
                        echo form_input("guardian_name", $this->input->post("guardian_name"), array("class"=>"form-control", 'placeholder'=>'Full Name of Guardian if applicable'));
                        ?>
                  </div>
                  <div class="form-group col-sm-3">
                     <?php 
                        echo form_label('Guardian Phone#:', 'guardian_phone', array("class"=>'col-sm-12'));
                        echo form_input("guardian_phone", $this->input->post("guardian_phone"), array("class"=>"form-control", 'placeholder'=>'Guardian Phone#'));
                        ?>
                  </div>
               </div>

               <h4>Address in Canada</h4>
               <div class="row">
                  <div class="col-sm-12">
                     <div class="input-group col-sm-3" style="margin-bottom:10px">
                        <?php  
                        echo form_checkbox("same_policy", "Y", $this->input->post("same_policy"), array('class'=>'setpremium', 'style'=>'margin-left:10px')); ?>  Same with policy
                     </div>
                  </div>
                  
                  <div class="form-group col-sm-3">
                     <?php 
                        echo form_label('Street Address:', 'street_address', array("class"=>'col-sm-12'));
                        echo form_input("street_address", $this->input->post("street_address"), array("class"=>"form-control", 'placeholder'=>'Street Address'));
                     ?>
                  </div>
                  <div class="form-group col-sm-3">
                     <?php 
                        echo form_label('City/Town:', 'city', array("class"=>'col-sm-12'));                           
                        echo form_input("city", $this->input->post("city"), array("class"=>"form-control", 'placeholder'=>'City/Town'));
                     ?>
                  </div>
                  <div class="form-group col-sm-3">
                     <?php 
                        echo form_label('Province:', 'province', array("class"=>'col-sm-12'));                           
                        echo form_input("province", $this->input->post("province"), array("class"=>"form-control", 'placeholder'=>'Province'));
                     ?>
                  </div>
                  <div class="form-group col-sm-3">
                     <?php 
                        echo form_label('Telephone:', 'telephone', array("class"=>'col-sm-12'));
                        echo form_input("telephone", $this->input->post("telephone"), array("class"=>"form-control", 'placeholder'=>'Telephone'));
                     ?>
                  </div>
                  <div class="form-group col-sm-3">
                     <?php 
                        echo form_label('Email:', 'email', array("class"=>'col-sm-12'));
                        echo form_input("email", $this->input->post("email"), array("class"=>"form-control", 'placeholder'=>'Email'));
                     ?>
                  </div>
                  <div class="form-group col-sm-3">
                     <?php 
                        echo form_label('PostCode:', 'post_code', array("class"=>'col-sm-12'));
                        echo form_input("post_code", $this->input->post("post_code"), array("class"=>"form-control", 'placeholder'=>'PostCode'));
                     ?>
                  </div>

                  <div class="form-group col-sm-3">
                     <?php echo form_label('Date of Arrival in Canada:', 'arrival_date_canada', array("class"=>'col-sm-12'));   ?>
                     <div class="input-group date">
                        <?php                
                        echo form_input("arrival_date_canada", $this->input->post("arrival_date_canada"), array("class"=>"form-control datepicker", 'placeholder'=>'Date of Arrival in Canada'));
                        ?>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                     </div>
                  </div>

                  <div class="form-group col-sm-3">
                     <?php 
                        echo form_label('Cellular:', 'cellular', array("class"=>'col-sm-12'));
                        echo form_input("cellular", $this->input->post("cellular"), array("class"=>"form-control", 'placeholder'=>'Cellular'));
                     ?>
                  </div>
               </div>              
               <h4>Name and Address of Family Physician in Country of Origin</h4>
               <div class="row">
                  <div class="col-sm-12">
                     <div class="form-group col-sm-3">
                        <?php 
                           echo form_label('Name:', 'physician_name', array("class"=>'col-sm-12'));                           
                           echo form_input("physician_name", $this->input->post("physician_name"), array("class"=>"form-control", 'placeholder'=>'Name'));
                        ?>
                     </div>
                     <div class="form-group col-sm-3">
                        <?php 
                           echo form_label('Clinic Name or Address:', 'clinic_name', array("class"=>'col-sm-12'));                           
                           echo form_input("clinic_name", $this->input->post("clinic_name"), array("class"=>"form-control", 'placeholder'=>'Clinic Name or Address'));
                        ?>
                     </div>
                     <div class="form-group col-sm-3">
                         <?php 
                           echo form_label('Street Address:', 'physician_street_address', array("class"=>'col-sm-12'));                           
                           echo form_input("physician_street_address", $this->input->post("physician_street_address"), array("class"=>"form-control", 'placeholder'=>'Street Address'));
                        ?>
                     </div>
                     <div class="form-group col-sm-3">
                        <?php 
                           echo form_label('City/Town:', 'physician_city', array("class"=>'col-sm-12'));                           
                           echo form_input("physician_city", $this->input->post("physician_city"), array("class"=>"form-control", 'placeholder'=>'City/Town'));
                        ?>
                     </div>                           
                     <div class="form-group col-sm-3">
                        <?php 
                           echo form_label('Country:', 'country', array("class"=>'col-sm-12'));       
                           echo $country;
                        ?>
                     </div>
                     <div class="form-group col-sm-3">
                        <?php 
                           echo form_label('Post Code:', 'physician_post_code', array("class"=>'col-sm-12'));                           
                           echo form_input("physician_post_code", $this->input->post("physician_post_code"), array("class"=>"form-control", 'placeholder'=>'Post Code'));
                        ?>
                     </div>
                     <div class="form-group col-sm-3">
                        <?php 
                           echo form_label('Telephone:', 'physician_telephone', array("class"=>'col-sm-12'));                           
                           echo form_input("physician_telephone", $this->input->post("physician_telephone"), array("class"=>"form-control", 'placeholder'=>'Telephone'));
                        ?>
                     </div>
                     <div class="form-group col-sm-3">
                        <?php 
                           echo form_label('Alt Telephone:', 'physician_alt_telephone', array("class"=>'col-sm-12'));                           
                           echo form_input("physician_alt_telephone", $this->input->post("physician_alt_telephone"), array("class"=>"form-control", 'placeholder'=>'Alt Telephone'));
                        ?>
                     </div>
                  </div>
               </div>

               <h4>Name and Address of Family Physician in Canada</h4>
               <div class="row">
                  <div class="col-sm-12">
                     <div class="form-group col-sm-3">
                        <?php 
                           echo form_label('Name:', 'physician_name_canada', array("class"=>'col-sm-12'));                           
                           echo form_input("physician_name_canada", $this->input->post("physician_name_canada"), array("class"=>"form-control", 'placeholder'=>'Name'));
                        ?>
                     </div>
                     <div class="form-group col-sm-3">
                        <?php 
                           echo form_label('Clinic Name or Address:', 'clinic_name_canada', array("class"=>'col-sm-12'));                           
                           echo form_input("clinic_name_canada", $this->input->post("clinic_name_canada"), array("class"=>"form-control", 'placeholder'=>'Clinic Name or Address'));
                        ?>
                     </div>
                     <div class="form-group col-sm-3">
                         <?php 
                           echo form_label('Street Address:', 'physician_street_address_canada', array("class"=>'col-sm-12'));                           
                           echo form_input("physician_street_address_canada", $this->input->post("physician_street_address_canada"), array("class"=>"form-control", 'placeholder'=>'Street Address'));
                        ?>
                     </div>
                     <div class="form-group col-sm-3">
                        <?php 
                           echo form_label('City/Town:', 'physician_city_canada', array("class"=>'col-sm-12'));                           
                           echo form_input("physician_city_canada", $this->input->post("physician_city_canada"), array("class"=>"form-control", 'placeholder'=>'City/Town'));
                        ?>
                     </div>
                     <div class="form-group col-sm-3">
                        <?php 
                           echo form_label('Post Code:', 'physician_post_code_canada', array("class"=>'col-sm-12'));                           
                           echo form_input("physician_post_code_canada", $this->input->post("physician_post_code_canada"), array("class"=>"form-control", 'placeholder'=>'Post Code'));
                        ?>
                     </div>
                     <div class="form-group col-sm-3">
                        <?php 
                           echo form_label('Telephone:', 'physician_telephone_canada', array("class"=>'col-sm-12'));                           
                           echo form_input("physician_telephone_canada", $this->input->post("physician_telephone_canada"), array("class"=>"form-control", 'placeholder'=>'Telephone'));
                        ?>
                     </div>
                     <div class="form-group col-sm-3">
                        <?php 
                           echo form_label('Alt Telephone:', 'physician_alt_telephone_canada', array("class"=>'col-sm-12'));                           
                           echo form_input("physician_alt_telephone_canada", $this->input->post("physician_alt_telephone_canada"), array("class"=>"form-control", 'placeholder'=>'Alt Telephone'));
                        ?>
                     </div>
                  </div>
               </div>

               <h2>OTHER INSURANCE COVERAGE<small></small></h2>
               <div class="row">

                  <div class="col-sm-12">
                     <div class="row">
                        <div class="col-sm-12">
                           <div class="col-sm-7">
                              Do you, your spouse or your parents/guardians have any other medical or travel insurance coverage?
                           </div>
                           <div class="col-sm-1">
                              <?php 
                              echo form_radio("travel_insurance_coverage_guardians", "Y", $this->input->post("travel_insurance_coverage_guardians"), array('class'=>'setpremium')); ?>  Yes
                           </div>
                           <div class="col-sm-1">
                              <?php 
                              echo form_radio("travel_insurance_coverage_guardians", "N", $this->input->post("travel_insurance_coverage_guardians"), array('class'=>'setpremium')); ?>  No
                           </div>

                           <div class="col-sm-12">
                              If yes, provide details of other insurance company coverage below. If no, confirm by checking the box below. 
                           </div>
                        </div>
                        <div class="col-sm-3">
                           <?php 
                              echo form_label('Full Name:', 'full_name', array("class"=>'col-sm-12'));
                              echo form_input("full_name", $this->input->post("full_name"), array("class"=>"form-control", 'placeholder'=>'Full Name'));
                           ?>
                        </div>
                        <div class="col-sm-3">
                           <?php 
                              echo form_label('Employee Name:', 'employee_name', array("class"=>'col-sm-12'));
                              echo form_input("employee_name", $this->input->post("employee_name"), array("class"=>"form-control", 'placeholder'=>'Employee Name'));
                           ?>
                        </div>
                        <div class="col-sm-3">
                           <?php 
                              echo form_label('Full Name:', 'full_name', array("class"=>'col-sm-12'));
                              echo form_input("full_name", $this->input->post("full_name"), array("class"=>"form-control", 'placeholder'=>'Full Name'));
                           ?>
                        </div>
                        <div class="col-sm-3">
                           <?php 
                              echo form_label('Street Address:', 'employee_street_address', array("class"=>'col-sm-12'));
                              echo form_input("employee_street_address", $this->input->post("employee_street_address"), array("class"=>"form-control", 'placeholder'=>'Street Address'));
                           ?>
                        </div>
                        <div class="col-sm-3">
                           <?php 
                              echo form_label('City/Town:', 'city_town', array("class"=>'col-sm-12'));
                              echo form_input("city_town", $this->input->post("city_town"), array("class"=>"form-control", 'placeholder'=>'City/Town'));
                           ?>
                        </div>
                        <div class="form-group col-sm-3">
                           <?php 
                              echo form_label('Country:', 'country2', array("class"=>'col-sm-12'));       
                              echo $country2;
                           ?>
                        </div>
                        <div class="col-sm-3">
                           <?php 
                              echo form_label('Telephone:', 'employee_telephone', array("class"=>'col-sm-12'));
                              echo form_input("employee_telephone", $this->input->post("employee_telephone"), array("class"=>"form-control", 'placeholder'=>'Telephone'));
                           ?>
                        </div>
                     </div>
                  </div>
               </div>

               <h2>MEDICAL INFORMATION<small></small></h2>
               <div class="row">
                  <div class="col-sm-12">
                     <div class="row">
                        <div class="form-group col-sm-12">
                           <?php 
                              echo form_label('Brief description of your sickness or injury:', 'medical_description', array("class"=>'col-sm-12'));                           
                              echo form_textarea("medical_description", $this->input->post("medical_description"), array("class"=>"form-control", 'placeholder'=>'Brief description of your sickness or injury'));
                           ?>
                        </div>  

                        <div class="col-sm-6">
                           <?php 
                              echo form_label('Date symptoms or injury first appeared:', 'date_symptoms', array("class"=>'col-sm-12'));                           
                              echo form_input("date_symptoms", $this->input->post("date_symptoms"), array("class"=>"form-control datepicker", 'placeholder'=>'Date symptoms or injury first appeared'));
                           ?>
                        </div>  

                        <div class="col-sm-6">
                           <?php 
                              echo form_label('Date you first saw physician for this condition:', 'date_first_physician', array("class"=>'col-sm-12'));                           
                              echo form_input("date_first_physician", $this->input->post("date_first_physician"), array("class"=>"form-control datepicker", 'placeholder'=>'Date you first saw physician for this condition'));
                           ?>
                        </div>
                        <div class="col-sm-12" style="margin-top:20px">
                           <div class="col-sm-7">
                              Do you, your spouse or your parents/guardians have any other medical or travel insurance coverage?
                           </div>
                           <div class="col-sm-1">
                              <?php 
                              echo form_radio("travel_insurance_coverage", "Y", $this->input->post("travel_insurance_coverage"), array('class'=>'setpremium')); ?>  Yes
                           </div>
                           <div class="col-sm-1">
                              <?php 
                              echo form_radio("travel_insurance_coverage", "N", $this->input->post("travel_insurance_coverage"), array('class'=>'setpremium')); ?>  No
                           </div>

                           <div class="col-sm-12" style="margin-bottom:10px">
                              If yes, provide details of other insurance company coverage below. If no, confirm by checking the box below. 
                           </div>


                           <div class="form-group col-sm-12">
                              <div class="col-sm-3">
                                 <?php echo form_label('Date (MM/DD/YYYY):', 'medication_date_1', array("class"=>'col-sm-12'));   ?>
                                 <div class="input-group date">
                                    <?php                
                                    echo form_input("medication_date_1", $this->input->post("medication_date_1"), array("class"=>"form-control datepicker", 'placeholder'=>'Date (MM/DD/YYYY)'));
                                    ?>
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                 </div>
                              </div>

                              <div class="col-sm-3">
                                 <?php 
                                    echo form_label('Medication:', 'medication_1', array("class"=>'col-sm-12'));                           
                                    echo form_input("medication_1", $this->input->post("medication_1"), array("class"=>"form-control", 'placeholder'=>'Medication'));
                                 ?>
                              </div> 
                           </div>
                           <div class="form-group col-sm-12">
                              <div class="col-sm-3">
                                 <?php echo form_label('Date (MM/DD/YYYY):', 'medication_date_2', array("class"=>'col-sm-12'));   ?>
                                 <div class="input-group date">
                                    <?php                
                                    echo form_input("medication_date_2", $this->input->post("medication_date_2"), array("class"=>"form-control datepicker", 'placeholder'=>'Date (MM/DD/YYYY)'));
                                    ?>
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                 </div>
                              </div>

                              <div class="col-sm-3">
                                 <?php 
                                    echo form_label('Medication:', 'medication_2', array("class"=>'col-sm-12'));                           
                                    echo form_input("medication_2", $this->input->post("medication_2"), array("class"=>"form-control", 'placeholder'=>'Medication'));
                                 ?>
                              </div> 
                           </div>
                           <div class="form-group col-sm-12">
                              <div class="col-sm-3">
                                 <?php echo form_label('Date (MM/DD/YYYY):', 'medication_date_3', array("class"=>'col-sm-12'));   ?>
                                 <div class="input-group date">
                                    <?php                
                                    echo form_input("medication_date_3", $this->input->post("medication_date_3"), array("class"=>"form-control datepicker", 'placeholder'=>'Date (MM/DD/YYYY)'));
                                    ?>
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                 </div>
                              </div>
                              <div class="col-sm-3">
                                 <?php 
                                    echo form_label('Medication:', 'medication_3', array("class"=>'col-sm-12'));                           
                                    echo form_input("medication_3", $this->input->post("medication_3"), array("class"=>"form-control", 'placeholder'=>'Medication'));
                                 ?>
                              </div> 
                           </div>
                        </div>

                     </div>
                  </div>
               </div>

               <h2>EXPENSES CLAIMED<small></small> 
                   <button class="btn btn-primary add_new_expenses" type="button">Add new expenses item </button>
               </h2>
               <div class="row">
                  <div class="col-sm-12">
                     <div class="expenses-list">
                                                                               
                     </div>
                  </div>
               </div>

               <!-- Intake Forms List Section -->
               <br/>
               <h2 class="modal-title intake-heading">INTAKE FORMS </h2>
               <div class="row intake-forms-list col-sm-12">

               </div>
               <input type="hidden" name="no_of_form" value="0"/> <!-- used to knnow how many forms added in this page -->
               <!-- end intake forms list  -->

               <h2>PAYEE INFORMATION<small></small></h2>
               <div class="row">
                  <div class="col-sm-12">
                     <div class="col-sm-3">
                        <?php 
                        echo form_radio("payment_type", "cheque", $this->input->post("payment_type"), array('class'=>'setpremium')); ?>  Cheque
                     </div>
                     <div class="col-sm-3">
                        <?php 
                        echo form_radio("payment_type", "direct deposit", $this->input->post("payment_type"), array('class'=>'setpremium')); ?>  Direct Deposit
                     </div>

                     <div class="col-sm-3">
                        <button class="btn btn-primary add_payee" name="filter" type="button" value="claim">Add a Payees</button>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-sm-12">
                     <table class="table table-hover table-bordered">
                        <thead>
                           <tr>
                              <th class="wire_transfer_section">Bank Name</th>
                              <th class="cheque_section wire_transfer_section">Payee Name</th>
                              <th class="wire_transfer_section">Account#</th>
                              <th class="cheque_section">Address</th>
                              <th>&nbsp;</th>                    
                           </tr>
                        </thead>
                        <tbody class="payee-data">                                                     
                        </tbody>
                     </table>
                  </div>
               </div>

               <br/>
               <h2>ATTACHED LIST<small></small> <button class="btn btn-primary multiupload_files"  type="button">Upload Attached</button></h2>  
               <div class="row">
                  <div class="col-sm-12">
                     <div class="col-sm-3 uploaded_files">
                     </div>

                     <div class="col-sm-3">
                     </div>
                  </div>
               </div>
               <br/>
               <div class="row">
                  <div class="col-sm-3">
                     <?php 
                        echo form_label('Status:', 'status', array("class"=>'col-sm-12'));                  
                        $status = array(
                           ""=>'--Status--',
                           'accepted'=>'Accepted',
                           'processing'=>'Processing',
                           'pending'=>'Pending',
                           'denied'=>'Denied',
                           'paid'=>'Paid',
                           'recovered'=>'Recovered',
                           'close'=>'Close',
                           'appeal'=>'Appeal'
                           );
                        echo form_dropdown("status", $status, $this->input->get("status"), array("class"=>'form-control'));
                     ?>
                  </div>
               </div>

               <div class="row" style="margin-top:20px">
                  <div class="col-sm-2">
                     <input class="btn btn-primary" name="Save" value="Save" type="submit">   
                  </div>
                  <div class="col-sm-2">
                     <?php echo anchor("claim", "Cancel", array("class"=>'btn btn-primary')); ?>
                  </div>
                  <div class="col-sm-2"> 
                     <input class="btn btn-primary" name="Examine" value="Examine" type="submit">  
                  </div>
                  <div class="col-sm-2"> 
                     <input class="btn btn-primary email_print" data-toggle="modal"  name="Email" value="Email/Print" type="button" data-target="#print_template">      
                  </div>
               </div>

               <?php echo form_close(); ?>

            </div>
         </div>
      </div>
   </div>
</duv>

<style>
   .autocomplete-suggestions{
      width: 603px !important;
   }
</style>
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
         echo form_open_multipart("case/send_print_email", array("id"=>'send_print_email'));
       ?>
      <div class="modal-body">
          <div class="row">
            <div class="col-sm-6">
               <div>
                  <label for="mail_label" class="col-sm-2">Mail Address:</label>    
                  <div class="form-group col-sm-6">
                     <input name="same_address" value="1" id="mail_address" class="col-sm-1" type="checkbox">
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
   <div class="base-row">
      <div class="row" style="border: 1px solid rgb(204, 204, 204); padding: 10px;">
         <div class="col-sm-3">
            <?php  
               echo form_label('Invoice#:', 'invoice', array("class"=>'col-sm-12'));
               echo form_input("expenses_climed[invoice][]", $this->input->post("invoice"), array("class"=>"form-control"));
            ?>
         </div>  
         <div class="col-sm-3">
            <?php 
               echo form_label('Name of Provider:', 'provider_name', array("class"=>'col-sm-12'));
               echo form_input("expenses_climed[provider_name][]", $this->input->post("provider_name"), array("class"=>"form-control"));
            ?>
         </div>  
         <div class="col-sm-3">
            <?php 
               echo form_label('Name of Referring Physician:', 'referencing_physician', array("class"=>'col-sm-12'));
               echo form_input("expenses_climed[referencing_physician][]", $this->input->post("referencing_physician"), array("class"=>"form-control"));
            ?>
         </div>  
         <div class="col-sm-3">
            <?php 
               echo form_label('Coverage Code:', 'coverage_code', array("class"=>'col-sm-12'));
                  $coverage_code = array(
                     ""=>'Coverage code',
                     'V01 - Hospitalization'=>'Hospitalization',
                     'V02A - Medical Services'=>'Medical Services',
                     'V02A - Doctor Visit'=>'Doctor Visit',
                     'V02A - Emergency Visit'=>'Emergency Visit',
                     'V02A - Specialist Visit'=>'Specialist Visit',
                     'V02A - Others'=>'Others',
                     'V02B - Diagnoistic Services'=>'Diagnoistic Services',
                     'V02B - X-Ray'=>'X-Ray',
                     'V02B - Ultrasound'=>'Ultrasound',
                     'V02B - Urine Test'=>'Urine Test',
                     'V02B - Blood Test'=>'Blood Test',
                     'V02B - CT Scans'=>' CT Scans',
                     'V02B - MRI'=>'MRI',
                     'V02B - Others'=>'Others',
                     'V13 - Private Duty Nursing'=>'Private Duty Nursing',
                     'V01A - Out-Patient Treatment'=>'Out-Patient Treatment',
                     'V07 - Prescription Drugs'=>'Prescription Drugs',
                     'V01B - Medical Appliances'=>'Medical Appliances',
                     'V04A - Ambulance'=>'Ambulance',
                     'V02A - Paramedical Services'=>'Paramedical Services',
                     'V02D - Acupuncture'=>'Acupuncture',
                     'V02E - Osteopath'=>'Osteopath',
                     'V02F - Physiotherapy'=>'Physiotherapy',
                     'V02G - Chiropractor'=>'Chiropractor',
                     'V02H - Chiropodist'=>'Chiropodist',
                     'V02J - Podiatrist'=>'Podiatrist',
                     'V06 - Accidental Dental'=>'Accidental Dental',
                     'V06B - Relief of Dental Pain'=>'Relief of Dental Pain',
                     'V08A - Return of Remains'=>'Return of Remains',
                     'V08B - Cremation/Burial'=>'Cremation/Burial',
                     'V12 - Air Flight Accident'=>'Air Flight Accident'
                  );
               echo form_dropdown("expenses_climed[coverage_code][]", $coverage_code, $this->input->get("coverage_code"), array("class"=>'form-control'));
            ?>
         </div>  
         <div class="col-sm-3">
            <?php 
               echo form_label('Diagnosis:', 'diagnosis', array("class"=>'col-sm-12'));
               echo form_input("expenses_climed[diagnosis][]", $this->input->post("diagnosis"), array("class"=>"form-control autocomplete_field"));
            ?>
         </div>  
         <div class="col-sm-3">
            <?php 
               echo form_label('Description of Services:', 'service_description', array("class"=>'col-sm-12'));
               echo form_input("expenses_climed[service_description][]", $this->input->post("service_description"), array("class"=>"form-control"));
            ?>
         </div>  
         <div class="col-sm-3">
            <?php 
               echo form_label('Date of Service:', 'date_of_service', array("class"=>'col-sm-12'));
               echo form_input("expenses_climed[date_of_service][]", $this->input->post("date_of_service"), array("class"=>"form-control  datepicker"));
            ?>
         </div> 
         <div class="col-sm-3">
            <?php 
               echo form_label('Amount Billed:', 'amount_billed', array("class"=>'col-sm-12'));
               echo form_input("expenses_climed[amount_billed][]", $this->input->post("amount_billed"), array("class"=>"form-control"));
            ?>
         </div> 
         <div class="col-sm-3">
            <?php 
               echo form_label('Amount Client Paid:', 'amount_client_paid', array("class"=>'col-sm-12'));
               echo form_input("expenses_climed[amount_client_paid][]", $this->input->post("amount_client_paid"), array("class"=>"form-control"));
            ?>
         </div> 
         <div class="col-sm-3">
            <?php 
               echo form_label('Payee:', 'payee', array("class"=>'col-sm-12'));
               echo $payees;
            ?>
         </div> 
         <div class="col-sm-3">
            <?php 
               echo form_label('Comment:', 'comment', array("class"=>'col-sm-12'));
               echo form_input("expenses_climed[comment][]", $this->input->post("comment"), array("class"=>"form-control"));
            ?>
         </div> 
         <div class="col-sm-3">
            <i class="fa fa-trash row-link remove_claim" style="padding-top: 33px;"></i>
         </div>
      </div>
   </div>
</div>

<table style="display:none">
   <tbody class="payee-buffer">
      <tr>
         <td class="wire_transfer_section">
            <?php 
               echo form_input("payees[bank][]", $this->input->post("bank"), array("class"=>"form-control", 'placeholder'=>'Bank Name'));
            ?>
         </td>
         <td class="cheque_section wire_transfer_section">
            <?php 
               echo form_input("payees[payee_name][]", $this->input->post("payee_name"), array("class"=>"form-control", 'placeholder'=>'Payee Name'));
            ?>
         </td>
         <td class="wire_transfer_section">
            <?php 
               echo form_input("payees[account_cheque][]", $this->input->post("account_cheque"), array("class"=>"form-control", 'placeholder'=>'Account#'));
            ?>
         </td> 
         <td class="cheque_section">
            <?php 
               echo form_input("payees[address][]", $this->input->post("address"), array("class"=>"form-control", 'placeholder'=>'Address#'));
            ?>
         </td>         
         <td>
            <i class="fa fa-trash row-link remove-payee"></i>
         </td>
      </tr>                                                       
   </tbody>
</table>

<script src="<?php echo base_url() ?>/assets/js/jQuery.print.js"></script>
<script src="<?php echo base_url() ?>/assets/js/jquery.validate.min.js"></script>
<?php echo link_tag('assets/css/bootstrap-datepicker.css'); ?>
<script src="<?php echo base_url() ?>/assets/js/bootstrap-datetimepicker.js"></script>
<script>
   $(document).ready(function() {
      $(".datepicker").datepicker({
           startDate: '-5y',
           endDate: '+2y',
       });

      // load atleast one claim item form for first use
      var html = $(".base-row").html();
      $(".expenses-list").append(html);
      $(".autocomplete_field").autocomplete({
        serviceUrl: "<?php echo base_url()."claim/search_diagnosis/description"; ?>" ,
        minLength: 2,
        dataType: "json",
      });
      $(".datepicker").datepicker({
           startDate: '-5y',
           endDate: '+2y',
       });
   })
   
   .on("click",".more_filters", function(){
      $(".more_items").toggle();
   })

   // fuzzy search
   .on("click", ".autocomplete_field", function() {
      $(".autocomplete_field").autocomplete({
        serviceUrl: "<?php echo base_url()."claim/search_diagnosis/description"; ?>" ,
        minLength: 2,
        dataType: "json",
      });
    }) 
   
   .on("click", ".add_new_expenses", function(){
      var html = $(".base-row").html();
      $(".expenses-list").append(html);
      $(".autocomplete_field").autocomplete({
        serviceUrl: "<?php echo base_url()."claim/search_diagnosis/description"; ?>" ,
        minLength: 2,
        dataType: "json",
      });
      $(".datepicker").datepicker({
           startDate: '-5y',
           endDate: '+2y',
       });
   })
   .on("click", ".remove_claim", function(){
      $(this).parent("div").parent("div").remove();
   })
   
   .on("click", ".add_payee", function(){
      var html = $(".payee-buffer").html();
      $(".payee-data").append(html);
   })
   .on("click", ".remove-payee", function(){
      $(this).parent("td").parent("tr").remove();
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

      // get policy info      
      var data = $.parseJSON(localStorage.getItem("policy_data"));

      // replace string from casemanager name etc
      var str = $(".doc-"+id+"  .doc-desc").html();
      str = str.replace(/{insured_name}/gi, $("input[name=insured_first_name]").val()+' '+$("input[name=insured_last_name]").val())
      .replace("{insured_address}", $("input[name=street_address]").val()+' '+$("input[name=city]").val()+' '+$("input[name=province]").val())
      .replace("{insured_lastname}", $("input[name=insured_last_name]").val())
      .replace("{policy_no}", $("input[name=policy_no]").val())
      .replace("{case_no}", $("input[name=case_no]").val())
      .replace("{policy_coverage_info}", "{policy_coverage_info}")
      .replace("{casemanager_name}", '<?php echo $this->ion_auth->user()->row()->first_name ?>')
      .replace("{current_date_+_90}", '<?php echo date('Y-m-d', strtotime(' + 90 days')) ?>')

      .replace("{clinic_name}", $("input[name=clinic_name]").val())
      .replace("{insured_dob}", $("input[name=dob]").val())
      .replace("{policy_no}", $("input[name=policy_no]").val())
      .replace("{policy_no}", $("input[name=policy_no]").val())
      .replace("{policy_no}", $("input[name=policy_no]").val())
      .replace("{policy_no}", $("input[name=policy_no]").val()); 

      $(".doc-"+id+" .doc-desc").html(str);

      // reset all edit/preview section
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
            url: "<?php echo base_url("claim/send_print_email") ?>",
            method: "post",
            dataType:"json",
            data:{
               email:$("#send_print_email input[name=email]").val(), 
               street_no:$("#send_print_email input[name=street_no_email]").val(), 
               street_name:$("#send_print_email input[name=street_name_email]").val(), 
               city:$("#send_print_email input[name=city_email]").val(), 
               province:$("#send_print_email select[name=province_email]").val(), 
               template:template,
               doc: $("#send_print_email .select-doc.active").text()
            },
            beforeSend: function(){
               $(".modal-content").addClass("csspinner load1");
            },
            success: function(data) {
               // create new intake form - - count no of intake forms
               var count = $(".intake-forms").length + 1;

               // place no of form in hidden field 
               $("input[name=no_of_form]").val(count);

               // get notes and files
               var notes = data.data_intake;
               var files = '<div class="col-sm-9" style=""><input type="hidden" name="file_pdf_'+count+'" value="'+data.file_name+'" /><span class="file-label">'+data.file_name+'</span> <i class="fa fa-trash row-link" id="'+count+'"></i></div>';

               // generate html data
               var html = '<div class="col-sm-12 intake-forms"><div class="col-sm-2"><div class="col-sm-12">'+count+'. #<?php echo $this->ion_auth->user()->row()->id; ?></div><div class="col-sm-12"><?php echo $this->ion_auth->user()->row()->first_name; ?></div><div class="col-sm-12"><?php echo date("Y-m-d H:i:s"); ?></div></div><div class="col-sm-10"><div class=col-sm-12"><input type="hidden" name="notes_'+count+'" value="'+notes+'" />' + notes + '</div><div id="intake-files-'+count+'" class="form-group col-sm-11">'+files+'</div><div class="col-sm-1&quot;"><i class="fa fa-remove row-link remove-form pull-right"></i></div></div></div>';

               // place every value to intake display area
               $(".intake-forms-list").append(html);

               // close model popup
               $('#print_template').modal('hide');

               $(".modal-content").removeClass("csspinner load1");

            }
         })
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

   // custom script for multi file upload
   .on("click",".multiupload", function(){
      var count = $("input[type=file]").length;

      // count no of intake forms
      var no_of_form = $(".intake-forms").length + 1;

      // add new file here
      $(".modal-body .files").append('<div class="col-sm-9" style="display:none"><input style="display:none" type="file" name="files_'+no_of_form+'[]" id="file'+(count+1)+'" accept="pdf" /><span class="file-label"></span> <i class="fa fa-trash row-link" id="'+(count+1)+'"></i></div>');

      // place trigger clicked once file append in files class
      $('#file'+(count+1)).trigger("click");
   })

   // custom script for multi file upload
   .on("click",".multiupload_files", function(){
      var count = $("input[type=file]").length;

      // count no of intake forms
      var no_of_form = $(".uploaded_files .col-sm-9").length + 1;

      // add new file here
      $(".uploaded_files").append('<div class="col-sm-9"  style="display:none" ><input style="display:none" type="file" name="files_multi[]" id="file'+(count+1)+'" accept="pdf" /><span class="file-label"></span> <i class="fa fa-trash row-link" id="'+(count+1)+'"></i></div>');

      // place trigger clicked once file append in files class
      $('#file'+(count+1)).trigger("click");
   })

   // delete files
   .on("click",".fa-trash", function(){
      $(this).parent("div").remove();
      $("#file"+$(this).attr("id")).remove();
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

   // once user click over save intake form, we are just hold every value untill claim is not submitted
   .on("click", '.save-intakeform', function(){

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
      var html = '<div class="col-sm-12 intake-forms"><div class=col-sm-12"><input type="hidden" name="notes_'+count+'" value="'+notes+'" />' + notes + '</div><div id="intake-files-'+count+'"></div> <div class=col-sm-3"><i class="fa fa-remove row-link remove-form pull-right"></i></div> <div class="col-sm-12">By: <?php echo $this->ion_auth->user()->row()->first_name; ?> on <i><?php echo date("Y-m-d"); ?></i></div></div>';

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
            }
            else{
               alert("Sorry, policy information does not exists, please check policy no and try again");
               $(this).val("");
            }
            $(".nav-m22d").removeClass("csspinner load1");
         }
      })
   })

   // once user clicked on same with policy button
   .on("click", "input[name=same_policy]", function(){

      // get local data
      var data = $.parseJSON(localStorage.getItem("policy_data"));
      if($(this).is(":checked"))
      {
         // fill all json values to address fields
         $("input[name=street_address]").val(data[0].street_number+" "+data[0].street_name);
         $("input[name=city]").val(data[0].city);
         $("input[name=province]").val(data[0].province2);
         $("input[name=telephone]").val(data[0].phone1);
         $("input[name=email]").val(data[0].contact_email);
         $("input[name=post_code]").val(data[0].postcode);
         $("input[name=arrival_date_canada]").val(data[0].arrival_date);
         // $("input[name=cellular]").val(data.plan_list.street_number);
      }
      else
      {
         $("input[name=street_address],input[name=city],input[name=province],input[name=telephone],input[name=email],input[name=post_code],input[name=arrival_date_canada],input[name=cellular]").val("");
      }
   })

   // once user clicked on same with policy button
   .on("click", "#mail_address", function(){

      // get local data
      var data = $.parseJSON(localStorage.getItem("policy_data"));
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


   // when currency changed in payees section
   .on("change", 'select[name="payees[payee_currency][]"]', function(){
      if($(this).val() == 'CAD'){
         // add currency rate option
         $(this).parent("td").next("td").children("input").attr("readonly", "readonly").val("");
      } else {
         // remove currency rate option
         $(this).parent("td").next("td").children("input").removeAttr("readonly");

      }
   })

   // once user select pay type
   .on("click", "input[name=payment_type]", function(){
      if($(this).val() == 'cheque'){
         $(".wire_transfer_section").hide();
         $(".cheque_section").show();
      } else {
         $(".cheque_section").hide();
         $(".wire_transfer_section").show();
      }
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

// to validate expenses items
function validate(){
   // check length of expenses items if not deleted
   var length = $(".expenses-list .row").length;
   if(!length){
      alert("Please create alteast one expenses claimed item.");
      $(".add_new_expenses").focus();
      return false;
   }
   return true;
}

</script>