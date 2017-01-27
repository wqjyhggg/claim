<duv >
   <div class="page-title">
      <div class="title_left">
         <h3>Claim Examine</h3>
      </div>
   </div>
   <div class="clearfix"></div>
   <!-- Policy search and List Section -->
   <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
         <div class="x_panel">
            <div class="x_title">
               <h2>CLAIM HISTORY<small></small></h2>
               <div class="clearfix"></div>
               <?php echo $message; ?>
            </div>
            <div class="x_content">
               <?php if(!empty($expenses)): ?>
                  <div class="row">
                     <div class="table-responsive">
                        <?php if(!empty($claim_history)): ?>
                           <table class="table table-hover table-bordered">
                              <thead>
                                 <tr>
                                    <th>Claim No</th>
                                    <th>Case No</th>
                                    <th>Claim Date</th>
                                    <th>Total Claimed</th>
                                    <th>Total Paid</th>
                                    <th>Currency</th>
                                    <th>Pay To</th>
                                    <th>Cheque No</th>
                                    <th>Total Received</th>                       
                                 </tr>
                              </thead>
                              <tbody>
                                 <?php foreach ($claim_history as $key => $value): ?>
                                 <tr>
                                    <td><?php echo $value['claim_no']; ?></td>
                                    <td><?php echo $value['case_no']; ?></td>
                                    <td><?php echo $value['claim_date']; ?></td>
                                    <td><?php echo $value['amount_claimed']; ?></td>
                                    <td><?php echo $value['amount_client_paid']; ?></td>
                                    <td><?php echo $value['currency']; ?></td>
                                    <td><?php echo $value['pay_to']; ?></td>
                                    <td><?php //echo $value['claim_no']; ?></td>
                                    <td><?php //echo $value['claim_no']; ?></td>
                                 </tr>
                              <?php endforeach; ?>
                              </tbody>
                           </table>
                        <?php else: ?>
                           <center><?php echo heading('No record available', 4); ?></center>
                        <?php endif;?>
                     </div>
                  </div>

                  <h4>Items</h4>
                  <div class="row">
                     <div class="table-responsive">
                        <table class="table table-hover table-bordered">
                           <thead>
                              <tr>
                                 <th>No</th>
                                 <th>Claim No</th>
                                 <th>Invoice No</th>
                                 <th>Service Date</th>
                                 <th>Coverage</th>
                                 <th>Diagnosis</th>
                                 <th>Amt Claimed</th>
                                 <th>Amt Payable</th>
                                 <th>Amt Deductable</th>  
                                 <th>Amt Insured</th>  
                                 <th>Amt Received</th> 
                                 <th>Comment</th>                       
                              </tr>
                           </thead>
                           <tbody>
                              <?php 
                              $i = 1;
                              foreach ($expenses as $key => $value): $value['count'] = $i; ?>
                              <tr class="edit_claim row-link" attr='<?php echo json_encode($value); ?>'>
                                 <td><?php echo $i; ?></td>
                                 <td><?php echo $value['claim_no'] ?></td>
                                 <td><?php echo $value['invoice'] ?></td>
                                 <td><?php echo $value['date_of_service'] ?></td>
                                 <td><?php echo $value['coverage_code'] ?></td>
                                 <td><?php echo $value['diagnosis'] ?></td>
                                 <td><?php echo $value['amount_claimed'] ?></td>
                                 <td><?php echo $value['amt_payable'] ?></td>
                                 <td><?php echo $value['amt_deductable'] ?></td>
                                 <td><?php echo $value['amt_insured'] ?></td>
                                 <td><?php echo $value['amt_received'] ?></td>
                                 <td><?php echo $value['comment'] ?></td>
                              </tr>
                           <?php $i++;endforeach; ?>
                           </tbody>
                        </table>
                     </div>
                  </div>
                  <div class="edit-claim-item" style="display:none">
                     <h4 class="claim-label">Edit Claim(000112) No.1</h4>
                     <div class="row">
                        <?php echo form_open_multipart("claim/save_item", array('class'=>'form-horizontal', 'method'=>'post', 'id'=>'save_item')); ?>
                        <div class="form-group col-sm-3">
                           <?php 
                              echo form_hidden("id");
                              echo form_label('Claim No.:', 'claim_no', array("class"=>'col-sm-12'));                           
                              echo form_input("claim_no", $this->input->post("claim_no"), array("class"=>"form-control", 'placeholder'=>'Claim No.'));
                           ?>
                        </div>
                        <div class="form-group col-sm-3">
                           <?php 
                              echo form_label('Pay To:', 'pay_to', array("class"=>'col-sm-12'));                           
                              echo form_input("pay_to", $this->input->post("pay_to"), array("class"=>"form-control", 'placeholder'=>'Pay To'));
                           ?>
                        </div>
                        <div class="form-group col-sm-3">
                           <?php 
                              echo form_label('Currency:', 'currency', array("class"=>'col-sm-12')); 
                              $currency = array(
                                    "USD"=>'USD',
                                    "CAD"=>'CAD',
                                    "CNY"=>'CNY',
                                 );
                              echo form_dropdown("currency", $currency, $this->input->get("currency"), array("class"=>'form-control'));
                           ?>
                        </div>
                        <div class="form-group col-sm-3">
                           <?php 
                              echo form_label('Case No:', 'case_no', array("class"=>'col-sm-12'));
                              echo form_input("case_no", $this->input->post("case_no"), array("class"=>"form-control", 'placeholder'=>'Case No'));
                           ?>
                        </div>
                        <div class="form-group col-sm-3">
                           <?php 
                              echo form_label('Currency Rate:', 'currency_rate', array("class"=>'col-sm-12'));
                              echo form_input("currency_rate", $this->input->post("currency_rate"), array("class"=>"form-control", 'placeholder'=>'Currency Rate'));
                           ?>
                        </div>
                        <div class="form-group col-sm-3">
                           <?php 
                              echo form_label('Invoice No:', 'invoice', array("class"=>'col-sm-12'));
                              echo form_input("invoice", $this->input->post("invoice"), array("class"=>"form-control", 'placeholder'=>'Invoice No'));
                           ?>
                        </div>

                        <div class="form-group col-sm-3">
                           <?php echo form_label('Claim Date:', 'claim_date', array("class"=>'col-sm-12'));   ?>
                           <div class="input-group date">
                              <?php                
                              echo form_input("claim_date", $this->input->post("claim_date"), array("class"=>"form-control datepicker", 'placeholder'=>'Claim Date'));
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


                        <div class="form-group col-sm-3">
                           <?php 
                              echo form_label('Coverage Code:', 'coverage_code', array("class"=>'col-sm-12'));
                              echo form_input("coverage_code", $this->input->post("coverage_code"), array("class"=>"form-control", 'placeholder'=>'Coverage Code'));
                           ?>
                        </div>
                        <div class="form-group col-sm-3">
                           <?php 
                              echo form_label('Amt Client Paid:', 'amount_client_paid', array("class"=>'col-sm-12'));
                              echo form_input("amount_client_paid", $this->input->post("amount_client_paid"), array("class"=>"form-control", 'placeholder'=>'Amt Client Paid'));
                           ?>
                        </div>
                        <div class="form-group col-sm-3">
                           <?php 
                              echo form_label('Reason:', 'reason', array("class"=>'col-sm-12'));
                              echo form_input("reason", $this->input->post("reason"), array("class"=>"form-control", 'placeholder'=>'Reason'));
                           ?>
                        </div>
                        <div class="form-group col-sm-3">
                           <?php 
                              echo form_label('Diagnosis:', 'diagnosis', array("class"=>'col-sm-12'));
                              echo form_input("diagnosis", $this->input->post("diagnosis"), array("class"=>"form-control", 'placeholder'=>'Diagnosis'));
                           ?>
                        </div>
                        <div class="form-group col-sm-3">
                           <?php 
                              echo form_label('Amt Claimed:', 'amount_claimed', array("class"=>'col-sm-12'));
                              echo form_input("amount_claimed", $this->input->post("amount_claimed"), array("class"=>"form-control", 'placeholder'=>'Amt Claimed'));
                           ?>
                        </div>
                        <div class="form-group col-sm-3">
                           <?php 
                              echo form_label('Amt Deductable:', 'amt_deductable', array("class"=>'col-sm-12'));
                              echo form_input("amt_deductable", $this->input->post("amt_deductable"), array("class"=>"form-control", 'placeholder'=>'Amt Deductable'));
                           ?>
                        </div>
                        <div class="form-group col-sm-3">
                           <?php 
                              echo form_label('Amt Insured:', 'amt_insured', array("class"=>'col-sm-12'));
                              echo form_input("amt_insured", $this->input->post("amt_insured"), array("class"=>"form-control", 'placeholder'=>'Amt Insured'));
                           ?>
                        </div>
                        <div class="form-group col-sm-3">
                           <?php 
                              echo form_label('Amt Received:', 'amt_received', array("class"=>'col-sm-12'));
                              echo form_input("amt_received", $this->input->post("amt_received"), array("class"=>"form-control", 'placeholder'=>'Amt Received'));
                           ?>
                        </div>
                        <div class="form-group col-sm-3">
                           <?php 
                              echo form_label('Amt Payable:', 'amt_payable', array("class"=>'col-sm-12'));
                              echo form_input("amt_payable", $this->input->post("amt_payable"), array("class"=>"form-control", 'placeholder'=>'Amt Payable'));
                           ?>
                        </div>
                        <div class="form-group col-sm-3">
                           <?php 
                              echo form_label('Comment:', 'comment', array("class"=>'col-sm-12'));
                              echo form_input("comment", $this->input->post("comment"), array("class"=>"form-control", 'placeholder'=>'Comment'));
                           ?>
                        </div>
                        <div class="col-sm-2"> 
                           <?php echo form_label('&nbsp;', 'save', array("class"=>'col-sm-12')); ?>
                           <input class="btn btn-primary" name="Save" value="Save" type="submit">  
                       </div>
                        <?php echo form_close(); ?>
                     </div> 
                  </div>

                  <hr/>
               
               <?php endif;?>
               <h4 style="margin-top:25px;">POLICY INFO</h4>
               <div class="row">
                  <div class="form-group col-sm-4">
                     <?php echo form_label('Arrival Date:', 'arrival_date', array("class"=>'col-sm-12'));   ?>
                     <div class="input-group date">
                        <?php           
                        // get policy info here
                        $policy_info = json_decode($claim_details['policy_info'], TRUE);
                        echo form_input("arrival_date", $policy_info['arrival_date'], array("class"=>"form-control datepicker", 'placeholder'=>'Arrival Date'));
                        ?>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                     </div>
                  </div>
                  <div class="form-group col-sm-4">
                     <?php echo form_label('Effective Date:', 'effective_date', array("class"=>'col-sm-12'));   ?>
                     <div class="input-group date">
                        <?php                
                        echo form_input("effective_date", $policy_info['effective_date'], array("class"=>"form-control datepicker", 'placeholder'=>'Effective Date'));
                        ?>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                     </div>
                  </div>
                  <div class="form-group col-sm-4">
                     <?php echo form_label('Expiry Date:', 'expiry_date', array("class"=>'col-sm-12'));   ?>
                     <div class="input-group date">
                        <?php                
                        echo form_input("expiry_date", $policy_info['expiry_date'], array("class"=>"form-control datepicker", 'placeholder'=>'Expiry Date'));
                        ?>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                     </div>
                  </div>


                  <div class="form-group col-sm-4">
                     <?php 
                        echo form_label('Premium: $ 565.75', 'Premium', array("class"=>'col-sm-12'));
                     ?>
                  </div>
                  <div class="form-group col-sm-4">
                     <?php 
                        echo form_label('Sum Insured: $ '.$policy_info['sum_insured'], 'Sum Insured', array("class"=>'col-sm-12'));
                     ?>
                  </div>
                  <div class="form-group col-sm-4">
                     <?php 
                        echo form_label('Deductable Amount: $ '.$policy_info['deductible_amount'], 'Deductable Amount', array("class"=>'col-sm-12'));
                     ?>
                  </div>
                  <div class="form-group col-sm-4">
                     <?php 
                        echo form_label('Pre-existion condition coverage:', 'existion_condition', array("class"=>'col-sm-12')); 
                        $existion_condition = array(
                              "With Stable pre-existion condition coverage"=>'With Stable pre-existion condition coverage'
                           );
                        echo form_dropdown("existion_condition", $existion_condition, $this->input->get("existion_condition"), array("class"=>'form-control'));
                     ?>
                  </div>
               </div>
               <hr/>

               <?php echo form_open_multipart("", array('class'=>'form-horizontal', 'method'=>'post')); ?>
               <h4 style="margin-top:25px;" class="move_down">CASE INFO <i class="fa fa-angle-down pull-right"></i></h4>
               <div class="case_info" style="display:none">
                  <div class="row">
                     <div class="form-group col-sm-3">
                        <?php 
                           echo form_label('Insured First Name:', 'insured_first_name', array("class"=>'col-sm-12'));                            
                           echo form_input("insured_first_name", $this->common_model->field_val("insured_first_name", $claim_details), array("class"=>"form-control", 'placeholder'=>'Insured First Name'));
                        ?>
                     </div>
                     <div class="col-sm-3">
                        <?php 
                           echo form_label('Insured Last Name:', 'insured_last_name', array("class"=>'col-sm-12'));                            
                           echo form_input("insured_last_name", $this->common_model->field_val("insured_last_name", $claim_details), array("class"=>"form-control", 'placeholder'=>'Insured Last Name'));
                        ?>
                     </div>
                     <div class="col-sm-3">
                        <div class="col-sm-4">
                           <?php 
                           echo form_label('&nbsp;', 'gender', array("class"=>'col-sm-12'));
                           echo form_radio("gender", "male", ($this->common_model->field_val("gender", $claim_details)=='male'?TRUE:FALSE), array('class'=>'setpremium')); ?>  Male
                        </div>
                        <div class="col-sm-5">
                           <?php 
                           echo form_label('&nbsp;', 'gender', array("class"=>'col-sm-12'));
                           echo form_radio("gender", "female", ($this->common_model->field_val("gender", $claim_details)=='female'?TRUE:FALSE), array('class'=>'setpremium')); ?>  Female
                        </div>
                     </div>
                     <div class="col-sm-3">
                        <?php 
                           echo form_label('ID', 'id', array("class"=>'col-sm-12'));
                           echo form_input("personal_id", $this->common_model->field_val("personal_id", $claim_details), array("class"=>"form-control", 'placeholder'=>'ID'));
                        ?>
                     </div>
                  </div>

                  <div class="row">
                     <div class="form-group col-sm-3">
                        <?php echo form_label('Date of Birth:', 'dob', array("class"=>'col-sm-12'));   ?>
                        <div class="input-group date">
                           <?php                
                           echo form_input("dob", $this->common_model->field_val("dob", $claim_details), array("class"=>"form-control datepicker", 'placeholder'=>'Date of Birth'));
                           ?>
                           <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                        </div>
                     </div>
                     <div class="col-sm-3">
                        <?php 
                           echo form_label('Policy#:', 'policy_no', array("class"=>'col-sm-12'));                            
                           echo form_input("policy_no", $this->common_model->field_val("policy_no", $claim_details), array("class"=>"form-control", 'placeholder'=>'Policy#'));
                           echo form_error("policy_no");
                        ?>
                     </div>
                     <div class="col-sm-3">
                        <?php 
                           echo form_label('School Name:', 'school_name', array("class"=>'col-sm-12'));                            
                           echo form_input("school_name", $this->common_model->field_val("school_name", $claim_details), array("class"=>"form-control", 'placeholder'=>'School Name'));
                        ?>
                     </div>
                     <div class="col-sm-3">
                        <?php 
                           echo form_label('Group ID:', 'group_id', array("class"=>'col-sm-12'));                            
                           echo form_input("group_id", $this->common_model->field_val("group_id", $claim_details), array("class"=>"form-control", 'placeholder'=>'Group ID'));
                        ?>
                     </div>
                  </div>
                  <div class="row">
                     <div class="form-group col-sm-3">
                        <?php echo form_label('Enroll Date:', 'apply_date', array("class"=>'col-sm-12'));   ?>
                        <div class="input-group date">
                           <?php                
                           echo form_input("apply_date", $this->common_model->field_val("apply_date", $claim_details), array("class"=>"form-control datepicker", 'placeholder'=>'Enroll Date'));
                           ?>
                           <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                        </div>
                     </div>
                     <div class="form-group col-sm-3">
                        <?php echo form_label('Arrival Date in Canada:', 'arrival_date', array("class"=>'col-sm-12'));   ?>
                        <div class="input-group date">
                           <?php                
                           echo form_input("arrival_date", $this->common_model->field_val("arrival_date", $claim_details), array("class"=>"form-control datepicker", 'placeholder'=>'Arrival Date in Canada'));
                           ?>
                           <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                        </div>
                     </div>
                     <div class="form-group col-sm-3">
                        <?php 
                           echo form_label('Full Name of Guardian if applicable:', 'guardian_name', array("class"=>'col-sm-12'));
                           echo form_input("guardian_name", $this->common_model->field_val("guardian_name", $claim_details), array("class"=>"form-control", 'placeholder'=>'Full Name of Guardian if applicable'));
                           ?>
                     </div>
                     <div class="form-group col-sm-3">
                        <?php 
                           echo form_label('Guardian Phone#:', 'guardian_phone', array("class"=>'col-sm-12'));
                           echo form_input("guardian_phone", $this->common_model->field_val("guardian_phone", $claim_details), array("class"=>"form-control", 'placeholder'=>'Guardian Phone#'));
                           ?>
                     </div>
                  </div>

                  <h4>Address in Canada</h4>
                  <div class="row">
                     <div class="col-sm-12">
                        <div class="input-group col-sm-3" style="margin-bottom:10px">
                           <?php  
                           echo form_checkbox("same_policy", "Y", $this->common_model->field_val("same_policy", $claim_details), array('class'=>'setpremium', 'style'=>'margin-left:10px')); ?>  Same with policy
                        </div>
                     </div>
                     
                     <div class="form-group col-sm-3">
                        <?php 
                           echo form_label('Street Address:', 'street_address', array("class"=>'col-sm-12'));                           
                           echo form_input("street_address", $this->common_model->field_val("street_address", $claim_details), array("class"=>"form-control", 'placeholder'=>'Street Address'));
                        ?>
                     </div>
                     <div class="form-group col-sm-3">
                        <?php 
                           echo form_label('City/Town:', 'city', array("class"=>'col-sm-12'));                           
                           echo form_input("city", $this->common_model->field_val("city", $claim_details), array("class"=>"form-control", 'placeholder'=>'City/Town'));
                        ?>
                     </div>
                     <div class="form-group col-sm-3">
                        <?php 
                           echo form_label('Province:', 'province', array("class"=>'col-sm-12'));                           
                           echo form_input("province", $this->common_model->field_val("province", $claim_details), array("class"=>"form-control", 'placeholder'=>'Province'));
                        ?>
                     </div>
                     <div class="form-group col-sm-3">
                        <?php 
                           echo form_label('Telephone:', 'telephone', array("class"=>'col-sm-12'));
                           echo form_input("telephone", $this->common_model->field_val("telephone", $claim_details), array("class"=>"form-control", 'placeholder'=>'Telephone'));
                        ?>
                     </div>
                     <div class="form-group col-sm-3">
                        <?php 
                           echo form_label('Email:', 'email', array("class"=>'col-sm-12'));
                           echo form_input("email", $this->common_model->field_val("email", $claim_details), array("class"=>"form-control", 'placeholder'=>'Email'));
                        ?>
                     </div>
                     <div class="form-group col-sm-3">
                        <?php 
                           echo form_label('PostCode:', 'post_code', array("class"=>'col-sm-12'));
                           echo form_input("post_code", $this->common_model->field_val("post_code", $claim_details), array("class"=>"form-control", 'placeholder'=>'PostCode'));
                        ?>
                     </div>

                     <div class="form-group col-sm-3">
                        <?php echo form_label('Date of Arrival in Canada:', 'arrival_date_canada', array("class"=>'col-sm-12'));   ?>
                        <div class="input-group date">
                           <?php                
                           echo form_input("arrival_date_canada", $this->common_model->field_val("arrival_date_canada", $claim_details), array("class"=>"form-control datepicker", 'placeholder'=>'Date of Arrival in Canada'));
                           ?>
                           <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                        </div>
                     </div>

                     <div class="form-group col-sm-3">
                        <?php 
                           echo form_label('Cellular:', 'cellular', array("class"=>'col-sm-12'));
                           echo form_input("cellular", $this->common_model->field_val("cellular", $claim_details), array("class"=>"form-control", 'placeholder'=>'Cellular'));
                        ?>
                     </div>
                  </div>              
                  <h4>Name and Address of Family Physician in Country of Origin</h4>
                  <div class="row">
                     <div class="col-sm-12">
                        <div class="form-group col-sm-3">
                           <?php 
                              echo form_label('Name:', 'physician_name', array("class"=>'col-sm-12'));                           
                              echo form_input("physician_name", $this->common_model->field_val("physician_name", $claim_details), array("class"=>"form-control", 'placeholder'=>'Name'));
                           ?>
                        </div>
                        <div class="form-group col-sm-3">
                           <?php 
                              echo form_label('Clinic Name or Address:', 'clinic_name', array("class"=>'col-sm-12'));                           
                              echo form_input("clinic_name", $this->common_model->field_val("clinic_name", $claim_details), array("class"=>"form-control", 'placeholder'=>'Clinic Name or Address'));
                           ?>
                        </div>
                        <div class="form-group col-sm-3">
                            <?php 
                              echo form_label('Street Address:', 'physician_street_address', array("class"=>'col-sm-12'));                           
                              echo form_input("physician_street_address", $this->common_model->field_val("physician_street_address", $claim_details), array("class"=>"form-control", 'placeholder'=>'Street Address'));
                           ?>
                        </div>
                        <div class="form-group col-sm-3">
                           <?php 
                              echo form_label('City/Town:', 'physician_city', array("class"=>'col-sm-12'));                           
                              echo form_input("physician_city", $this->common_model->field_val("physician_city", $claim_details), array("class"=>"form-control", 'placeholder'=>'City/Town'));
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
                              echo form_input("physician_post_code", $this->common_model->field_val("physician_post_code", $claim_details), array("class"=>"form-control", 'placeholder'=>'Post Code'));
                           ?>
                        </div>
                        <div class="form-group col-sm-3">
                           <?php 
                              echo form_label('Telephone:', 'physician_telephone', array("class"=>'col-sm-12'));                           
                              echo form_input("physician_telephone", $this->common_model->field_val("physician_telephone", $claim_details), array("class"=>"form-control", 'placeholder'=>'Telephone'));
                           ?>
                        </div>
                        <div class="form-group col-sm-3">
                           <?php 
                              echo form_label('Alt Telephone:', 'physician_alt_telephone', array("class"=>'col-sm-12'));                           
                              echo form_input("physician_alt_telephone", $this->common_model->field_val("physician_alt_telephone", $claim_details), array("class"=>"form-control", 'placeholder'=>'Alt Telephone'));
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
                              echo form_input("physician_name_canada", $this->common_model->field_val("physician_name_canada", $claim_details), array("class"=>"form-control", 'placeholder'=>'Name'));
                           ?>
                        </div>
                        <div class="form-group col-sm-3">
                           <?php 
                              echo form_label('Clinic Name or Address:', 'clinic_name_canada', array("class"=>'col-sm-12'));                           
                              echo form_input("clinic_name_canada", $this->common_model->field_val("clinic_name_canada", $claim_details), array("class"=>"form-control", 'placeholder'=>'Clinic Name or Address'));
                           ?>
                        </div>
                        <div class="form-group col-sm-3">
                            <?php 
                              echo form_label('Street Address:', 'physician_street_address_canada', array("class"=>'col-sm-12'));                           
                              echo form_input("physician_street_address_canada", $this->common_model->field_val("physician_street_address_canada", $claim_details), array("class"=>"form-control", 'placeholder'=>'Street Address'));
                           ?>
                        </div>
                        <div class="form-group col-sm-3">
                           <?php 
                              echo form_label('City/Town:', 'physician_city_canada', array("class"=>'col-sm-12'));                           
                              echo form_input("physician_city_canada", $this->common_model->field_val("physician_city_canada", $claim_details), array("class"=>"form-control", 'placeholder'=>'City/Town'));
                           ?>
                        </div>
                        <div class="form-group col-sm-3">
                           <?php 
                              echo form_label('Post Code:', 'physician_post_code_canada', array("class"=>'col-sm-12'));                           
                              echo form_input("physician_post_code_canada", $this->common_model->field_val("physician_post_code_canada", $claim_details), array("class"=>"form-control", 'placeholder'=>'Post Code'));
                           ?>
                        </div>
                        <div class="form-group col-sm-3">
                           <?php 
                              echo form_label('Telephone:', 'physician_telephone_canada', array("class"=>'col-sm-12'));                           
                              echo form_input("physician_telephone_canada", $this->common_model->field_val("physician_telephone_canada", $claim_details), array("class"=>"form-control", 'placeholder'=>'Telephone'));
                           ?>
                        </div>
                        <div class="form-group col-sm-3">
                           <?php 
                              echo form_label('Alt Telephone:', 'physician_alt_telephone_canada', array("class"=>'col-sm-12'));                           
                              echo form_input("physician_alt_telephone_canada", $this->common_model->field_val("physician_alt_telephone_canada", $claim_details), array("class"=>"form-control", 'placeholder'=>'Alt Telephone'));
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
                                 echo form_radio("travel_insurance_coverage", "Y", ($this->common_model->field_val("travel_insurance_coverage", $claim_details) == 'Y'?TRUE:FALSE), array('class'=>'setpremium')); ?>  Yes
                              </div>
                              <div class="col-sm-1">
                                 <?php 
                                 echo form_radio("travel_insurance_coverage", "N", $this->common_model->field_val("travel_insurance_coverage", $claim_details) == 'N'?TRUE:FALSE, array('class'=>'setpremium')); ?>  No
                              </div>

                              <div class="col-sm-12">
                                 If yes, provide details of other insurance company coverage below. If no, confirm by checking the box below. 
                              </div>
                           </div>
                           <div class="col-sm-3">
                              <?php 
                                 echo form_label('Full Name:', 'full_name', array("class"=>'col-sm-12'));
                                 echo form_input("full_name", $this->common_model->field_val("full_name", $claim_details), array("class"=>"form-control", 'placeholder'=>'Full Name'));
                              ?>
                           </div>
                           <div class="col-sm-3">
                              <?php 
                                 echo form_label('Employee Name:', 'employee_name', array("class"=>'col-sm-12'));
                                 echo form_input("employee_name", $this->common_model->field_val("employee_name", $claim_details), array("class"=>"form-control", 'placeholder'=>'Employee Name'));
                              ?>
                           </div>
                           <div class="col-sm-3">
                              <?php 
                                 echo form_label('Full Name:', 'full_name', array("class"=>'col-sm-12'));
                                 echo form_input("full_name", $this->common_model->field_val("full_name", $claim_details), array("class"=>"form-control", 'placeholder'=>'Full Name'));
                              ?>
                           </div>
                           <div class="col-sm-3">
                              <?php 
                                 echo form_label('Street Address:', 'employee_street_address', array("class"=>'col-sm-12'));
                                 echo form_input("employee_street_address", $this->common_model->field_val("employee_street_address", $claim_details), array("class"=>"form-control", 'placeholder'=>'Street Address'));
                              ?>
                           </div>
                           <div class="col-sm-3">
                              <?php 
                                 echo form_label('City/Town:', 'city_town', array("class"=>'col-sm-12'));
                                 echo form_input("city_town", $this->common_model->field_val("city_town", $claim_details), array("class"=>"form-control", 'placeholder'=>'City/Town'));
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
                                 echo form_input("employee_telephone", $this->common_model->field_val("employee_telephone", $claim_details), array("class"=>"form-control", 'placeholder'=>'Telephone'));
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
                                 echo form_textarea("medical_description", $this->common_model->field_val("medical_description", $claim_details), array("class"=>"form-control", 'placeholder'=>'Brief description of your sickness or injury'));
                              ?>
                           </div>  

                           <div class="col-sm-6">
                              <?php 
                                 echo form_label('Date symptoms or injury first appeared:', 'date_symptoms', array("class"=>'col-sm-12'));                           
                                 echo form_input("date_symptoms", $this->common_model->field_val("date_symptoms", $claim_details), array("class"=>"form-control datepicker", 'placeholder'=>'Date symptoms or injury first appeared'));
                              ?>
                           </div>  

                           <div class="col-sm-6">
                              <?php 
                                 echo form_label('Date you first saw physician for this condition:', 'date_first_physician', array("class"=>'col-sm-12'));                           
                                 echo form_input("date_first_physician", $this->common_model->field_val("date_first_physician", $claim_details), array("class"=>"form-control datepicker", 'placeholder'=>'Date you first saw physician for this condition'));
                              ?>
                           </div>
                           <div class="col-sm-12" style="margin-top:20px">
                              <div class="col-sm-7">
                                 Do you, your spouse or your parents/guardians have any other medical or travel insurance coverage?
                              </div>
                              <div class="col-sm-1">
                                 <?php 
                                 echo form_radio("travel_insurance_coverage_guardians", "Y", $this->common_model->field_val("travel_insurance_coverage_guardians", $claim_details), array('class'=>'setpremium')); ?>  Yes
                              </div>
                              <div class="col-sm-1">
                                 <?php 
                                 echo form_radio("travel_insurance_coverage_guardians", "N", $this->common_model->field_val("travel_insurance_coverage_guardians", $claim_details), array('class'=>'setpremium')); ?>  No
                              </div>

                              <div class="col-sm-12" style="margin-bottom:10px">
                                 If yes, provide details of other insurance company coverage below. If no, confirm by checking the box below. 
                              </div>


                              <div class="form-group col-sm-12">
                                 <div class="col-sm-3">
                                    <?php echo form_label('Date (MM/DD/YYYY):', 'medication_date_1', array("class"=>'col-sm-12'));   ?>
                                    <div class="input-group date">
                                       <?php                
                                       echo form_input("medication_date_1", $this->common_model->field_val("medication_date_1", $claim_details), array("class"=>"form-control datepicker", 'placeholder'=>'Date (MM/DD/YYYY)'));
                                       ?>
                                       <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                    </div>
                                 </div>

                                 <div class="col-sm-3">
                                    <?php 
                                       echo form_label('Medication:', 'medication_1', array("class"=>'col-sm-12'));                           
                                       echo form_input("medication_1", $this->common_model->field_val("medication_1", $claim_details), array("class"=>"form-control", 'placeholder'=>'Medication'));
                                    ?>
                                 </div> 
                              </div>
                              <div class="form-group col-sm-12">
                                 <div class="col-sm-3">
                                    <?php echo form_label('Date (MM/DD/YYYY):', 'medication_date_2', array("class"=>'col-sm-12'));   ?>
                                    <div class="input-group date">
                                       <?php                
                                       echo form_input("medication_date_2", $this->common_model->field_val("medication_date_2", $claim_details), array("class"=>"form-control datepicker", 'placeholder'=>'Date (MM/DD/YYYY)'));
                                       ?>
                                       <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                    </div>
                                 </div>

                                 <div class="col-sm-3">
                                    <?php 
                                       echo form_label('Medication:', 'medication_2', array("class"=>'col-sm-12'));                           
                                       echo form_input("medication_2", $this->common_model->field_val("medication_2", $claim_details), array("class"=>"form-control", 'placeholder'=>'Medication'));
                                    ?>
                                 </div> 
                              </div>
                              <div class="form-group col-sm-12">
                                 <div class="col-sm-3">
                                    <?php echo form_label('Date (MM/DD/YYYY):', 'medication_date_3', array("class"=>'col-sm-12'));   ?>
                                    <div class="input-group date">
                                       <?php                
                                       echo form_input("medication_date_3", $this->common_model->field_val("medication_date_3", $claim_details), array("class"=>"form-control datepicker", 'placeholder'=>'Date (MM/DD/YYYY)'));
                                       ?>
                                       <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                    </div>
                                 </div>
                                 <div class="col-sm-3">
                                    <?php 
                                       echo form_label('Medication:', 'medication_3', array("class"=>'col-sm-12'));                           
                                       echo form_input("medication_3", $this->common_model->field_val("medication_3", $claim_details), array("class"=>"form-control", 'placeholder'=>'Medication'));
                                    ?>
                                 </div> 
                              </div>
                           </div>

                        </div>
                     </div>
                  </div>

                  <!-- Intake Forms List Section -->
                  <br/>
                  <h2 class="modal-title intake-heading">INTAKE FORMS <button type="button" class="btn btn-primary create_intake_form" data-toggle="modal" data-target="#create_intake_form"><i class="fa fa-plus-circle"></i> Create InTakeForm</button></h2>
                  <div class="row intake-forms-list col-sm-12">
                     <?php 
                     if(!empty($intake_forms)):
                        foreach ($intake_forms as $key => $value):
                           ?>
                            <div class="col-sm-12 intake-forms">
                                <div class="col-sm-12&quot;"><?php echo $value['notes'] ?></div>
                                <div id="intake-files-1">
                                    <div class="form-group col-sm-12 files">
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
                                </div>
                                <div class="col-sm-3&quot;"><i class="fa fa-remove row-link remove-form pull-right" alt="<?php echo $value['id']; ?>"></i></div>
                                <div class="col-sm-12">By: <?php echo $value['created_by'] ?> on <i><?php echo date("Y-m-d", strtotime($value['created'])) ?></i></div>
                            </div>  
                           <?php
                        endforeach;
                     endif;
                     ?>
                  </div>
                  <input type="hidden" name="no_of_form" value="0"/> <!-- used to knnow how many forms added in this page -->
                  <!-- end intake forms list  -->
                 
                  <h2>PAYEE INFORMATION<small></small></h2>
                  <div class="row">
                     <div class="col-sm-12">
                        <div class="col-sm-3">
                           <?php 
                           echo form_radio("payment_type", "cheque", $this->common_model->field_val("payment_type", $claim_details), array('class'=>'setpremium')); ?>  Cheque
                        </div>
                        <div class="col-sm-3">
                           <?php 
                           echo form_radio("payment_type", "wire transfer", $this->common_model->field_val("payment_type", $claim_details), array('class'=>'setpremium')); ?>  Wire Transfer
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
                                 <th>Bank Name</th>
                                 <th>Payee Name</th>
                                 <th>Account/Cheque#</th>
                                 <th>Payment</th>
                                 <th>Currency</th>
                                 <th>Currency Rate</th>
                                 <th>&nbsp;</th>                    
                              </tr>
                           </thead>
                           <tbody class="payee-data">
                              <?php                              
                              if(!empty($payees)):
                                 foreach ($payees as $key => $value): ?>
                                  <tr>
                                    <td>
                                       <?php 
                                          echo form_input("payees[bank][]", $value["bank"], array("class"=>"form-control", 'placeholder'=>'Bank Name'));
                                       ?>
                                    </td>
                                    <td>
                                       <?php 
                                          echo form_input("payees[payee_name][]", $value["payee_name"], array("class"=>"form-control", 'placeholder'=>'Payee Name'));
                                       ?>
                                    </td>
                                    <td>
                                       <?php 
                                          echo form_input("payees[account_cheque][]", $value["account_cheque"], array("class"=>"form-control", 'placeholder'=>'Account/Cheque#'));
                                       ?>
                                    </td>
                                    <td>
                                       <?php 
                                          echo form_input("payees[payment][]", $value["payment"], array("class"=>"form-control", 'placeholder'=>'Payment'));
                                       ?>
                                    </td>
                                    <td>
                                       <?php 
                                       $payee_currency = array(
                                                "USD"=>'USD',
                                                "CAD"=>'CAD',
                                                "CNY"=>'CNY',
                                             );
                                          echo form_dropdown("payees[payee_currency][]", $payee_currency, $value["payee_currency"], array("class"=>'form-control'));
                                       ?>
                                    </td>
                                    <td>
                                       <?php 
                                          echo form_input("payees[payee_currency_rate][]", $value["payee_currency_rate"], array("class"=>"form-control", 'placeholder'=>'Currency Rate'));
                                       ?>
                                    </td>
                                    <td>
                                       <i class="fa fa-trash row-link remove-payee"></i>
                                    </td>
                                 </tr>   
                              <?php   
                                 endforeach;
                              endif;
                              ?>                                                     
                           </tbody>
                        </table>
                     </div>
                  </div>

                  <br/>
                  <h2>ATTACHED LIST<small></small> <button class="btn btn-primary multiupload_files"  type="button">Upload Attached</button></h2>  
                  <div class="row">
                     <div class="col-sm-12">
                        <div class="col-sm-3 uploaded_files">
                           <?php 
                              $files = $claim_details['files'] ? explode(",", $claim_details['files']) : array(); 
                              if(!empty($files)):
                                 foreach ($files as $file):
                                    ?>
                                     <div class="col-sm-9" style="">
                                         <span class="file-label"><?php echo anchor("file_claim/".$file . '__' . $claim_details['id'], $file, array('target'=>'_blank')); ?></span>
                                         <?php echo anchor("file_claim/" . $file . '__' . $claim_details['id'], '<i class="fa fa-search row-link"></i>', array('target'=>'_blank', 'title'=>'Browse File')); ?>
                                         <?php echo anchor("claim_doc_download/" . $file . '__' . $claim_details['id'], '<i class="fa fa-download row-link"></i>', array('title'=>'Download File')); ?>                                                    
                                     </div>
                                     <?php
                                 endforeach;
                              else:
                                 echo "no files attached";
                              endif;
                           ?>
                        </div>
                        <div class="col-sm-3">
                           &nbsp;
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
                              'received'=>'Received',
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
               </div>

               <div class="row" style="margin-top:20px">
                  <div class="row">
                     <div class="col-sm-2">
                        <input class="btn btn-primary" name="Save" value="Save" type="submit">   
                     </div>
                     <div class="col-sm-2">
                        <?php echo anchor("claim", "Cancel", array("class"=>'btn btn-primary')); ?>
                     </div>
                     <div class="col-sm-2">
                        <input class="btn btn-primary" name="Investigate Pending" value="Investigate Pending" type="button">   
                     </div>
                  </div>

                  <div class="row" style="margin-top: 20px;">
                     <div class="col-sm-2"> 
                        <label style="float: right; font-size: 25px;"> Decision </label>
                     </div>
                     <div class="col-sm-2"> 
                        <input class="btn btn-primary" name="Accept" value="Accept" type="button">  
                     </div>
                     <div class="col-sm-1"> 
                        <input class="btn btn-primary" name="Deny" value="Deny" type="button">  
                     </div>
                     <div class="col-sm-2"> 
                        <?php
                        $reason = array(
                           ""=>'--Denial Reason--',
                           );
                        echo form_dropdown("reason", $reason, $this->input->get("reason"), array("class"=>'form-control'))
                        ?>
                     </div>
                     <div class="col-sm-2"> 
                        <input class="btn btn-primary email_print" data-toggle="modal"  name="Email" value="Email/Print" type="button" data-target="#print_template">      
                     </div>
                     <div class="col-sm-2"> 
                        <input class="btn btn-primary" name="Record Exempt" value="Record Exempt" type="button">  
                     </div>
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
         echo form_open_multipart("claim/send_print_email_claim", array("id"=>'send_print_email'));
       ?>
      <div class="modal-body">
          <div class="row">
            <div class="col-sm-6">
               <div>
                  <label for="mail_label" class="col-sm-2">Mail Addres:</label>    
                  <div class="form-group col-sm-6">
                     <input name="priority" value="HIGH" id="mail_address" class="col-sm-1" type="checkbox">
                     <label for="mail_address" class="col-sm-10 pull-right" style="margin-top: 3px;">Use same address</label>
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

