<div>
	<div class="page-title">
		<div class="title_left">
			<h3>Reserve Report</h3>
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
							<?php echo form_label('Created From:', 'created_from', array("class"=>'col-sm-12')); ?>
							<div class="input-group date">
								<?php echo form_input ( "created_from", $created_from, array ("class" => "form-control datepicker", 'placeholder' => 'Created From') ); ?>
								<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
							</div>
						</div>
						<div class="form-group col-sm-3">
							<?php echo form_label('Created To:', 'created_to', array("class"=>'col-sm-12')); ?>
							<div class="input-group date">
								<?php echo form_input ( "created_to", $created_to, array ("class" => "form-control datepicker", 'placeholder' => 'Created To') ); ?>
								<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
							</div>
						</div>
						<div class="form-group col-sm-3">
							<?php echo form_label('Updated From:', 'last_update_from', array("class"=>'col-sm-12')); ?>
							<div class="input-group date">
								<?php echo form_input ( "last_update_from", $last_update_from, array ("class" => "form-control datepicker", 'placeholder' => 'Updated From') ); ?>
								<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
							</div>
						</div>
						<div class="form-group col-sm-3">
							<?php echo form_label('Last Updated To:', 'last_update_to', array("class"=>'col-sm-12')); ?>
							<div class="input-group date">
								<?php echo form_input ( "last_update_to", $last_update_to, array ("class" => "form-control datepicker", 'placeholder' => 'Updated To') ); ?>
								<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-sm-9">
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
									<th>Case / Claim No.</th>
									<th>InitialReserveAmount</th>
									<th>TotalReserveAmount</th>
									<th>CurrentReserveAmount</th>
									<th>NetReserveAmount</th>
									<th>ReserveCurrencyCode</th>
									<th>ReserveCreateDate</th>
									<th>ReserveLastUpdateDate</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ( $records as $key => $value ) { ?>
								<tr>
									<td><?php echo $value['case_no']; ?></td>
									<td><?php echo number_format($value['init_reserve_amount'], 2); ?></td>
									<td><?php echo number_format($value['reserve_amount'], 2); ?></td>
									<td><?php echo number_format($value['reserve_amount'] - $value['paied_amount'], 2); ?></td>
									<td><?php echo number_format($value['reserve_amount'] - $value['approved_amount'], 2); ?></td>
									<td>CAD</td>
									<td><?php echo $value['init_reserve_tm']; ?></td>
									<td><?php echo $value['reserve_update_tm']; ?></td>
								</tr>
								<?php } ?>
							</tbody>
						</table>
						<?php else: ?>
						<center><?php echo heading("No record available", 4); ?></center>
						<?php endif; ?>
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