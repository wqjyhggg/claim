<div>
	<div class="page-title">
		<div class="title_left">
			<h3>Payables</h3>
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
						<div class="form-group col-sm-4">
							<?php echo form_label('Created Date From:', 'created_from', array("class"=>'col-sm-12')); ?>
							<div class="input-group date">
								<?php echo form_input ( "created_from", $this->input->post ( "created_from" ), array ("class" => "form-control datepicker", 'placeholder' => 'Created From') ); ?>
								<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
							</div>
							<?php echo form_label('Created Date To:', 'created_to', array("class"=>'col-sm-12')); ?>
							<div class="input-group date">
								<?php echo form_input ( "created_to", $this->input->post ( "created_to" ), array ("class" => "form-control datepicker", 'placeholder' => 'Created To') ); ?>
								<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
							</div>
						</div>
						<div class="form-group col-sm-4">
							<?php echo form_label('Updated Date From:', 'last_update_from', array("class"=>'col-sm-12')); ?>
							<div class="input-group date">
								<?php echo form_input ( "last_update_from", $this->input->post ( "last_update_from" ), array ("class" => "form-control datepicker", 'placeholder' => 'Updated From') ); ?>
								<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
							</div>
							<?php echo form_label('Updated Date To:', 'last_update_to', array("class"=>'col-sm-12')); ?>
							<div class="input-group date">
								<?php echo form_input ( "last_update_to", $this->input->post ( "last_update_to" ), array ("class" => "form-control datepicker", 'placeholder' => 'Updated To') ); ?>
								<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
							</div>
						</div>
						<div class="form-group col-sm-4">
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
									<th>Claim No.</th>
									<th>Itim No.</th>
									<th>Status</th>
									<th>Updated</th>
									<th>Created</th>
									<th>Created By</th>
									<th>Coverage Code</th>
									<th>Payable</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ( $records as $key => $value ) { ?>
								<tr>
									<td><?php echo $value['claim_no'] ? anchor('claim/claim_detail/'.$value['id'], $value['claim_no'], array('title'=>'Details')) : ''; ?></td>
									<td><?php echo $value['claim_item_no']; ?></td>
									<td><?php echo $statuses[$value['status']]; ?></td>
									<td><?php echo $value['last_update']; ?></td>
									<td><?php echo substr($value['created'], 0, 10); ?></td>
									<td><?php echo $value['created_email']; ?></td>
									<td><?php echo $value['coverage_code']; ?></td>
									<td><?php echo $value['amt_payable']; ?></td>
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
<?php echo link_tag('assets/css/bootstrap-datepicker.css'); ?>
<script src="<?php echo base_url() ?>/assets/js/bootstrap-datetimepicker.js"></script>
<script>
$(document).ready(function() {
	$(".datepicker").datepicker({
//		startDate: '-105y',
		endDate: '+0d',
	});
});
</script>