<?php
	$categories = array (
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

?>

<div class="barre_jeux" id="barre_jeux">
	<?php 
	if (isset ($game) ) 
	{
		print "	<span class='barre_jeux_element'>".
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
				<span class='barre_jeux_element'>";
		foreach($game['Link'] as $link_id => $link_array)
		{
			print "	<span class='barre_jeux_element'>
					<a target=\"_blank\" href=\"".$link_array['url']."\">".$link_array['name']."</a>
					</span>";
			if ( count($game['Link']) != $link_id+1) echo "<span class='barre_jeux_element'> - </span>";
		}
	}
	else
	{
		$games = $this->requestAction(array('controller'=>'games', 'action' => 'listgames'));
		foreach ($games as $game) :
			array_push($categories[$game['Game']['category']]['games'],$game);
			/*echo "<span class='barre_jeux_element' id='barre_jeux_".$game['Game']['id']."'>";
			echo $this->Html->link($game['Game']['name'], array(
							'controller' => 'articles',
							'action' => 'index',
							$game['Game']['id']
							)
						);
			echo '</span>';*/
		endforeach;
		
		echo "<nav class=\"home_barre_mines\"><ul>";
		$unepremiereborder = "class=\"home_barre_mines_first\"";
		foreach($categories as $category)
		{
			if ( ! empty ($category['games']) )
			{
				print "<li ".$unepremiereborder."><a href=''>".$category['name']." <span style=\"vertical-align	:	bottom\">&#9660;</span></a><ul>";
				foreach ($category['games'] as $game)
				{
					print "<li>";
						echo $this->Html->link($game['Game']['name'], array(
								'controller' => 'articles',
								'action' => 'index',
								$game['Game']['id']
								)
							);
					print "</li>";
				}
				print"</ul></li>";
			}
			$unepremiereborder="";
		}
		echo "</nav>";
	}	
	?>
</div>