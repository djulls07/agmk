<div class="barre_jeux">
	<?php
	$games = $this->requestAction(array('controller'=>'games', 'action' => 'listgames'));
	foreach ($games as $game) :
		echo "<span id='barre_jeux_".$game['Game']['id']."'>";
		echo $this->Html->link($game['Game']['name'], array(
                        'controller' => 'articles',
                        'action' => 'index',
                        $game['Game']['id']
                        )
                    );
		echo '</span>';
	endforeach;
    ?>
</div>