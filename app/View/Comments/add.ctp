<?php
echo $this->Form->create('Comment');
?>
<fieldset>
<legend> <?php echo __('Add comment'); ?></legend>
<?php
echo $this->Form->input('body', array('rows' => 3));
?>
</fieldset>
<?php echo $this->Form->end(__('Save')); ?>