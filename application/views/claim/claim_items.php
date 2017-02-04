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
      if(!empty($expenses)):
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