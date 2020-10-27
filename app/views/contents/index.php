<?php require APPROOT . '/views/inc/header.php';?>
<br>
<div class="container">
	<div class="row md-1">
		<div class="col-md-12">
		<?php if (isset($_SESSION['user_name'])) : ?>
			<a href="<?php echo URLROOT;?>/contents/add" class="btn btn-primary float-right">
				Add Image
			</a>
		<?php endif; ?>
		</div>
	</div>
	<?php foreach($data['images'] as $image) : ?>
		<div class="card card-body mb-3">
		<img src="<?php echo $image->image_path;?>" class="card-img-top mx-auto mb-3" style="width: auto; height: auto; max-height: 35rem;" alt="...">
			<h4 class="card-title">
				<?php echo $image->image_title; ?>
			</h4>
			<p class="card-text"><?php echo $image->image_desc; ?></p>
					<div class="card-footer">
			<small class="text-muted">This is a comment from random internet user</small>
		</div>
			<a href="<?php echo URLROOT; ?>/posts/show/<?php echo $image->image_id; ?>" class="btn btn-dark">More</a>
		</div>
	<?php endforeach; ?>
<?php require APPROOT . '/views/inc/footer.php';?>