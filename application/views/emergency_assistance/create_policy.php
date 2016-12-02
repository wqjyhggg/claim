

<duv >
   <div class="page-title">
      <div class="title_left">
         <h3>Create Policy</h3>
      </div>
   </div>
   <div class="clearfix"></div>
   <!-- Policy search and List Section -->
   <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
         <div class="x_panel">
            <div class="x_title">
               <h2>Policy Details<small></small></h2>
               <div class="clearfix"></div>
            </div>
            <div class="x_content">
               <?php echo form_open("", array('class'=>'form-horizontal', 'method'=>'post')); ?>
               <div class="row" style="margin-bottom:15px;">
                  <div class="form-group col-sm-3">
                     <label><span>JF Elite Plus International Student to Canada</span></label>
                  </div>
                  <div class="form-group col-sm-3">
                     <label style="text-transform: capitalize;">By Agent[ AgentID:1 ] : AdminF AdminL</label>
                  </div>
               </div>
               <div class="row">
                  <div class="col-sm-12">
                     <fieldset>
                        <legend>Travel Dates</legend>
                        <div class="row">
                           <div class="form-group col-sm-3">
                              <?php echo form_label('Apply Date:', 'apply_date', array("class"=>'col-sm-12'));   ?>
                              <div class="input-group date">
                                 <?php                
                                 echo form_input("apply_date", $this->input->post("apply_date"), array("class"=>"form-control", 'placeholder'=>'Apply Date'));
                                 ?>
                                 <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                              </div>
                           </div>
                           <div class="form-group col-sm-3">
                              <?php echo form_label('Arrival Date:', 'arrival_date', array("class"=>'col-sm-12'));   ?>
                              <div class="input-group date">
                                 <?php                
                                 echo form_input("arrival_date", $this->input->post("arrival_date"), array("class"=>"form-control", 'placeholder'=>'Arrival Date'));
                                 ?>
                                 <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                              </div>
                           </div>
                           <div class="form-group col-sm-3">
                              <?php echo form_label('Effective Date:', 'effective_date', array("class"=>'col-sm-12'));   ?>
                              <div class="input-group date">
                                 <?php                
                                 echo form_input("effective_date", $this->input->post("effective_date"), array("class"=>"form-control", 'placeholder'=>'Effective Date'));
                                 ?>
                                 <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                              </div>
                           </div>
                           <div class="form-group col-sm-3">
                              <?php echo form_label('Expiry Date:', 'expiry_date', array("class"=>'col-sm-12'));   ?>
                              <div class="input-group date">
                                 <?php                
                                 echo form_input("expiry_date", $this->input->post("expiry_date"), array("class"=>"form-control", 'placeholder'=>'Expiry Date'));
                                 ?>
                                 <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                              </div>
                           </div>
                        </div>
                        <div class="row">
                           <div class="col-sm-1">
                              <?php 
                                 echo form_label('Days:', 'totaldays', array("class"=>'col-sm-12'));                            
                                 echo form_input("totaldays", $this->input->post("totaldays"), array("class"=>"form-control", 'placeholder'=>'Days'));
                              ?>
                           </div>
                           <div class="col-sm-2">
                              <div class="input-group col-sm-12" style="padding-top: 28px;">
                                 <?php echo form_checkbox("checkboxdays", "Y", $this->input->post("checkboxdays"), array('class'=>'setpremium')); ?>  1 Year
                              </div>
                           </div>
                           <div class="col-sm-3">
                              <?php 
                                 echo form_label('Daily Rate:', 'dailyrate', array("class"=>'col-sm-12'));                     
                                 echo form_input("dailyrate", $this->input->post("dailyrate"), array("class"=>"form-control", 'placeholder'=>'Daily Rate', 'readonly'=>'readonly'));
                              ?>
                           </div>
                           <div class="col-sm-3">
                              <?php 
                                 echo form_label('Age:', 'totalyears', array("class"=>'col-sm-12'));                            
                                 echo form_input("totalyears", $this->input->post("totalyears"), array("class"=>"form-control", 'placeholder'=>'Age', 'readonly'=>'readonly'));
                              ?>
                           </div>
                           <div class="col-sm-3">
                              <?php 
                                 echo form_label('Premium:', 'premium', array("class"=>'col-sm-12'));                           
                                 echo form_input("premium", $this->input->post("premium"), array("class"=>"form-control", 'placeholder'=>'Premium'));
                              ?>
                           </div>
                        </div>
                     </fieldset>
                  </div>
               </div>
               <br>
               <div class="row">
                  <div class="col-sm-12">
                     <fieldset>
                        <legend>Insurable Options</legend>
                        <div class="row">
                           <div class="form-group col-sm-3">
                              <?php 
                                 echo form_label('Beneficiary:', 'beneficiary', array("class"=>'col-sm-12'));                           
                                 echo form_input("beneficiary", $this->input->post("beneficiary"), array("class"=>"form-control", 'placeholder'=>'Beneficiary'));
                              ?>
                           </div>
                           <div class="form-group col-sm-3">
                              <?php 
                                 echo form_label('Is Family Plan:', 'isfamilyplan', array("class"=>'col-sm-12'));                           
                                 echo form_checkbox("isfamilyplan", "Y",  $this->input->post("isfamilyplan"), array("class"=>"input-group", 'placeholder'=>'Is Family Plan'));
                              ?>
                           </div>
                           <div class="form-group col-sm-3">
                              <?php 
                                 echo form_label('Holiday Rate:', 'holiday_rate', array("class"=>'col-sm-12'));                           
                                 echo form_checkbox("holiday_rate", "Y",  $this->input->post("holiday_rate"), array("class"=>"input-group", 'placeholder'=>'Holiday Rate'));
                              ?>
                           </div>
                           <div class="form-group col-sm-3">
                              <label class="col-sm-12">Sum Insured (CAD) : $5,000,000</label>
                              <input name="sum_insured" value="5000000" type="hidden">
                           </div>
                        </div>
                        <div class="row">
                           <div class="form-group col-sm-3">
                               <?php 
                                 echo form_label('Student ID:', 'student_id', array("class"=>'col-sm-12'));                           
                                 echo form_input("student_id", $this->input->post("student_id"), array("class"=>"form-control", 'placeholder'=>'Student ID'));
                              ?>
                           </div>
                           <div class="form-group col-sm-3">
                              <?php 
                                 echo form_label('School Name:', 'institution', array("class"=>'col-sm-12'));                           
                                 echo form_input("institution", $this->input->post("institution"), array("class"=>"form-control", 'placeholder'=>'School Name'));
                              ?>
                           </div>
                           <div class="form-group col-sm-3">
                              <?php 
                                 echo form_label('School Full Address:', 'institution_addr', array("class"=>'col-sm-12'));                           
                                 echo form_input("institution_addr", $this->input->post("institution_addr"), array("class"=>"form-control", 'placeholder'=>'School Full Address'));
                              ?>
                           </div>
                           <div class="form-group col-sm-3">
                              <?php 
                                 echo form_label('School Phone:', 'institution_phone', array("class"=>'col-sm-12'));                           
                                 echo form_input("institution_phone", $this->input->post("institution_phone"), array("class"=>"form-control", 'placeholder'=>'School Phone'));
                              ?>
                           </div>
                        </div>
                     </fieldset>
                  </div>
               </div>
               <br>
               <div class="row">
                  <div class="col-sm-12">
                     <fieldset>
                        <legend>Insurable Members</legend>
                        <input name="customer_id" value="0" type="hidden">
                        <div class="row">
                           <label class="col-sm-12">Customer Information</label>
                           <div class="col-sm-3">
                              <?php 
                                 echo form_label('First Name:', 'firstname', array("class"=>'col-sm-12'));                           
                                 echo form_input("firstname", $this->input->post("firstname"), array("class"=>"form-control", 'placeholder'=>'First Name'));
                              ?>
                           </div>
                           <div class="col-sm-3">
                              <?php 
                                 echo form_label('Last Name:', 'lastname', array("class"=>'col-sm-12'));                           
                                 echo form_input("lastname", $this->input->post("lastname"), array("class"=>"form-control", 'placeholder'=>'Last Name'));
                              ?>
                           </div>
                           <div class="col-sm-3">
                              <?php echo form_label('Birth Date:', 'birthday', array("class"=>'col-sm-12'));   ?>
                              <div class="input-group date">
                                 <?php                
                                 echo form_input("birthday", $this->input->post("birthday"), array("class"=>"form-control", 'placeholder'=>'Birth Date'));
                                 ?>
                                 <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                              </div>
                           </div>
                           <div class="col-sm-3">
                              <?php 
                                 echo form_label('Gender:', 'gender', array("class"=>'col-sm-12'));                  
                                 $gender = array(
                                    ""=>'--Gender--',
                                    'M'=>'Male',
                                    'F'=>'Female'
                                    );
                                 echo form_dropdown("gender", $gender, $this->input->get("gender"), array("class"=>'form-control'));
                              ?>
                           </div>
                        </div>
                     </fieldset>
                  </div>
               </div>
               <br>
               <div class="row">
                  <div class="col-sm-12">
                     <fieldset>
                        <legend>Address</legend>
                        <div class="row">
                           <div class="form-group col-sm-3">
                              <?php 
                                 echo form_label('Street No:', 'street_number', array("class"=>'col-sm-12'));                           
                                 echo form_input("street_number", $this->input->post("street_number"), array("class"=>"form-control", 'placeholder'=>'Street No'));
                              ?>
                           </div>
                           <div class="form-group col-sm-3">
                              <?php 
                                 echo form_label('Street Name:', 'street_name', array("class"=>'col-sm-12'));                           
                                 echo form_input("street_name", $this->input->post("street_name"), array("class"=>"form-control", 'placeholder'=>'Street Name'));
                              ?>
                           </div>
                           <div class="form-group col-sm-3">
                              <?php 
                                 echo form_label('Suite No.:', 'suite_number', array("class"=>'col-sm-12'));
                                 echo form_input("suite_number", $this->input->post("suite_number"), array("class"=>"form-control", 'placeholder'=>'Suite No.'));
                              ?>
                           </div>
                           <div class="form-group col-sm-3">
                              <?php 
                                 echo form_label('City:', 'city', array("class"=>'col-sm-12'));                           
                                 echo form_input("city", $this->input->post("city"), array("class"=>"form-control", 'placeholder'=>'City'));
                              ?>
                           </div>
                        </div>
                        <div class="row">
                           <div class="form-group col-sm-3">
                              <?php 
                                 echo form_label('Province:', 'province2', array("class"=>'col-sm-12'));                  
                                 $province2 = array(""=>'--Select Province--');
                                 echo form_dropdown("province2", $province2, $this->input->get("province2"), array("class"=>'form-control'));
                              ?>
                           </div>
                           <div class="form-group col-sm-3">
                              <?php 
                                 echo form_label('Country:', 'country2', array("class"=>'col-sm-12'));                  
                                 $country2 = array(""=>'--Select Country--');
                                 echo form_dropdown("country2", $country2, $this->input->get("country2"), array("class"=>'form-control'));
                              ?>
                           </div>
                           <div class="form-group col-sm-3">
                              <?php 
                                 echo form_label('Postcode:', 'postcode', array("class"=>'col-sm-12'));                           
                                 echo form_input("postcode", $this->input->post("postcode"), array("class"=>"form-control", 'placeholder'=>'Postcode'));
                              ?>
                           </div>
                        </div>
                        <div class="row">
                           <div class="col-sm-3">
                              <?php 
                                 echo form_label('Phone1:', 'phone1', array("class"=>'col-sm-12'));                           
                                 echo form_input("phone1", $this->input->post("phone1"), array("class"=>"form-control", 'placeholder'=>'Phone1'));
                              ?>
                           </div>
                           <div class="col-sm-3">
                              <?php 
                                 echo form_label('Phone2:', 'phone2', array("class"=>'col-sm-12'));                           
                                 echo form_input("phone2", $this->input->post("phone2"), array("class"=>"form-control", 'placeholder'=>'Phone2'));
                              ?>
                           </div>
                        </div>
                     </fieldset>
                  </div>
               </div>
               <br>
               <div class="row">
                  <div class="col-sm-12">
                     <fieldset>
                        <legend>Contact</legend>
                        <div class="row">
                           <div class="col-sm-3">
                              <?php 
                                 echo form_label('Email:', 'contact_email', array("class"=>'col-sm-12'));                           
                                 echo form_input("contact_email", $this->input->post("contact_email"), array("class"=>"form-control", 'placeholder'=>'Email'));
                              ?>
                           </div>
                           <div class="col-sm-3">
                              <?php 
                                 echo form_label('Contact Phone:', 'contact_phone', array("class"=>'col-sm-12'));                           
                                 echo form_input("contact_phone", $this->input->post("contact_phone"), array("class"=>"form-control", 'placeholder'=>'Contact Phone'));
                              ?>
                           </div>
                           <div class="col-sm-3">
                              <?php 
                                 echo form_label('Residence:', 'residence', array("class"=>'col-sm-12'));                           
                                 echo form_input("residence", $this->input->post("residence"), array("class"=>"form-control", 'placeholder'=>'Residence'));
                              ?>
                           </div>
                        </div>
                     </fieldset>
                  </div>
               </div>
               <br>  
               <div class="row">
                  <div class="col-sm-12">
                     <fieldset>
                        <legend>Special Note/Instructions</legend>
                        <div class="row">
                           <div class="col-sm-12">
                              <?php 
                                 echo form_label('Notes:', 'note', array("class"=>'col-sm-12'));                           
                                 echo form_textarea("note", $this->input->post("note"), array("class"=>"form-control", 'placeholder'=>'Notes'));
                              ?>
                           </div>
                        </div>
                     </fieldset>
                  </div>
               </div>
               <br>
               <div class="row">
                  <div class="col-sm-12" id="goto_next_page">
                     <input class="btn btn-primary pull-right" name="submit" value="Add New Policy" type="submit">      
                  </div>
                  <div class="col-sm-12 alert-error float-error" title="Click to Close the notice" style="display:none;" id="error_next_page">
                  </div>
               </div>
               <div class="row">
                  <div class="col-sm-12">
                  </div>
               </div>
               </form>
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

