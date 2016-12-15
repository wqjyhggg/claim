<duv>
   <div class="page-title">
      <div class="title_left">
         <h3>Employee Schedule</h3>         
      </div>
   </div>
   <div class="clearfix"></div>

   <!-- Policy search and List Section -->
   <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
         <div class="x_panel">
            <div class="x_title">
               <h2>Schedule Calendar<small></small></h2>
               <div class="clearfix"></div>
            </div>
            <div class="x_content"> 
               <div class="col-sm-12">           
                  <?php echo $calendar ?>
               </div>
               <div class="clearfix"></div>
            </div>
         </div>
      </div>
   </div>
</duv>

<!-- Create Intake Form Modal -->
<div id="model_window" class="modal fade" role="dialog">
  <div class="modal-dialog  modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Create Schedule</h4>
      </div>
      <div class="modal-body">
          <div class="row">             
            <div class="form-group col-sm-3">
               <?php          
               echo form_input("last_name", $this->input->get("last_name"), array("class"=>"form-control autocomplete_field", 'placeholder'=>'Last Name'));
               ?>
            </div> 
            <div class="form-group col-sm-3">
               <?php               
               echo form_input("first_name", $this->input->get("first_name"), array("class"=>"form-control autocomplete_field", 'placeholder'=>'First Name'));
               ?>
            </div>
            <div class="form-group col-sm-3">
               <?php               
               echo form_input("email", $this->input->get("email"), array("class"=>"form-control autocomplete_field", 'placeholder'=>'Email'));
               ?>
            </div>
            <div class="col-sm-3">
               <?php echo form_submit("Search", "Search", array("class"=>'btn btn-primary', "type"=>'submit')) ?>
               <?php echo anchor("auth/users", "Reset", array('class'=>'btn btn-info')) ?>
            </div>
         </div>
         <div class="x_panel">
            <div class="x_title">
               <h2>Select User From List<small></small></h2>
               <div class="clearfix"></div>
            </div>
            <div class="x_content">
               <div class="table-responsive">
                  <table class="table table-hover table-bordered">
                     <thead>
                        <tr>
                           <th><a href="http://192.168.1.253:81/jf_claim_management/auth/users?field=first_name&amp;order=asc" class="">First Name</a></th>
                           <th><a href="http://192.168.1.253:81/jf_claim_management/auth/users?field=last_name&amp;order=asc" class="">Last Name</a></th>
                           <th><a href="http://192.168.1.253:81/jf_claim_management/auth/users?field=email&amp;order=asc" class="">Email Address</a></th>
                        </tr>
                     </thead>
                     <tbody>
                        <tr>
                           <td>bhawani</td>
                           <td>shankar</td>
                           <td>g8bhawani@gmail.com</td>
                        </tr>
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
         <div class="row">             
            <div class="form-group col-sm-6">
               <?php 
                 $status = array(
                   ''=>'Select Shift',
                   '1'=>'8am-2pm',
                   '0'=>'2pm-8pm',
                   '2'=>'8pm-8am',
                 );
                 echo form_dropdown("status", $status, $this->input->get("status"), array("class"=>'form-control'));
               ?>
            </div>
            <div class="col-sm-3">
               <?php echo form_submit("Add", "Add", array("class"=>'btn btn-primary', "type"=>'submit')) ?>
            </div>
         </div>
      </div>
    </div>
  </div>
</div>
<!-- end intake form model here -->

<?php echo link_tag('assets/css/bootstrap-datepicker.css'); ?>
<script src="<?php echo base_url() ?>/assets/js/bootstrap-datetimepicker.js"></script>
<script>
   $(document).ready(function() {
      $(".datepicker").datepicker({
           startDate: '-117y',
           endDate: '+0y',
       });

      $("select[name=reason]").change(function(){
         if($(this).val() == 'Outpatient')
            $(".hospital_info").text("Doctor Info");
         else if($(this).val() == 'Other')
            $(".hospital_info").text("Doctor Info/Hospital Info");
         else
            $(".hospital_info").text("Hospital Info");
      })

      // to check model will not open in blank dates
      $("td").click(function(){
         if(!$(this).children("span").hasClass("day_listing") && !$(this).children("div").children("span").hasClass("day_listing"))
            return false;
      })
   })
</script>