<div class="background">
<?php
$this->extend('/Common/view');

$this->assign('title', 'POST DU FOFO');?>

<p class="post_body"><?php echo h($post['Post']['message']); ?><br />
<small>
	<?php 
		echo $post['Post']['poster'];
	?>
</small>
</p>
</div>