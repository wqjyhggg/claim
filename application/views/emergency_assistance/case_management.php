<style>
.modal-lg {
    width: 75%;
}
</style>
<duv>
   <div class="page-title">
      <div class="title_left">
         <h3>Case Management</h3>
      </div>
   </div>
   <div class="clearfix"></div>
   <?php echo $message; ?>

   <!-- Case search and List Section -->
   <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
         <div class="x_panel">
         <div class="x_title">
            <h2>Case Filter<small></small></h2>
            <div class="clearfix"></div>
         </div>
         <div class="x_content">

            <!-- search case filter start -->
           <?php echo form_open("", array('class'=>'form-horizontal', 'method'=>'get')); ?>
            <div class="row">
               <div class="form-group col-sm-3">
                  <?php
                  echo form_input("case_no", $this->input->get("case_no"), array("class"=>"form-control", 'placeholder'=>'Case No'));
                  ?>
               </div>
               <div class="form-group col-sm-3">
                  <?php
                  echo form_input("policy_no", $this->input->get("policy_no"), array("class"=>"form-control", 'placeholder'=>'Policy No'));
                  ?>
               </div>
               <div class="form-group col-sm-3">
                  <div class="input-group date">
                     <?php
                     echo form_input("created_from", $this->input->get("created_from"), array("class"=>"form-control datepicker", 'placeholder'=>'Create Date From'));
                     ?>
                     <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                  </div>
               </div>
               <div class="form-group col-sm-3">
                  <div class="input-group date">
                     <?php
                     echo form_input("created_to", $this->input->get("created_to"), array("class"=>"form-control datepicker", 'placeholder'=>'Create Date To'));
                     ?>
                     <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                  </div>
               </div>

               <div class="form-group col-sm-3">
                  <?php
                  echo form_input("insured_lastname", $this->input->get("insured_lastname"), array("class"=>"form-control", 'placeholder'=>'Insured Last Name'));
                  ?>
               </div>

               <div class="form-group col-sm-3">
                  <?php
                  echo form_input("insured_firstname", $this->input->get("insured_firstname"), array("class"=>"form-control", 'placeholder'=>'Insured First Name'));
                  ?>
               </div>

               <div class="form-group col-sm-3">
                  <?php
                  $options_status = array(
                     ''=>'--Case Status--',
                     'A'=>'Active',
                     'D'=>'Inactive',
                     'C'=>'Close'
                     );
                  echo form_dropdown("status", $options_status, $this->input->get("status"), array("class"=>"form-control"));
                  ?>
               </div>

               <div class="form-group col-sm-3">
                  <?php
                  $options = array(
                     ''=>'--Assigned Status--',
                     'assigned'=>'Assigned',
                     'unassigned'=>'Unassigned'
                     );
                  echo form_dropdown("assigned_status", $options, $this->input->get("assigned_status"), array("class"=>"form-control"));
                  ?>
               </div>

               <div class="form-group col-sm-3">
                  <?php
                  echo form_label('My Task:', 'case_manager', array("class"=>'col-sm-4'));
                  ?>
                  <div class="form-group col-sm-8">
                     <?php
                     echo form_checkbox("case_manager", $case_manager, ($this->input->get("case_manager") == $case_manager ? TRUE : FALSE), array("id"=>'case_manager', 'class'=>'col-sm-1'));
                     echo form_label('Owned by Me', 'case_manager', array("class"=>'col-sm-10 pull-right', 'style'=>'margin-top: 3px;'));
                     ?>
                  </div>
               </div>

               <div class="form-group col-sm-3">
                  <?php
                  echo form_label('Priority:', 'priority_label', array("class"=>'col-sm-4'));
                  ?>
                  <div class="form-group col-sm-6">
                     <?php
                     echo form_checkbox("priority", "HIGH", ($this->input->get("priority") == 'HIGH' ? TRUE : FALSE), array("id"=>'priority', 'class'=>'col-sm-1'));
                     echo form_label('High', 'priority', array("class"=>'col-sm-10 pull-right', 'style'=>'margin-top: 3px; float: left; text-align: left; margin-right: 34px; width: 47px;'));
                     ?>
                  </div>
               </div>

               <div class="col-sm-3">
                  <button class="btn btn-primary" name="filter" value="case">Search</button>
                  <?php echo anchor("emergency_assistance/case_management", "Reset", array('class'=>'btn btn-info')); ?>
               </div>
            </div>
            <?php echo form_close(); ?>
            <!-- search case filter end -->
            <div class="clearfix"><br/></div>

            <!-- search results start -->
            <div class="x_content">
               <?php if(!empty($cases)): ?>
               <div class="table-responsive">
                  <table class="table table-hover table-bordered">
                     <thead>
                        <tr>
                           <th><?php echo form_checkbox("selectall", 1); ?></th>
                           <th>Case number</th>
                           <th>Create Date</th>
                           <th>Place</th>
                           <th>Reason</th>
                           <th>Policy Number</th>
                           <th>Insured Name</th>
                           <th>DOB</th>
                           <th>Follow Up EAC</th>
                           <th>Case Manager</th>
                           <th>Priority</th>
                           <th>Status</th>
                        </tr>
                     </thead>
                     <tbody>
                     <?php foreach ($cases as $key => $value): ?>
                        <!-- placing all attributes in table row to replace feature in doc via js -->
                        <tr class="row-link" alt="<?php echo $value['id']; ?>"
                           insured_address="<?php echo nl2br($value['insured_address']) ?>"
                           insured_lastname="<?php echo $value['insured_lastname'] ?>"
                           insured_name="<?php echo $value['insured_name'] ?>"
                           policy_no="<?php echo $value['policy_no'] ?>"
                           policy_info='<?php echo $value['policy_info'] ?>'
                           case_no="<?php echo $value['case_no'] ?>"
                           casemanager_name="<?php echo $value['case_manager_name'] ?>"
                           >
                           <th><?php echo form_checkbox("case", $value['id'], FALSE, array('class'=>($case_manager <> $value['case_manager']?'own_by_other':''), ($value['status'] == 'C'?'disabled':'')=>'')); ?></th>
                           <td><?php echo $value['case_no']; ?></td>
                           <td><?php echo date('d/m/Y', strtotime($value['created'])); ?></td>
                           <td><?php echo $value['province']; ?></td>
                           <td><?php echo $value['reason']; ?></td>
                           <td><?php echo $value['policy_no']; ?></td>
                           <td><?php echo $value['insured_name']; ?></td>
                           <td><?php echo ($value['dob']<>'N/A')?date('d/m/Y', strtotime($value['dob'])):'N/A'; ?></td>
                           <td><?php echo $value['assign_to_name']; ?></td>
                           <td><?php echo $value['case_manager_name']; ?></td>
                           <td><?php echo $value['priority']; ?></td>
                           <td><?php echo @$options_status[$value['status']]; ?></td>
                        </tr>
                     <?php endforeach; ?>
                     </tbody>
                  </table>
               </div>
               </br>
               <div class="row form-group">
                  <div class="col-sm-12">
                     <div class="col-sm-2">
                        <button class="btn btn-primary show_button auto_assign" disabled>Auto Assign</button>
                     </div>
                     <div class="col-sm-2">
                        <div class="col-sm-12">
                           <button class="btn btn-primary show_button assign_to" disabled>Transfer CM <i class="fa fa-angle-double-right"></i> </button>
                        </div>
                        <div class="col-sm-12">
                           <button class="btn btn-primary show_button follow_up"  data-toggle="modal" data-target="#follow_reason" disabled>EAC Follow Up <i class="fa fa-angle-double-right"></i></button>
                        </div>
                     </div>
                     <div class="col-sm-8 employees-section" style="display:none">
                        <div class="col-sm-4">
                           <?php echo $casemanagers;?>
                        </div>
                        <div class="col-sm-2">
                           <button class="btn btn-primary pull-right save_assign" style="display:none" ><i class="fa fa-check-circle-o"></i> Save</button>
                        </div>
                     </div>
                  </div>

                  <div class="col-sm-12 form-group">
                     <div class="col-sm-2">
                        <button class="btn btn-primary show_button view_edit editable" disabled>View/Edit Case</button>
                     </div>

                     <div class="col-sm-2">
                         <div class="col-sm-12">
                           <button class="btn btn-primary show_button mark_inactive editable" disabled>Set Inactive</button>
                        </div>
                     </div>


                     <div class="col-sm-2">
                         <div class="col-sm-12">
                           <button class="btn btn-primary show_button mark_close editable" disabled>Set Close</button>
                        </div>
                     </div>

                     <div class="col-sm-2">
                        <button class="btn btn-primary show_button email_print editable"  data-toggle="modal" data-target="#print_template" disabled>Email/Print</button>
                     </div>
                  </div>
               </div>

               <?php else:?>
                  <center><?php echo heading("No record available", 4); ?></center>
               <?php endif;
               echo $pagination;
               ?>
            </div>
            <!-- End Search List Section -->
         </div>
      </div>
   </div>
