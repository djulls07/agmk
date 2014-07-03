<?php
	$this->extend('/Common/articles_design');
?>
<script type="text/javascript">
	var deg = 0;
	boxshadox = 'inset 0px -100px 100px -50px rgba(0,0,0,0.5)';
	
	function changeStyle(divid,stylename,value)
	{
		element = document.getElementById(divid);
		element.style['-webkit-'+stylename] = value;
		element.style['-moz-'+stylename] = value;
		element.style['-ms-'+stylename] = value;
		element.style['-o-'+stylename] = value;
		element.style[stylename] = value;
	}

	function tourneCube(sens){
		deg += 90*sens;
		changeStyle('cube','transform','rotateX('+deg+'deg)');
		//changeStyle('front','box-shadow',boxshadox);
		//changeStyle('back','box-shadow',boxshadox);
		//changeStyle('up','box-shadow',boxshadox);
		//changeStyle('bottom','box-shadow',boxshadox);
		//changeStyle('front','background','-webkit-linear-gradient(top, white 0%,gray 70%,black 100%)');
	}
	
	var stopdragvar = false; 
	
	function	dragCube(dragobj)
	{
		var e = window.event;
		var starty = e.clientY;
		document.onmousemove = function(e) {
		var endy = e.clientY;
        if (dragobj) {
            var newy = endy-starty;
            var dir = endy > starty ? '-1' : 1;
            if ( stopdragvar ) { tourneCube(dir) } ;
			stopdragvar = false;
        }
        return false;
    }
	}
	
	function stopdrag()
	{
		stopdragvar = false; 
	}
	function startdrag(dragobj)
	{
		stopdragvar = true; 
		dragCube(dragobj)
	}
</script>
<?php if(  isset ($articles_main_news) )  if (!empty($articles_main_news)) : ?>
	<div class="col_gauche_mainnews">
		<?php if (0) : ?>
		<div id="slideshow">
			<ul id="sContent_mainnews" style="width:400%">
				<?php foreach ( $articles_main_news as $article_main_news) : ?>
				<?php endforeach; ?>
				<li><div style="width:25%; float:left; height:100%;  text-align:center" class="vertical_center_div"><img src="http://lorempixel.com/400/200/food/"></div></li>
				<li><div style="width:25%; float:left;height:100%;  text-align:center" class="vertical_center_div"><img src="http://lorempixel.com/400/200/cats/"></div></li>
				<li><div style="width:25%; float:left;height:100%;  text-align:center" class="vertical_center_div"><img src="http://lorempixel.com/400/200/animals/"></div></li>
				<li><div style="width:25%; float:left;height:100%; text-align:center" class="vertical_center_div"><img src="../../img/main4.jpg"></div></li>
			</ul>
		</div>
		<?php else : ?>
			<div class="left" onclick="tourneCube(1)">&#10142</div>
			<div class="col_gauche_mainnews_cube_container">
				<div id="cube">
					<?php 
					$cube_faces = array ( "front","back","up","bottom" );
					for ($main_news_id = 0 ; $main_news_id <4 ; $main_news_id++) :
						$cube_face = $cube_faces[$main_news_id];
						if (isset($articles_main_news[$main_news_id])) {
							$article_main_news=$articles_main_news[$main_news_id]['Article'];
							echo'<div id='.$cube_face.' onmousedown="startdrag(this)" onmouseup="stopdrag()"><div class="col_gauche_news">';
								$article_image='/img/agamek_logo_crop.png';
								$style_default="background-position:center center; background-size:contain";
								if ( isset ($article_main_news['thumb']) )
									if (!empty ($article_main_news['thumb']))
											{
												$article_image	=	$article_main_news['thumb'];
												$style_default="";
											}
								?>
								<div class="col_gauche_news_image" style="background-image:url('<? print $article_image."');".$style_default; ?>">
									<?php
										echo $this->Html->link(' ', array(
											'controller' => 'articles',
											'action' => 'view',
											$article_main_news['id']
											)
										);
									?>
								</div>
								<div class="col_gauche_news_text">
									<a href="/articles/view/<?php print $article_main_news['id']; ?>">
										<div class="col_gauche_news_text_title"><?php echo $article_main_news['title']; ?></div>
										<div class="col_gauche_news_text_subtitle"><?php echo $article_main_news['subtitle']; ?></div>
									</a>
								</div>
							</div></div>
						<?php }	else
							echo '<div id='.$cube_face.'><img src="http://lorempixel.com/400/200/technics/"></div>';
						?>
					<?php endfor; ?>
				</div>
			</div>
			<div class="right" onclick="tourneCube(-1)">&#10143</div>
		<?php endif; ?>
	</div>
<?php endif; ?>
	
<div class="col_titre">
	ACTUALITE
</div>
<?php
	echo $this->Session->flash();
	$newsTotal=count($articles);	//debug($Acomment);	
	$Acomments=count($Acomment); // nombre total de commentaires
	$pageindex=1;
	$news_id	=	0;
	if (isset ($_GET['pageindex']))
		if (! empty($_GET['pageindex']) && $_GET['pageindex']<=ceil($newsTotal/$newsParPage) && is_numeric($_GET['pageindex']))
			$pageindex=$_GET['pageindex'];

	for ($i=0;($i<$newsParPage || ! $newsParPage) && ($i+($pageindex-1)*$newsParPage)<$newsTotal ;$i++)
	{
		$news_id = ($i+($pageindex-1)*$newsParPage);
		$article=$articles[$news_id]['Article'];
		$comments = 0;
		for($j = 0 ; $j < $Acomments ; $j++)
			if($Acomment[$j]['Acomment']['article_id'] == $article['id']) $comments++;
		?>
		<div class="col_gauche_news">

			<?php 
			$article_image='/img/agamek_logo_crop.png';
			$style_default="background-position:center center; background-size:contain";
			if ( isset ($article['thumb']) )
				if (!empty ($article['thumb']))

						{
							$article_image	=	$article['thumb'];
							$style_default="";
						}
			?>
			<div class="col_gauche_news_image" style="background-image:url('<? print $article_image."');".$style_default; ?>">
				<?php
					echo $this->Html->link(' ', array(
						'controller' => 'articles',
						'action' => 'view',
						$article['id']
						)
					);
				?>
				<?php 	//echo '<a href="/articles/view/' . $article['id']. '">';
						//echo $this->Media->image($article['thumb'], 175, 110); ?><!--</a>-->
			</div>
			<div class="col_gauche_news_text">
			<a href="/articles/view/<?php print $article['id']; ?>">
				<div class="col_gauche_news_text_title"><?php echo $article['title']; ?></div>
				<div class="col_gauche_news_text_subtitle"><?php echo $article['subtitle']; ?></div>
				<div class="col_gauche_news_text_social"> <? if ( $comments ) print "&#9714;".$comments; ?></div>
			</a>
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
		}
	}
?>
</p>
