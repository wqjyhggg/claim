$(document).ready(function(){
	$('.phonelogin').click(function () {
		$.ajax({
			url: "/myphone/login",
			method: "get",
			datatype: 'json',
			success: function(data) {
				if (data.status='OK') {
					$('#phone_logout').show();
					$('#phone_login').hide();
				}
			}
		})
	});

	$('.phonelogout').click(function () {
		$.ajax({
			url: "/myphone/logout",
			method: "get",
			datatype: 'json',
			success: function(data) {
				if (data.status='OK') {
					$('#phone_logout').hide();
					$('#phone_login').show();
				}
			}
		})
	});

	$('.phonebreak').click(function () {
		$.ajax({
			url: "/myphone/breaktm",
			method: "get",
			datatype: 'json',
			success: function(data) {
				if (data.status='OK') {
					$('#phone_logout').hide();
					$('#phone_login').show();
				}
			}
		})
	});

	$('.phonewaiting').click(function () {
		$.ajax({
			url: "/myphone/waiting",
			method: "get",
			datatype: 'json',
			success: function(data) {
				if (data.status='OK') {
					$('#phone_logout').hide();
					$('#phone_login').show();
				}
			}
		})
	});

	$.ajax({
		url: "/myphone",
		method: "get",
		datatTpe: 'json',
		success: function(data) {
			if (data.login == 'OK') {
				$('#phone_logout').show();
				$('#phone_login').hide();
			} else if (data.login == 'Unknown') {
				$('#phone_opt_div').hide();
			} else {
				$('#phone_logout').hide();
				$('#phone_login').show();
			}
		}
	})
})