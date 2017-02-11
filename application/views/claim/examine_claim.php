<duv>
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
               <?php if(!empty($claim_history)): ?>
                  <?php echo form_open_multipart("claim/save_item", array('class'=>'form-horizontal', 'method'=>'post', 'id'=>'save_item')); ?>
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
                                    <th>Pay To</th>
                                    <th>Cheque No</th>
                                    <th>Total Received</th>
                                 </tr>
                              </thead>
                              <tbody>
                                 <?php foreach ($claim_history as $key => $value): ?>
                                 <tr class="select_claim row-link" alt="<?php echo $value['claim_id']; ?>" case_no="<?php echo $value['case_no']; ?>">
                                    <td><?php echo $value['claim_no']; ?></td>
                                    <td><?php echo $value['case_no']; ?></td>
                                    <td><?php echo $value['claim_date']; ?></td>
                                    <td><?php echo $value['amount_claimed']; ?></td>
                                    <td><?php echo $value['amount_client_paid']; ?></td>
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
                     <div class="table-responsive claim_items">
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
                                 <tr class="edit_claim row-link <?php if($value['status']=='record_exempt') echo 'claim_record_exempt'; ?>" alt="<?php echo $value['id'] ?>" attr='<?php echo json_encode($value); ?>'>
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
                     <h4 class="claim-label">##########</h4>
                     <div class="row">
                        <div class="form-group col-sm-3">
                           <?php 
                              echo form_hidden("id");
                              echo form_hidden("claim_id");
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
                              echo form_label('Case No:', 'case_no', array("class"=>'col-sm-12'));
                              echo form_input("case_no", $this->input->post("case_no"), array("class"=>"form-control", 'placeholder'=>'Case No'));
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
                              echo form_dropdown("coverage_code", $coverage_code, $this->input->get("coverage_code"), array("class"=>'form-control', 'placeholder'=>'Coverage Code'));
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
                              echo form_input("diagnosis", $this->input->post("diagnosis"), array("class"=>"form-control autocomplete_field", 'placeholder'=>'Diagnosis'));
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
                     </div> 
                  </div>

                  <hr/>
                  <h4 style="margin-top:25px;">POLICY INFO</h4>
                  <div class="row policy_info">
                     <?php echo $policy_info;  ?>
                  </div>
               <hr/>

               <h4 style="margin-top:35px;margin-bottom:26px;">CASE INFO </h4>
               <div class="case_info">
                  <?php echo $case_info; ?>
               </div>
               <div class="row actions" style="margin-top:20px; display:none">
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
                     <div class="col-sm-2 deny_reasons" style="display:none"> 
                        <?php
                        $reason = array(
                           ''=>'--Denial Reason--'                           
                           );
                        foreach($docs as $doc)
                           $reason[$doc['id']] = $doc['name'];

                        echo form_dropdown("reason", $reason, '', array('class'=>'form-control'))
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
               
               <?php endif;?>
               
            </div>
         </div>
      </div>
   </div>