<table style="display:none">
   <tbody class="base-row">
      <tr>
         <td>
            <?php 
               echo form_input("expenses_climed[invoice][]", $this->input->post("invoice"), array("class"=>"form-control"));
            ?>
         </td>  
         <td>
            <?php 
               echo form_input("expenses_climed[provider_name][]", $this->input->post("provider_name"), array("class"=>"form-control"));
            ?>
         </td>  
         <td>
            <?php 
               echo form_input("expenses_climed[referencing_physician][]", $this->input->post("referencing_physician"), array("class"=>"form-control"));
            ?>
         </td>  
         <td>
            <?php 
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
         </td>  
         <td>
            <?php 
               echo form_input("expenses_climed[diagnosis][]", $this->input->post("diagnosis"), array("class"=>"form-control autocomplete_field"));
            ?>
         </td>  
         <td>
            <?php 
               echo form_input("expenses_climed[service_description][]", $this->input->post("service_description"), array("class"=>"form-control"));
            ?>
         </td>  
         <td>
            <?php 
               echo form_input("expenses_climed[date_of_service][]", $this->input->post("date_of_service"), array("class"=>"form-control"));
            ?>
         </td> 
         <td>
            <?php 
               echo form_input("expenses_climed[amount_billed][]", $this->input->post("amount_billed"), array("class"=>"form-control"));
            ?>
         </td> 
         <td>
            <?php 
               echo form_input("expenses_climed[amount_client_paid][]", $this->input->post("amount_client_paid"), array("class"=>"form-control"));
            ?>
         </td> 
         <td>
            <?php 
            $currency = array(
                     "USD"=>'USD',
                     "CAD"=>'CAD',
                     "CNY"=>'CNY',
                  );
               echo form_dropdown("expenses_climed[currency][]", $currency, $this->input->get("currency"), array("class"=>'form-control'));
            ?>
         </td> 
         <td>
            <?php 
               echo form_input("expenses_climed[currency_rate][]", $this->input->post("currency_rate"), array("class"=>"form-control"));
            ?>
         </td> 
         <td>
            <?php 
               echo form_input("expenses_climed[payee][]", $this->input->post("payee"), array("class"=>"form-control"));
            ?>
         </td> 
         <td>
            <?php 
               echo form_input("expenses_climed[comment][]", $this->input->post("comment"), array("class"=>"form-control"));
            ?>
         </td> 
         <td>
            <i class="fa fa-trash row-link remove_claim"></i>
         </td>
      </tr>
   </tbody>
