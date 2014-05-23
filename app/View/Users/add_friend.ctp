<?php
	echo $this->Form->create('User');
	echo $this->Form->input('User.id', array('type' => 'hidden', 'value' => AuthComponent::user('id')));
	echo $this->Form->input('User');
	echo $this->Form->end('Add Friend');
?>
