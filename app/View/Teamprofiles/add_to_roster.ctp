<h1>Add player to <?=$this->Html->link($team['Team']['name'], 
	array('controller' => 'teams', 'action' => 'view', $team['Team']['id'])); ?> Rosters</h1>

<nav>
	<?php echo $this->Html->link('Add Game/Roster', 
		array('controller' => 'teamprofiles', 'action' => 'add', $team['Team']['id'])); ?> |
	<?php echo $this->Html->link('Back', array('controller' => 'teams', 'action' => 'view', $team['Team']['id'])); ?>
</nav>
<hr>
<br />
<?php echo $this->Form->create('Teamprofile'); ?>

<h4> ADD <?php echo $this->Html->link($user['User']['username'], 
		array('controller' => 'users', 'action' => 'view', $user['User']['id'])) . ' to ' . 
	$team['Team']['name'] . ' Roster'.  
	$this->Form->input('game_id', array('label' => ''));?></h4>


<?php echo $this->Form->end(__('Add')); ?>