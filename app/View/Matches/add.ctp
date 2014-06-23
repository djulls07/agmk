<div class="matches form">
<?php echo $this->Form->create('Match'); ?>
	<fieldset>
		<legend><?php echo __('Add Match'); ?></legend>
	<?php
		echo $this->Form->input('event_id');
		echo $this->Form->input('team1_id');
		echo $this->Form->input('team2_id');
		echo $this->Form->input('win_points');
		echo $this->Form->input('loose_points');
		echo $this->Form->input('date_team1_1');
		echo $this->Form->input('date_team1_2');
		echo $this->Form->input('date_team1_3');
		echo $this->Form->input('date_team2_1');
		echo $this->Form->input('date_team2_2');
		echo $this->Form->input('date_team2_3');
		echo $this->Form->input('real_date');
		echo $this->Form->input('team_win');
		echo $this->Form->input('screen_win');
		echo $this->Form->input('screen_alt');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Matches'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Events'), array('controller' => 'events', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Event'), array('controller' => 'events', 'action' => 'add')); ?> </li>
	</ul>
</div>
