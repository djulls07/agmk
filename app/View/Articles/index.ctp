<nav id="news">

<div class="contenu">			
	<div class="col_gauche">
		<div class="col_gauche_mainnews">
			<div id="slideshow">
				<ul id="sContent_mainnews" style="width:400%">
					<li><div style="width:25%; float:left; height:100%;  text-align:center" class="vertical_center_div">Main News 1</div></li>
					<li><div style="width:25%; float:left;height:100%;  text-align:center" class="vertical_center_div">Main News 2</div></li>
					<li><div style="width:25%; float:left;height:100%;  text-align:center" class="vertical_center_div">Main News 3</div></li>
					<li><div style="width:25%; float:left;height:100%; text-align:center" class="vertical_center_div">Main News 4</div></li>
				</ul>
			</div>
		</div>
		<div class="col_titre">
			ACTUALITE
		</div>
		<?php 			
			$newsTotal=count($articles);
			$pageindex=1;
			$news_id	=	0;
			if (isset ($_GET['pageindex']))
				if (! empty($_GET['pageindex']) && $_GET['pageindex']<=ceil($newsTotal/$newsParPage) && is_numeric($_GET['pageindex']))
					$pageindex=$_GET['pageindex'];

			for ($i=0;($i<$newsParPage || ! $newsParPage) && ($i+($pageindex-1)*$newsParPage)<$newsTotal ;$i++)
			{
				$news_id = ($i+($pageindex-1)*$newsParPage);
				$article=$articles[$news_id]['Article'];
				?>
				<div class="col_gauche_news">
					<div class="col_gauche_news_image">
						<?php 	echo '<a href="/Agamek/articles/view/' . $article['id']. '">'; 
								echo $this->Media->image($article['thumb'], 175, 110); ?>
						</a>
					</div>
					<div class="col_gauche_news_text">
						<?php
							echo $this->Html->link($article['title'], array(
								'controller' => 'articles',
								'action' => 'view',
								$article['id']
								)
							);
						?>
					</div>
				</div>
			<?php }
			print "<p class='col_gauche_pages'>";
			$nbr_pages = ceil($newsTotal/$newsParPage);
			if ( $newsParPage )
			if ( $nbr_pages != 1 )
				for ($i=1;$i<=$nbr_pages;$i++)
				{
					if ($i == $pageindex)
						print "<a style=\"font-weight : bold; color : #9d86b7;\" ";
					else
						print "<a ";
					print "href=\"?pageindex=".$i."\">".$i."</a> ";
				}
		?>
		</p>
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

</nav>