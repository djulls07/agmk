<?php
	$this->extend('/Common/articles_design');
?>			
<div class="col_gauche_mainnews">
	<div id="slideshow">
		<ul id="sContent_mainnews" style="width:400%">
			<li><div style="width:25%; float:left; height:100%;  text-align:center" class="vertical_center_div"><img src="../../img/main1.jpg"></div></li>
			<li><div style="width:25%; float:left;height:100%;  text-align:center" class="vertical_center_div"><img src="../../img/main2.jpg"></div></li>
			<li><div style="width:25%; float:left;height:100%;  text-align:center" class="vertical_center_div"><img src="../../img/main3.jpg"></div></li>
			<li><div style="width:25%; float:left;height:100%; text-align:center" class="vertical_center_div"><img src="../../img/main4.jpg"></div></li>
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
				<?php 	echo '<a href="/articles/view/' . $article['id']. '">';
						echo $this->Media->image($article['thumb'], 175, 110); ?></a>
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
	if ( $newsParPage ) // si l'affichage n'est pas infini
	{
		$nbr_pages = ceil($newsTotal/$newsParPage); // et s'il n'y a pas qu'une seule page
		if ( $nbr_pages != 1 )
		{
			for ($i=1;$i<=$nbr_pages;$i++) // alors affichage des numéros de pages
			{
				if ($i == $pageindex)
					print "<a style=\"font-weight : bold; color : #9d86b7;\" ";
				else
					print "<a ";
				print "href=\"?pageindex=".$i."\">".$i."</a> ";
			}

			?>
			<form action="/users/edit/74?url=users%2Fedit%2F74" id="UserEditForm" method="post" accept-charset="utf-8">
			<div style="display:none;">
			<input type="hidden" name="_method" value="PUT"/></div>
			<input type="hidden" name="data[User][id]" value="74" id="UserId"/>
			<select name="data[User][newsParPage]" id="UsernewsParPage"><option value="5">5</option><option value="10">10</option><option value="15">15</option><option value="20">20</option><option value="0">infinite</option></select>
			<input type="submit" value="News par page"/>
			<?php
		}
	} 
?>
</p>
