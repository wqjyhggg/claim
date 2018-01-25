<table border="1">
	<thead>
		<tr><td><b>Phone Number</b></td><td><b>Status</b></td></tr>
	</thead>
	<tbody>
		<?php foreach ($status as $key => $val) { ?>
		<tr><td><?php echo $key; ?></td><td><?php echo $val; ?></td></tr>
		<?php } ?>
	</tbody>
</table>