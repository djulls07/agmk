<div class="add_message">
<?php echo $this->Form->create('Message'); ?>
<fieldset>
	<legend>Send a message to  <?= $dest_username; ?></legend>
	<?php echo $this->Form->input('dest_username', array('type' => 'hidden', 'value' => $dest_username)); ?>
	<?php echo $this->Form->input('dest_id', array('type' => 'hidden', 'value' => $dest_id)) ; ?>
	<?= $this->Form->input('content', array('type' => 'text', 'label' => 'Message', 'rows' => 3)); ?>
</fieldset>
<?php echo $this->Form->end(__('Send message')); ?>
</div>