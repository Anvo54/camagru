<?php require APPROOT . '/views/inc/header.php';?>
<br>
<div class="container main">
	<div class="jumbotron jumbotron-fluid text-center">
		<h1><?php echo SITENAME; ?></h1>
		<p class="lead"><?php echo $data['description'];?></p>
		<small class="text-muted"><?php echo $data['message'] ?></small>
	</div>
</div>
<?php require APPROOT . '/views/inc/footer.php';?>