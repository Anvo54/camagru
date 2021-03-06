<?php require APPROOT . '/views/inc/header.php';?>
<div class="container main">
<div class="col-md-6 mx-auto">
		<div class="card card-body bg-light mt-5">
			<h2>Create and account</h2>
			<p>Fill out this form to register</p>
			<form action="<?php echo URLROOT;?>/users/register" method="post">
				<div class="form-group">
					<label for="user_name">User name: <sup>*</sup> </label>
					<input type="text" name="user_name" maxlength="32" user class="form-control form-control-lg <?php echo (!empty($data['name_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['user_name'];?>">
					<span class="invalid-feedback"><?php echo $data['name_err'];?></span>
				</div>
				<div class="form-group">
					<label for="email">Email: <sup>*</sup> </label>
					<input type="email" name="email"  maxlength="64" class="form-control form-control-lg <?php echo (!empty($data['email_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['email'];?>" >
					<span class="invalid-feedback"><?php echo $data['email_err'];?></span>
				</div>
				<div class="form-group">
					<label for="password">Password: <sup>*</sup> </label>
					<input type="password" name="password" maxlength="32" class="form-control form-control-lg <?php echo (!empty($data['password_err'])) ? 'is-invalid' : ''; ?>" value="<?php $data['password'];?>">
					<span class="invalid-feedback"><?php echo $data['password_err'];?></span>
				</div>	
				<div class="form-group">
					<label for="confirm_password">Confirm Password: <sup>*</sup> </label>
					<input type="password" name="confirm_password" maxlength="32" class="form-control form-control-lg <?php echo (!empty($data['confirm_password_err'])) ? 'is-invalid' : ''; ?>" value="<?php $data['confirm_password'];?>">
					<span class="invalid-feedback"><?php echo $data['confirm_password_err'];?></span>
				</div>
				<div class="row">
					<div class="col">
						<input type="submit" value="Register" class="btn btn-success btn-block">
					</div>
					<class class="col">
						<a href="<?php echo URLROOT; ?>/users/login" class="btn btn-light btn-block">Have an account?</a>
					</class>
				</div>
			</form>
		</div>
	</div>
</div>
<?php require APPROOT . '/views/inc/footer.php';?>
