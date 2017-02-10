<duv >
   <div class="page-title">
      <div class="title_left">
         <h3>My Tasks</h3>
      </div>
   </div>
   <div class="clearfix"></div>
   <!-- Product List Section -->
   <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
         <div class="x_panel">
            <div class="x_title">
               <h2>My Tasks! (5 Cases/2 Claims)<small></small></h2>
               <div class="clearfix"></div>
            </div>
            <div class="x_content">
               <div class="table-responsive">
               <?php if(!empty($records)): ?>
                  <table class="table table-hover table-bordered">
                     <thead>
                        <tr>
                           <th></th>
                           <th>No.</th>
                           <th>Priority</th>
                           <th>Task No</th>
                           <th>Insured Name</th>
                           <th>Created DateTime</th>
                           <th>Due Date</th>
                           <th>Outcome</th>
                           <th>Follow Up EAC</th>
                           <th>Created By</th>
                           <th>Complition Date</th>
                           <th>Category</th>
                     </thead>
                     <tbody>
                        <?php $i = 0;
                        foreach ($records as $key => $value): 
                           $i++;
                         ?>
                           <tr>
                              <td><i class="fa fa-edit"></i></td>
                              <td><?php echo $i; ?>.</td>
                              <td><?php echo $value['priority']; ?></td>
                              <td><?php echo $value['task_no']; ?></td>
                              <td><?php echo $value['insured_name']; ?></td>
                              <td><?php echo date('Y-m-d h:i a', strtotime($value['created'])); ?></td>
                              <td><?php echo $value['due_date']; ?></td>
                              <td><?php echo $value['outcome']; ?></td>
                              <td><?php echo $value['followup_by']?"EAC".$value['followup_by']:""; ?></td>
                              <td><?php echo $value['created_by']; ?></td>
                              <td><?php echo $value['completion_date']; ?></td>
                              <td><?php echo $value['category']; ?></td>
                           </tr>
                        <?php endforeach; ?>
                     </tbody>
                  </table>
                  <?php else:?>
                  <center><?php echo heading("No record available", 4); ?></center>
               <?php endif;
               echo $pagination;
               ?>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- End List Section -->
</duv>