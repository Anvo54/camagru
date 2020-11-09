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
		
		// To send HTML mail, the Content-type header must be set
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		
		// Additional headers
		$headers .= 'From: Camagru <no-reply@camagru.com>' . "\r\n";

		mail($address,$subject,$message, $headers);

	}