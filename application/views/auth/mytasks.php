<?php $this->load->model('mytask_model'); ?>
<div>
	<div class="page-title">
		<div class="title_left"><h3>My Tasks</h3></div>
	</div>
	<div class="clearfix"></div>
	<!-- Product List Section -->
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2 class="task_heading">
						My Tasks!<small></small>
					</h2>
					<div class='pull-right'><input type="checkbox" id="finished_input" <?php echo ($finished ? 'checked' : '');?>> Finished Task</div>
					<div class='pull-right'><a href="<?php echo $case_only_url; ?>" class="btn btn-info" role="button">Case Only</a></div>
					<div class='pull-right'><a href="<?php echo $claim_only_url; ?>" class="btn btn-info" role="button">Claim Only</a></div>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<div class="table-responsive">
					<?php if(!empty($records)): ?>
						<table class="table table-hover table-bordered">
							<thead>
								<tr>
									<th>Task ID</th>
									<th><?php echo $this->pagination->sort("priority", "Priority") ?></th>
									<th>Case/Claim No.</th>
									<th>Status</th>
									<th>Insured Name</th>
									<th>Created By</th>
									<th>Created DateTime</th>
									<th><?php echo $this->pagination->sort("due", "Due DateTime") ?></th>
									<?php if ($this->ion_auth->in_group(Users_model::GROUP_ADMIN)) { ?>
									<th>Assign to</th>
									<?php } ?>
							</thead>
							<tbody>
								<?php
								$i = 0;
								$claims = array();
								$cases = array();
								foreach ( $records as $key => $value ) :
									$i ++;
									if ($value ['type'] == 'CLAIM')
										$claims [] = $i;
									else
										$cases [] = $i;
								?>
								<tr <?php if($value['priority'] == 'HIGH') echo 'style="background-color:rgba(155, 243, 151, 0.44)"'; ?>>
									<td><?php echo anchor('auth/edit_task/'.$value['id'], $value['id'], array('title'=>'Edit Task')) . " (" . $value ['type'] . ")"; ?></td>
									<td><?php echo $value['priority']; ?></td>
									<td><?php echo anchor(($value['type']=='CLAIM'?'claim/claim_detail/'.$value['item_id']:'emergency_assistance/edit_case/'.$value['item_id']), $value['task_no'], array('title'=>'Item Details')) ?></td>
									<td><?php echo $value['status']; ?></td>
									<td><?php echo $value['insured_name']; ?></td>
									<td><?php echo $value['created_email']; ?></td>
									<td><?php echo $value['created']; ?></td>
									<td><?php echo $value['due_date'] . " " . $value['due_time']; ?></td>
									<?php if ($this->ion_auth->in_group(Users_model::GROUP_ADMIN)) { ?>
									<td><?php echo $value['assign_name']; ?></td>
									<?php } ?>
								</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					<?php else: ?>
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
</div>
<script>
$(document).ready(function() {
	$('#finished_input').on('change', function() {
		var ck;
		if ($(this).is(':checked')) {
			ck = 1;
		} else {
			ck = 0;
		}
		$.ajax({
			url: '<?php echo $finish_url; ?>',
			type: 'POST',
			datatype: 'json',
			data: {finished : ck},
			success: function(result) {
				location.href='<?php echo base_url() ?>/auth/mytasks';
			}
		});
	});

<?php
if (isset($i)) {
	$str = '';
	if (count ( $claims ) and count ( $cases )) {
		$str = '(' . count ( $cases ) . ' Case' . (count ( $cases ) > 1 ? 's' : '') . '/' . count ( $claims ) . ' Claim' . (count ( $claims ) > 1 ? 's' : '') . ')';
	} elseif (count ( $claims )) {
		$str = '(' . count ( $claims ) . ' Claim' . (count ( $claims ) > 1 ? 's' : '') . ')';
	} elseif (count ( $cases )) {
		$str = '(' . count ( $cases ) . ' Case' . (count ( $cases ) > 1 ? 's' : '') . ')';
	}
	if ($str) {
?>
	$(".task_heading").text('My Tasks! <?php echo $str; ?>');
<?php
	}
}
?>
});
</script>