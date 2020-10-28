<?php require APPROOT . '/views/inc/header.php';?>
<br>
<div class="container">
	<div class="card card-body bg-light mt5">
		<div class="row">
			<div class="col camera">
				<video id="video">Video stream not available.</video>
			</div>
		</div>
		<div class="row">
			<div class="output col">
				<img id="photo">
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col">
				<input type="button" id="startbutton" class="btn btn-lg btn-success text-center" value="Take photo"></input>
			</div>
		</div>
		<canvas id="canvas"></canvas>
		<input type="text" name="imageName" id="imageName">
		<input type="button" id="savebutton" value="save">
	</div>
</div>
<script src="<?php echo URLROOT; ?>/public/js/capture.js"></script>
<?php require APPROOT . '/views/inc/footer.php';?>