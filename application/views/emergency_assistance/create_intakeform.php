<duv >
   <div class="page-title">
      <div class="title_left">
         <h3>Create Intake Form</h3>         
      </div>
   </div>
   <div class="clearfix"></div>

   <!-- Create Intake Form Section -->
   <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
         <div class="x_panel">

            <div class="x_title">
               <h2>Intake Form Detail<small></small></h2>
               <div class="clearfix"></div>
            </div>
            <div class="x_content">  
              <?php echo form_open("", array('class'=>'form-horizontal', 'method'=>'post')); ?>
                <div class="row">
                  <div class="form-group col-sm-6">
                     <?php 
                        echo form_label('Intake Form #:', 'form_id', array("class"=>'col-sm-12'));                               
                        echo form_input("form_id", $this->input->post("form_id"), array("class"=>"form-control", 'placeholder'=>'Intake Form #'));
                     ?>
                  </div>              
                  <div class="form-group col-sm-6">
                     <?php      
                     echo form_label('Create Date:', 'create_date', array("class"=>'col-sm-12'));        
                     echo form_input("create_date", date("Y-m-d H:i:s"), array("class"=>"form-control", 'placeholder'=>'Create Date'));
                     ?>
                  </div>
                  <div class="form-group col-sm-6">
                     <?php 
                        echo form_label('Create By:', 'create_by', array("class"=>'col-sm-12'));                               
                        echo form_input("create_by", $this->input->post("create_by"), array("class"=>"form-control", 'placeholder'=>'Create By'));
                     ?>
                  </div>  
                  <div class="form-group col-sm-12">
                     <?php 
                        echo form_label('Intake Notes:', 'intake_notes', array("class"=>'col-sm-12'));                               
                        echo form_textarea("intake_notes", $this->input->post("intake_notes"), array("class"=>"form-control", 'placeholder'=>'Intake Notes'));
                     ?>
                  </div>  
                         
                  <div class="col-sm-6">
                     <label class="col-sm-12">&nbsp;</label>
                     <button class="btn btn-primary">Save</button>
                     <button class="btn btn-primary">Upload Attached</button>
                     <?php echo anchor("emergency_assistance/create_case", 'Cancel', array("class"=>'btn btn-info')) ?>
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