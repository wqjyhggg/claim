<!DOCTYPE html>
<html class=" " lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>Phone Status</title>
<!-- jQuery -->
<script src="<?php echo base_url(); ?>assets/js/jquery_003.js"></script><!-- style sheets specific to the page -->
</head>
<body>
<div id="content">
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
</div>

<script>
$(document).ready(function(){
	setInterval(function(){
		// check user logout script here
		$.ajax({
			url: "<?php echo base_url("report/phonestatus/status"); ?>",
			method:"get",
			// dataType: "json",
			success: function(data){
				$("#content").html(data);
			}
		})
	}, 10000);
})
</script>
</body>
</html>