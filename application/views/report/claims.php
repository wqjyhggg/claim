<div>
	<div class="page-title">
		<div class="title_left">
			<h3>Claims</h3>
		</div>
	</div>
	<div class="clearfix"></div>
	<!-- Product List Section -->
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_content">
					<!-- search filter start -->
					<?php echo form_open("", array('class'=>'form-horizontal', 'method'=>'get')); ?>
					<div class="row">
						<div class="form-group col-sm-3">
							<?php echo form_label('Priority:', 'priority', array ("class" => 'col-sm-12')); ?>
							<select name="priority" class="form-control">
								<option value="">-- Select Priority --</option>
								<?php foreach ($priorities as $val) { ?>
								<option value="<?php echo $val; ?>" <?php if ($val == $this->input->get('priority')) { echo "selected"; } ?>><?php echo $val; ?></option>
								<?php } ?>
							</select>
						</div>
						<div class="form-group col-sm-3">
							<?php echo form_label('Status:', 'status', array ("class" => 'col-sm-12')); ?>
							<select name="status" class="form-control">
								<option value="">-- Select Status --</option>
								<?php foreach ($statuses as $key => $val) { ?>
								<option value="<?php echo $key; ?>" <?php if ($key == $this->input->get('status')) { echo "selected"; } ?>><?php echo $val; ?></option>
								<?php } ?>
							</select>
						</div>
						<div class="form-group col-sm-3">
							<?php echo form_label('Manager:', 'assign_to', array ("class" => 'col-sm-12')); ?>
							<select name="assign_to" class="form-control">
								<option value="">-- Select Manager --</option>
								<?php foreach ($managers as $rc) { ?>
								<option value="<?php echo $rc['id']; ?>" <?php if ($rc['id'] == $this->input->get('assign_to')) { echo "selected"; } ?>><?php echo $rc['email']; ?></option>
								<?php } ?>
							</select>
						</div>
						<div class="form-group col-sm-3">
							<?php echo form_label('Creater:', 'created_by', array ("class" => 'col-sm-12')); ?>
							<select name="created_by" class="form-control">
								<option value="">-- Select Creater --</option>
								<?php foreach ($eacs as $rc) { ?>
								<option value="<?php echo $rc['id']; ?>" <?php if ($rc['id'] == $this->input->get('created_by')) { echo "selected"; } ?>><?php echo $rc['email']; ?></option>
								<?php } ?>
								<?php foreach ($managers as $rc) { ?>
								<?php     if (!array_key_exists($rc['id'], $eacs)) { ?>
								<option value="<?php echo $rc['id']; ?>" <?php if ($rc['id'] == $this->input->get('created_by')) { echo "selected"; } ?>><?php echo $rc['email']; ?></option>
								<?php     } ?>
								<?php } ?>
							</select>
						</div>
						<div class="col-sm-11">
							<label class="col-sm-12">&nbsp;</label>
							<button class="btn btn-primary pull-right" name="filter" value="1">Search</button>
							<?php echo anchor($export_url, 'Export', array('title'=>'Export', 'class' => 'btn btn-primary pull-right')); ?>
						</div>
					</div>
					<?php echo form_close(); ?>
					<!-- search policy filter end -->
					<div class="clearfix"><br /></div>

					<div class="table-responsive">
					<?php if(!empty($records)): ?>
						<table class="table table-hover table-bordered">
							<thead>
								<tr>
									<th>Case No.</th>
									<th>Claim No.</th>
									<th>Status</th>
									<th>Created By</th>
									<th>Created DateTime</th>
									<th>Product</th>
									<th>Policy</th>
									<th>Manager</th>
									<th>Last Update</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ( $records as $key => $value ) { ?>
								<tr>
									<td><?php echo $value['case_no'] ? anchor('emergency_assistance/edit_case/'.$value['id'], $value['case_no'], array('title'=>'Details')) : ''; ?></td>
									<td><?php echo $value['claim_no'] ? anchor('claim/claim_detail/'.$value['id'], $value['claim_no'], array('title'=>'Details')) : ''; ?></td>
									<td><?php echo $statuses[$value['status']]; ?></td>
									<td><?php echo $value['created_email']; ?></td>
									<td><?php echo $value['created']; ?></td>
									<td><?php echo $value['product_short']; ?></td>
									<td><?php echo $value['policy_no']; ?></td>
									<td><?php echo $value['manager_email']; ?></td>
									<td><?php echo $value['last_update']; ?></td>
								</tr>
								<?php } ?>
							</tbody>
						</table>
						<?php else: ?>
						<center><?php echo heading("No record available", 4); ?></center>
						<?php endif; ?>
						<?php echo $pagination; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- End List Section -->
</div>
<script>
$(document).ready(function() {
});
</script>