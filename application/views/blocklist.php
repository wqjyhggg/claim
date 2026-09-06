<div>
	<div class="page-title">
		<div class="title_left">
			<h3>Block Customer Management</h3>
		</div>
	</div>
	<div class="clearfix"></div>
	<?php echo $message?>
	
	<!-- search section -->
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_content">
					<?php echo form_open("blocklist", array('class'=>'form-horizontal', 'method'=>'get')); ?>
					<div class="row">
            <div class="form-group col-sm-3">
              <?php echo form_label ( 'Firstname:', 'firstname', array ("class" => 'col-sm-12') ); ?>
              <?php echo form_input("firstname", $this->input->get("firstname"), array ("class" => "form-control", 'placeholder' => 'First Name')); ?>
            </div>
            <div class="form-group col-sm-3">
              <?php echo form_label ( 'Lastname:', 'lastname', array ("class" => 'col-sm-12') ); ?>
              <?php echo form_input("lastname", $this->input->get("lastname"), array ("class" => "form-control", 'placeholder' => 'Last Name')); ?>
            </div>
            <div class="form-group col-sm-3">
              <div class="input-group date">
                <?php echo form_label ( 'Birthday:', 'birthday', array ("class" => 'col-sm-12') ); ?>
                <?php echo form_input("birthday", $this->input->get("birthday"), array ("class" => "form-control datepicker", 'placeholder' => 'Birthday')); ?>
                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
              </div>
            </div>
						<div class="col-sm-3">
              <?php echo form_label ( 'Status:', 'status', array ("class" => 'col-sm-12') ); ?>
							<?php echo form_dropdown ( "status", array(0 => "-- Status --", 1 => "Warning", 2 => "Blocked"), $this->input->post_get( "status" ), array ("class" => 'form-control') );?>
						</div>
						<div class="col-sm-6">
							<?php echo form_label('Listed Customer:', 'listed_user', array ("class" => 'col-sm-12')); ?>
              <span style="margin-left: 1em;">
              <input type="checkbox" name="listed_user" value="1" <?php if ($this->input->get('listed_user') != 0) { echo "checked"; } ?> /> Listed
						</div>
						<div class="col-sm-6">
							<?php echo form_submit("Search", "Search", array("class"=>'btn btn-primary', "type"=>'submit'))?>
						</div>
					</div>
					<?php echo form_close(); ?>
				</div>
			</div>
		</div>
	</div>
	<div class="clearfix"></div>
	<!-- end of search section -->

	<!-- Product List Section -->
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Block Customer List<small></small></h2>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<?php if(!empty($block_list)) : ?>
					<div class="table-responsive">
						<table class="table table-hover table-bordered">
							<thead>
								<tr>
									<th><?php echo $this->pagination->sort("block_list_id", "ID") ?></th>
									<th><?php echo $this->pagination->sort("firstname", "First Name") ?></th>
									<th><?php echo $this->pagination->sort("lastname", "Last Name") ?></th>
									<th><?php echo $this->pagination->sort("birthday", "Birthday") ?></th>
									<th><?php echo $this->pagination->sort("status", "Status") ?></th>
									<th>Notes</th>
									<th>Time</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($block_list as $user) : ?>
								<tr>
									<td>#<?php echo isset($user['block_list_id'])?htmlspecialchars($user['block_list_id'],ENT_QUOTES,'UTF-8'):"-";?></td>
									<td><?php echo htmlspecialchars($user['firstname'],ENT_QUOTES,'UTF-8');?></td>
									<td><?php echo htmlspecialchars($user['lastname'],ENT_QUOTES,'UTF-8');?></td>
									<td><?php echo htmlspecialchars($user['birthday'],ENT_QUOTES,'UTF-8');?></td>
									<td><?php echo empty($user['status'])?"-":(($user['status']==1)?"Warning":"Blocked") ?></td>
									<td>
                    <?php
                    $notes = isset($user['notes']) ? $user['notes'] : "";
                    $notes_short = mb_strlen($notes, 'UTF-8') > 20
                        ? mb_substr($notes, 0, 20, 'UTF-8') . '...'
                        : $notes;
                    ?>

                    <a href="javascript:void(0);"
                      class="edit-notes"
                      data-id="<?php echo (int)$user['block_list_id']; ?>"
                      data-user-id="<?php echo $user_id; ?>"
                      data-notes="<?php echo htmlspecialchars($notes, ENT_QUOTES, 'UTF-8'); ?>"
                      title="Click to edit notes">
                        <?php echo htmlspecialchars($notes_short, ENT_QUOTES, 'UTF-8'); ?>
                    </a>
                  </td>
									<td><?php echo htmlspecialchars($user['created'],ENT_QUOTES,'UTF-8');?></td>
									<td><?php echo empty($user['status'])?anchor("blocklist/add?firstname=".htmlspecialchars($user['firstname'],ENT_QUOTES,'UTF-8')."&lastname=".htmlspecialchars($user['lastname'],ENT_QUOTES,'UTF-8')."&birthday=".htmlspecialchars($user['birthday'],ENT_QUOTES,'UTF-8'), 'Add') : (($user['status']==1)?anchor("blocklist/update?status=1&block_list_id=".$user['block_list_id'], 'Block'):anchor("blocklist/update?status=2&block_list_id=".$user['block_list_id'], 'Unblock'));?></td>
								</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
					<?php else: ?>
					<center><?php echo heading("No record available", 4); ?></center>
					<?php endif; ?>
					<?php echo $pagination; ?>
				</div>
			</div>
		</div>
	</div>
	<!-- End List Section -->
  <!-- Notes Edit Modal -->
  <div class="modal fade" id="notesModal" tabindex="-1" role="dialog" aria-labelledby="notesModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title" id="notesModalLabel">Customer Notes</h4>
        </div>
        <div class="modal-body">
          <!-- Current Notes -->
          <div class="form-group">
            <label>Current Notes:</label>
            <div id="currentNotes" style="
                          border: 1px solid #ddd;
                          background-color: #f9f9f9;
                          padding: 10px;
                          height: 200px;
                          overflow-y: auto;
                          white-space: pre-wrap;
                          word-break: break-word;
                        ">
            </div>
          </div>
          <!-- New Note -->
          <div class="form-group">
            <label for="newNote">Add Note:</label>
            <textarea id="newNote" class="form-control" rows="4" placeholder="Enter note..."></textarea>
          </div>
          <input type="hidden" id="notesBlockListId">
          <input type="hidden" id="userId">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-primary" id="addNoteButton">Add</button>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