</duv>

<!-- follow up model window here -->
<div id="follow_reason" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Follow up case</h4>
      </div>
      <?php
         echo form_open_multipart("emergency_assistance/follow_up_cases", array("id"=>'follow_up_cases'));
       ?>
      <div class="modal-body">
          <div class="row">
            <div class="col-sm-12">
               <div>
                  <?php
                  echo form_label('Please Enter The Reason:', 'notes', array("class"=>'col-sm-12'));
                  ?>
                  <div class="col-sm-12">
                     <?php
                     echo form_textarea("notes", "", array("class"=>"form-control col-sm-6 form-group required", 'placeholder'=>'Please Enter The Reason'));
                     ?>
                  </div>
                  <div class="col-sm-12 follow-section">
                     <?php foreach ($employee_shift as $key => $value): ?>
                        <div class="col-sm-4">
                           <fieldset>
                              <legend><?php echo $value; ?></legend>
                              <?php
                                 $list = "employees_".$key;
                                 echo $$list;
                               ?>
                           </fieldset>
                           <div class="clearfix"><br/></div>
                        </div>
                     <?php endforeach; ?>

                     <div class="col-sm-12">
                        <button class="btn btn-primary pull-right save_assign" style="display:none" ><i class="fa fa-check-circle-o"></i> Save</button>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="modal-footer">
         <label class="col-sm-12">&nbsp;</label>
         <button class="btn btn-info complete-follow">Follow Up</button>
         <button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
      </div>
      <?php echo form_close(); ?>
    </div>

  </div>
