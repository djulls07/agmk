 <STYLE type="text/css">
		div.contentgauche
		{
			background-image:url('images/<?php print $articles[]Game['image_gauche']; ?>.png');
		}
		div.contentdroite
		{
			"; if ($page_jeu!="accueil") print"background-image:url('images/".$page_jeu_style['image_droite'].".png');"; print"
		}
		div.menu a
		{
			background	:	".$page_jeu_style['a_background'].";
			color : ".$page_jeu_style['a_color'].";
		}
		div.menu a:hover
		{
			background	:	".$page_jeu_style['a_hover_background'].";
			color : ".$page_jeu_style['a_hover_color'].";
		}
 </STYLE>