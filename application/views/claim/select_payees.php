<?php                              
if(!empty($payees)): $i = 0;
   foreach ($payees as $key => $value): $i++; ?>
      <div class="row"  style="border: 1px solid rgb(204, 204, 204); padding: 10px; margin-bottom: 9px">
         <div class="col-sm-12">
            <div class="col-sm-2">
               <?php 
               echo form_radio("payment_type_".$i, "cheque", ($value["payment_type"] == 'cheque'?TRUE:FALSE), array('class'=>'setpremium'));
               echo form_label('Cheque:', 'Cheque');
               ?>  
            </div>
            <div class="col-sm-2">
               <?php 
               echo form_radio("payment_type_".$i, "direct deposit",  ($value["payment_type"] == 'direct deposit'?TRUE:FALSE), array('class'=>'setpremium'));
               echo form_label('Direct Deposit', 'Direct Deposit');
               echo form_hidden('payees[id][]', $value['id']);
               ?>  
            </div>
         </div>
         <br/>
         <div class="col-sm-3 wire_transfer_section" <?php echo ($value["payment_type"] <> 'direct deposit'?'style="display:none"':''); ?>>
            <?php 
               echo form_label('Bank Name:', 'Bank Name', array("class"=>'col-sm-12'));
               echo form_input("payees[bank][]", $value["bank"], array("class"=>"form-control", 'placeholder'=>'Bank Name'));
            ?>
         </div>
         <div class="col-sm-3 cheque_section wire_transfer_section">
            <?php 
               echo form_label('Payee Name:', 'Payee Name', array("class"=>'col-sm-12'));
               echo form_input("payees[payee_name][]", $value["payee_name"], array("class"=>"form-control", 'placeholder'=>'Payee Name'));
            ?>
         </div>
         <div class="col-sm-3 wire_transfer_section" <?php echo ($value["payment_type"] <> 'direct deposit'?'style="display:none"':''); ?>>
            <?php 
               echo form_label('Account#:', 'Account', array("class"=>'col-sm-12'));
               echo form_input("payees[account_cheque][]", $value["account_cheque"], array("class"=>"form-control", 'placeholder'=>'Account#'));
            ?>
         </div>
         <div class="col-sm-3 cheque_section" <?php echo ($value["payment_type"] == 'direct deposit'?'style="display:none"':''); ?>>
            <?php 
               echo form_label('Address:', 'Address', array("class"=>'col-sm-12'));
               echo form_input("payees[address][]", $value["address"], array("class"=>"form-control", 'placeholder'=>'Address'));
            ?>
         </div>
         <div class="col-sm-3">
            <?php 
               echo form_label('Payment:', 'Payment', array("class"=>'col-sm-12'));
               echo form_input("payees[payment][]", $value["payment"], array("class"=>"form-control", 'placeholder'=>'Payment'));
            ?>
         </div>
         <!-- <div class="col-sm-3">
            <label class='col-sm-12'>&nbsp;</label>
            <i class="col-sm-3 fa fa-trash row-link remove-payee"></i>
         </div> -->
      </div> 
<?php   
   endforeach;
endif;
?> 