<?php require APPROOT . '/views/inc/header.php';?>
<div class="container main">
<div class="col-md-6 mx-auto">
		<div class="card card-body bg-light mt-5">
			<h2>
				Thank you for registering!<br>
				<small class="text-muted">Please check your email for verification email!</small>
			</h2>
			<form action="<?php echo URLROOT;?>/users/login" method="post">
				<div class="row">
					<class class="col">
						<i>Verified?</i>
						<a href="<?php echo URLROOT; ?>/users/login" class="btn btn-outline-dark btn-block">Login</a>
					</class>
				</div>
			</form>
		</div>
	</div>
</div>
<?php require APPROOT . '/views/inc/footer.php';?>
