<?php
if(file_exists("img/backgrounds/".$game['image_gauche'].".png") && file_exists("img/backgrounds/".$game['image_gauche'].".png")) 
{
?>

 <STYLE type="text/css">
		div.contentgauche
		{
			background-image:url('../../img/backgrounds/<?php print $game['image_gauche']; ?>.png');
		}
		div.contentdroite
		{
			background-image:url('../../img/backgrounds/<?php print $game['image_droite']; ?>.png');
		}
		div.menu a
		{
			background	:	#<?php echo $game['a_background']; ?>;
			color	:	#<?php echo $game['a_color']; ?>;
		}
		div.menu a:hover
		{
			background	:	#<?php echo $game['a_hover_background']; ?>;
			color	:	#<?php echo $game['a_hover_color']; ?>;

		}
 </STYLE>
 
 
 <?php 
 }
 else
 {
 ?>
 
  <STYLE type="text/css">
		div.contentgauche
		{
			background-image:url('../../img/backgrounds/accueil.png');
		}
		div.contentdroite
		{
		}
		div.menu a
		{
			background	:	#a7a7a7;
			color	:	black;

		}
		div.menu a:hover
		{
			background	:	#9d86b7;
			color	:	black;

		}
 </STYLE>
 
 <?php }
 
 echo $this->fetch('content'); ?>