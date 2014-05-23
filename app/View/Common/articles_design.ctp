<?php
if (isset ($game) ) 
{
?>
 <STYLE type="text/css">
		#barre_jeux
		{
			background-color	:	#<?php echo $game['Game']['a_background']; ?>;
			color	:	#<?php echo $game['Game']['a_color']; ?>;
		}
 </STYLE>
<?php
//if(file_exists("img/backgrounds/".$game['Game']['image_gauche'].".png") && file_exists("img/backgrounds/".$game['Game']['image_gauche'].".png")) 
//{
?>
 <STYLE type="text/css">
		div.contentgauche
		{
			background-image:url('../../img/backgrounds/<?php print $game['Game']['image_gauche']; ?>.png');
		}
		div.contentdroite
		{
			background-image:url('../../img/backgrounds/<?php print $game['Game']['image_droite']; ?>.png');
		}
		div.menu a
		{
			background	:	#<?php echo $game['Game']['a_background']; ?>;
			color	:	#<?php echo $game['Game']['a_color']; ?>;
		}
		div.menu a:hover
		{
			background	:	#<?php echo $game['Game']['a_hover_background']; ?>;
			color	:	#<?php echo $game['Game']['a_hover_color']; ?>;

		}
		.col_titre
		{
			background	:	#<?php echo $game['Game']['a_background']; ?>;
			color	:	#<?php echo $game['Game']['a_color']; ?>;
		}
		/*div.contenu
		{
			padding-top:3.5%;
		}*/
 </STYLE>
 
 
 <?php 
 //}
 }
  //echo $this->element('barre_specific');
 ?>
<div class="contenu">
	<div class="col_gauche">
		<?php echo $this->fetch('content');  ?>
	</div>
	<div class="col_droite">
		<div class="col_droite_tv">
				<div id="slideshow">
				<ul id="sContent_tv">
					<li><div style="width:33%; float:left; height:100%; background:green">TV 1</div></li>
					<li><div style="width:33%; margin-left:0.5%; margin-right:0.5%; float:left;height:100%; background:yellow">TV 2</div></li>
					<li><div style="width:33%; float:left;height:100%; background:red">TV 3</div></li>
				</ul>
			</div>
		</div>
		<div class="col_titre">
			TITRE
		</div>
		<div class="col_droite_info">
			Info1
		</div>
				<div class="col_titre">
			TITRE
		</div>
		<div class="col_droite_info">
			Info1
		</div>
		<div class="col_titre">
			TITRE
		</div>
		<div class="col_droite_info">
			Info1
		</div>
		<div class="col_droite_info">
			Info2
		</div>
				<div class="col_titre">
			TITRE
		</div>
		<div class="col_droite_info">
			Info1
		</div>
	</div>
</div>