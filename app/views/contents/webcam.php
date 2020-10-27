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
		<!---<form action="<?php echo URLROOT;?>/contents/webcam" method="post">-->
		<form method="post">
			<div class="form-group">
				<label for="name">Name: <sup>*</sup> </label>
				<input type="text" name="name" class="form-control form-control-lg <?php echo (!empty($data['name_err'])) ? 'is-invalid' : ''; ?>" value="<?php $data['name'];?>">
				<span class="invalid-feedback"><?php echo $data['name_err'];?></span>
			</div>
			<div class="form-group">
				<label for="email">Descripion: <sup>*</sup> </label>
				<input type="text" name="description" class="form-control form-control-lg <?php echo (!empty($data['description_err'])) ? 'is-invalid' : ''; ?>" value="<?php $data['description'];?>" >
				<span class="invalid-feedback"><?php echo $data['description_err'];?></span>
			</div>
			<div class="row">
				<div class="col">
					<a href="<?php echo URLROOT; ?>/gallery/add" class="btn btn-light btn-block">Select file</a>
				</div>
				<class class="col">
					<!---<input id="savebutton" type="submit" value="Save"class="btn btn-success btn-block">-->
					<input id="savebutton" type="submit" value="Save"class="btn btn-success btn-block">
				</class>
			</div>
		</form>
	</div>
</div>
<script src="<?php echo URLROOT; ?>/public/js/capture.js"></script>
<?php require APPROOT . '/views/inc/footer.php';?>