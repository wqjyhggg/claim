<duv class="main-div">
   <div class="page-title">
      <div class="title_left">
         <h3>Users Management</h3>
      </div>
   </div>
   <div class="clearfix"></div>
   <?php echo $message ?>

   <!-- search section -->
   <div class="row">
     <div class="col-md-12 col-sm-12 col-xs-12">
       <div class="x_panel">
         <div class="x_content">
           <?php echo form_open("auth/users", array('class'=>'form-horizontal', 'method'=>'get')); ?>
             <div class="row">
               <div class="form-group col-sm-3">
                  <?php echo form_dropdown("groups", $groups, $this->input->get("groups"), array("class"=>'form-control')) ?>
               </div>
               <div class="form-group col-sm-3">
                   <div class="input-group date">
                     <?php echo form_input("keyword", $this->input->get("keyword"), array("class"=>"form-control", 'placeholder'=>'Search by email and name')) ?>
                     <span class="input-group-addon"><span class="fa fa-search"></span></span>
                   </div>
               </div>
               <div class="col-sm-3">
                  <?php echo form_submit("Search", "Search", array("class"=>'btn btn-primary', "type"=>'submit')) ?>
                  <?php echo anchor("auth/users", "Reset", array('class'=>'btn btn-info')) ?>
               </div>
             </div>
           <?php echo form_close(); ?>
         </div>
       </div>
     </div>
   </div>
   <!-- end of search section -->

   <div class="clearfix"></div>
   <!-- Product List Section -->
   <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
         <div class="x_panel">
            <div class="x_title">
               <h2>Users List<small></small></h2><?php echo anchor("auth/create_user", 'Add', array("class"=>'btn btn-primary pull-right')) ;?>
               <div class="clearfix"></div>
            </div>
            <div class="x_content">
               <?php if(!empty($users)): ?>
               <div class="table-responsive">
                  <table class="table table-hover table-bordered">
                     <thead>
                        <tr>
                           <th>First Name</th>
                           <th>Last Name</th>
                           <th>Email Address</th>
                           <th>Group</th>
                           <th>Status</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody>
                     <?php foreach ($users as $user):?>
                        <tr>
                           <td><?php echo htmlspecialchars($user->first_name,ENT_QUOTES,'UTF-8');?></td>
                           <td><?php echo htmlspecialchars($user->last_name,ENT_QUOTES,'UTF-8');?></td>
                           <td><?php echo htmlspecialchars($user->email,ENT_QUOTES,'UTF-8');?></td>
                           <td>
                           <?php foreach ($user->groups as $group):?>
                           <?php echo htmlspecialchars($group->description,ENT_QUOTES,'UTF-8'); ?><br />
                           <?php endforeach?>
                           </td>
                           <td><?php echo ($user->active) ? anchor("auth/deactivate/".$user->id, lang('index_active_link')) : anchor("auth/activate/". $user->id, lang('index_inactive_link'));?></td>
                           <td><?php echo anchor("auth/edit_user/".$user->id, 'Edit') ;?></td>
                        </tr>
                     <?php endforeach;?>
                     </tbody>
                  </table>
               </div>
               <?php else:?>
                  <center><?php echo heading("No record available", 4); ?></center>
               <?php endif ?>
            </div>
         </div>
      </div>
   </div>
   <!-- End List Section -->

</duv>
