<?php
App::uses('AuthComponent', 'Component');
$games = $this->requestAction(array('controller'=>'games', 'action' => 'listgames'));?><div class="barre_jeux">
	<?php
	for($i=0; $i<count($games)-1; $i++):
		echo $this->Html->link($games[$i]['Game']['name'], array(
                        'controller' => 'articles',
                        'action' => 'index',
                        $games[$i]['Game']['id']
                        )
                    );
	endfor;
    ?>
</div>