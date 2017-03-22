<duv>
<?php $edit = $claim_details['status'] <> 'paid' and $claim_details['status'] <> 'closed' and $claim_details['status'] <> 'accepted'; ?>
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
            <?php echo $message; ?>
            <div class="x_title">
               <h2>CLAIM HISTORY<small></small></h2>
               <div class="clearfix"></div>
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
                                 <tr class="select_claim row-link" data='<?php echo json_encode($value) ?>' alt="<?php echo $value['claim_id']; ?>" case_no="<?php echo $value['case_no']; ?>">
                                    <td><?php echo $value['claim_no']; ?></td>
                                    <td><?php echo $value['case_no']; ?></td>
                                    <td><?php echo $value['claim_date']; ?></td>
                                    <td><?php echo $value['amount_claimed']?$value['amount_claimed']:0; ?></td>
                                    <td><?php echo $value['amount_client_paid']?$value['amount_client_paid']:0; ?></td>
                                    <td><?php echo $value['payee_name']?$value['payee_name']:$value['provider_name']; ?></td>
                                    <td><?php //echo $value['claim_no']; ?></td>
                                    <td><?php echo $value['amt_received']?$value['amt_received']:0; ?></td>
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
                                 <th>Claim Item No</th>
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
                              $amount_payble = 0;
                              foreach ($expenses as $key => $value): $value['count'] = $i; $amount_payble += $value['amt_payable']; ?>
                                 <tr class="edit_claim row-link <?php if($value['status']=='record_exempt') echo 'claim_record_exempt'; ?>" alt="<?php echo $value['id'] ?>" attr='<?php echo json_encode($value); ?>'>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $value['claim_no'] ?></td>
                                    <td><?php echo $value['claim_item_no'] ?></td>
                                    <td><?php echo $value['invoice'] ?></td>
                                    <td><?php echo $value['date_of_service'] ?></td>
                                    <td><?php echo $value['coverage_code'] ?></td>
                                    <td><?php echo $value['diagnosis'] ?></td>
                                    <td><?php echo $value['amount_claimed']?$value['amount_claimed']:0 ?></td>
                                    <td><?php echo $value['amt_payable']?$value['amt_payable']:0 ?></td>
                                    <td><?php echo $value['amt_deductable']?$value['amt_deductable']:0 ?></td>
                                    <td><?php echo $value['amt_insured']?$value['amt_insured']:0 ?></td>
                                    <td><?php echo $value['amt_received']?$value['amt_received']:0 ?></td>
                                    <td><?php echo $value['comment'] ?></td>
                                 </tr>
                           <?php $i++;endforeach; ?>
                           </tbody>
                        </table>
                        <?php echo form_hidden('total_amount_payble', $amount_payble); ?>
                     </div>
                  </div>
                  <!-- prepare expenses list used to fill in explanation of benifit doc -->
                  <div style="display:none" id="claim-items">
                     <table style="margin-bottom: 14px;" width="100%" border="1">
                        <thead>
                           <tr>
                              <th>Service Description</th>
                              <th>Date of Service</th>
                              <th>Claim Amount</th>
                              <th>Payable Amount</th>
                              <th>Claim Notes</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php
                           if(!empty($expenses)):
                              $claim_total = $payable = 0;
                              foreach ($expenses as $key => $value):
                                 $claim_total+=$value['amount_claimed'];  $payable += $value['amt_payable'];
                                 ?>
                              <tr>
                                 <td><?php echo $value['service_description'] ?></td><td><?php echo $value['date_of_service'] ?></td><td><?php echo $value['amount_claimed'] ?></td><td>$<?php echo $value['amt_payable'] ?></td><td><?php echo $value['comment'] ?></td>
                              </tr>
                              <?php
                              endforeach;
                           else: 
                              ?>
                              <tr>
                                 <td colspan="20">No records available</td>
                              </tr>
                           <?php

                           endif;
                           ?>      
                        <tr>
                           <td></td><th>Totals:</th><td>$<?php  echo $claim_total; ?></td><td>$<?php  echo $payable; ?></td><td></td>
                        </tr>
                        </tbody>
                     </table>
                  </div>

                  <div class="edit-claim-item" style="display:none">
                     <h4 class="claim-label">##########</h4>
                     <div class="row">
                        <div class="form-group col-sm-3">
                           <?php
                              echo form_hidden("id");
                              echo form_hidden("claim_id");
                              echo form_label('Claim No.:', 'claim_no', array("class"=>'col-sm-12'));
                              echo form_input("claim_no", $this->input->post("claim_no"), array("class"=>"form-control required", 'placeholder'=>'Claim No.', 'readonly'=>'readonly'));
                           ?>
                        </div>
                        <div class="form-group col-sm-3">
                           <?php
                              echo form_label('Pay To:', 'pay_to', array("class"=>'col-sm-12'));
                              $options = array(
                                 ''=>'--Select Payee--'
                                 );
                              echo form_dropdown('pay_to', $options, '', array('class'=>'form-control required'));
                           ?>
                        </div>
                        <div class="form-group col-sm-3">
                           <?php
                              echo form_label('Case No:', 'case_no', array("class"=>'col-sm-12'));
                              echo form_input("case_no", $this->input->post("case_no"), array("class"=>"form-control", 'placeholder'=>'Case No', 'readonly'=>'readonly' ));
                           ?>
                        </div>
                        <div class="form-group col-sm-3">
                           <?php
                              echo form_label('Invoice No:', 'invoice', array("class"=>'col-sm-12'));
                              echo form_input("invoice", $this->input->post("invoice"), array("class"=>"form-control required", 'placeholder'=>'Invoice No'));
                           ?>
                        </div>

                        <div class="form-group col-sm-3">
                           <?php echo form_label('Claim Date:', 'claim_date', array("class"=>'col-sm-12'));   ?>
                           <div class="input-group date">
                              <?php
                              echo form_input("claim_date", $this->input->post("claim_date"), array("class"=>"form-control datepicker required", 'placeholder'=>'Claim Date'));
                              ?>
                              <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                           </div>
                        </div>

                        <div class="form-group col-sm-3">
                           <?php
                              echo form_label('Cellular:', 'cellular', array("class"=>'col-sm-12'));
                              echo form_input("cellular", $this->input->post("cellular"), array("class"=>"form-control required", 'placeholder'=>'Cellular'));
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
                              echo form_dropdown("coverage_code", $coverage_code, $this->input->get("coverage_code"), array("class"=>'form-control required', 'placeholder'=>'Coverage Code'));
                           ?>
                        </div>
                        <div class="form-group col-sm-3">
                           <?php
                              echo form_label('Amt Client Paid:', 'amount_client_paid', array("class"=>'col-sm-12'));
                              echo form_input("amount_client_paid", $this->input->post("amount_client_paid"), array("class"=>"form-control required", 'placeholder'=>'Amt Client Paid'));
                           ?>
                        </div>
                        <div class="form-group col-sm-3">
                           <?php
                              echo form_label('Reason:', 'reason', array("class"=>'col-sm-12'));
                              echo form_input("reason", $this->input->post("reason"), array("class"=>"form-control required", 'placeholder'=>'Reason'));
                           ?>
                        </div>
                        <div class="form-group col-sm-3">
                           <?php
                              echo form_label('Diagnosis:', 'diagnosis', array("class"=>'col-sm-12'));
                              echo form_input("diagnosis", $this->input->post("diagnosis"), array("class"=>"form-control autocomplete_field required", 'placeholder'=>'Diagnosis'));
                           ?>
                        </div>
                        <div class="form-group col-sm-3">
                           <?php
                              echo form_label('Amt Claimed:', 'amount_claimed', array("class"=>'col-sm-12'));
                              echo form_input("amount_claimed", $this->input->post("amount_claimed"), array("class"=>"form-control required", 'placeholder'=>'Amt Claimed'));
                           ?>
                        </div>
                        <div class="form-group col-sm-3">
                           <?php
                              echo form_label('Amt Deductable:', 'amt_deductable', array("class"=>'col-sm-12'));
                              echo form_input("amt_deductable", $this->input->post("amt_deductable"), array("class"=>"form-control required", 'placeholder'=>'Amt Deductable'));
                           ?>
                        </div>
                        <div class="form-group col-sm-3">
                           <?php
                              echo form_label('Amt Insured:', 'amt_insured', array("class"=>'col-sm-12'));
                              echo form_input("amt_insured", $this->input->post("amt_insured"), array("class"=>"form-control required", 'placeholder'=>'Amt Insured'));
                           ?>
                        </div>
                        <div class="form-group col-sm-3">
                           <?php
                              echo form_label('Amt Received:', 'amt_received', array("class"=>'col-sm-12'));
                              echo form_input("amt_received", $this->input->post("amt_received"), array("class"=>"form-control required", 'placeholder'=>'Amt Received'));
                           ?>
                        </div>
                        <div class="form-group col-sm-3">
                           <?php
                              echo form_label('Amt Payable:', 'amt_payable', array("class"=>'col-sm-12'));
                              echo form_input("amt_payable", $this->input->post("amt_payable"), array("class"=>"form-control required", 'placeholder'=>'Amt Payable'));
                           ?>
                        </div>
                        <div class="form-group col-sm-3">
                           <?php
                              echo form_label('Comment:', 'comment', array("class"=>'col-sm-12'));
                              echo form_input("comment", $this->input->post("comment"), array("class"=>"form-control", 'placeholder'=>'Comment'));
                           ?>
                        </div>
                        <div class="form-group col-sm-3">
                           <?php
                              echo form_label('Recovery Name:', 'recovery_name', array("class"=>'col-sm-12'));
                              echo form_input("recovery_name", $this->input->post("recovery_name"), array("class"=>"form-control", 'placeholder'=>'Recovery Name'));
                           ?>
                        </div>
                        <div class="form-group col-sm-3">
                           <?php
                              echo form_label('Recovery Amt:', 'recovery_amt', array("class"=>'col-sm-12'));
                              echo form_input("recovery_amt", $this->input->post("recovery_amt"), array("class"=>"form-control", 'placeholder'=>'Recovery Amount'));
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
               <div class="row actions" style="margin-top:20px;">
                  <div class="row">
                     <?php if($edit): ?>                     
                        <div class="col-sm-2 item_specific" style="display:none">
                           <input class="btn btn-primary" name="Save" value="Save" type="submit">
                        </div>
                     <?php endif;?>
                     <div class="col-sm-2">
                        <?php echo anchor("claim", "Cancel", array("class"=>'btn btn-primary')); ?>
                     </div>
                     <?php if($edit): ?>   
                        <div class="col-sm-2 investigate_pending">
                           <input class="btn btn-primary" name="Investigate Pending" value="Investigate Pending" type="button">
                        </div>
                     <?php endif;?>
                  </div>

                  <div class="row" style="margin-top: 20px;">
                     <div class="col-sm-2">
                        <label style="float: right; font-size: 25px;"> Decision </label>
                     </div>
                     <div class="col-sm-3 my_decision" style="display:none">
                        &nbsp;
                     </div>

                     <?php if($edit): ?>  
                        <div class="col-sm-2 accept_decision">
                           <input class="btn btn-primary" name="Accept" value="Accept" type="button">
                        </div>
                        <div class="col-sm-1 deny_decision">
                           <input class="btn btn-primary" name="Deny" value="Deny" type="button">
                        </div>
                        <div class="col-sm-2 deny_reasons" style="display:none">
                           <?php
                           $reason = array(
                              ''=>'--Denial Reason--'
                              );
                           foreach($docs as $doc)
                              $reason[$doc['id']] = $doc['name'];

                           echo form_dropdown("deny_reason", $reason, '', array('class'=>'form-control'))
                           ?>
                        </div>
                        <div class="col-sm-2">
                           <input class="btn btn-primary email_print" data-toggle="modal"  name="Email" value="Email/Print" type="button" data-target="#print_template">
                        </div>
                        <div class="col-sm-2 record_exempt">
                           <input class="btn btn-primary" name="Record Exempt" value="Record Exempt" type="button">
                        </div>
                     <?php endif;?>

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
      <div class="modal-body reload_docs">
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
                              '{otc_logo_big}',
                              '{current_date}'
                              );
                           $replace = array(
                              img(array('src'=>'assets/img/otc.jpg','width'=>'130')),
                              img(array('src'=>'assets/img/otc_big.jpg','width'=>'262')),
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
<div style="display:none">
   <div id="products">
      <?php echo $products; ?>
   </div>
</div>

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

<!-- word templates here -->
<div style="display:none" class="word_templates">
<?php if(!empty($word_templates)): ?>
   <ul>
   <?php foreach($word_templates as $tmp): ?>
      <li style='list-style: outside none none;'><?php echo form_checkbox('word_doc', $tmp['content']).' <b>'.$tmp['title'].'</b>: '.$tmp['content'] ?></li>
   <?php endforeach; ?>
   </ul>
<?php endif; ?>
</div>

<script src="<?php echo base_url() ?>/assets/js/jQuery.print.js"></script>
<script src="<?php echo base_url() ?>/assets/js/jquery.validate.min.js"></script>
<?php echo link_tag('assets/css/bootstrap-datepicker.css'); ?>
<script src="<?php echo base_url() ?>/assets/js/bootstrap-datetimepicker.js"></script>
<script>
   $(document).ready(function() {

      var amt_payable = 0;
      // enable buttons according to claim Decision
      var decision = "<?php echo @$claim_details['status']; ?>"
      if(decision == ''){
         $(".accept_decision, .deny_decision, .record_exempt, .investigate_pending").show();
         $(".my_decision").hide();
      } else {
         if(decision == 'accepted' || decision == 'denied' || decision == 'paid')
            $(".accept_decision, .deny_decision, .record_exempt, .investigate_pending").hide();
         else
            $(".accept_decision, .deny_decision, .record_exempt, .investigate_pending").show();

         $(".my_decision").show().html('<label style="float: left; font-size: 25px;">: '+decision+' </label>');
      }

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

   // fill autofill on key type
   .on("keyup", ".company_name input", function(){
      $(".company_name input").val($(this).val());
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
      var data = $("input[name=policy_info]").val()?$.parseJSON($("input[name=policy_info]").val()):'';

      // parse case data details
      var claim_data = $.parseJSON($(".select_claim.active-green").attr('data'));

      // replace string from casemanager name etc
      var str = $(".doc-"+id+"  .doc-desc").html();
      str = str.replace(/{insured_name}/gi, claim_data.insured_first_name+' '+claim_data.insured_last_name)
      .replace(/{claimant_name}/gi, claim_data.insured_first_name+' '+claim_data.insured_last_name)
      .replace("{insured_address}", claim_data.street_address+' '+claim_data.city+' '+claim_data.province)
      .replace("{insured_lastname}", claim_data.insured_last_name)
      .replace("{policy_no}", claim_data.policy_no)
      .replace("{case_no}", claim_data.case_no)
      .replace("{policy_coverage_info}", "{policy_coverage_info}")
      .replace("{casemanager_name}", '<?php echo $this->ion_auth->user()->row()->first_name ?>')
      .replace("{claimexaminer_name}", claim_data.claimexaminer_name)
      .replace("{current_date_+_90}", '<?php echo date('Y-m-d', strtotime(' + 90 days')) ?>')

      .replace("{clinic_name}", claim_data.clinic_name)
      .replace("{insured_dob}", claim_data.dob)

      .replace("{policy_holder}", claim_data.insured_first_name+' '+claim_data.insured_last_name)
      .replace("{policy_no}", claim_data.policy_no)
      .replace("{policy_no}", claim_data.policy_no);
      if(data)
         str = str.replace("{coverage_period}", data[0].effective_date+" to "+data[0].expiry_date);
      else
        str =  str.replace("{coverage_period}", '');

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

         // show selected word templates
         $(".outer_custom_comment").each(function(){
            var text = [];
            $("input[name=word_doc]:checked").each(function(){
               text.push(" - "+$(this).val());
            })
            var text = text.join("<br>");
            text += "<br>";
            $(this).html(text.replace(/\n/g, "<br>"));
            $(this).children('ul').remove();
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

         // create word template selection for deny reason
         var $outer = $(".outer_custom_comment");
         $outer.each(function(){
            var text = $.trim($('.word_templates').html());

            $(this).empty();
            $(this).append(text);
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

   // to load, show/hide contents
   .on("click", ".move_down", function(){
      $(this).next("div.row").slideToggle();
      $(this).children("i").toggleClass("fa-angle-up").toggleClass("fa-angle-down");
   })

   .on("click", ".edit_claim", function(){

      $("input").removeClass('error-true');
      <?php

      $str = "";
      if(!empty($custom_payees))
         foreach ($custom_payees as $key => $value) {
            $str .= '<option value="'.$value['payee_name'].'">'.$value['payee_name'].'</option>';
         }

      if($str){
         ?>
         $("select[name=pay_to]").html('<?php echo $str; ?>');
         <?php
      }
      ?>

      // settings for activate listing
      $(".edit_claim").removeClass('active-green');
      $(this).addClass('active-green');

      var data = $.parseJSON($(this).attr("attr"));

      // place all values to input fields
      var decision = "";
      $.each(data, function( index, value ) {
         $(".edit-claim-item input[name="+index+"]").val(value);
         $(".edit-claim-item select[name="+index+"]").val(value);
         if(index == 'status')
            decision = value;

         if(index == 'amt_payable'){
            value = parseFloat(value);
            amt_payable = value;
         }
      });

      // change label
      $(".claim-label").text("Edit Claim("+(data.claim_no?data.claim_no:'#####')+") No."+data.count);

      $(".edit-claim-item, .item_specific").show();

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
      if($(this).valid())
      {
         $(".preview-template").trigger('click');
         var template = $(".doc-"+doc_id).children("div.doc-desc").html();
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

   // change value of total payable
   // .on("keyup", "input[name=amt_payable]", function(){
   //    $("input[name=total_amount_payble]").val($(this).val()) ;
   // })

   // once user clicked on accept button
   .on("click", "input[name=Accept]", function(){

      // check total payble amount
      if(($("input[name=total_amount_payble]").val() == '0' || !$("input[name=total_amount_payble]").val()) && ($("input[name=amt_payable]").val() == '0' || !$("input[name=amt_payable]").val())){
         alert("Please add payable amount to any claim item first to accept claim.")
         return false;
      }


      var policy_data = $("input[name=policy_info]").val()?$.parseJSON($("input[name=policy_info]").val()):[{"sum_insured":0}];
      var amount_insured = policy_data[0].sum_insured?policy_data[0].sum_insured:0;

      if(amount_insured > 0)
         if(amount_insured < (parseFloat($("input[name=total_amount_payble]").val()) - amt_payable + parseFloat($("input[name=amt_payable]").val()))){         
            alert("Payable amount should be less then insured amount($"+amount_insured+").");
            return false;
         }

      if(confirm('Are you sure you want to accept claim?')){

         var href = $("#save_item").attr("action");

         $.ajax({
            url: href,
            method: "post",
            data:$("#save_item").serialize(),
            beforeSend: function(){
               $(".modal-content, .main_container").addClass("csspinner load1");
            },
            success: function() {
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
            }
         })
      } else {
         return false;
      }
   })

   // once user clicked on Investigate Pending button
   .on("click", "input[name='Investigate Pending']", function(){
      if(confirm('Are you sure you want to mark this claim as pending?')){

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
      if(confirm('Are you sure you want to mark this claim as record exempt?')){

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
   .on("change", "select[name=deny_reason]", function(){
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

      // hide edit claim section
      $(".edit-claim-item").hide();
      $(".item_specific").hide();

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

            // enable buttons according to claim Decision
            var decision = result.status;
            if(decision == ''){
               $(".accept_decision, .deny_decision, .record_exempt, .investigate_pending").show();
               $(".my_decision").hide();
            } else {
               if(decision == 'accepted' || decision == 'denied' || decision == 'paid')
                  $(".accept_decision, .deny_decision, .record_exempt, .investigate_pending").hide();
               else
                  $(".accept_decision, .deny_decision, .record_exempt, .investigate_pending").show();

               $(".my_decision").show().html('<label style="float: left; font-size: 25px;">: '+decision+' </label>');
            }
            $(".claim-items").html($("#claim-items").html())
         }
      });

      // reload all  claim docs
      $.ajax({
         url: "<?php echo base_url("claim/reload_docs") ?>",
         method: "post",
         dataType:"json",
         success: function(result) {
            $(".reload_docs").html(result.reload_docs);

            $(".preview-template, .email-intakeform, .print").attr('disabled','disabled')

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

            // create word template selection for deny reason
            var $outer = $(".outer_custom_comment");
            $outer.each(function(){
               var text = $.trim($('.word_templates').html());

               $(this).empty();
               $(this).append(text);
            });

            var $outer_select = $(".select-product");
            $outer_select.each(function(){
               var text = $.trim($(this).text());

               $(this).empty();
               $(this).append($("#products").html());
            });

            $(".claim-items").html($("#claim-items").html())

         }
      });
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
$(".claim-items").html($("#claim-items").html())

// create word template selection for deny reason
var $outer = $(".outer_custom_comment");
$outer.each(function(){
   var text = $.trim($('.word_templates').html());

   $(this).empty();
   $(this).append(text);
});

var $outer_select = $(".select-product");
$outer_select.each(function(){
   var text = $.trim($(this).text());

   $(this).empty();
   $(this).append($("#products").html());
});

</script>