</div>
<!-- follow up model end here -->

<!-- Email print doc content here -->
<div id="print_template" class="modal fade" role="dialog">
  <div class="modal-dialog  modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Print/email Template Letter</h4>
      </div>
      <?php
         echo form_open_multipart("emergency_assistance/send_print_email", array("id"=>'send_print_email'));
       ?>
      <div class="modal-body">
          <div class="row">
            <div class="col-sm-6">
               <div>
                  <label for="mail_label" class="col-sm-2">Mail Addres:</label>
                  <div class="form-group col-sm-6">
                     <input name="priority" value="HIGH" id="mail_address" class="col-sm-1" type="checkbox">
                     <label for="mail_address" class="col-sm-10 pull-right" style="margin-top: 3px;">Use same address with the policy</label>
                  </div>
               </div>
               <div>
                  <?php
                  echo form_label('To:', 'email', array("class"=>'col-sm-12'));
                  ?>
                  <div class="form-group col-sm-12">
                     <?php
                     echo form_input("email", "", array("class"=>"form-control col-sm-6 form-group email required", 'placeholder'=>'Email Address'));
                     ?>
                  </div>
               </div>
            </div>
            <div class="form-group col-sm-12">

               <div class="form-group col-sm-3">
                  <?php
                  echo form_label('Street No.:', 'street_no', array("class"=>'col-sm-12'));
                  echo form_input("street_no", "", array("class"=>"form-control required", 'placeholder'=>'Street No.'));
                  echo form_error("street_no");
                  ?>
               </div>
               <div class="form-group col-sm-3">
                  <?php
                  echo form_label('Street Name.:', 'street_name', array("class"=>'col-sm-12'));
                  echo form_input("street_name", "", array("class"=>"form-control required", 'placeholder'=>'Street Name.'));
                  echo form_error("street_name");
                  ?>
               </div>
               <div class="form-group col-sm-3">
                  <?php
                  echo form_label('City:', 'city', array("class"=>'col-sm-12'));
                  echo form_input("city", "", array("class"=>"form-control required", 'placeholder'=>'City'));
                  echo form_error("city");
                  ?>
               </div>

               <div class="form-group col-sm-3">
                  <?php
                     echo form_label('Province:', 'province', array("class"=>'col-sm-12'));
                     echo $province;
                     echo form_error("province");
                  ?>
               </div>

               <?php
                  echo form_label('Select Template:', 'select_template', array("class"=>'col-sm-12'));
               ?>
               <div class="form-group col-sm-12">
                  <?php foreach($docs as $doc): ?>
                     <div class="select-doc col-sm-2" doc="<?php echo $doc['id'] ?>">
                        <i class="fa fa-file-word-o large"></i>
                        <?php echo $doc['name'] ?>
                     </div>
                  <?php endforeach; ?>
               </div>
            </div>
            <div class="form-group col-sm-12 docfiles">
               <?php foreach($docs as $doc): ?>
                  <div class="col-sm-12 doc-description doc-<?php echo $doc['id'] ?>" style="display:none">
                     <div class="col-sm-12 doc_title">
                        <?php echo heading($doc['name']); ?>
                     </div>
                     <div class="col-sm-12 doc-desc">
                        <?php
                           // find and replace text
                           $find = array(
                              '{otc_logo}',
                              '{otc_logo_big}',
                              '{current_date}'
                              );
                           $replace = array(
                              img(array('src'=>'assets/img/otc.jpg','width'=>'90', 'height'=>'50')),
                              img(array('src'=>'assets/img/otc_big.jpg','width'=>'262')),
                              date("F d, Y")
                              );
                         echo str_replace($find, $replace, $doc['description']);
                        ?>
                     </div>
                  </div>
               <?php endforeach; ?>
            </div>
         </div>
      </div>
      <div class="modal-footer">
         <label class="col-sm-12">&nbsp;</label>
         <button type="button" class="btn btn-info preview-template" disabled>Preview</button>
         <button class="btn btn-primary email-intakeform" disabled >Email</button>
         <button type="button" class="btn btn-info print" disabled>Print</button>
         <button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
      </div>
      <?php echo form_close(); ?>
    </div>

  </div>
