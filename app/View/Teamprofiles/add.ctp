<div id="addTeamProfile">
	<?php echo $this->Form->create('Teamprofile'); ?>
	<?php echo $this->Form->input('game_id', array('label' => 'Game')); ?>
	<?php echo $this->Form->end(__('Add')); ?>
</div>