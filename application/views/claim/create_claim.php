

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
               <?php echo form_open("", array('class'=>'form-horizontal', 'method'=>'post')); ?>
               <div class="row" style="margin-bottom:15px;">
                  <div class="form-group col-sm-3">
                     <?php 
                        echo form_label('Insured First Name:', 'insured_first_name', array("class"=>'col-sm-12'));                            
                        echo form_input("insured_first_name", $this->input->post("insured_first_name"), array("class"=>"form-control", 'placeholder'=>'Insured First Name'));
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
                        echo form_checkbox("gender", "Y", $this->input->post("gender"), array('class'=>'setpremium')); ?>  Male
                     </div>
                     <div class="col-sm-5">
                        <?php 
                        echo form_label('&nbsp;', 'gender', array("class"=>'col-sm-12'));
                        echo form_checkbox("gender", "Y", $this->input->post("gender"), array('class'=>'setpremium')); ?>  Female
                     </div>
                  </div>
                  <div class="col-sm-3">
                     <?php 
                        echo form_label('ID', 'id', array("class"=>'col-sm-12'));
                        echo form_input("personal_id", $this->input->post("personal_id"), array("class"=>"form-control", 'placeholder'=>'ID'));
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
                  </div>
                  <div class="col-sm-3">
                     <?php 
                        echo form_label('Policy#:', 'policy_no', array("class"=>'col-sm-12'));                            
                        echo form_input("policy_no", $this->input->post("policy_no"), array("class"=>"form-control", 'placeholder'=>'Policy#'));
                     ?>
                  </div>
                  <div class="col-sm-3">
                     <?php 
                        echo form_label('School Name:', 'school_name', array("class"=>'col-sm-12'));                            
                        echo form_input("school_name", $this->input->post("school_name"), array("class"=>"form-control", 'placeholder'=>'School Name'));
                     ?>
                  </div>
                  <div class="col-sm-3">
                     <?php 
                        echo form_label('Group ID:', 'group_id', array("class"=>'col-sm-12'));                            
                        echo form_input("group_id", $this->input->post("group_id"), array("class"=>"form-control", 'placeholder'=>'Group ID'));
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
                              echo form_checkbox("travel_insurance_coverage", "Y", $this->input->post("travel_insurance_coverage"), array('class'=>'setpremium')); ?>  Yes
                           </div>
                           <div class="col-sm-1">
                              <?php 
                              echo form_checkbox("travel_insurance_coverage", "N", $this->input->post("travel_insurance_coverage"), array('class'=>'setpremium')); ?>  No
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
                              echo form_checkbox("travel_insurance_coverage", "Y", $this->input->post("travel_insurance_coverage"), array('class'=>'setpremium')); ?>  Yes
                           </div>
                           <div class="col-sm-1">
                              <?php 
                              echo form_checkbox("travel_insurance_coverage", "N", $this->input->post("travel_insurance_coverage"), array('class'=>'setpremium')); ?>  No
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

               <!-- <h2>EXPENSES CLAIMED<small></small></h2>
               <div class="row">
                  <div class="col-sm-12">
                     <div class="table-responsive">
                        <table class="table table-hover table-bordered">
                           <thead>
                              <tr>
                                 <th>Invoice#</th>
                                 <th>Name of Provider</th>
                                 <th>Name of Referring Physician</th>
                                 <th>Coverage Code</th>
                                 <th>Diagnosis</th>
                                 <th>Description of Services</th>
                                 <th>Date of Service</th>
                                 <th>Amount Billed</th>
                                 <th>Amount Client Paid</th>
                                 <th>Currency</th>
                                 <th>Currency Rate</th>   
                                 <th>Payee</th>
                                 <th>Comment</th>                        
                              </tr>
                           </thead>
                           <tbody>
                              <tr>
                                 <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                              </tr>
                              <tr>
                                 <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                              </tr>
                              <tr>
                                 <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                              </tr>
                              <tr>
                                 <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                              </tr>
                              <tr>
                                 <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                              </tr>
                              
                           </tbody>
                        </table>
                     </div>
                  </div>
               </div> -->

               <!-- <h2>Intake Form List<small></small></h2>
               <div class="row">
                  <div class="col-sm-12">

                  </div>
               </div> -->
               <!-- 
               <h2>PAYEE INFORMATION<small></small></h2>
               <div class="row">
                  <div class="col-sm-12">
                     <div class="col-sm-3">
                        <?php 
                        echo form_checkbox("payment_type", "cheque", $this->input->post("payment_type"), array('class'=>'setpremium')); ?>  Cheque
                     </div>
                     <div class="col-sm-3">
                        <?php 
                        echo form_checkbox("payment_type", "wire transfer", $this->input->post("payment_type"), array('class'=>'setpremium')); ?>  Wire Transfer
                     </div>

                     <div class="col-sm-3">
                        <button class="btn btn-primary" name="filter" value="claim">Add a Payees</button>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-sm-12">
                     <div class="col-sm-2">
                        <?php 
                           echo form_label('Bank Name:', 'bank', array("class"=>'col-sm-12'));
                           echo form_input("bank", $this->input->post("bank"), array("class"=>"form-control", 'placeholder'=>'Bank Name'));
                        ?>
                     </div>
                     <div class="col-sm-2">
                        <?php 
                           echo form_label('Payee Name:', 'payee_name', array("class"=>'col-sm-12'));
                           echo form_input("payee_name", $this->input->post("payee_name"), array("class"=>"form-control", 'placeholder'=>'Payee Name'));
                        ?>
                     </div>
                     <div class="col-sm-2">
                        <?php 
                           echo form_label('Account/Cheque#:', 'account_cheque', array("class"=>'col-sm-12'));
                           echo form_input("account_cheque", $this->input->post("account_cheque"), array("class"=>"form-control", 'placeholder'=>'Account/Cheque#'));
                        ?>
                     </div>
                     <div class="col-sm-2">
                        <?php 
                           echo form_label('Payment:', 'payment', array("class"=>'col-sm-12'));
                           echo form_input("payment", $this->input->post("payment"), array("class"=>"form-control", 'placeholder'=>'Payment'));
                        ?>
                     </div>
                     <div class="col-sm-2">
                        <?php 
                           echo form_label('Currency:', 'currency', array("class"=>'col-sm-12'));
                           echo form_input("currency", $this->input->post("currency"), array("class"=>"form-control", 'placeholder'=>'Currency'));
                        ?>
                     </div>
                     <div class="col-sm-2">
                        <?php 
                           echo form_label('Currency Rate:', 'currency_rate', array("class"=>'col-sm-12'));
                           echo form_input("currency_rate", $this->input->post("currency_rate"), array("class"=>"form-control", 'placeholder'=>'Currency Rate'));
                        ?>
                     </div>
                  </div>
               </div> 
               -->

               <br/>
               <!-- <h2>ATTACHED LIST<small></small></h2>
               <div class="row">
                  <div class="col-sm-12">
                     <div class="col-sm-3">
                        The Attached PDF list1<br/>
                        The Attached PDF list1
                     </div>

                     <div class="col-sm-3">
                        <button class="btn btn-primary">Upload Attached</button>
                     </div>
                  </div>
               </div> -->
               <div class="row">
                  <div class="col-sm-3">
                     <?php 
                        echo form_label('Status:', 'status', array("class"=>'col-sm-12'));                  
                        $status = array(
                           ""=>'--Status--',
                           'M'=>'Receive',
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
                     <input class="btn btn-primary" name="Cancel" value="Cancel" type="submit">  
                  </div>
                  <!-- <div class="col-sm-2"> 
                     <input class="btn btn-primary" name="Examine" value="Examine" type="submit">  
                  </div>
                  <div class="col-sm-2"> 
                     <input class="btn btn-primary" name="Email" value="Email/Print" type="submit">      
                  </div> -->
               </div>

               <?php echo form_close(); ?>

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
   })
   $(document).on("click",".more_filters", function(){
      $(".more_items").toggle();
   })
</script>