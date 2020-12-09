<?php require APPROOT . '/views/inc/header.php';?>
<div class="container main">
<div class="col-md-6 mx-auto">
		<div class="card card-body bg-light mt-5">
			<h2>Login to your account</h2>
			<form action="<?php echo URLROOT;?>/users/login" method="post">
				<div class="form-group">
					<label for="user_name">User name: <sup>*</sup> </label>
					<input type="text" name="user_name" maxlength="32" class="form-control form-control-lg <?php echo (!empty($data['name_err'])) ? 'is-invalid' : ''; ?>" value="<?php $data['user_name'];?>">
					<span class="invalid-feedback"><?php echo $data['name_err'];?></span>
				</div>
				<div class="form-group">
					<label for="password">Password: <sup>*</sup> </label>
					<input type="password" name="password" maxlength="32" class="form-control form-control-lg <?php echo (!empty($data['password_err'])) ? 'is-invalid' : ''; ?>" value="<?php $data['password'];?>">
					<span class="invalid-feedback"><?php echo $data['password_err'];?></span>
				</div>
				<div class="row">
					<div class="col">
						<input type="submit" value="Login" class="btn btn-success btn-block">
					</div>
					<class class="col">
						<a href="<?php echo URLROOT; ?>/users/register" class="btn btn-outline-dark btn-block">Create account?</a>
						<a href="<?php echo URLROOT; ?>/users/forgot" class="btn btn-sm btn-light btn-block">Forgot password?</a>
					</class>
				</div>
			</form>
		</div>
	</div>
</div>
<?php require APPROOT . '/views/inc/footer.php';?>