</div>
<!-- end here -->
<div style="display:none" id="products"><?php echo $products; ?></div>


<?php echo link_tag('assets/css/bootstrap-datepicker.css'); ?>
<script src="<?php echo base_url() ?>/assets/js/bootstrap-datetimepicker.js"></script>
<script src="<?php echo base_url() ?>/assets/js/jQuery.print.js"></script>
<script src="<?php echo base_url() ?>/assets/js/jquery.validate.min.js"></script>
<script>
var employee_id;
$(document).ready(function() {
   $("input[name=case]").prop("checked", false);
   $(".datepicker").datepicker({
        startDate: '-105y',
        endDate: '+2y',
    });
}).on("click", ".row-link", function(){                                                // open edit case page to enter reserver amount

   var id = $(this).attr("alt");
   window.location = "<?php echo base_url("emergency_assistance/edit_case") ?>/"+id+"?ref=manage";
}).on("click", "input[name=selectall]",  function(){                                   // select all checkboxes script

   if($(this).is(":checked"))                                                          // check user click check or uncheck tickbox
      $("input[name=case]").prop("checked", true);
   else
      $("input[name=case]").prop("checked", false);

   $("input[name=case]:disabled").prop("checked", false);
}).on("click", "input[name=case], input[name=selectall]",  function(e){                // enable disable buttons

   e.stopPropagation();
   var length = $("input[name=case]:checked").length;
   var length_other = $("input[name=case].own_by_other:checked").length;
   if(length && !length_other)
   {
      $(".show_button").removeAttr("disabled");
      if(length > 1)
          $(".view_edit, .email_print").attr("disabled", "disabled");
   }
   else
   {
      $(".show_button").attr("disabled", "disabled");
      if(length == 1)
          $(".view_edit, .email_print").removeAttr("disabled");
      if(length > 0)
      {
          $(".mark_inactive").removeAttr("disabled");
          $(".mark_close").removeAttr("disabled");
      }
      $(".employees-section").hide();
   }
}).on("click", ".assign_to", function(){                                               // on clicked assign to button

   $(".employees-section, .save_assign").show();

}).on("click", ".follow_up", function(){                                               // clicking on follow_up button

   // open popup screen why need to follow up this case and assign to emc user
   $(".employees-section").hide();
   $(".save_assign").hide();
}).on("click", ".view_edit", function(){                                               // once manager click on "View/     Edit"case button

   var id = $("input[name=case]:checked").val();
   window.location = "<?php echo base_url("emergency_assistance/edit_case") ?>/"+id+"?ref=manage";
}).on("change", "select", function(){                                                  // set validation on emc select list

   var val = $(this).val();
   $("select").val("");
   $(this).val(val);
   employee_id = val;                                                                  // set selected employee
}).on("click", ".save_assign", function(){                                             // clicking on save assign button

   // check if employee selected or not
   if(!$("select[name=case_manager]").val())
   {
      alert("Please select case manager first.");
      return false;
   }

   // assign emc user to selected cases
   var cases = [];
   $("input[name=case]:checked").each(function(){
      cases.push($(this).val());
   })
   var cases = cases.join(",");

   // assign cases to emc manager here
   $.ajax({
      url: "<?php echo base_url("emergency_assistance/assign_cases/manually") ?>",
      method: "post",
      data:{cases:cases, employee_id: employee_id},
      beforeSend: function(){
         $(".right_col").addClass("csspinner load1");
      },
      success: function() {
         window.location.reload();
      }
   })
})

