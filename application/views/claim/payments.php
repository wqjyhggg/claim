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
                        <tr>
                           <td>1.</td>
                           <td>0001221</td>
                           <td>0012545</td>
                           <td>Tony Su</td>
                           <td>2016-10-23</td>
                           <td>Blood Test</td>
                           <td></td>
                           <td>100</td>
                           <td>500</td>
                           <td>10</td>
                           <td>Tomas</td>
                        </tr>
                     </tbody>
                  </table>
               </div>
               <h2>PAYEE INFORMATION<small></small></h2>
               <div class="row">
                  <div class="col-sm-12">
                     <div class="col-sm-3">
                        <?php 
                        echo form_radio("payment_type", "cheque", $this->input->post("payment_type"), array('class'=>'setpremium')); ?>  Cheque
                     </div>
                     <div class="col-sm-3">
                        <?php 
                        echo form_radio("payment_type", "wire transfer", $this->input->post("payment_type"), array('class'=>'setpremium')); ?>  Wire Transfer
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
                        </tbody>
                     </table>
                  </div>
               </div>
               <div class="row" style="margin-top:20px">
                  <div class="col-sm-2">
                     <input class="btn btn-primary" name="Confirm Payment" value="Confirm Payment" type="submit">   
                  </div>
                  <div class="col-sm-1">
                     <?php echo anchor("claim", "Cancel", array("class"=>'btn btn-primary')); ?>
                  </div>
                  <div class="col-sm-2"> 
                     <input class="btn btn-primary" name="Examine" value="Close Claim" type="submit">  
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- End List Section -->
</duv>

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

<script>
$(document).on("click", "button[name=search_claim]", function(){
   $("#search_claim").slideToggle("slow");
})

.on("click", ".add_payee", function(){
   var html = $(".payee-buffer").html();
   $(".payee-data").append(html);
})
.on("click", ".remove-payee", function(){
   $(this).parent("td").parent("tr").remove();
})
</script>