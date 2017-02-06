<div class="form-group col-sm-4">
   <?php echo form_label('Arrival Date:', 'arrival_date', array("class"=>'col-sm-12'));   ?>
   <div class="input-group date">
      <?php           
      // get policy info here
      $policy_info = json_decode($claim_details['policy_info'], TRUE);
      $policy_info = @$policy_info[0];
      echo form_input("arrival_date", @$policy_info['arrival_date'], array("class"=>"form-control datepicker", 'placeholder'=>'Arrival Date'));
      ?>
      <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
   </div>
</div>
<div class="form-group col-sm-4">
   <?php echo form_label('Effective Date:', 'effective_date', array("class"=>'col-sm-12'));   ?>
   <div class="input-group date">
      <?php                
      echo form_input("effective_date", @$policy_info['effective_date'], array("class"=>"form-control datepicker", 'placeholder'=>'Effective Date'));
      ?>
      <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
   </div>
</div>
<div class="form-group col-sm-4">
   <?php echo form_label('Expiry Date:', 'expiry_date', array("class"=>'col-sm-12'));   ?>
   <div class="input-group date">
      <?php                
      echo form_input("expiry_date", @$policy_info['expiry_date'], array("class"=>"form-control datepicker", 'placeholder'=>'Expiry Date'));
      ?>
      <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
   </div>
</div>


<div class="form-group col-sm-4">
   <?php 
      echo form_label('Premium: $ '. @$policy_info['premium'], 'Premium', array("class"=>'col-sm-12'));
   ?>
</div>
<div class="form-group col-sm-4">
   <?php 
      echo form_label('Sum Insured: $ '.@$policy_info['sum_insured'], 'Sum Insured', array("class"=>'col-sm-12'));
   ?>
</div>
<div class="form-group col-sm-4">
   <?php 
      echo form_label('Deductable Amount: $ '.@$policy_info['deductible_amount'], 'Deductable Amount', array("class"=>'col-sm-12'));
   ?>
</div>
<div class="form-group col-sm-4">
   <?php 
      echo form_label('Pre-existion condition coverage:', 'existion_condition', array("class"=>'col-sm-12')); 
      $existion_condition = array(
            "With stable pre-existing condition coverage"=>'With stable pre-existing condition coverage',
            'Without stable pre-existing condition coverage'=>'Without stable pre-existing condition coverage'
         );
      echo form_dropdown("existion_condition", $existion_condition, $this->input->get("existion_condition"), array("class"=>'form-control'));
   ?>
</div>