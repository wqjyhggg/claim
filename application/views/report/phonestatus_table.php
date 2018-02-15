<table border="1">
	<thead>
		<tr><td><b>Phone Number</b></td><td><b>Status</b></td><td><b>Queue</b></td></tr>
	</thead>
	<tbody>
		<?php foreach ($status as $key => $val) { ?>
		<tr><td><?php echo $key; ?></td><td><?php echo $val['status']; ?></td><td><?php echo $val['queue']; ?></td></tr>
		<?php } ?>
	</tbody>
</table>
<table border="1">
	<thead>
		<tr><td><b>Queue</b></td><td><b>Calls</b></td></tr>
	</thead>
	<tbody>
		<tr><td>English</td><td><?php echo $English; ?></td></tr>
		<tr><td>Chinese</td><td><?php echo $Chinese; ?></td></tr>
	</tbody>
</table>