<duv >
   <div class="page-title">
      <div class="title_left">
         <h3>Create Provider</h3>         
      </div>
   </div>
   <div class="clearfix"></div>

   <!-- Create Provider Section -->
   <div class="row">
      <?php echo $message; ?>
      <div class="col-md-12 col-sm-12 col-xs-12">
         <div class="x_panel">
            <div class="x_content">  
              <?php echo form_open("", array('class'=>'form-horizontal', 'method'=>'post')); ?>
                <div class="row">
                  <div class="form-group col-sm-6">
                     <?php 
                        echo form_label('Name:', 'name', array("class"=>'col-sm-12'));                               
                        echo form_input("name", $this->input->post("name"), array("class"=>"form-control", 'placeholder'=>'Name'));
                        echo form_error("discount");
                     ?>
                  </div>
                  <div class="form-group col-sm-6">
                     <?php      
                        echo form_label('Address:', 'address', array("class"=>'col-sm-12'));        
                        echo form_input("address", $this->input->post("address"), array("class"=>"form-control", 'placeholder'=>'Address'));
                        echo form_error("discount");
                     ?>
                  </div>
                  <div class="form-group col-sm-6">
                     <?php 
                        echo form_label('Postcode:', 'postcode', array("class"=>'col-sm-12'));                               
                        echo form_input("postcode", $this->input->post("postcode"), array("class"=>"form-control", 'placeholder'=>'Postcode'));
                        echo form_error("postcode");
                     ?>
                  </div>  
                  <div class="form-group col-sm-6">
                     <?php 
                        echo form_label('Discount:', 'discount', array("class"=>'col-sm-12'));                               
                        echo form_input("discount", $this->input->post("discount"), array("class"=>"form-control", 'placeholder'=>'Discount'));
                        echo form_error("discount");
                     ?>
                  </div>  
                  <div class="form-group col-sm-6">
                     <?php 
                        echo form_label('Contact Person:', 'contact_person', array("class"=>'col-sm-12'));                               
                        echo form_input("contact_person", $this->input->post("contact_person"), array("class"=>"form-control", 'placeholder'=>'Contact Person'));
                        echo form_error("contact_person");
                     ?>
                  </div>  
                  <div class="form-group col-sm-6">
                     <?php 
                        echo form_label('Phone No.:', 'phone_no', array("class"=>'col-sm-12'));                               
                        echo form_input("phone_no", $this->input->post("phone_no"), array("class"=>"form-control", 'placeholder'=>'Phone No.'));
                        echo form_error("phone_no");
                     ?>
                  </div>  
                  <div class="form-group col-sm-6">
                     <?php 
                        echo form_label('Email:', 'email', array("class"=>'col-sm-12'));                               
                        echo form_input("email", $this->input->post("email"), array("class"=>"form-control", 'placeholder'=>'Email'));
                        echo form_error("email");
                     ?>
                  </div>  
                  <div class="form-group col-sm-6">
                     <?php 
                        echo form_label('PPO Codes:', 'ppo_codes', array("class"=>'col-sm-12'));                               
                        echo form_input("ppo_codes", $this->input->post("ppo_codes"), array("class"=>"form-control", 'placeholder'=>'PPO Codes'));
                        echo form_error("ppo_codes");
                     ?>
                  </div>  
                  <div class="form-group col-sm-6">
                     <?php 
                        echo form_label('Services:', 'services', array("class"=>'col-sm-12'));                               
                        echo form_input("services", $this->input->post("services"), array("class"=>"form-control", 'placeholder'=>'Services'));
                        echo form_error("services");
                     ?>
                  </div> 
                  <div class="form-group col-sm-6">
                     <?php 
                        echo form_label('Priority:', 'priority', array("class"=>'col-sm-12'));  
                        $options = array(
                           ''=>'Select Priority',
                           '1'=>'1-Star',
                           '2'=>'2-Star',
                           '3'=>'3-Star',
                           '4'=>'4-Star',
                           '5'=>'5-Star',
                           );                             
                        echo form_dropdown("priority", $options,  $this->input->post("priority"), array("class"=>"form-control", 'placeholder'=>'Priority'));
                        echo form_error("priority");
                     ?>
                  </div>        
                  <div class="col-sm-6">
                     <label class="col-sm-12">&nbsp;</label>
                     <button class="btn btn-primary">Save</button>
                     <?php echo anchor("emergency_assistance/", "Cancel", array("class"=>'btn btn-info')) ?>
                     <button class="btn btn-primary">Batch upload From Excel</button>
                  </div>
               </div> 

               <?php echo form_close(); ?>
               <!-- search policy filter end -->

               <div class="clearfix"></div>
            </div>
         </div>
      </div>
   </div>

</duv>

<?php echo link_tag('assets/css/bootstrap-datepicker.css'); ?>
<script src="<?php echo base_url() ?>/assets/js/bootstrap-datetimepicker.js"></script>
<script>
$(document).ready(function() {
   $(".datepicker").datepicker({
        startDate: '-5y',
        endDate: '+2y',
    });
})
$(document).on("click",".more_filters", function(){
   $(".more_items").toggle();
})
</script>