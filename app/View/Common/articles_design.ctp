<?php
if (isset ($game) ) 
{
?>
 <STYLE type="text/css">
		#barre_jeux
		{
			background-color	:	#<?php echo $game['Game']['a_background']; ?>;
			/*background: linear-gradient(to bottom, #282828 10%, #<?php echo $game['Game']['a_background']; ?> 100%) repeat scroll 0% 0% transparent;*/
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
			background-image:url('/img/backgrounds/<?php print $game['Game']['image_gauche']; ?>.png');
		}
		div.contentdroite
		{
			background-image:url('/img/backgrounds/<?php print $game['Game']['image_droite']; ?>.png');
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
 ?>
<div class="contenu">
	<div class="col_gauche">
		<?php echo $this->fetch('content');  ?>
	</div>
	<div class="col_droite">
		<div class="col_droite_tv">
			<iframe width="100%" height="100%" src="//www.youtube.com/embed/0iiNPtM9bKs?autoplay=0&version=3" frameborder="0" allowfullscreen></iframe>

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
						<div id="footer">
						<p>Suivre AGAMEK
						<br>
						twitter facebook google+ pinterest reddit you-porn</p>
						<p>
							Tous droits reserves 2014
						</p>
						
					</div>
</div>