<?php echo $this->Form->create('Friendship') ; ?>

<?php echo $this->Form->input('username', array('type' => 'text', 'label' => 'Friend Name')); ?>

<?php echo $this->Form->end(__('Add Friend')); ?>