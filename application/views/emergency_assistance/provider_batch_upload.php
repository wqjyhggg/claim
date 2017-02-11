<duv >
   <div class="page-title">
      <div class="title_left">
         <h3>Provider Batch Upload</h3>         
      </div>
   </div>
   <div class="clearfix"></div>

   <!-- Create Provider Section -->
   <div class="row">
      <?php echo $message; ?>
      <div class="col-md-12 col-sm-12 col-xs-12">
         <div class="x_panel">
            <div class="x_content">  
              <?php echo form_open_multipart("", array('class'=>'form-horizontal', 'method'=>'post')); ?>
                <div class="row">
                  <div class="form-group col-sm-6">
                     <?php 
                        echo form_label('Select CSV File:', 'name', array("class"=>'col-sm-12'));                               
                        echo form_upload("csv", "", array( 'placeholder'=>'csv'));
                        echo form_error("csv");
                        echo form_hidden("csv_file", TRUE);
                     ?>
                  </div>                
                  <div class="col-sm-6">
                     <label class="col-sm-12">&nbsp;</label>
                     <button class="btn btn-primary" name="upload" value="file">Upload</button>
                     <?php echo anchor("emergency_assistance/create_provider", "Cancel", array("class"=>'btn btn-info')) ?>
                     <?php echo anchor("emergency_assistance/sample_file", "<i class='fa fa-download'></i> Download Sample File", array("class"=>'btn btn-primary')) ?>
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
// once auto file clicked
.on("change","input[type=file]", function(){

   // validate file extension
   var ext = $(this).val().split('.').pop().toLowerCase();
   if($.inArray(ext, ['csv']) == -1) {
       alert('invalid extension! Please attach only csv file.');
       $(this).val('');
       return false;
   }

   // display file name and delete button
   $(this).next("span.file-label").text($(this).val()).parent("div.col-sm-9").show();
})
$(document).on("click",".more_filters", function(){
   $(".more_items").toggle();
})
</script>