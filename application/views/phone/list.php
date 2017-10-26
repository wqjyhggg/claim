<div>
	<div class="page-title">
		<div class="title_left"><h3>List</h3></div>
	</div>
	<div class="clearfix"></div>
	<!-- Product List Section -->
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2 class="phone_heading">Phone list (<?php echo isset($call_list['totalRows']) ? $call_list['totalRows'] : 0; ?>)
					</h2>
					<div class='pull-right'>
						<form action="<?php echo $action_url; ?>" method="POST">
							<input type="date" id="dt" name="dt" max='<?php echo date("Y-m-d"); ?>'>
							<input type='submit' value='Get day list'>
						</form>
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<div class="table-responsive">
					<?php if(!empty($call_list['rows'])): ?>
						<table class="table table-hover table-bordered">
							<thead>
								<tr>
									<th>&nbsp;</th>
									<th>Start</th>
									<th>End</th>
									<th>Caller Name</th>
									<th>Caller</th>
									<th>Dest</th>
									<th>Direction</th>
									<th>Minutes</th>
							</thead>
							<tbody>
								<?php
								$i = 0;
								foreach($call_list['rows'] as $key => $value) :
									$i ++;
								?>
								<tr>
									<td><?php echo $i; ?></td>
									<td><?php echo date("Y-m-d H:i:s", strtotime($value['start_time'])); ?></td>
									<td><?php echo date("Y-m-d H:i:s", strtotime($value['end_time'])); ?></td>
									<td><?php echo $value['caller_id_name']; ?></td>
									<td><?php echo $value['caller_id_number']; ?></td>
									<td><?php echo $value['destination_number']; ?></td>
									<td><?php echo $value['direction']; ?></td>
									<td><?php echo $value['minutes']; ?></td>
								</tr>
								<?php endforeach; ?>
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