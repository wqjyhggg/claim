<div class="table-responsive">
<?php 
$i = 0;
if(!empty($claims)):?>
      <table class="table table-hover table-bordered">
         <thead>
            <tr>
               <th>No.</th>
               <th>Claim No.</th>
               <th>Claim Item No.</th>
               <th>Invoice No.</th>
               <th>Service Date</th>
               <th>Coverage</th>
               <th>Diagnosis</th>
               <th>Amt Claimed</th>
               <th>Amt Payable</th>
               <th>Amt Deductable</th>
               <th>Amt Insured</th>
               <th>Pay To</th>
         </thead>
         <tbody>
            <?php foreach($claims as $val): ?>
               <tr class="row-link select_payees" alt="<?php echo $val['claim_id'] ?>" pay_to="<?php echo $val['pay_to'] ?>" amt_payable="<?php echo $val['amt_payable'] ?>">
                  <td><?php echo ++$i; ?>.</td>
                  <td><?php echo $val['claim_no'] ?></td>
                  <td><?php echo $val['claim_item_no'] ?></td>
                  <td><?php echo $val['invoice'] ?></td>
                  <td><?php echo $val['date_of_service'] ?></td>
                  <td><?php echo $val['coverage_code'] ?></td>
                  <td><?php echo $val['diagnosis'] ?></td>
                  <td><?php echo $val['amount_claimed'] ?></td>
                  <td><?php echo $val['amt_payable'] ?></td>
                  <td><?php echo $val['amt_deductable'] ?></td>
                  <td><?php echo $val['amt_insured'] ?></td>
                  <td><?php echo $val['pay_to'] ?></td>
               </tr>
         <?php  endforeach; ?>
         </tbody>
      </table>
<?php endif; ?>
</div>