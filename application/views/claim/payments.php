<duv >
   <div class="page-title">
      <div class="title_left">
         <h3>Payments</h3>
      </div>
   </div>
   <div class="clearfix"></div>
   <!-- Product List Section -->
   <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
         <div class="x_panel">
            <div class="x_title">
            <button type="button" class="btn btn-primary" name="search_claim"><i class="fa fa-search"></i> Search Payable Claims</button>
            </div>
            <div class="x_content">
            <!-- search claim filter start -->       
               <?php echo form_open("", array('class'=>'form-horizontal', 'method'=>'get', 'id'=>'search_claim', 'style'=>'display:none')); ?>           
               <div class="row">           
                  <div class="form-group col-sm-3">
                     <?php       
                     echo form_label('Last Name:', 'lastname_claim', array("class"=>'col-sm-12'));    
                     echo form_input("lastname_claim", $this->input->get("lastname_claim"), array("class"=>"form-control", 'placeholder'=>'Last Name'));
                     ?>
                  </div> 
                  <div class="form-group col-sm-3">
                     <?php 
                     echo form_label('First Name:', 'firstname_claim', array("class"=>'col-sm-12'));               
                     echo form_input("firstname_claim", $this->input->get("firstname_claim"), array("class"=>"form-control", 'placeholder'=>'First Name'));
                     ?>
                  </div> 
                  <div class="form-group col-sm-3">
                     <?php
                     echo form_label('Policy Number:', 'policy_claim', array("class"=>'col-sm-12'));                  
                     echo form_input("policy_claim", $this->input->get("policy_claim"), array("class"=>"form-control", 'placeholder'=>'Policy Number'));
                     ?>
                  </div>  
                  <div class="form-group col-sm-3">
                     <?php
                     echo form_label('Claim Number:', 'claim_no_claim', array("class"=>'col-sm-12'));                  
                     echo form_input("claim_no_claim", $this->input->get("claim_no_claim"), array("class"=>"form-control", 'placeholder'=>'Claim Number'));
                     ?>
                  </div>
                  <div class="form-group col-sm-3">
                     <?php echo form_label('Claim Date From:', 'claim_date_from', array("class"=>'col-sm-12')); ?>
                     <div class="input-group date">
                        <?php    
                        echo form_input("claim_date_from", $this->input->get("claim_date_from"), array("class"=>"form-control datepicker", 'placeholder'=>'Claim Date From'));
                        ?>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                     </div>
                  </div>
                  <div class="form-group col-sm-3">
                     <?php echo form_label('Claim Date To:', 'claim_date_to', array("class"=>'col-sm-12')); ?>
                     <div class="input-group date">
                        <?php 
                        echo form_input("claim_date_to", $this->input->get("claim_date_to"), array("class"=>"form-control datepicker", 'placeholder'=>'Claim Date To'));
                        ?>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                     </div>
                  </div>
                  <div class="col-sm-3">
                     <label class="col-sm-12">&nbsp;</label>
                     <button class="btn btn-primary" name="filter" value="claim">Display Claim</button>
                  </div>
               </div> 
               <?php echo form_close(); ?>
               <!-- search claim filter end -->
               <div class="clearfix"><br/></div>
               
               <div class="table-responsive">
                  <?php 
                  $i = 0;
                  if(!empty($claims)):?>
                        <table class="table table-hover table-bordered">
                           <thead>
                              <tr>
                                 <th>No.</th>
                                 <th>Claim No.</th>
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
                                 <tr class="row-link select_payees" alt="<?php echo $val['claim_id'] ?>">
                                    <td><?php echo ++$i; ?>.</td>
                                    <td><?php echo $val['claim_no'] ?></td>
                                    <td><?php echo $val['invoice'] ?></td>
                                    <td><?php echo $val['date_of_service'] ?></td>
                                    <td><?php echo $val['coverage_code'] ?></td>
                                    <td><?php echo $val['diagnosis'] ?></td>
                                    <td><?php echo $val['amount_claimed'] ?></td>
                                    <td><?php echo $val['amt_payable'] ?></td>
                                    <td><?php echo $val['amt_deductable'] ?></td>
                                    <td><?php echo $val['amt_insured'] ?></td>
                                    <td><?php echo $val['provider_name']?$val['provider_name']:$val['payee_name'] ?></td>
                                 </tr>
                           <?php  endforeach; ?>
                           </tbody>
                        </table>
                  <?php endif; ?>
               </div>
               <div class="payee_section" style="display:none">
                  <h2>PAYEE INFORMATION<small></small></h2>
                  <?php echo form_open("claim/confirm_payment", array('class'=>'form-horizontal', 'method'=>'post', 'id'=>'confirm_payment')); echo form_hidden('claim_id') ?>
                  <div class="row">
                     <div class="col-sm-12">
                        <div class="col-sm-3">
                           <button class="btn btn-primary add_payee" name="filter" type="button" value="claim">Add a Payees</button>
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-sm-12 payees_items">
                        <div class="payee-data">                                                     
                        </div>
                     </div>
                  </div>
                  <div class="row" style="margin-top:20px">
                     <div class="col-sm-2">
                        <input class="btn btn-primary" name="Confirm_Payment" value="Confirm Payment" type="submit">   
                     </div>
                     <div class="col-sm-1">
                        <?php echo anchor("claim", "Cancel", array("class"=>'btn btn-primary')); ?>
                     </div>
                     <div class="col-sm-2"> 
                        <input class="btn btn-primary" name="Close_Claim" value="Close Claim" type="button">  
                     </div>
                  </div>
                  <?php echo form_close(); ?>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- End List Section -->
