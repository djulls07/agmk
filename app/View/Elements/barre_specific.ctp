<?php

	/*$categories = array (
		"8"	=> array(
					"name"	=>	"MOBA",
					"games"	=>	array()
				),
		"1"	=>	array(
					"name"	=>	"MMO",
					"games"	=>	array()
				),
		"5"	=>	array(
					"name"	=>	"RTS",
					"games"	=>	array()
				),
		"3"	=>	array(
					"name"	=>	"FPS",
					"games"	=>	array()
				),
		"9"	=> array(
					"name"	=>	"V-Fight",
					"games"	=>	array()
				),
		"0"	=>	array(
					"name"	=>	"Others",
					"games"	=>	array()
				),
	);
	$games = $this->requestAction(array('controller'=>'games', 'action' => 'listgames'));
		foreach ($games as $game) :
			array_push($categories[$game['Game']['category']]['games'],$game);

		endforeach;*/
?>

<div class="barre_jeux" id="barre_jeux">
	<?php 
	if (isset ($game) ) 
	{
		print "<a href='/articles/index/".$game['Game']['id']."'>";
		if ( file_exists('../webroot/img/icons/logo_gameid-'.$game['Game']['id'].'.png' ))
			print"<img class='barre_specific_image' src='/img/icons/logo_gameid-".$game['Game']['id'].".png' /></a>";
		else
			print"<img class='barre_specific_image' src='/img/agamek_logo_crop.png' /></a>";
		/*print "	<span class='barre_jeux_element'>".
				$this->Html->link("Accueil", array(
						'controller' => 'articles',
						'action' => 'index',
						)
					)
				."</span>
				<span class='barre_jeux_element'> &#9654; </span>
				<span class='barre_jeux_element'>".
				$this->Html->link($game['Game']['name'], array(
							'controller' => 'articles',
							'action' => 'index',
							$game['Game']['id']
							)
						)
				."</span>
				<span class='barre_jeux_element'> &#9654; </span>
				<span class='barre_jeux_element'>";*/
		echo "<nav class=\"home_barre_mines\"><ul>";
		$unepremiereborder = "class=\"home_barre_mines_first\"";
		foreach($game['Link'] as $link_id => $link_array)
		{
			/*print "	<span class='barre_jeux_element'>
					<a target=\"_blank\" href=\"".$link_array['url']."\">".$link_array['name']."</a>
					</span>";
			if ( count($game['Link']) != $link_id+1) echo "<span class='barre_jeux_element'> - </span>";*/
			$target = "";
			if ( substr( $link_array['url'], 0 , 4) == "http" )
				$target = "target='_blank'";
			print "<li ".$unepremiereborder."><a href=".$link_array['url']." ".$target.">".$link_array['name']."</a></li>";
			$unepremiereborder="";
		}
		echo "</ul></nav>";
	}
	else
	{
		$categories	=	CategoriesComponent::getGamesInCategories();
		echo "<nav class=\"home_barre_mines\"><ul>";
		$unepremiereborder = "class=\"home_barre_mines_first\"";
		foreach($categories as $category)
		{
			if ( ! empty ($category['games']) )
			{
				print "<li ".$unepremiereborder."><a href=''>".$category['name']." <span style=\"vertical-align	:	bottom\">&#9660;</span></a><ul>";
				foreach ($category['games'] as $game)
				{
					print "<li><a href='/articles/index/".$game['Game']['id']."'>";
					if ( file_exists('../webroot/img/icons/logo_gameid-'.$game['Game']['id'].'.png' ))
						print"<img src='/img/icons/logo_gameid-".$game['Game']['id'].".png' />";
					else
						print"<img src='/img/agamek_logo_crop.png' />";
					print	"&nbsp;". strtoupper($game['Game']['name'])."</a></li>";
				}
				print"</ul></li>";
				$unepremiereborder="";
			}
		}
		echo"<li>";?>
		<li id="PLAY_button"><a href="/events">PLAY!</a></li><li>
		<?php
		echo $this->Html->link('COACHING', array(
			'controller' => 'articles',
			'action' => 'index',
			)
		);
		echo"</li><li>";
		?>
		<a target="_blanck" href="http://agamek.org/forum">FORUM</a>
		<?php
		echo"</li>";
		echo "</ul></nav>";
	}	
	?>
</div>