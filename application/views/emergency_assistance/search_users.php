<?php if(!empty($users)): ?>
<div class="table-responsive">
  <table class="table table-hover table-bordered">
     <thead>
        <tr>
           <th>ID</th>
           <th>First Name</th>
           <th>Last Name</th>
           <th>Email Address</th>
           <th>Shift</th>
        </tr>
     </thead>
     <tbody>
        <?php foreach ($users as $user):?>
        <tr>
           <td><?php echo "EAC".str_pad($user['id'], 4, 0, STR_PAD_LEFT);?></td>
           <td><?php echo htmlspecialchars($user['first_name'],ENT_QUOTES,'UTF-8');?></td>
           <td><?php echo htmlspecialchars($user['last_name'],ENT_QUOTES,'UTF-8');?></td>
           <td><?php echo htmlspecialchars($user['email'],ENT_QUOTES,'UTF-8');?></td>
           <td>
              <div class="form-group col-sm-12">
                 <div class="form-group col-sm-9">
                    <?php 
                      // to check future dates
                      $disabled = FALSE;
                      if(time() > strtotime($date) and $type == 'date')
                        $disabled = TRUE;

                      $status = array(
                        ''=>'Select Shift',
                        '8am-2pm'=>'8am-2pm',
                        '2pm-8pm'=>'2pm-8pm',
                        '8pm-8am'=>'8pm-8am',
                      );
                      $attr = array(
                        "class"=>'form-control select_schedule',
                         'alt'=>$user['id']
                         );

                      // to set default blank once case manager clicked on day header
                      if($type == 'day')
                        $user['schedule'] = "";

                      // in case of past date
                      if($disabled)
                        $attr['disabled'] = TRUE;
                      echo form_dropdown("status", $status, $user['schedule'], $attr);
                    ?>
                 </div>
                <?php if(!@$attr['disabled']):?>
                  <div class="form-group col-sm-2" <?php if(!$user['schedule']): ?>style="display:none"<?php endif; ?> >
                    <i class="fa fa-trash row-link" style="margin-top:10px" title="Remove Schedule"></i>
                  </div>
                <?php endif; ?>
              </div>
           </td>
        </tr>
        <?php endforeach;?>
     </tbody>
  </table>
</div>
<?php else:?>
  <center><?php echo heading("No record available", 4); ?></center>
<?php endif;?>