</duv>

<div style="display:none">
   <div class="payee-buffer">
      <div class="row"  style="border: 1px solid rgb(204, 204, 204); padding: 10px; margin-bottom: 9px">
         <div class="col-sm-12">
            <div class="col-sm-2">
               <?php 
               echo form_radio("payment_type", "cheque", TRUE, array('class'=>'setpremium'));
               echo form_label('Cheque:', 'Cheque');
               ?>  
            </div>
            <div class="col-sm-2">
               <?php 
               echo form_radio("payment_type", "direct deposit", FALSE, array('class'=>'setpremium'));
               echo form_label('Direct Deposit', 'Direct Deposit');
               ?>  
            </div>
         </div>
         <br/>
         <div class="col-sm-3 wire_transfer_section" style="display:none">
            <?php 
               echo form_label('Bank Name:', 'Bank Name', array("class"=>'col-sm-12'));
               echo form_input("payees[bank][]", $this->input->post("bank"), array("class"=>"form-control", 'placeholder'=>'Bank Name'));
            ?>
         </div>
         <div class="col-sm-3 cheque_section wire_transfer_section">
            <?php 
               echo form_label('Payee Name:', 'Payee Name', array("class"=>'col-sm-12'));
               echo form_input("payees[payee_name][]", $this->input->post("payee_name"), array("class"=>"form-control", 'placeholder'=>'Payee Name'));
            ?>
         </div>
         <div class="col-sm-3 wire_transfer_section" style="display:none">
            <?php 
               echo form_label('Account#:', 'Account', array("class"=>'col-sm-12'));
               echo form_input("payees[account_cheque][]", $this->input->post("account_cheque"), array("class"=>"form-control", 'placeholder'=>'Account#'));
            ?>
         </div>
         <div class="col-sm-3 cheque_section">
            <?php 
               echo form_label('Address:', 'Address', array("class"=>'col-sm-12'));
               echo form_input("payees[address][]", $this->input->post("address"), array("class"=>"form-control", 'placeholder'=>'Address'));
            ?>
         </div>
         <div class="col-sm-3">
            <label class='col-sm-12'>&nbsp;</label>
            <i class="col-sm-3 fa fa-trash row-link remove-payee"></i>
         </div>
      </div>
   </div>
</div>

<?php echo link_tag('assets/css/bootstrap-datepicker.css'); ?>
<script src="<?php echo base_url() ?>/assets/js/bootstrap-datetimepicker.js"></script>
<script>
$(document).ready(function() {
   $(".datepicker").datepicker({
        startDate: '-105y',
        endDate: '+2y',
    });
});
<?php
if(!empty($this->input->get())) 
{
 ?>
  $("#search_claim").show(); 
 <?php
}
?>
$(document).on("click", "button[name=search_claim]", function(){
   $("#search_claim").slideToggle("slow");
})
.on("click", ".add_payee", function(){
   var html = $(".payee-buffer").html();

   var length = $(".payee-data .row").length;

   html = html.replace(/payment_type/g, "payment_type_"+(length+1));

   $(".payee-data").append(html);
})
.on("click", ".remove-payee", function(){

   if(confirm('Are you sure you want to remove payee?')){
      $(this).parent("div").parent("div").remove();

      // remove payee from db if already stored
      var payee_id = $(this).parent("div").parent("div").find("input[name='payees[id][]']").val();
      if(payee_id){         
         $.ajax({
            url: "<?php echo base_url("claim/delete_payee/") ?>"+payee_id,
            method: "get"
         })
      }
   }

   // remap payment_type names to avoide errors
   $count = 0;
   $(".payee-data .row").map(function(){
      $count++;
      $(this).find('input[name^=payment_type]').attr('name', 'payment_type_'+$count);
   })
})
// when clicked on claim item history section
.on('click', ".select_payees", function(){
   var claim_id = $(this).attr('alt');

   // enable payee section
   $(".payee_section").slideDown();

   // settings for activate listing
   $(".select_payees").removeClass('active-green');
   $(this).addClass('active-green');

   // get claimed items here
   $.ajax({
      url: "<?php echo base_url("claim/select_payees") ?>",
      method: "post",
      data:{
         claim_id:claim_id, 
      },
      dataType:"json",
      beforeSend: function(){
         $(".main_container").addClass("csspinner load1");
      },
      success: function(result) {

         // place data table to releted section
         $(".payee-data").html(result.payees)

         // place claim id
         $("input[name=claim_id]").val(claim_id);

         // remove loader function
         $(".main_container").removeClass("csspinner load1");
         
      }
   })
})

.on("submit", "#confirm_payment", function(e){
   e.preventDefault();

   var claim_id = $(".select_payees.active-green").attr('alt');

   // confirm payment code goes here.
   $.ajax({
      url: $(this).attr("action"),
      method: "post",
      data:$(this).serialize(),
      dataType:"json",
      beforeSend: function(){
         $(".main_container").addClass("csspinner load1");
      },
      success: function(result) {
         window.location.reload();
      }
   })

})

.on("click", "input[name=Close_Claim]", function(e){
   e.preventDefault();
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
.on("click", "input[name^=payment_type]", function(){
   var element = $(this).parent("div").parent("div").parent("div");
   if($(this).val() == 'cheque'){
      element.find(".wire_transfer_section").hide();
      element.find(".cheque_section").show();
   } else {
      element.find(".cheque_section").hide();
      element.find(".wire_transfer_section").show();
   }
})

</script>