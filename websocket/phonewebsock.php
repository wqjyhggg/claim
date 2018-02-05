<?php
// 1 * * * * (cd /var/claim/webscoket; /usr/bin/php phonewebsock.php) >> /home/ubuntu/ws_server 2>&1

require_once ('./websockets.php');
$portt = 8080;
class phonewebsock extends WebSocketServer {
	const MSG_OK = "OK";
	public $debug = 0;
	
	protected function process($user, $message) {
	}
	protected function connected($user) {
		// Do nothing: This is just an echo server, there's no need to track the user.
		// However, if we did care about the users, we would probably have a cookie to
		// parse at this step, would be looking them up in permanent storage, etc.
	}
	protected function closed($user) {
		// Do nothing: This is where cleanup would go, in case the user had any sort of
		// open files or other objects associated with them. This runs after the socket
		// has been closed, so there is no need to clean up the socket itself here.
	}
	protected function processget($user, $message) {
		$msgs = preg_split("#/#", trim($message));

		if (is_array($msgs) && ($msgs[0] == WebSocketUser::SERVER_STR)) {
			if ($this->debug) {
				echo $message . "\n";
			}
			if (is_array($msgs) && (sizeof($msgs) == 3)) {
				// This is good message
				foreach ( $this->users as $u ) {
					if ($this->debug) {
						echo "S1:" . $u->requestedResource . "\n";
					}
					if ($u->requestedResource == $msgs[1]) {
						if ($this->debug) {
							echo "S2:" . $msgs [2] . "\n";
						}
						$this->send($u, $msgs [2]);
						break;
					}
				}
				$this->send($user, self::MSG_OK);
			} else {
				print_r($msgs);
				echo "Error server message: " . $message . "\n";
			}
		}
		if ($this->debug) {
			// print_r($this->users);
			echo "Total Users: " . sizeof($this->users) . "\n";
			/*
			foreach ( $this->users as $u ) {
				echo $u->id . "\n";
				echo $u->requestedResource . "\n";
			}
			*/
		}
	}
}

function testsocket() {
	global $portt;
	$errno = $errstr = '';
	
	$fp = @fsockopen('127.0.0.1', $portt, $errno, $errstr, 1);
	if (! $fp) {
		return false;
	} else {
		fclose($fp);
		return true;
	}
}

if (! testsocket()) {
	echo "Start server Listen on : " . $portt . " at " . date("Y-m-d H:i:s") . " \n";
	$echo = new phonewebsock("0.0.0.0", $portt);
	try {
		$echo->run();
	} catch ( Exception $e ) {
		$echo->stdout($e->getMessage());
	}
	echo "Stopped server at " . date("Y-m-d H:i:s") . " \n";
}