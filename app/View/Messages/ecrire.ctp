<?php echo $this->Form->create('Message'); ?>
<?php echo $this->Form->input('dest_username', array('autocomplete' => 'off', 'id' => 'MessageTo', 'label' => 'To')); ?>
<?php echo $this->Form->input('dest_id', array('type' => 'hidden', 'id' => 'dest_id')); ?>
<div id="results">
</div>

<?php echo $this->Form->input('content', array('type' => 'text', 'label' => 'Message', 'rows' => 3)); ?>
<?php echo $this->Form->end(__('Send')); ?>

<?php echo $this->Html->script('ecrire'); ?>