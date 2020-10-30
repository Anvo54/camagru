<?php require APPROOT . '/views/inc/header.php';?>
<div class="container">
	<div class="card card-body bg-light mt-4">
		<div class="grey-box-bg" style="height: 25rem;">
			<h3>Drag your file here!</h3><br>
			<a href="<?php echo URLROOT; ?>/contents/webcam" class="btn btn-success">Or use webcam</a>
		</div>
		<br>
		<form action="<?php echo URLROOT;?>/contents/add" method="post">
			<div class="form-group">
				<label for="name">Name: <sup>*</sup> </label>
				<input type="text" name="image_title" class="form-control form-control-lg <?php echo (!empty($data['title_err'])) ? 'is-invalid' : ''; ?>" value="<?php $data['image_title'];?>">
				<span class="invalid-feedback"><?php echo $data['title_err'];?></span>
			</div>
			<div class="form-group">
				<label for="description">Description: <sup>*</sup> </label>
				<input type="text" name="image_desc" class="form-control form-control-lg <?php echo (!empty($data['image_desc_err'])) ? 'is-invalid' : ''; ?>" value="<?php $data['image_desc'];?>" >
				<span class="invalid-feedback"><?php echo $data['image_desc_err'];?></span>
			</div>
			<div class="form-group">
				<label for="description">imagepath: <sup>*</sup> </label>
				<input type="text" name="image_path" class="form-control form-control-lg <?php echo (!empty($data['image_desc_err'])) ? 'is-invalid' : ''; ?>" value="<?php $data['image_path'];?>" >
				<span class="invalid-feedback"><?php echo $data['image_desc_err'];?></span>
			</div>
			<class class="col">
				<input type="submit" value="Save"class="btn btn-success float-right">
			</class>
		</form>
	</div>
</div>
<script src="<?php echo URLROOT; ?>/public/js/uploader.js"></script>
<?php require APPROOT . '/views/inc/footer.php';?>