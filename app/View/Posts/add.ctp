<?php $this->start('menu_forum_gauche'); ?>
<li class="col-md-12 text-center"><a href="http://agamek.org/topics/view/<?php echo $topic['Topic']['id'];?>">Back</a></li>
<?php $this->end(); ?>
<h2>Original topic: <?php echo $topic['Topic']['subject'];?></h2>
<div class="col-md-12 well">
<?php echo $this->Form->create('Post');?>
	<fieldset>
		<legend class="text-info"> <?php echo $user['username'];?> reply: </legend>
		<label>Response</label><?php echo $this->Form->input('message', array('type' => 'textarea', 'label'=>false));?>
		<span class="help-block"> Type your message... ( with your keyboard )</span>
	</fieldset>
	<button type="submit" class="btn">Submit</button>
</form>
</div>
<?php $userId = $firstPost['Post']['poster_id']; ?>
<div class="col-md-12">
	<div class="row well">
		<div class="col-md-3">
			<?php 
				@$file = fopen('http://agamek.org/forum/img/avatars/'.$userId.'.png', "r");
				if ($file) {
					$ext = 'http://agamek.org/forum/img/avatars/'.$userId.'.png';
					fclose($file);
				} else if (!$file) {
					@$file = fopen('http://agamek.org/forum/img/avatars/'.$userId.'.jpeg', "r");
					if ($file) {
						$ext =  'http://agamek.org/forum/img/avatars/'.$userId.'.jpeg';
						fclose($file);
					} else if (!$file) {
						@$file = fopen('http://agamek.org/forum/img/avatars/'.$userId.'.jpg', "r");
						if ($file) {
							$ext =  'http://agamek.org/forum/img/avatars/'.$userId.'.jpg';
							fclose($file);
						} else {
							$ext = 'http://agamek.org/img/avatar.jpg';
						}
					}
				}			
				//$ext = 'http://agamek.org/forum/img/avatars/'.$user['id'].'.png'
			?>
			<p class="text-left"><small class="text-warning"><?php echo $firstPost['Post']['poster'];?></small><br /><br />
			<img src="<?php echo $ext;?>"></p>
		</div>
		<div class="col-md-9"> <p class="text-warning"><small><?php echo $firstPost['Post']['poster'];?> said:</small></p>
			<?php echo $firstPost['Post']['message']; ?>
		</div>
	</div>
</div>
