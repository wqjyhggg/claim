<duv >
   <div class="page-title">
      <div class="title_left">
         <h3>Edit Task</h3>
      </div>
   </div>
   <div class="clearfix"></div>

   <!-- Create Provider Section -->
   <div class="row">
      <?php echo $message; ?>
      <div class="col-md-12 col-sm-6 col-xs-12">
         <div class="x_panel">
            <div class="x_content">
              <?php echo form_open("", array('class'=>'form-horizontal', 'method'=>'post')); ?>
                <div class="row">
                  <div class="form-group col-sm-6">
                     <?php
                        echo form_label('Category:', 'category', array("class"=>'col-sm-12'));
                        ?>
                        <div class="form-group col-sm-12">
                           <?php echo $task_details['category']; ?>
                        </div>
                        <?php
                     ?>
                  </div>
                  <div class="form-group col-sm-6">
                     <?php
                        echo form_label('Case Number:', 'case_no', array("class"=>'col-sm-12'));
                        ?>
                        <div class="form-group col-sm-12">
                           <?php echo $task_details['task_no']; ?>
                        </div>
                        <?php
                     ?>
                  </div>
                  <div class="form-group col-sm-6">
                     <?php
                        echo form_label('Insured Name:', 'Insured Name', array("class"=>'col-sm-12'));
                        ?>
                        <div class="form-group col-sm-12">
                           <?php echo $task_details['insured_name']; ?>
                        </div>
                        <?php
                     ?>
                  </div>

                  <div class="col-sm-6">
                     <div class="col-sm-4">
                        <?php 
                        echo form_label('&nbsp;', 'priority', array("class"=>'col-sm-12'));
                        echo form_radio("priority", "Normal", ($this->common_model->field_val("priority", $task_details)=='Normal'?TRUE:FALSE), array('class'=>'setpremium')); ?>  Normal
                     </div>
                     <div class="col-sm-5">
                        <?php 
                        echo form_label('&nbsp;', 'priority', array("class"=>'col-sm-12'));
                        echo form_radio("priority", "HIGH", ($this->common_model->field_val("priority", $task_details)=='HIGH'?TRUE:FALSE), array('class'=>'setpremium')); ?>  High
                     </div>
                  </div>
                  <div class="clearfix"></div>
                  <div class="form-group col-sm-6">
                     <?php
                     if($task_details['type'] == 'CASE')
                     {
                        echo form_label('Follow Up EAC:', 'assigned_to', array("class"=>'col-sm-12'));
                        echo $eacmanagers;
                        echo form_error("assign_to");
                     }
                     else
                     {
                        echo form_label('Assign Claim Examiner:', 'assigned_to', array("class"=>'col-sm-12'));
                        echo $claim_examiner;
                        echo form_error("assign_to");
                     }                        
                     ?>
                  </div>

                  <div class="col-sm-6">
                     <label class="col-sm-12">&nbsp;</label>
                     <button class="btn btn-primary">Save</button>
                     <?php echo anchor("auth/mytasks", "Cancel", array("class"=>'btn btn-info')) ?>
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
        startDate: '-105y',
        endDate: '+2y',
    });
})
$(document).on("click",".more_filters", function(){
   $(".more_items").toggle();
})
</script>