// clicking on follow button
.on("submit", "#follow_up_cases", function(e){

   // prevent form to submit
   e.preventDefault();


   if($(this).valid())
   {

      // check if employee selected or not
      if(!employee_id)
      {
         alert("Please select emc user first.");
         return false;
      }

      // assign emc user to selected cases
      var cases = [];
      $("input[name=case]:checked").each(function(){
         cases.push($(this).val());
      })
      var cases = cases.join(",");

      // assign cases to emc manager here
      $.ajax({
         url: "<?php echo base_url("emergency_assistance/follow_up_cases") ?>",
         method: "post",
         data:{cases:cases, employee_id: employee_id, notes: $("textarea[name=notes]").val() },
         beforeSend: function(){
            $(".right_col").addClass("csspinner load1");
            $(".modal").addClass("csspinner");
         },
         success: function() {
            window.location.reload();
         }
      })
   }
})

// clicking on mark as inactive button
.on("click", ".mark_inactive", function(){

   if(!confirm('Are you sure you want to mark inactive selected cases?'))
      return false;

   // selected cases
   var cases = [];
   $("input[name=case]:checked").each(function(){
      cases.push($(this).val());
   })
   var cases = cases.join(",");

   // assign cases to emc manager here
   $.ajax({
      url: "<?php echo base_url("emergency_assistance/updatestatus/D") ?>",
      method: "post",
      data:{cases:cases, employee_id: employee_id},
      beforeSend: function(){
         $(".right_col").addClass("csspinner load1");
      },
      success: function() {
         window.location.reload();
      }
   })
})

// clicking on mark as close button
.on("click", ".mark_close", function(){

   if(!confirm('Are you sure you want to close selected cases?'))
      return false;

   // selected cases
   var cases = [];
   $("input[name=case]:checked").each(function(){
      cases.push($(this).val());
   })
   var cases = cases.join(",");

   // assign cases to emc manager here
   $.ajax({
      url: "<?php echo base_url("emergency_assistance/updatestatus/C") ?>",
      method: "post",
      data:{cases:cases, employee_id: employee_id},
      beforeSend: function(){
         $(".right_col").addClass("csspinner load1");
      },
      success: function() {
         window.location.reload();
      }
   })
})

// clicking on save assign button
.on("click", ".auto_assign", function(){

   // assign emc user to selected cases
   var cases = [];
   $("input[name=case]:checked").each(function(){
      cases.push($(this).val());
   })
   var cases = cases.join(",");

   // return confirm yes/no before go further
   if(confirm("Are you sure you want to assign case automatically?"))
   {
      // assign cases to emc manager here
      $.ajax({
         url: "<?php echo base_url("emergency_assistance/assign_cases/automatic") ?>",
         method: "post",
         data:{cases:cases, employee_id: employee_id},
         beforeSend: function(){
            $(".right_col").addClass("csspinner load1");
         },
         success: function() {
            window.location.reload();
         }
      })
   }
   else
      return false;
})

.on("click", ".select-doc", function(){                                              // show email/print function

   // hide all doc files here
   $(".doc-description").hide();
   $(".select-doc").removeClass("active");

   // get doc if
   var id = $(this).attr("doc");
   $(this).addClass("active");

   // show related doc file
   $(".doc-"+id).show();

   // get selected case details object
   var obj = $("input[name=case]:checked").parent("th").parent("tr.row-link");

   var data = $("input[name=case]:checked").parent("th").parent("tr.row-link").attr('policy_info');

   data = data?$.parseJSON(data):'';

   // replace string from casemanager name etc
   var str = $(".doc-"+id+"  .doc-desc").html();
   str = str.replace(/{insured_name}/gi, obj.attr("insured_name"))
   .replace("{insured_address}", obj.attr("insured_address"))
   .replace("{insured_lastname}", obj.attr("insured_lastname"))
   .replace("{policy_no}", obj.attr("policy_no"))
   .replace("{case_no}", obj.attr("case_no"))
   .replace("{policy_coverage_info}", "{policy_coverage_info}")
   .replace("{casemanager_name}", obj.attr("casemanager_name"));

   if(data)
      str = str.replace("{coverage_period}", data[0].effective_date+" to "+data[0].expiry_date);
   else
      str = str.replace("{coverage_period}", '');

   $(".doc-"+id+" .doc-desc").html(str);

   // reset all edit//preview section
   $(".preview-template").text("Preview").removeClass("active-preview");

   // enable disable buttons
   $(".print").attr("disabled", "disabled");
   $(".preview-template, .email-intakeform").removeAttr("disabled");

})