$(document).ready(function () {
  /* Click Notes */
  $(document).on('click', '.edit-notes', function () {
    var blockListId = $(this).data('id');
    var notes = $(this).attr('data-notes');
    var user_id = $(this).attr('user_id');
    // Set current notes
    $('#currentNotes').text(notes);
    // Set ID
    $('#notesBlockListId').val(blockListId);
    // User ID
    $('#userId').val(user_id);
    // Clear input
    $('#newNote').val('');
    // Show modal
    $('#notesModal').modal('show');
  });

  /* Add new note */
  $('#addNoteButton').on('click', function () {
    var blockListId = $('#notesBlockListId').val();
    var newNote = $('#newNote').val();
    var userId = $('#userId').val();
    // Remove leading/trailing spaces
    newNote = $.trim(newNote);
    /*
     * Empty input:
     * Same behavior as Cancel
     */
    if (newNote === '') {
      $('#notesModal').modal('hide');
      return;
    }
    /*
     * Disable button to prevent double click
     */
    var $button = $(this);
    $button.prop('disabled', true);
    $.ajax({
      url: '<?php echo site_url("blocklist/add_note"); ?>',
      type: 'POST',
      dataType: 'json',
      data: {
          block_list_id: blockListId,
          user_id: userId,
          note: newNote
      },
      success: function (response) {
        if (response.success) {
          $('#notesModal').modal('hide');
          /*
           * Reload page so the latest notes
           * will be displayed.
           */
          location.reload();
        } else {
          alert(response.message || 'Failed to add note.');
        }
      },
      error: function () {
        alert('An error occurred while adding the note.');
      },
      complete: function () {
        $button.prop('disabled', false);
      }
    });
  });
});
</script>