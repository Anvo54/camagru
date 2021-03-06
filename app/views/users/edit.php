<?php require APPROOT . '/views/inc/header.php';?>
<div class="container main">
<div class="col-md-6 mx-auto">
		<div class="card card-body bg-light mt-5">
			<h2>Manage my profile</h2>
			<p>Manage your profile settings here</p>
			<?php if (!empty($data['error_message'])) : ?>
				<div class="alert alert-danger"><?php echo $data['error_message']; ?></div>
			<?php endif; ?>
			<?php if (!empty($data['success_message'])) : ?>
				<div class="alert alert-success"><?php echo $data['success_message']; ?></div>
			<?php endif; ?>
			<form action="<?php echo URLROOT;?>/users/edit/<?php echo $_SESSION['user_id'] ?>" method="post">
				<div class="form-group">
					<label for="user_name">User name: <sup>*</sup> </label>
					<input type="text" name="user_name" class="form-control form-control-lg" maxlength="32" required value="<?php echo $data['user']->user_name;?>">
				</div>
				<div class="form-group">
					<label for="email">Email: <sup>*</sup> </label>
					<input type="email" name="email" class="form-control form-control-lg" maxlength="64" value="<?php echo $data['user']->user_email;?>" required>
				</div>
				<div class="form-group">
					<label for="password">Old Password: <sup>*</sup> </label>
					<input type="password" name="password" class="form-control form-control-lg>" required minlength="6" maxlength="32">
				</div>	
				<div class="form-group">
					<label for="confirm_password">New Password: <sup>*</sup> </label>
					<input type="password" name="new_password" class="form-control form-control-lg" required minlength="6" maxlength="32">
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col">
							<label for="confirm_password">Like Notifications</label><br>
							<input type="checkbox" name="like_email" value="true" <?php if ($data['user']->like_email == "1") echo "checked"?>>
						</div>
						<div class="col">
						<label for="confirm_password">Comment Notifications</label><br>
							<input type="checkbox" name="comment_email" value="true" <?php if ($data['user']->comment_email == "1") echo "checked"?>>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col">
						<input type="submit" value="Edit" class="btn btn-success btn-block">
					</div>
					<class class="col">
						<a href="<?php echo URLROOT; ?>/users/delete/<?php echo $_SESSION['user_id']; ?>" class="btn btn-danger btn-block">Delete account</a>
					</class>
				</div>
			</form>
		</div>
	</div>
</div>
<?php require APPROOT . '/views/inc/footer.php';?>
