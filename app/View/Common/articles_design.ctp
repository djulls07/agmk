<?php
if ( isset ($game) ) 
{
if( false) {
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
}
//if(file_exists("img/backgrounds/".$game['Game']['image_gauche'].".png") && file_exists("img/backgrounds/".$game['Game']['image_gauche'].".png")) 
//{
?>
 <STYLE type="text/css">
		<?php if ( file_exists('../webroot/img/backgrounds/'.$game['Game']['image_gauche'].'.png' )) { ?>
		aside#contentgauche
		{
			background-image:url('/img/backgrounds/<?php print $game['Game']['image_gauche']; ?>.png');
		}
		<?php } if ( file_exists('../webroot/img/backgrounds/'.$game['Game']['image_gauche'].'.png' )) { ?>
		aside#contentdroite
		{
			background-image:url('/img/backgrounds/<?php print $game['Game']['image_droite']; ?>.png');
		}
		<?php } ?>
		/*div.menu a
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
			background-image:-webkit-gradient(linear, right top, left bottom, color-stop(0%,#ececec), color-stop(40%,#<?php echo $game['Game']['a_background']; ?>),color-stop(60%,#<?php echo $game['Game']['a_background']; ?>),color-stop(97%,#ececec));
			background-image : -moz-linear-gradient(right top, #ececec 0%, #<?php echo $game['Game']['a_background']; ?> 40%,#<?php echo $game['Game']['a_background']; ?> 60%,#ececec 97%);
			background-image : -ms-linear-gradient(right top, #ececec 0%, #<?php echo $game['Game']['a_background']; ?> 40%,#<?php echo $game['Game']['a_background']; ?> 60%,#ececec 97%);
			background-image : -o-linear-gradient(right top, #ececec 0%, #<?php echo $game['Game']['a_background']; ?> 40%,#<?php echo $game['Game']['a_background']; ?> 60%,#ececec 97%);
			background-image : linear-gradient(right top, #ececec 0%, #<?php echo $game['Game']['a_background']; ?> 40%,#<?php echo $game['Game']['a_background']; ?> 60%,#ececec 97%);
		}*/
		/*div.contenu
		{
			padding-top:3.5%;
		}*/
		
		.col_gauche_news_text:hover {
			/*box-shadow: inset 0px 0px 10px 2px #<?php echo $game['Game']['a_background']; ?>;*/
		}
 </STYLE>
 
 
 <?php 
 //}
 }
 ?>
<STYLE type="text/css">
 		div.content
		{
			background : #ececec;
		}
 </STYLE>
<div class="contenu">
	<div class="col_gauche">
		<?php echo $this->fetch('content');  ?>
	</div>
	<div class="col_droite">
	<!--- STREAMS --->
		<div class="col_droite_tv">
			<iframe width="100%" height="100%" src="//www.youtube.com/embed/fXbRTNEpccc?autoplay=0&version=3" frameborder="0" allowfullscreen></iframe>

		</div>
		<!--<div class="col_titre col_titre_stream">
			STREAMS
		</div>
			<div class="col_droite_info" id="streams">
				<ul>
					<li><a href=""><span class="streams_program">Emission1</span><span class="streams_horaires">20h-21h</span></a></li>
					<li><a href=""><span class="streams_program">Emission2</span><span class="streams_horaires">21h-24h</span></a></li>
					<li><a href=""><span class="streams_program">Emission3</span><span class="streams_horaires">26h-31h</span></a></li>
				</ul>
			</div>-->
	<!--- EVENTS --->
		<div class="col_titre">
			ON-GOING EVENTS
		</div>
		<div class="col_titre">
			UP-COMING EVENTS
		</div>
	<!--- CONCOURS --->
		<div class="col_titre">
			CONCOURS
		</div>
	<!--- ARTICLES A LA UNE --->
		<?php if ( false && isset ($articles_a_la_une) )  if (!empty($articles_a_la_une)) : ?>
			<div class="col_titre">
				A LA UNE
			</div>
			<div class="col_droite_info">
				<?php 
				foreach($articles_a_la_une as $article_a_la_une){
				$article_a_la_une=$article_a_la_une['Article'];
					echo'<div class="col_gauche_news col_gauche_news_separation">';
						$article_image='/img/agamek_logo_crop.png';
						$style_default="background-position:center center; background-size:contain";
						if ( isset ($article_a_la_une['thumb']) )
							if (!empty ($article_a_la_une['thumb']))

									{
										$article_image	=	$article_a_la_une['thumb'];
										$style_default="";
									}
						?>
						<div class="col_gauche_news_image" style="background-image:url('<? print $article_image."');".$style_default; ?>">
							<?php
								echo $this->Html->link(' ', array(
									'controller' => 'articles',
									'action' => 'view',
									$article_a_la_une['id']
									)
								);
							?>
						</div>
						<div class="col_gauche_news_text">
							<a href="/articles/view/<?php print $article_a_la_une['id']; ?>">
								<div class="col_gauche_news_text_title"><?php echo $article_a_la_une['title']; ?></div>
								<div class="col_gauche_news_text_subtitle"><?php echo $article_a_la_une['subtitle']; ?></div>
							</a>
						</div>
					</div>
			<?php }
			echo'</div>';
		endif; ?>
	</div>
</div>