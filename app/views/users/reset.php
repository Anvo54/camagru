<?php require APPROOT . '/views/inc/header.php';?>
<div class="container main">
<div class="col-md-6 mx-auto">
		<div class="card card-body bg-light mt-5">
			<h2>Reset your password</h2>
			<p>Hello <?php echo $data['user']->user_name; ?></p>
			<form action="<?php echo URLROOT;?>/users/reset/<?php echo $data['link'] ?>" method="post">
				<div class="form-group">
					<label for="password">New password: <sup>*</sup> </label>
					<input type="password" name="password" class="form-control form-control-lg <?php echo (!empty($data['password_err'])) ? 'is-invalid' : ''; ?>" value="<?php $data['password'];?>">
					<span class="invalid-feedback"><?php echo $data['password_err'];?></span>
				</div>	
				<div class="form-group">
					<label for="confirm_password">Confirm Password: <sup>*</sup> </label>
					<input type="password" name="confirm_password" class="form-control form-control-lg <?php echo (!empty($data['confirm_password_err'])) ? 'is-invalid' : ''; ?>" value="<?php $data['confirm_password'];?>">
					<span class="invalid-feedback"><?php echo $data['confirm_password_err'];?></span>
				</div>
				<div class="row">
					<div class="col">
						<input type="submit" value="Change password" class="btn btn-success btn-block">
					</div>
					<class class="col">
						<a href="<?php echo URLROOT; ?>/users/login" class="btn btn-light btn-block">Cancel?</a>
					</class>
				</div>
			</form>
		</div>
	</div>
</div>
<?php require APPROOT . '/views/inc/footer.php';?>
