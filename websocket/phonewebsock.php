#!/usr/bin/env php
<?php
require_once ('./websockets.php');
$portt = 8080;
class phonewebsock extends WebSocketServer {
	const MSG_OK = "OK";
	public $debug = 0;
	
	protected function process($user, $message) {
		if ($user->requestedResource == WebSocketUser::SERVER_STR) {
			$msgs = preg_split("/:/", trim($message));
			if ($this->debug) {
				echo $message . "\n";
			}
			if (is_array($msgs) && (sizeof($msgs) == 2)) {
				// This is good message
				foreach ( $this->users as $u ) {
					if ($user->requestedResource == $msgs[0]) {
						if ($this->debug) {
							echo "S1:" . $msgs [2] . "\n";
						}
						$this->send($u, $msgs [2]);
						break;
					}
				}
				$this->send($user, self::MSG_OK);
				break;
			}
		}
		if ($this->debug) {
			// print_r($this->users);
			foreach ( $this->users as $u ) {
				echo $u->id . "\n";
				echo $u->requestedResource . "\n";
			}
		}
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