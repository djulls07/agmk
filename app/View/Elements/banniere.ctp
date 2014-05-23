<?php
$specific_user_color="orange";
$specific_user_avatar="avatar.jpg";
$specific_user_notifications=10;
$specific_user_messages=0;
$specific_user_GMT=2;
?>
<div class="banniere">
	<div class="banniere_content">
		<div class="banniere_image">
		</div>
		<div class="social">
				<?php 
					echo $this->Html->image("facebook.gif", array(
						"alt" => "Facebook",
					));
					echo "<p/>".$this->Html->image("twitter.png", array(
						"alt" => "Twitter",
					));
				?>
		</div>
		<div class="pub">pub
		</div>
</div>
</div>