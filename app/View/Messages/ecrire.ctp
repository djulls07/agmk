<?php echo $this->Form->create('Message'); ?>
<?php echo $this->Form->input('To', array('autocomplete' => 'off', 'id' => 'MessageTo')); ?>
<?php echo $this->Form->input('dest_id', array('type' => 'hidden', 'id' => 'dest_id')); ?>
<?php echo $this->Form->input('src_id', array('type' => 'hidden', 'id' => 'dest_username')); ?>
<div id="results">
</div>
<?php echo $this->Form->end(__('Send')); ?>

<?php echo $this->Html->script('ecrire'); ?>