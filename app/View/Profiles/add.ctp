<?php echo $this->Form->create('Profile'); ?>
<fieldset>
<legend><?php echo __('Add Game profile'); ?></legend>
<?php echo $this->Form->input('Game'); ?>
<?php echo $this->Form->input('pseudo', array('type' => 'hidden')); ?>
<?php echo $this->Form->input('level', array('type' => 'hidden')); ?>
<?php echo $this->Form->input('region', array('type' => 'hidden'));?>
</fieldset>
<?php //echo $this->Form->end(__('Submit')); ?>
<div id="loading"> Loading</div>
<div id="dialog">
<form id="formPop"></form>
</div>
<?php echo $this->Html->script('addProfile'); ?>