// preview template script
.on("click", ".preview-template", function(){
   // get selected doc
   $(this).toggleClass("active-preview");
   var doc_id = $(".select-doc.active").attr("doc");
   if($(this).hasClass("active-preview"))
   {
      $(this).text("Edit Template");
      var $outer = $(".doc-"+doc_id+" .outer-text input, .doc-"+doc_id+" .outer-text textarea, .doc-"+doc_id+" .select-product select");
      $outer.each(function(){
         var text = $.trim($(this).val());

         $(this).parent("p,span").html(text.replace(/\n/g, "<br>"));
         $(this).remove();
      });

      // enable print button
      $(".print").removeAttr("disabled");
   }
   else
   {
      $(this).text("Preview");
      var $outer = $(".outer-text");
      $outer.each(function(){
         var text = $.trim($(this).html()).replace(/<br>/g, "\n");

         $(this).empty();
         if(!$(this).hasClass("area"))
            $(this).append("<input class='outer-text' value='" + text + "'></input>");
         else
            $(this).append("<textarea  style='width:100%' rows='6'>"+ text +"</textarea>");
      });

      // for the products list
      var $outer_select = $(".select-product");
      $outer_select.each(function(){
         var text = $.trim($(this).text());

         $(this).empty();
         $(this).append($("#products").html()).children("select").val(text);
      });

      // disable print button
      $(".print").attr("disabled", "disabled");
   }

})

// print button script here
.on("click", ".print", function(){
   var doc_id = $(".select-doc.active").attr("doc");
   $(".doc-"+doc_id).print({
        globalStyles: false,
        mediaPrint: true,
        iframe: true,
        noPrintSelector: ".avoid-this",
    });
})

// send email print to recepient email:-
.on("submit", "#send_print_email", function(e){
   e.preventDefault();
   var doc_id = $(".select-doc.active").attr("doc");
   var template = $(".doc-"+doc_id).children("div.doc-desc").html();
   if($(this).valid())
   {
      $.ajax({
            url: "<?php echo base_url("emergency_assistance/send_print_email") ?>",
            method: "post",
            data:{
               email:$("input[name=email]").val(),
               street_no:$("input[name=street_no]").val(),
               street_name:$("input[name=street_name]").val(),
               city:$("input[name=city]").val(),
               province:$("select[name=province]").val(),
               template:template,
               case_id: $("input[name=case]:checked").val(),
               doc: $(".select-doc.active").text()
            },
            beforeSend: function(){
               $(".modal-content").addClass("csspinner load1");
            },
            success: function() {
               window.location.reload();
            }
         })
   }
})

// once user clicked on same with policy button
.on("click", "#mail_address", function(){

   // get local data
   var data = $.parseJSON($("input[name=case]:checked").parent('th').parent('tr').attr('policy_info'));
   if($(this).is(":checked"))
   {
      // fill all json values to address fields
      $("input[name=street_no]").val(data[0].street_number);
      $("input[name=street_name]").val(data[0].street_name);
      $("input[name=city]").val(data[0].city);
      $("select[name=province]").val(data[0].province2);
   }
   else
   {
      $("input[name=street_no],input[name=street_name],input[name=city],select[name=province]").val("");
   }
})

// create input boxes where requirement need
var $outer = $(".outer-text");
$outer.each(function(){
   var text = $.trim($(this).text());

   $(this).empty();
   if(!$(this).hasClass("area"))
      $(this).append("<input class='outer-text' value='" + text + "'></input>");
   else
      $(this).append("<textarea  style='width:100%' rows='6' value=''>"+ text +"</textarea>");
});

var $outer_select = $(".select-product");
$outer_select.each(function(){
   var text = $.trim($(this).text());

   $(this).empty();
   $(this).append($("#products").html());
});



</script>
