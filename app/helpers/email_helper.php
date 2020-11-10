<?php
	function sendVerificationMail($address, $user, $link) {
		$subject = "Account verification";
		$message = '
		<html>
		<head>
		  <title>email verification for '.$user.'</title>
		</head>
		<body>
			<p>Thank you for registering at Camagru!</p>
			<br>
			<p>Please verify your email <a href="'.URLROOT."/users/verify/".$link.'">Here</a></p>
		</body>
		</html>
		';

		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: Camagru <no-reply@camagru.com>' . "\r\n";

		mail($address,$subject,$message, $headers);
	}

	function sendRecoveryMail($address, $user, $link) {
		$subject = "Password recovery";
		$message = '
		<html>
		<head>
		  <title>email verification for '.$user.'</title>
		</head>
		<body>
			<h1>Password recovey link below!</h1>
			<br>
			<p>Create a new password <a href="'.URLROOT."/users/reset/".$link.'">Here</a></p>
		</body>
		</html>
		';

		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: Camagru <no-reply@camagru.com>' . "\r\n";

		mail($address,$subject,$message, $headers);
	}

	function sendNotificationMail($address, $id, $type) {
		$subject = "New ".$type;
		$message = '
		<html>
		<head>You have a new '.strtolower($type).'!</title>
		</head>
		<body>
			<h1>You have a new '.strtolower($type).'!</h1>
			<br>
			<p>Your post just got a new '.strtolower($type).'. Click <a href="'.URLROOT."/contents/show/".$id.'">Here</a> to see it!</p>
		</body>
		</html>
		';
		

		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: Camagru <no-reply@camagru.com>' . "\r\n";

		mail($address,$subject,$message, $headers);
	}