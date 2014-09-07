<!-- <STYLE>
[class*="col-"], footer {
  background-color: lightgreen;
  border: 2px solid black;
  border-radius: 6px;
  line-height: 40px;
  text-align: center;
}
</STYLE> -->

<?php $repLink = $this->Html->link('Reply', 
	array('controller'=>'posts', 'action'=>'add', $topic[0]['Topic']['id']));?>

<!-- forum menu first -->
<?php $this->start('menu_forum_gauche'); ?>
<li class="col-md-12 text-center"><?php echo $repLink; ?>
</li>
<li class="col-md-12 text-center"><a href="http://agamek.org/forums/view/<?php echo $topic[0]['Topic']['forum_id']; ?>">Backk</a></li>
<?php $this->end(); ?>



<?php //debug($count);?>

<!-- pagination -->
<div class="row">
	<div class="col-md-7">
		<h2 class=""><?php echo $topic[0]['Topic']['subject'];?></h2>
	</div>
	<div class="row-md-5 pull-right">
		<ul class="pagination">
			<?php
			foreach($index as $k=>$v) {
				echo $v;
			}
			?>
		</ul>
	</div>
</div>
<?php foreach($topic[0]['Post'] as $post): ?>
<?php $user = $posters[$post['poster_id']]; ?>
<div class="row">
	<nav class="pull-right">
          <ul class="nav nav-pills">
        	<li>
        		<?php echo $repLink; ?>
        	</li>
			<li><a href="http://agamek.org/forums/view/<?php echo $topic[0]['Topic']['forum_id']; ?>">Back</a></li>
          </ul>
    </nav>
</div>
<div class="row well">
	<div class="col-md-3"><p class="text-left text-warning"><bold><?php echo $post['poster']; ?></bold></p>
	</div>
	<div class="col-md-9"><p class="text-left text-warning"><small><?php echo date("Y-m-d h:i:s"); ?></small></p>
	</div>
	<div class="col-md-3"><p class="text-left"><bold><small><?php echo $user['group_id']['g_title']; ?></small></bold></p>
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