</duv>

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
                     echo form_hidden('type', 'email'); // used for which action need to perform "email or deny claim"
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

      $("tr[alt=<?php echo $id; ?>]").addClass('active-green');
      $(".datepicker").datepicker({
           startDate: '-105y',
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

   .on("click", ".email_print", function(){
         $("input[name=type]").val("email");  
         $(".email-intakeform").text("Email");    
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
         $(this).parent("div").parent("div").parent("div.intake-forms").remove();

         $.ajax({
            url: "<?php echo base_url("emergency_assistance/deleteform/") ?>"+id,
            method: "get"
         })
      } else {
         return false;
      }
   })

   
   // delete attached document
   .on("click",".remove_doc", function(e){

      e.preventDefault();

      var link = $(this).parent('a').attr("href");

      if(confirm('Are you sure you want to delete? '))
      {
         // remove form area instant to make it visible fast
         $(this).parent("a").parent("div").remove();

         $.ajax({
            url: link,
            method: "get"
         })
      } else {
         return false;
      }
   })

     // once user clicked on same with policy button
   .on("click", "#mail_address", function(){

      // get local data
      var data = $.parseJSON($("input[name=policy_info]").val());
      if($(this).is(":checked"))
      {
         // fill all json values to address fields
         $("input[name=street_no_email]").val(data.street_number);
         $("input[name=street_name_email]").val(data.street_name);
         $("input[name=city_email]").val(data.city);
         $("select[name=province_email]").val(data.province2);
      }
      else
      {
         $("input[name=street_no_email],input[name=street_name_email],input[name=city_email],select[name=province_email]").val("");
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
      $(this).next("div.row").slideToggle();
      $(this).children("i").toggleClass("fa-angle-up").toggleClass("fa-angle-down");
   })

   .on("click", ".edit_claim", function(){

      // settings for activate listing
      $(".edit_claim").removeClass('active-green');
      $(this).addClass('active-green');

      var data = $.parseJSON($(this).attr("attr"));

      // place all values to input fields
      $.each(data, function( index, value ) {
         $(".edit-claim-item input[name="+index+"]").val(value);
         $(".edit-claim-item select[name="+index+"]").val(value);
      });

      // change label
      $(".claim-label").text("Edit Claim("+(data.claim_no?data.claim_no:'#####')+") No."+data.count);

      $(".edit-claim-item").show();

      // enable diagnosis fuzzy search
      $(".autocomplete_field").autocomplete({
        serviceUrl: "<?php echo base_url()."claim/search_diagnosis/description"; ?>" ,
        minLength: 2,
        dataType: "json",
      });

      // enable all buttons
      $(".actions").show();
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
               case_id: $(".select_claim.active-green").attr('alt'),
               claim_item_id:$(".edit_claim.active-green").attr('alt'), 
               doc: $("#send_print_email .select-doc.active").text(),
               type: $("#send_print_email input[name=type]").val()
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
      if(confirm('Are you sure you want to accept claim item?')){

         $.ajax({
            url: "<?php echo base_url("claim/status/accepted") ?>",
            method: "post",
            data:{
               claim_id:$(".select_claim.active-green").attr('alt'), 
               claim_item_id:$(".edit_claim.active-green").attr('alt'), 
            },
            beforeSend: function(){
               $(".main_container").addClass("csspinner load1");
            },
            success: function() {
               window.location.reload();
            }
         })
      } else {
         return false;
      }
   })

   // once user clicked on Investigate Pending button 
   .on("click", "input[name='Investigate Pending']", function(){
      if(confirm('Are you sure you want to mark this claim item as pending?')){

         $.ajax({
            url: "<?php echo base_url("claim/status/pending") ?>",
            method: "post",
            data:{
               claim_id:$(".select_claim.active-green").attr('alt'), 
               claim_item_id:$(".edit_claim.active-green").attr('alt'), 
            },
            beforeSend: function(){
               $(".main_container").addClass("csspinner load1");
            },
            success: function() {
               window.location.reload();
            }
         })
      } else {
         return false;
      }
   })

   // once user clicked on Investigate Pending button 
   .on("click", "input[name='Record Exempt']", function(){
      if(confirm('Are you sure you want to mark this claim item as record exempt?')){

         $.ajax({
            url: "<?php echo base_url("claim/status/record_exempt") ?>",
            method: "post",
            data:{
               claim_id:$(".select_claim.active-green").attr('alt'), 
               claim_item_id:$(".edit_claim.active-green").attr('alt'), 
            },
            beforeSend: function(){
               $(".main_container").addClass("csspinner load1");
            },
            success: function() {
               window.location.reload();
            }
         })
      } else {
         return false;
      }
   })

   // when clicked over deny button
   .on("click", "input[name=Deny]", function(){
      $(".deny_reasons").show();
   })

   // when user select any deny reason
   .on("change", "select[name=reason]", function(){
      if($(this).val()) {
          if(confirm('Are you sure you want to deny claim?')){

            // change email button label
            $(".email-intakeform").text("Email and Deny Claim");

            // deny claim and close its details      
            $("input[name=type]").val("deny");
            $('#print_template').modal('show'); 
            $("div[doc="+$(this).val()+"]").trigger('click');
         } else {
            return false;
         }
      }
   })

   // when clicked on claim item history section
   .on('click', ".select_claim", function(){
      var claim_id = $(this).attr('alt');
      var case_no = $(this).attr('case_no');

      // settings for activate listing
      $(".select_claim").removeClass('active-green');
      $(this).addClass('active-green');

      // get claimed items here
      $.ajax({
         url: "<?php echo base_url("claim/claim_items") ?>",
         method: "post",
         data:{
            claim_id:claim_id, 
            case_no:case_no, 
         },
         dataType:"json",
         beforeSend: function(){
            $(".main_container").addClass("csspinner load1");
         },
         success: function(result) {

            // place data table to releted section
            $(".claim_items").html(result.claim_items)
            $(".main_container").removeClass("csspinner load1");
            $(".case_info").html(result.case_info)
            $(".policy_info").html(result.policy_info)
            
         }
      })
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