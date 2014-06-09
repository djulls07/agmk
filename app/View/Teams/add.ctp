<?php echo $this->Form->create('Team'); ?>

<?php echo $this->Form->input('name', array('label' => 'Team Name')); ?>

<?php echo $this->Form->input('tag'); ?>

<?php echo $this->Form->end(__('Create team'));