<style>
.modal-lg {
    width: 95%;
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
                  echo form_label('Priority:', 'priority_label', array("class"=>'col-sm-4')); 
                  ?>
                  <div class="form-group col-sm-6">
                     <?php
                     echo form_checkbox("priority", "HIGH", ($this->input->get("priority") == 'HIGH' ? TRUE : FALSE), array("id"=>'priority', 'class'=>'col-sm-1')); 
                     echo form_label('High', 'priority', array("class"=>'col-sm-10 pull-right', 'style'=>'margin-top: 3px;'));
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
                           <th>Assign to</th>
                           <th>Case Manager</th>
                           <th>Priority</th>            
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
                           case_no="<?php echo $value['case_no'] ?>"
                           casemanager_name="<?php echo $value['case_manager_name'] ?>"
                           >
                           <th><?php echo form_checkbox("case", $value['id']); ?></th>
                           <td><?php echo $value['case_no']; ?></td>
                           <td><?php echo date('d/m/Y', strtotime($value['created'])); ?></td>
                           <td><?php echo $value['province']; ?></td>
                           <td><?php echo $value['reason']; ?></td>
                           <td><?php echo $value['policy_no']; ?></td>
                           <td><?php echo $value['insured_name']; ?></td>
                           <td><?php echo date('d/m/Y', strtotime($value['dob'])); ?></td>
                           <td><?php echo $value['assign_to_name']; ?></td>
                           <td><?php echo $value['case_manager_name']; ?></td>
                           <td><?php echo $value['priority']; ?></td>
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
                           <button class="btn btn-primary show_button assign_to" disabled>Assign To <i class="fa fa-angle-double-right"></i> </button>
                        </div>
                        <div class="col-sm-12">
                           <button class="btn btn-primary show_button follow_up" disabled>Follow Up <i class="fa fa-angle-double-right"></i></button>  
                        </div>   
                     </div>
                     <div class="col-sm-8 employees-section" style="display:none">
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
                           <button class="btn btn-primary pull-right save_assign" style="display:none" ><i class="fa fa-check-circle-o"></i> Save Assign</button> 
                           <button class="btn btn-primary pull-right save" style="display:none" ><i class="fa fa-check-circle-o"></i> Save</button>  
                        </div>   
                     </div>  
                  </div>
                 
                  <div class="col-sm-12 form-group">
                     <div class="col-sm-2">
                        <button class="btn btn-primary show_button view_edit" disabled>View/Edit Case</button>  
                     </div>

                     <div class="col-sm-2">    
                         <div class="col-sm-12">
                           <button class="btn btn-primary show_button mark_inactive" disabled>Set Inactive</button>
                        </div>  
                     </div>

                     <div class="col-sm-2">    
                        <button class="btn btn-primary show_button email_print"  data-toggle="modal" data-target="#print_template" disabled>Email/Print</button> 
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
         //echo form_open_multipart("emergency_assistance/send_email", array("id"=>'send_email'));
       ?>
      <div class="modal-body">
          <div class="row">
               <div class="form-group col-sm-3">
                  <?php
                  echo form_label('To:', 'email', array("class"=>'col-sm-12'));
                  ?>
                  <div class="form-group col-sm-12">
                     <?php  
                     echo form_input("email", "", array("class"=>"form-control col-sm-6 form-group", 'placeholder'=>'Email Address'));
                     ?>
                  </div>
               </div>
               <div class="form-group col-sm-12">
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
                  <div class="col-sm-6 doc-description doc-<?php echo $doc['id'] ?>" style="display:none">
                     <div class="col-sm-12 doc_title">
                        <?php echo heading($doc['name'].' <i class="fa fa-print large pull-right" title="Print file"></i>', 4); ?> 
                     </div>
                     <div class="col-sm-12 doc-desc">
                        <?php
                           // find and replace text
                           $find = array(
                              '{otc_logo}',
                              '{current_date}'
                              );
                           $replace = array(
                              img(array('src'=>'assets/img/otc.jpg','width'=>'90', 'height'=>'50')),
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
         <button class="btn btn-primary save-intakeform" type="submit">Send</button>
         <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
      </div>
      <?php //echo form_close(); ?>
    </div>

  </div>
</div>
<!-- end here -->



<?php echo link_tag('assets/css/bootstrap-datepicker.css'); ?>
<script src="<?php echo base_url() ?>/assets/js/bootstrap-datetimepicker.js"></script>
<script>
var employee_id;
$(document).ready(function() {
   $(".datepicker").datepicker({
        startDate: '-5y',
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
}).on("click", "input[name=case], input[name=selectall]",  function(e){                // enable disable buttons

   e.stopPropagation();
   var length = $("input[name=case]:checked").length;
   if(length)
   {
      $(".show_button").removeAttr("disabled");
      if(length > 1)
          $(".view_edit, .email_print").attr("disabled", "disabled");
   }
   else
   {
      $(".show_button").attr("disabled", "disabled");
      $(".employees-section").hide();
   }
}).on("click", ".assign_to", function(){                                               // on clicked assign to button

   $(".employees-section, .save_assign").show();
   $(".save").hide();
}).on("click", ".follow_up", function(){                                               // clicking on follow_up button

   $(".employees-section, .save").show();
   $(".save_assign").hide();
}).on("click", ".view_edit", function(){                                               // once manager click on "View/Edit"case button

   var id = $("input[name=case]:checked").val();
   window.location = "<?php echo base_url("emergency_assistance/edit_case") ?>/"+id+"?ref=manage";
}).on("change", "select", function(){                                                  // set validation on emc select list

   var val = $(this).val();
   $("select").val("");
   $(this).val(val);
   employee_id = val;                                                                  // set selected employee
}).on("click", ".save_assign", function(){                                             // clicking on save assign button
   
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
}).on("click", ".save", function(){                                                    // clicking on follow button
   
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
      data:{cases:cases, employee_id: employee_id},
      beforeSend: function(){
         $(".right_col").addClass("csspinner load1");
      },
      success: function() {
         window.location.reload();
      }
   })
}).on("click", ".mark_inactive", function(){                                           // clicking on save assign button
   
   // selected cases 
   var cases = [];
   $("input[name=case]:checked").each(function(){
      cases.push($(this).val());
   })
   var cases = cases.join(",");

   // assign cases to emc manager here
   $.ajax({
      url: "<?php echo base_url("emergency_assistance/mark_inactive") ?>",
      method: "post",
      data:{cases:cases, employee_id: employee_id},
      beforeSend: function(){
         $(".right_col").addClass("csspinner load1");
      },
      success: function() {
         window.location.reload();
      }
   })
}).on("click", ".auto_assign", function(){                                             // clicking on save assign button
   
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
}).on("click", ".select-doc", function(){                                              // show email/print function
   $(this).toggleClass("active");

   // get doc if
   var id = $(this).attr("doc");

   // open doc related to file selection
   if($(this).hasClass("active"))
   {
      $(".doc-"+id).show();
   } 
   else
   {
      $(".doc-"+id).hide();
   }

   // get selected case details object
   var obj = $("input[name=case]:checked").parent("th").parent("tr.row-link");

   // replace string from casemanager name etc
   var str = $(".doc-"+id+"  .doc-desc").html();
   str = str.replace(/{insured_name}/gi, obj.attr("insured_name"))
   .replace("{insured_address}", obj.attr("insured_address"))
   .replace("{insured_lastname}", obj.attr("insured_lastname"))
   .replace("{policy_no}", obj.attr("policy_no"))
   .replace("{case_no}", obj.attr("case_no"))
   .replace("{policy_coverage_info}", "{policy_coverage_info}")
   .replace("{casemanager_name}", obj.attr("casemanager_name"));

   $(".doc-"+id+" .doc-desc").html(str);

});

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

</script>