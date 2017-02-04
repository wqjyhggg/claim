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
                  echo form_hidden('payees[id][]', $value['id']);
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