<?php require APPROOT . '/views/inc/header.php';?>
<br>
<div class="container main">
	<div class="card card-body bg-light mt5">
		<div class="row">
			<div class="col camera">
				<video id="video">Video stream not available.</video>
			</div>
		</div>
		<form action="<?php URLROOT.'/contents/webcam' ?>" method="post">
		<div class="row">
			<div class="output col">
				<img id="photo">
				<input name="photo" id="base64" type="hidden"></input>
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col">
				<input type="button" id="startbutton" class="btn btn-lg btn-success text-center" value="Take photo"></input>
			</div>
		</div>
		<canvas id="canvas"></canvas>
		<div class="form-group">
				<label for="name">Name: <sup>*</sup> </label>
				<input type="text" name="image_title" class="form-control form-control-lg">
			</div>
			<div class="form-group">
				<label for="description">Description: <sup>*</sup> </label>
				<input type="text" name="image_desc" class="form-control form-control-lg" >
			</div>
		<input type="submit" value="Save Image" class="btn">
		</form>
	</div>
</div>
<script src="<?php echo URLROOT; ?>/public/js/capture.js"></script>
<?php require APPROOT . '/views/inc/footer.php';?>