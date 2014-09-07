<!-- <STYLE>
[class*="col-"], footer {
  background-color: lightgreen;
  border: 2px solid black;
  border-radius: 6px;
  line-height: 40px;
  text-align: center;
}
</STYLE> -->

<!-- forum menu first -->
<?php $this->start('menu_forum_gauche'); ?>
<li><a href="http://agamek.org/forums/view/<?php echo $topic[0]['Topic']['forum_id']; ?>">Back</a></li>
<li><a href="#">Reply</a></li>
<?php $this->end(); ?>



<?php //debug($count);?>

<!-- pagination -->
<h2><?php echo $topic[0]['Topic']['subject'];?></h2>
<div class="row">
	<ul class="pagination">
	<?php
	foreach($index as $k=>$v) {
		echo $v;
	}
	?>
	</ul>
</div>
<?php foreach($topic[0]['Post'] as $post): ?>
<?php $user = $posters[$post['poster_id']]; ?>
<div class="row">
	<nav class="col-md-12">
          <ul class="nav nav-pills">
        	<li><a href="#">Reply</a></li>
			<li><a href="http://agamek.org/forums/view/<?php echo $topic[0]['Topic']['forum_id']; ?>">Back</a></li>
          </ul>
    </nav>
</div>
<div class="row well">
	<div class="col-md-3"><p class="text-left text-warning"><bold><?php echo $post['poster']; ?></bold></p>
	</div>
	<div class="col-md-9"><p class="text-left text-warning"><small><?php echo date("Y-m-d h:i:s"); ?></small></p>
	</div>
	<div class="col-md-3"><p class="text-left"><bold><?php echo $user['group_id']['g_title']; ?></bold></p>
		<?php 
		@$file = fopen('http://agamek.org/forum/img/avatars/'.$user['id'].'.png', "r");
		if ($file) {
			$ext = 'http://agamek.org/forum/img/avatars/'.$user['id'].'.png';
			fclose($file);
		} else if (!$file) {
			@$file = fopen('http://agamek.org/forum/img/avatars/'.$user['id'].'.jpeg', "r");
			if ($file) {
				$ext =  'http://agamek.org/forum/img/avatars/'.$user['id'].'.jpeg';
				fclose($file);
			} else if (!$file) {
				@$file = fopen('http://agamek.org/forum/img/avatars/'.$user['id'].'.jpg', "r");
				if ($file) {
					$ext =  'http://agamek.org/forum/img/avatars/'.$user['id'].'.jpg';
					fclose($file);
				} else {
					$ext = 'http://agamek.org/img/avatar.jpg';
				}
			}
		}			
		//$ext = 'http://agamek.org/forum/img/avatars/'.$user['id'].'.png'
		?>
		<img src="<?php echo $ext;?>" />
		<p><small>Registered: <?php echo date("Y-m-d", $user['registered']);?><br />
		Posts: <?php echo $user['num_posts']; ?></small></p>
	</div>
	<div class="col-md-9">
		<p class="text-left"><?php echo $post['message']; ?></p>
	</div>
</div>
<?php endforeach; ?>