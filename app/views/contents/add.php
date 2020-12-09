<?php require APPROOT . '/views/inc/header.php';?>
<br>
<video id="video">Video stream not available.</video>
<div class="container main">
	<div class="card card-body bg-light mt5">
		<?php if (!empty($data['error_message'])) : ?>
			<div class="alert alert-danger"><?php echo $data['error_message']; ?></div>
		<?php endif; ?>
		<form action="<?php URLROOT.'/contents/add' ?>" method="post">
		<h5>Stickers</h5>
		<input type="checkbox" name="webcam" id="cam"> Use webcam
		<div class="row">
			<img src="<?php echo URLROOT.'/public/img/Stickers/tree.png' ?>" id="tree" class="img-thumbnail stickers">
			<img src="<?php echo URLROOT.'/public/img/Stickers/garden.png' ?>" id="garden" class="img-thumbnail stickers">
			<img src="<?php echo URLROOT.'/public/img/Stickers/star.png' ?>" id="star" class="img-thumbnail stickers">
			<img src="<?php echo URLROOT.'/public/img/Stickers/chain.png' ?>" id="chain" class="img-thumbnail stickers">
			<img src="<?php echo URLROOT.'/public/img/Stickers/cape.png' ?>" id="cape" class="img-thumbnail stickers">
			<img src="<?php echo URLROOT.'/public/img/Stickers/face_mask.png' ?>" id="facemask" class="img-thumbnail stickers">
		</div>
		<div class="row justify-content-center" ondrop="dropHandler(event);" ondragover="dragOverHandler(event);">
			<div>
				<canvas id='stickerCanvas'></canvas>
			</div>
		</div>
		<div class="row">
			<p class="col text-center" id="uploader-text">Select photo below to upload!</p>
		</div>
		<div class="row d-flex justify-content-center">
			<div id="photo"></div>
		</div>
		<br>
		<div class="row">
			<div class="col text-center">
				<input type="button" id="startbutton" class="btn btn-lg btn-success" value="Take photo"></input>
			</div>
		</div>
		<canvas id="canvas"></canvas>
		<div class="form-group">
				<label for="name">Name: <sup>*</sup> </label>
				<input type="text" name="image_title" class="form-control form-control-lg" maxlength="32" required>
			</div>
			<div class="form-group">
				<label for="description">Description: <sup>*</sup> </label>
				<input type="text" name="image_desc" class="form-control form-control-lg" maxlength="128" required>
			</div>
			<div class="row">
			<div class="output col">
				<input name="selected_image" id="selected_image" type="hidden"></input>
			</div>
		</div>
		</form>
		<div>
			<h4>Previous photos</h4>
			<div class="prevPhotos">
				<?php foreach ($data['user_images'] as $image): ?>
					<div class="img-container">
						<img src="<?php echo $image->image_path;?>" class="prevImage">
						<form action="<?php echo URLROOT; ?>/contents/delete/<?php echo $image->image_id ?>" method="post">
							<input type="submit" value="Delete" class="prevPhotoDelete">
						</form>
					</div>
				<?php endforeach;?>
			</div>
		</div>
	</div>
</div>
<script src="<?php echo URLROOT; ?>/public/js/capture.js"></script>
<?php require APPROOT . '/views/inc/footer.php';?>