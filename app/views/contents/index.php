<?php require APPROOT . '/views/inc/header.php';?>
<br>
<div class="container main">
	<div class="row md-1">
		<div class="col-md-12">
		<?php if (isset($_SESSION['user_name'])) : ?>
			<a href="<?php echo URLROOT;?>/contents/add" class="btn btn-primary float-right">
				Add Image
			</a>
			<?php endif; ?>
		</div>
	</div>
	<br>
	<?php if ($data['images']): ?>
	<?php foreach($data['images'] as $image) : ?>
		<div class="card card-body mb-3">
		<img src="<?php echo $image->image_path;?>" class="card-img-top mx-auto mb-3">
			<h4 class="card-title">
				<?php echo $image->image_title; ?>
			</h4>
			<p class="card-text"><?php echo $image->image_desc; ?></p>
			<a href="<?php echo URLROOT; ?>/contents/show/<?php echo $image->image_id; ?>" class="btn btn-dark">More</a>
		</div>
	<?php endforeach; ?>
	<?php else : ?>
		<div class="jumbotron">
			<h1>No images yet :(</h1>
		</div>
	<?php endif; ?>
	<ul class="pagination justify-content-center">
		<li class="<?php if($data['pageno'] <= 1){ echo 'disabled'; } ?>">
			<a href="<?php if($data['pageno'] <= 1){ echo '#'; } else { echo URLROOT.'/contents/'.($data['pageno'] - 1); } ?>">Prev</a>
		</li>
		<li class="<?php if($data['pageno'] >= $data['total_pages']){ echo 'disabled'; } ?>">
			<a href="<?php if($data['pageno'] >= $data['total_pages']){ echo '#'; } else { echo URLROOT.'/contents/'.($data['pageno'] + 1); } ?>">Next</a>
		</li>
	</ul>
	<?php echo 'Total pages: '.$data['total_pages']; ?>
<?php require APPROOT . '/views/inc/footer.php';?>