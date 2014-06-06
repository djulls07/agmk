<h2>Message: </h2>
<p><?php echo $message_src['Message']['content']; ?>
<br /><small><?php
	 echo $this->Html->link($message_src['Message']['src_username'],
	 	array('controller' => 'users', 'action' => 'view', $message_src['Message']['src_id'])); ?>
	</small></p><hr>
<?php echo $this->Form->create('Message', array('action' => 'reponse/'.$message_src['Message']['id'])); ?>
<?php echo $this->Form->input('content', array('label' => 'Reponse'));?>
<?php echo $this->Form->end(__('Send message')); ?>