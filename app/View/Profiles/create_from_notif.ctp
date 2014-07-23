<?php echo $this->Form->create('Profile', array('action' => 'createFromNotif/'.$params[0].'/'.$params[1].'/'.$params[2], 'id' => 'ProfileCreateFromNotifForm')); ?>
<fieldset>
<legend><?php echo __('Add Game profile'); ?></legend>
<?php echo $this->Form->input('Game'); ?>
<?php echo $this->Form->input('pseudo'); ?>
<?php echo $this->Form->input('level', array('readonly' => 'readonly')); ?>
<?php echo $this->Form->input('region', array('readonly' => 'readonly'));?>
</fieldset>
<?php //echo $this->Form->end(__('Submit')); ?>
<div id="loading"></div>
<div id="dialog">
<form id="formPop"></form>
</div>

<?php echo $this->Html->script('createProfileFromNotif'); ?>