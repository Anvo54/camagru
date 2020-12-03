<?php require APPROOT . '/views/inc/header.php';?>
<div class="container">
	<a href="<?php echo URLROOT ?>/contents" class="btn btn-light">Back</a>
	<?php if(isset($data['image']->user_id) && isset($_SESSION['user_id']) && $data['image']->user_id == $_SESSION['user_id']) : ?>
	<div class="float-right">
		<form action="<?php echo URLROOT; ?>/contents/delete/<?php echo $data['image']->image_id ?>" method="post">
			<input type="submit" value="Delete image" class="btn btn-danger">
		</form>
	</div>
	<?php endif; ?>
	<div class="card card-body mb-3">
		<img class="card-img-top mx-auto mb-3" src="<?php echo $data['image']->image_path;?>">
		<h1><?php echo $data['image']->image_title; ?></h1>
		<div class="bg-secondary text-white p-2 mb-3">
			Image by: <?php echo $data['user']->user_name; ?> on <?php echo $data['image']->created_at; ?> 
		</div>
	<p><?php echo $data['image']->image_desc;?></p>
	<p>Likes: <?php echo $data['likes'];?></p>
	<?php if ($data['liked'] != 1 && isset($_SESSION['user_id'])) :?>
		<form action="<?php echo URLROOT; ?>/contents/like/<?php echo $data['image']->image_id;?>" method="post">
			<input type="submit" value="Like" class="btn">
		</form>
	<?php elseif (isset($_SESSION['user_id'])) : ?>
		<form action="<?php echo URLROOT; ?>/contents/dislike/<?php echo $data['image']->image_id;?>" method="post">
			<input type="submit" value="Don't like" class="btn">
		</form>
	<?php endif; ?>
	<!--- Comments here --->
	<?php if ($data['comments']) : ?>
	<div class="card card-body mb-3">
	<h5 class="card-title">Comments</h5>
	<?php foreach($data['comments'] as $comment) : ?>
		<div class="card-footer">
			<p class="blockquote-footer">By: <?php echo $comment->user_name; ?> at: <?php echo $comment->created_at; ?></p>
				<small class="text-muted"><?php echo $comment->comment; ?></small>
				<?php if (isset($comment->user_id) && isset($_SESSION['user_id']) && $comment->user_id == $_SESSION['user_id']): ?>
				<div class="row float-right">
					<form action="<?php echo URLROOT ?>/contents/delcomment/<?php echo $comment->id; ?>" method="post">
						<input type="hidden" name="image_id" value="<?php echo $data['image']->image_id; ?>">
						<input type="hidden" name="user_id" value="<?php echo $data['user']->user_id; ?>">
						<br>
						<input type="submit" value="Delete comment" class="btn btn-danger btn-sm">
					</form>
				</div>
				<?php endif; ?>
			</div>
			<?php endforeach; ?>
	</div>
	<?php endif; ?>
	<!--- Comments end here --->
	<!--- Comment Form starts here --->
	<?php if (isset($_SESSION['user_id'])) : ?>
	<form action="<?php echo URLROOT ?>/contents/comment" method="post">
		<h3>Add a comment</h3>
		<textarea type="text" name="comment" id="comment-box" class="form-control" rows="5" required></textarea>
		<input type="hidden" name="post_id" value="<?php echo $data['image']->image_id; ?>">
		<br>
		<input type="submit" value="Add comment" class="btn btn-success">
	</form>
	<?php endif; ?>
	<!--- Comment Form ends here --->
</div>
</div>
<?php require APPROOT . '/views/inc/footer.php';?>