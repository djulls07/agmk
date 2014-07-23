<?php echo $this->Form->create('Tag'); ?>
<fielset>
	<legend> Edit tag </legend>
<?= $this->Form->input('content', array('label' => 'name')); ?>
</fieldset>
<?= $this->Form->end(__('Update')); ?>