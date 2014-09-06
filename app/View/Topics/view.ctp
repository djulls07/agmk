<!-- <STYLE>
[class*="col-"], footer {
  background-color: lightgreen;
  border: 2px solid black;
  border-radius: 6px;
  line-height: 40px;
  text-align: center;
}
</STYLE> -->
<?php //debug($posters);?>
<h2><?php echo $topic[0]['Topic']['subject'];?></h2>
<?php foreach($topic[0]['Post'] as $post): ?>
<?php $user = $posters[$post['poster_id']]; ?>
<div class="row well">
	<div class="col-md-3"><p class="text-left"><bold><?php echo $post['poster']; ?></bold></p>
	</div>
	<div class="col-md-9"><p class="text-left"><small><?php echo date("Y-m-d h:i:s"); ?></small></p>
	</div>
	<div class="col-md-3"><p class="text-left"><bold><?php echo 'AdminOrWatToChange'; ?></bold></p>
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
	</div>
	<div class="col-md-9">
		<p class="text-left"><?php echo $post['message']; ?></p>
	</div>

	
</div>
<?php endforeach; ?>