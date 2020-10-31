<nav class="navbar">
	<a href="<?php echo URLROOT;?>" class="logo">
		<img src="<?php echo URLROOT;?>/public/img/logo/Camagru_logo.svg" alt="Camagru logo">
	</a>
	<ul class="nav-links">
		<li class="nav-item"><a href="<?php echo URLROOT;?>/contents/index">Gallery</a></li>
		<?php if (isset($_SESSION['user_name'])) : ?>
			<li class="nav-item"><a href="<?php echo URLROOT;?>/users/edit/<?php echo $_SESSION['user_id']; ?>">My Profile</a></li>
			<li class="nav-item"><a href="<?php echo URLROOT;?>/contents/add">Add photo</a></li>
			<li class="nav-item"><a href="<?php echo URLROOT;?>/users/logout">Logout</a></li>
		<?php else : ?>
			<li class="nav-item"><a href="<?php echo URLROOT;?>/users/register">Register</a></li>
			<li class="nav-item"><a href="<?php echo URLROOT;?>/users/login">Sign in</a></li>
		<?php endif;?>
	</ul>
</nav>
