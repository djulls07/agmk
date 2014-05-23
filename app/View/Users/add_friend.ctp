<?php echo $this->Form->create('User'); ?>
<fieldset><legend>Users list</legend>
<?php echo $this->Form->input('Friend'); ?>
<?php echo $this->Form->input('id', array('type'=>'hidden', 'value' => AuthComponent::user('id'))); ?>
</fieldset>
<?php echo $this->Form->end(__('Add Friend')); ?>