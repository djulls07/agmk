<?php echo $this->Form->create('Team'); ?>

<?php echo $this->Form->input('name'); ?>

<?php echo $this->Form->input('tag'); ?>

<?php echo $this->Form->input('game_id', array('label' => 'Game')); ?>

<?php echo $this->Form->end(__('Create team'));