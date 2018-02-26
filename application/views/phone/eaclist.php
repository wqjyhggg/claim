<div>
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_content">
					<div class="table-responsive">
						<table class="table table-hover table-bordered">
							<thead>
								<tr>
									<th>Time</th>
									<th>Queue</th>
									<th>Caller Name</th>
									<th>Caller</th>
									<th>Minutes</th>
									<th>URL</th>
							</thead>
							<tbody>
								<?php foreach($call_list['rows'] as $key => $value) : ?>
								<tr class='phonefilelistclass' data-url='<?php echo isset($value['recording_url']) ? $value['recording_url'] : ''; ?>'>
									<td><?php echo date("Y-m-d H:i:s", strtotime($value['start_time'])); ?></td>
									<td><?php echo $value['queue']; ?></td>
									<td><?php echo $value['caller_id_name']; ?></td>
									<td><?php echo $value['caller_id_number']; ?></td>
									<td><?php echo $value['minutes']; ?></td>
									<td><?php echo isset($value['recording_url']) ? $value['recording_url'] : ''; ?></td>
								</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- End List Section -->
</div>