<?php 
	define('DB_HOST', 'localhost');
	define('DB_USER', 'root');
	define('DB_PASS', 'password');
	define('DB_NAME', 'camagru');

	include 'database.php';
	$db = new Database();

	
	$db->query('SELECT * FROM users');
	$r = $db->resultSet();



	function install($r){
/** */
	}


?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Camagru Setup</title>
	<link rel="shortcut icon" href="../public/img/icons/favicon_setup.ico" />
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
</head>
<body>
	<div class="container">
		<nav class="navbar navbar-light bg-light">
			<img src="../public/img/logo/Camagru_logo.svg" width="auto" height="30" alt="">
		</nav>
		<div class="jumbotron bg-light">
			<h3>Welcome to Camagru install wizard</h3>
			<br>
			<p class="alert alert-danger">THIS SCRIPT WILL REMOVE ALL PREVIOUS DATA FROM CAMAGRU DATABASE</p>
			<form action="" method="post">
			
			<input type="checkbox" name="sample-data" value="false"> Install sample data?
				<br>
			<input type="submit" value="Install" class="btn btn-success">
		</form>
		</div>
	</div>
</body>
</html>