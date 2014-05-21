<?php
echo $this->Form->create('Post');
?>
<fieldset>
<legend> <?php echo __('Add post'); ?></legend>
<?php
echo $this->Form->input('title');
echo $this->Form->input('body', array('rows' => 3));
?>
</fieldset>
<?php echo $this->Form->end(__('Save')); ?>