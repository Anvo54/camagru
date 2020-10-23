<?php require APPROOT . '/views/inc/header.php';?>
<br>
<div class="container">
	<div class="card card-body bg-light mt-5">
		<h2>Add image</h2>
		<p>Upload image or take photo with your webcam</p>

		<div class="container">
		<form action="<?php echo URLROOT;?>/users/register" method="post">
			<div class="form-group">
				<label for="name">Name: <sup>*</sup> </label>
				<input type="text" name="name" class="form-control form-control-lg <?php echo (!empty($data['name_err'])) ? 'is-invalid' : ''; ?>" value="<?php $data['name'];?>">
				<span class="invalid-feedback"><?php echo $data['name_err'];?></span>
			</div>
			<div class="form-group">
				<label for="email">Descripion: <sup>*</sup> </label>
				<input type="text" name="email" class="form-control form-control-lg <?php echo (!empty($data['email_err'])) ? 'is-invalid' : ''; ?>" value="<?php $data['email'];?>" >
				<span class="invalid-feedback"><?php echo $data['email_err'];?></span>
			</div>
			<div class="row">
				<div class="col">
					<a href="<?php echo URLROOT; ?>/gallery/add" class="btn btn-light btn-block">Select file</a>
				</div>
				<class class="col">
					<input type="submit" value="Use Webcam"class="btn btn-success btn-block">
				</class>
			</div>
		</form>
</div>
</div>
<?php require APPROOT . '/views/inc/footer.php';?>