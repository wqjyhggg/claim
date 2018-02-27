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
<style>
table {
border-style: double;
}
</style>
</head>
<body>
<div id="content">
	<table>
		<thead>
			<tr><td><b>Phone Number</b></td><td><b>Status</b></td><td><b>Queue</b></td></tr>
		</thead>
		<tbody>
			<?php foreach ($status as $key => $val) { ?>
			<tr><td><?php echo $key; ?></td><td><?php echo $val['status']; ?></td><td><?php echo $val['queue']; ?></td></tr>
			<?php } ?>
		</tbody>
	</table>
	<table>
		<thead>
			<tr><td><b>Queue</b></td><td><b>Calls</b></td></tr>
		</thead>
		<tbody>
			<tr><td>English</td><td><?php echo $English; ?></td></tr>
			<tr><td>Chinese</td><td><?php echo $Chinese; ?></td></tr>
		</tbody>
	</table>
</div>
<input type='button' id='phone_file_button' value='Get Current Files'>
<div id="phone_file_list"></div>
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

	$('#phone_file_button').click(function () {
		$.ajax({
			url: "<?php echo base_url("phone/getfile"); ?>",
			method:"get",
			data:{haslocal:"1"},
			dataType: "json",
			//beforeSend: function(){
				// $(".nav-m22d").addClass("csspinner load1");
			//},
			success: function(data) {
				if (typeof data.ok != "undefined") {
					$("#phone_file_list").html(data.html);
				}
			}
		})
	});
})
</script>
</body>
</html>
