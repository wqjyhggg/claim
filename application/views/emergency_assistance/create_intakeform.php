<duv >
   <div class="page-title">
      <div class="title_left">
         <h3>Create Note</h3>         
      </div>
   </div>
   <div class="clearfix"></div>

   <!-- Create Intake Form Section -->
   <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
         <div class="x_panel">

            <div class="x_title">
               <h2>Note Detail<small></small></h2>
               <div class="clearfix"></div>
            </div>
            <div class="x_content">  
              <?php echo form_open("", array('class'=>'form-horizontal', 'method'=>'post')); ?>
                <div class="row">
                  <div class="form-group col-sm-6">
                     <?php 
                        echo form_label('Note #:', 'form_id', array("class"=>'col-sm-12'));
                     ?>
                     <div class="form-group col-sm-12">
                        ####
                     </div>
                  </div>              
                  <div class="form-group col-sm-6">
                     <?php      
                     echo form_label('Create Date:', 'create_date', array("class"=>'col-sm-12')); 
                     ?>
                     <div class="form-group col-sm-12">
                        <?php       
                        echo date("Y-m-d");
                        ?>
                     </div>
                  </div>
                  <!-- <div class="form-group col-sm-6">
                     <?php 
                        echo form_label('Create By:', 'create_by', array("class"=>'col-sm-12'));                               
                        echo form_input("create_by", $this->input->post("create_by"), array("class"=>"form-control", 'placeholder'=>'Create By'));
                     ?>
                  </div>  --> 
                  <div class="form-group col-sm-12">
                     <?php 
                        echo form_label('Intake Notes:', 'intake_notes', array("class"=>'col-sm-12'));
                        echo form_textarea("intake_notes", $this->input->post("intake_notes"), array("class"=>"form-control", 'placeholder'=>'Intake Notes'));
                        echo form_error("intake_notes");
                     ?>
                  </div>  

                  <div class="form-group col-sm-12 files">

                  </div>
                         
                  <div class="col-sm-6">
                     <label class="col-sm-12">&nbsp;</label>
                     <button class="btn btn-primary">Save</button>
                     <a href="javascript:void(0)" class="btn btn-primary multiupload">Upload Attached</a>
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

<script>
// custom script for multi file upload
$(document).on("click",".multiupload", function(){
   var count = $("input[type=file]").length;

   // add new file here
   $(".files").append('<input type="file" name="files[]" id="file'+(count+1)+'" /> <i class="fa fa-trash" id="'+(count+1)+'"></i>');

   // place trigger clicked once file append in files class
   $('#file'+(count+1)).trigger("click");
});

// delete file script
$(document).on("click",".fa-trash", function(){
   $(this).remove();
   $("#file"+$(this).attr("id")).remove();
});

// once auto file clicked
$(document).on("change","input[type=file]", function(){
   alert($(this).val());
});

</script>