<?php echo $this->Form->create('Profile'); ?>
<fieldset>
<legend><?php echo __('Add profile'); ?></legend>
<?php echo $this->Form->input('pseudo', array('label' => 'Pseudo')); ?>
<?php echo $this->Form->input('level', array('label' => 'Level/ League')); ?>
<?php echo $this->Form->input('Game'); ?>
<?php echo $this->Form->end(__('Submit')); ?>
</fieldset>