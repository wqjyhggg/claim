<div>
	<div class="page-title">
		<div class="title_left">
			<h3>Agent Performance</h3>
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
							<?php echo form_label('Date From:', 'newcall_from', array("class"=>'col-sm-12')); ?>
							<div class="input-group date">
								<?php echo form_input ( "newcall_from", $this->input->post ( "newcall_from" ), array ("class" => "form-control datepicker", 'placeholder' => 'Date From') ); ?>
								<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
							</div>
						</div>
						<div class="form-group col-sm-3">
							<?php echo form_label('Date To:', 'newcall_to', array("class"=>'col-sm-12')); ?>
							<div class="input-group date">
								<?php echo form_input ( "newcall_to", $this->input->post ( "newcall_to" ), array ("class" => "form-control datepicker", 'placeholder' => 'Date To') ); ?>
								<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
							</div>
						</div>
						<div class="form-group col-sm-3">
							<?php echo form_label('Creater:', 'created_by', array ("class" => 'col-sm-12')); ?>
							<select name="agent" class="form-control">
								<option value="">-- Select Creater --</option>
								<?php foreach ($eacs as $rc) { ?>
								<option value="<?php echo $rc['id']; ?>" <?php if ($rc['id'] == $this->input->get('agent')) { echo "selected"; } ?>><?php echo $rc['email']; ?></option>
								<?php } ?>
							</select>
						</div>
						<div class="form-group col-sm-12">
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
									<th>Agent</th>
									<th>Email</th>
									<th>New Call</th>
									<th>Answer</th>
									<th>Hangup</th>
									<th>Direction</th>
									<th>Caller</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ( $records as $key => $value ) { ?>
								<tr>
									<td><?php echo $value['agent']; ?></td>
									<td><?php echo $value['email']; ?></td>
									<td><?php echo $value['newcall']; ?></td>
									<td><?php echo $value['answer']; ?></td>
									<td><?php echo $value['hangup']; ?></td>
									<td><?php echo $value['direction']; ?></td>
									<td><?php echo $value['caller_id_number']; ?></td>
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