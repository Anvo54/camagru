<?php require APPROOT . '/views/inc/header.php';?>
<div class="container main">
<div class="col-md-6 mx-auto">
		<div class="card card-body bg-light mt-5">
			<h2>Change your password</h2>
			<form action="<?php echo URLROOT;?>/users/forgot" method="post">
				<div class="form-group">
					<label for="user_name">User name: <sup>*</sup> </label>
					<input type="text" name="user_name"  maxlength="32" class="form-control form-control-lg <?php echo (!empty($data['name_err'])) ? 'is-invalid' : ''; ?>" value="<?php $data['user_name'];?> ">
					<span class="invalid-feedback"><?php echo $data['name_err'];?></span>
				</div>
				<div class="row">
					<div class="col">
						<input type="submit" value="Send password recovery link" class="btn btn-success btn-block">
					</div>
					<class class="col">
						<a href="<?php echo URLROOT; ?>/users/register" class="btn btn-outline-dark btn-block">Create account?</a>
					</class>
				</div>
			</form>
		</div>
	</div>
</div>
<?php require APPROOT . '/views/inc/footer.php';?>
