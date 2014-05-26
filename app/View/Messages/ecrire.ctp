<?php echo $this->Form->create('Message'); ?>
<?php echo $this->Form->input('To', array('autocomplete' => 'off', 'class' => 'MessageTo')); ?>
<?php echo $this->Form->end(__('Send')); ?>

<?php echo $this->Html->script('ecrire'); ?>