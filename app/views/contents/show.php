<?php require APPROOT . '/views/inc/header.php';?>
	<a href="<?php echo URLROOT ?>/contents" class="btn btn-light">Back</a>
	<hr>
	<img class="card-img-top mx-auto mb-3" style="width: auto; height: auto; max-height: 35rem;" src="<?php echo $data['image']->image_path;?>">
	<h1><?php echo $data['image']->image_title; ?></h1>
	<div class="bg-secondary text-white p-2 mb-3">
		Image by: <?php echo $data['user']->user_name; ?> on <?php echo $data['image']->created_at; ?> 
	</div>
	<p><?php echo $data['image']->image_desc;?></p>
	<p>Likes: <?php echo $data['likes'];?></p>
	<?php if ($data['liked'] != 1) :?>
		<form action="<?php echo URLROOT; ?>/contents/like/<?php echo $data['image']->image_id;?>" method="post">
			<input type="submit" value="Like" class="btn">
		</form>
		<?php else : ?>
		<form action="<?php echo URLROOT; ?>/contents/dislike/<?php echo $data['image']->image_id;?>" method="post">
			<input type="submit" value="Don't like" class="btn">
		</form>
	<?php endif; ?>
	<?php if($data['image']->user_id == $_SESSION['user_id']) : ?>
	<a href="<?php echo URLROOT; ?>/contents/edit/<?php echo $data['image']->image_id;?>" class="btn btn-dark">Edit</a>
	<div class="float-right">
		<form action="<?php echo URLROOT; ?>/contents/delete/<?php echo $data['image']->image_id ?>" method="post">
			<input type="submit" value="Delete" class="btn btn-danger">
		</form>
	</div>
	<?php endif; ?>
<?php require APPROOT . '/views/inc/footer.php';?>