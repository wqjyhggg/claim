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
            <?php echo form_open("emergency_assistance/search_users", array("class"=>'form-horizontal', 'id'=>'search_users'));?>                       
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
               <?php echo form_submit("Search", "Search", array("class"=>'btn btn-primary')) ?>
               <?php echo form_reset("Reset", "Reset", array("class"=>'btn btn-info')) ?>
            </div>
            <?php echo form_close(); ?>
         </div>
         <div class="x_panel">
            <div class="x_title">
               <h2>Setup Employees Schedule<small></small></h2>
               <div class="clearfix"></div>
            </div>
            <div class="x_content search_users">
               <center><?php echo heading("No record available", 4); ?></center>
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
   var date, type, day;
   $(document).ready(function() {

      // to check model should not open in blank dates
      $("td").click(function(){
         type = "date";
         if(!$(this).children("span").hasClass("day_listing") && !$(this).children("div").children("span").hasClass("day_listing"))
            return false;
         else
         {
            date = $(this).children("span.day_listing").html()?$(this).children("span.day_listing").html():$(this).children("div.today").children("span.day_listing").html();

            search_users(type);
         }
      })
   });
   $(document).on("click", ".day_header", function(){
      type = "day";
      day = $(this).children("h4").text();
      search_users(type);
   })

   // save schedule of employees
   $(document).on("change", ".select_schedule", function() {
      var schedule = $(this).val();
      var employee_id = $(this).attr("alt");
      var url = "<?php echo base_url("emergency_assistance/save_schedule/$year/$month"); ?>/" + date + '/' + type + '/' + day;
      var data = {employee_id:employee_id, schedule: schedule};
      $.ajax({
         url:url,
         method: "post",
         data:data,
         beforeSend: function(){

            // show ajax loader here
            $(".search_users").addClass("csspinner load1");
         },
         success: function(data){

            // in succss place return responce to list
            $(".search_users").removeClass("csspinner load1");
         }
      })
   })

  // fuzzy search
  $(function() {
    $(".autocomplete_field").click(function() {
      var name = $(this).attr("name");
      $(".autocomplete_field").autocomplete({
        serviceUrl: "<?php echo base_url()."auth/autocomplete/"; ?>" + name+"/2",
        minLength: 2,
        dataType: "json",
      });
    });
  });

  // search users via ajax
  $(document).on("submit", "#search_users", function(e){
      e.preventDefault();
      search_users(type);
  })

  function search_users(type){
    var url = "<?php echo base_url("emergency_assistance/search_users/$year/$month"); ?>/" + date + '/' + type + '/' + day;
      var data = $("#search_users").serialize();
      $.ajax({
         url:url,
         method: "post",
         data:data,
         beforeSend: function(){

            // show ajax loader here
            $(".search_users").addClass("csspinner load1");
         },
         success: function(data){

            // in succss place return responce to list
            $(".search_users").html(data);
            $(".search_users").removeClass("csspinner load1");
         }
      })
  }
</script>