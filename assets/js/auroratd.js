var ws_socket;
var ws_status;
var ws_phone = 0;
var ws_host=location.hostname;

function ws_init() {
	if (!ws_phone) return;
	
	var host = "ws://" + ws_host + ":8080/" + ws_phone
	try {
		ws_socket = new WebSocket(host);
		// log('WebSocket - status '+socket.readyState);
		ws_socket.onopen = function(msg) {
			//log("Welcome - status "+this.readyState);
			ws_status = this.readyState;
		};
		
		ws_socket.onmessage = function(msg) {
			//log("Received: "+msg.data); 
			$('#curr_queue').html(msg.data);
		};
		ws_socket.onclose   = function(msg) {
			// log("Disconnected - status "+this.readyState);
			$('#curr_queue').html('X');
			ws_status = this.readyState;
		};
	} catch (ex) { 
		// log(ex); 
	}
	// $("msg").focus();
}

function ws_send(msg){
	try { 
		ws_socket.send(msg); 
		//log('Sent: '+msg); 
	} catch(ex) { 
		// log(ex); 
	}
}
function ws_quit(){
	if (ws_socket != null) {
		// log("Goodbye!");
		ws_socket.close();
		ws_socket=null;
	}
}

function ws_reconnect() {
	ws_quit();
	ws_init();
}

$(document).ready(function(){
	$('.phonelogin').click(function () {
		$.ajax({
			url: "/myphone/login",
			method: "get",
			datatype: 'json',
			success: function(data) {
				if (data.status='OK') {
					$('#phone_logout').show();
					$('#phone_queue_div').show();
					$('#phone_login').hide();
					ws_phone = data.phone;
					ws_init();
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
					$('#phone_queue_div').hide();
					$('#phone_login').show();
					ws_quit();
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
					$('#phone_queue_div').hide();
					$('#phone_login').show();
					ws_quit();
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
					$('#phone_queue_div').hide();
					$('#phone_login').show();
					ws_quit();
				}
			}
		})
	});

	$('.phonequeue').click(function () {
		$.ajax({
			url: "/myphone/queue",
			method: "get",
			datatype: 'json',
			success: function(data) {
				if (data.status='OK') {
					if (ws_status != 1) {
						ws_phone = data.phone;
						ws_reconnect();
					}
					$('#curr_queue').html(data.queue);
				} else {
					$('#curr_queue').html('');
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
				$('#phone_queue_div').show();
				$('#phone_login').hide();
				ws_init();
			} else if (data.login == 'Unknown') {
				$('#phone_opt_div').hide();
				$('#phone_queue_div').hide();
			} else {
				$('#phone_logout').hide();
				$('#phone_queue_div').hide();
				$('#phone_login').show();
			}
		}
	})
	
	$(window).on('beforeunload', function(){
		ws_quit();
	});
})