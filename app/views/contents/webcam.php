<?php require APPROOT . '/views/inc/header.php';?>
<br>
<div class="container main">
	<div class="card card-body bg-light mt5">
			<?php if (!empty($data['error_message'])) : ?>
				<div class="alert alert-danger"><?php echo $data['error_message']; ?></div>
			<?php endif; ?>
		<div class="row">
			<div class="col camera" id="camera">
				<video id="video">
					Video stream not available.
				</video>
			</div>
		</div>
		<form action="<?php URLROOT.'/contents/webcam' ?>" method="post">
		<br>
		<div class="row">
			<div class="col text-center">
				<input type="button" id="startbutton" class="btn btn-lg btn-success" value="Take photo"></input>
			</div>
			<img src="<?php echo URLROOT.'/public/img/tree.png' ?>" id="tree" class="img-thumbnail stickers">
		</div>
		<canvas id="canvas"></canvas>
		<div class="form-group">
				<label for="name">Name: <sup>*</sup> </label>
				<input type="text" name="image_title" class="form-control form-control-lg" required>
			</div>
			<div class="form-group">
				<label for="description">Description: <sup>*</sup> </label>
				<input type="text" name="image_desc" class="form-control form-control-lg" required>
			</div>
			<div class="row">
				<h2 class="col text-center" id="uploader-text">Select photo to upload!</h2>
			</div>
			<div class="row">
			<div class="output col" id="photo">
				<input name="photo" id="base64" type="hidden"></input>
			</div>
		</div>
		</form>
	</div>
</div>
<script src="<?php echo URLROOT; ?>/public/js/capture.js"></script>
<?php require APPROOT . '/views/inc/footer.php';?>