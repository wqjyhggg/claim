<table class="table table-hover table-bordered">
   <thead>
      <tr>
         <th>No</th>
         <th>Claim No</th>
         <th>Claim Item No</th>
         <th>Invoice No</th>
         <th>Service Date</th>
         <th>Coverage</th>
         <!-- th>Diagnosis</th -->
         <th>Amt Claimed</th>
         <th>Amt Payable</th>
         <th>Amt Deductible</th>  
         <th>Amt Insured</th>  
         <th>Amt Received</th> 
         <th>Comment</th>                       
      </tr>
   </thead>
   <tbody>
      <?php 
      $i = 1;
      if(!empty($expenses)):
         $amount_payble = 0;
         foreach ($expenses as $key => $value): $value['count'] = $i; $amount_payble += $value['amt_payable']; ?>
            <tr class="edit_claim row-link  <?php if($value['status']=='record_exceptional') echo 'claim_record_exceptional'; ?>" alt="<?php echo $value['id']; ?>" attr='<?php echo json_encode($value); ?>'>
               <td><?php echo $i; ?></td>
               <td><?php echo $value['claim_no'] ?></td>
               <td><?php echo $value['claim_item_no'] ?></td>
               <td><?php echo $value['invoice'] ?></td>
               <td><?php echo $value['date_of_service'] ?></td>
               <td><?php echo $value['coverage_code'] ?></td>
               <!-- td><?php echo $value['diagnosis'] ?></td -->
               <td><?php echo $value['amount_claimed'] ?></td>
               <td><?php echo $value['amt_payable'] ?></td>
               <td><?php echo $value['amt_deductible'] ?></td>
               <td><?php echo $value['amt_insured'] ?></td>
               <td><?php echo $value['amt_received'] ?></td>
               <td><?php echo $value['comment'] ?></td>
            </tr>
         <?php 
            $i++;
         endforeach;
         else:
            ?>        
            <center><?php echo heading("No record available", 4); ?></center>
         <?php
      endif;
      ?>
   </tbody>
</table>
<?php echo form_hidden('total_amount_payble', $amount_payble); ?>
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