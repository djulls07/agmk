<?php echo $this->Form->create('Profile'); ?>
<fieldset>
<legend><?php echo __('Add Game profile'); ?></legend>
<?php echo $this->Form->input('Game'); ?>
<?php echo $this->Form->input('pseudo'); ?>
<?php echo $this->Form->input('level', array('readonly' => 'readonly')); ?>
</fieldset>
<?php //echo $this->Form->end(__('Submit')); ?>
<div id="loading"></div>
<?php echo $this->Html->script('addProfile'); ?>