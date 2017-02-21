<duv >
   <div class="page-title">
      <div class="title_left">
         <h3>Create User</h3>
      </div>
   </div>
   <div class="clearfix"></div>
   <!-- Product List Section -->
   <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
         <div class="x_panel">
            <div class="x_title">
               <h2>User Form<small></small></h2><?php echo anchor("auth/users", 'Cancel', array("class"=>'btn btn-primary pull-right')) ;?>
               <div class="clearfix"></div>
               <?php echo $message ?>
            </div>
            <div class="x_content">
              <?php echo form_open("auth/create_user", array("class"=>'form-horizontal'));?>              
              <div class="row">
                <div class="col-sm-6 form-group">
                  <?php echo form_label('First Name', 'first_name', array("class"=>'col-sm-12'));?>
                  <div class="col-sm-12 input-group">
                    <?php echo form_input($first_name);?>
                  </div>
                </div>

                <div class="col-sm-6 form-group">
                  <?php echo form_label('Last Name', 'last_name', array("class"=>'col-sm-12'));?>
                  <div class="col-sm-12 input-group">
                    <?php echo form_input($last_name);?>
                  </div>
                </div>

                <?php
                if($identity_column!=='email') {
                  ?>
                  <div class="col-sm-6 form-group">
                    <?php echo form_label('Identity', 'identity', array("class"=>'col-sm-12'));?>
                    <div class="col-sm-12 input-group">
                      <?php echo form_input($identity);?>
                    </div>
                  </div>
                <?php
                }
                ?>

                <div class="col-sm-6 form-group">
                  <?php echo form_label('Email', 'email', array("class"=>'col-sm-12'));?>
                  <div class="col-sm-12 input-group">
                    <?php echo form_input($email);?>
                  </div>
                </div>

                <div class="col-sm-6 form-group">
                  <?php echo form_label('Phone', 'phone', array("class"=>'col-sm-12'));?>
                    <div class="col-sm-12 input-group">
                  <?php echo form_input($phone);?>
                  </div>
                </div>

                <div class="col-sm-6 form-group">
                  <?php echo form_label('Password', 'password', array("class"=>'col-sm-12'));?>
                  <div class="col-sm-12 input-group">
                    <?php echo form_input($password);?>
                  </div>
                </div>

                <div class="col-sm-6 form-group">
                  <?php echo form_label('Confirm Password', 'password_confirm', array("class"=>'col-sm-12'));?>
                  <div class="col-sm-12 input-group">
                    <?php echo form_input($password_confirm);?>
                  </div>
                </div>
                <div class="clearfix"></div>

                <?php echo heading('Member of groups', 2);?>

                <div class="col-sm-12 form-group">
                  <?php foreach ($groups as $group):?>
                    <div class="col-sm-3">
                      <label class="form_checkbox">
                        <?php
                          $gID=$group['id'];
                          $checked = null;
                          $item = null;
                          $currentGroups = $this->input->post("groups");
                          if(!empty($currentGroups))
                            foreach($currentGroups as $grp) {
                                if ($gID == $grp) {
                                    $checked= ' checked="checked"';
                                break;
                                }
                            }
                        ?>
                        <input type="checkbox" name="groups[]" value="<?php echo $group['id'];?>"<?php echo $checked;?>>
                        <?php echo htmlspecialchars($group['description'],ENT_QUOTES,'UTF-8');?>
                      </label>
                    </div>
                  <?php endforeach?>
                </div>

              </div>

              <div class="row">              
                <div class="col-sm-6 form-group manager_panel" 
                <?php                   
                $groupData = $this->input->post('groups');
                if(empty($groupData) or !in_array(2, $groupData)){
                ?>
                  style="display:none"
                <?php }?>
                >
                  <?php echo form_label('Select Shift', 'shift', array("class"=>'col-sm-12'));?>
                  <div class="col-sm-12 input-group">
                    <?php
                      echo form_dropdown("shift", $shift_options, $this->form_validation->set_value('shift'), array('class'=>'form-control'));
                    ?>
                  </div>
                </div>

                <div class="col-sm-12 form-group">
                  <?php echo form_submit('submit', "Submit", array("class"=>'btn btn-primary pull-right'));?>
                </div>

              </div>
              <?php echo form_close();?>

            </div>
         </div>
      </div>
   </div>
</duv>
<script>
  // show manager panel if user is emc
  $(document).on("click", "input[type=checkbox]", function(){
    if($(this).val() == 2 && $(this).is(":checked")) 
    {
      // show manager panel
      $(".manager_panel").show();
    }

    if($(this).val() == 2 && !$(this).is(":checked")) 
    {
      // hide manager panel
      $(".manager_panel").hide();
    }
  })
</script>