</table>

<table style="display:none">
   <tbody class="payee-buffer">
      <tr>
         <td>
            <?php 
               echo form_input("payees[bank][]", $this->input->post("bank"), array("class"=>"form-control", 'placeholder'=>'Bank Name'));
            ?>
         </td>
         <td>
            <?php 
               echo form_input("payees[payee_name][]", $this->input->post("payee_name"), array("class"=>"form-control", 'placeholder'=>'Payee Name'));
            ?>
         </td>
         <td>
            <?php 
               echo form_input("payees[account_cheque][]", $this->input->post("account_cheque"), array("class"=>"form-control", 'placeholder'=>'Account/Cheque#'));
            ?>
         </td>
         <td>
            <?php 
               echo form_input("payees[payment][]", $this->input->post("payment"), array("class"=>"form-control", 'placeholder'=>'Payment'));
            ?>
         </td>
         <td>
            <?php 
            $payee_currency = array(
                     "USD"=>'USD',
                     "CAD"=>'CAD',
                     "CNY"=>'CNY',
                  );
               echo form_dropdown("payees[payee_currency][]", $payee_currency, $this->input->get("payee_currency"), array("class"=>'form-control'));
            ?>
         </td>
         <td>
            <?php 
               echo form_input("payees[payee_currency_rate][]", $this->input->post("payee_currency_rate"), array("class"=>"form-control", 'placeholder'=>'Currency Rate'));
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
   })
   .on("click", ".remove_claim", function(){
      $(this).parent("td").parent("tr").remove();
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
      var no_of_form = $(".intake-forms").length + 1;

      // add new file here
      $(".uploaded_files").append('<div class="col-sm-9"  style="display:none" ><input style="display:none" type="file" name="files_multi[]" id="file'+(count+1)+'" accept="pdf" /><span class="file-label"></span> <i class="fa fa-trash row-link" id="'+(count+1)+'"></i></div>');

      // place trigger clicked once file append in files class
      $('#file'+(count+1)).trigger("click");
   })

   // delete intake form
   .on("click",".fa.fa-remove.row-link.remove-form.pull-right", function(){
      var id = $(this).attr("alt");

      if(confirm('Are you sure you want to delete? '))
      {
         // remove form area instant to make it visible fast
         $(this).parent("div").parent("div.intake-forms").remove();

         $.ajax({
            url: "<?php echo base_url("emergency_assistance/deleteform/") ?>"+id,
            method: "get"
         })
      } else {
         return false;
      }
   })

   // once user click over save intake form, we are just hold every value untill case is not submitted
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

   .on("click", ".move_down", function(){
      $(".case_info").toggle();
      $(this).children("i").toggleClass("fa-angle-up").toggleClass("fa-angle-down");
   })

   .on("click", ".edit_claim", function(){
      var data = $.parseJSON($(this).attr("attr"));

      // place all values to input fields
      $.each(data, function( index, value ) {
         $(".edit-claim-item input[name="+index+"]").val(value);
         $(".edit-claim-item select[name="+index+"]").val(value);
      });

      // change label
      $(".claim-label").text("Edit Claim("+(data.claim_no?data.claim_no:'#####')+") No."+data.count);

      $(".edit-claim-item").show();
   })

   .on("submit", "#save_item", function(e){
      e.preventDefault();
      var href = $(this).attr("action");

      $.ajax({
            url: href,
            method: "post",
            data:$(this).serialize(),
            beforeSend: function(){
               $(".modal-content").addClass("csspinner load1");
            },
            success: function() {
               window.location.reload();
            }
         })
   })

   // send email print to recepient email:-
   .on("submit", "#send_print_email", function(e){
      e.preventDefault();
      var doc_id = $(".select-doc.active").attr("doc");
      var template = $(".doc-"+doc_id).children("div.doc-desc").html();
      if($(this).valid()) 
      {
         $.ajax({
            url: "<?php echo base_url("claim/send_print_email_claim") ?>",
            method: "post",
            data:{
               email:$("#send_print_email input[name=email]").val(), 
               street_no:$("#send_print_email  input[name=street_no_email]").val(), 
               street_name:$("#send_print_email  input[name=street_name_email]").val(), 
               city:$("#send_print_email  input[name=city_email]").val(), 
               province:$("#send_print_email  select[name=province_email]").val(), 
               template:template,
               case_id: "<?php echo $claim_details['id']; ?>",
               doc: $("#send_print_email .select-doc.active").text()
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

   // once user clicked on accept button 
   .on("click", "input[name=Accept]", function(){
      if(confirm('Are you sure you want to accept claim')){
         // redirect to payment page
         window.location = "<?php echo base_url("claim/payment?claim=".$claim_details['id']); ?>";
      } else {
         return false;
      }
   })

   // once user clicked on accept button 
   .on("click", "input[name=Deny]", function(){
      if(confirm('Are you sure you want to deny claim')){
         // deny claim and close its details 

      } else {
         return false;
      }
   })

// create input boxes where the requirement need
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