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
				<span class='barre_jeux_element'> / </span>
				<span class='barre_jeux_element'>".
				$this->Html->link($game['Game']['name'], array(
							'controller' => 'articles',
							'action' => 'index',
							$game['Game']['id']
							)
						)
				."</span>
				<span class='barre_jeux_element'> / </span>
				<span class='barre_jeux_element'>";
		foreach($game['Link'] as $link_id => $link_array)
		{
			print "	<span class='barre_jeux_element'>
					<a href=\"".$link_array['url']."\">".$link_array['name']."</a>
					</span>";
			if ( count($game['Link']) != $link_id+1) echo "<span class='barre_jeux_element'> - </span>";
		}
	}
	else
	{
		echo "<center>";
		$games = $this->requestAction(array('controller'=>'games', 'action' => 'listgames'));
		foreach ($games as $game) :
			echo "<span class='barre_jeux_element' id='barre_jeux_".$game['Game']['id']."'>";
			echo $this->Html->link($game['Game']['name'], array(
							'controller' => 'articles',
							'action' => 'index',
							$game['Game']['id']
							)
						);
			echo '</span>';
		endforeach;
		echo "</center>";
	}	
	?>
</div>