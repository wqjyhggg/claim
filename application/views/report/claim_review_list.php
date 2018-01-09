<div>
	<div class="page-title">
		<div class="title_left">
			<h3>Reports</h3>
		</div>
	</div>
	<div class="clearfix"></div>
	<!-- Product List Section -->
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_content">
					<div class="table-responsive">
						<table class="table table-hover table-bordered">
							<thead>
								<tr>
									<th>Claim No.</th>
									<th>Policy No.</th>
									<th>First Name</th>
									<th>Last Name</th>
									<th>Gender</th>
									<th>Birth Date</th>
									<th>&nbsp;</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach($claims as $value ) { ?>
								<tr>
									<td><?php echo $value['claim_no']; ?></td>
									<td><?php echo $value['policy_no']; ?></td>
									<td><?php echo $value['insured_first_name']; ?></td>
									<td><?php echo $value['insured_last_name']; ?></td>
									<td><?php echo $value['gender']; ?></td>
									<td><?php echo $value['dob']; ?></td>
									<td><?php echo anchor($current_url."?claim_id=".$value['id'], 'Review', array('title'=>'Review', 'class' => 'btn btn-primary')); ?></td>
								</tr>
								<?php } ?>
							</tbody>
						</table>
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