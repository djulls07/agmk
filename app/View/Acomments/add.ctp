<?php
echo $this->Form->create('Acomment');
?>
<fieldset>
<legend> <?php echo __('Add comment'); ?></legend>
<?php
echo $this->Form->input('content', array('rows' => 3));
?>
</fieldset>
<?php echo $this->Form->end(__('Save')); ?>