<div id="respondMessage">
<h1>Inbox</h1>
<nav>
	<?php echo $this->Html->link('Go to Outbox', array('action' => 'sent')); ?> |
	<?php echo $this->Html->link('New message', array('action' => 'ecrire')); ?> |
	<?php echo $this->Html->link('Back', array('action' => 'received')); ?>
</nav>
<hr>
<br />
<h3>Message from <?php echo $message_src['Message']['src_username']; ?></h3>
<p><?php echo h($message_src['Message']['content']); ?>
<br /><small><?php
	 echo $this->Html->link($message_src['Message']['src_username'],
	 	array('controller' => 'users', 'action' => 'view', $message_src['Message']['src_id'])); ?>
	</small></p><hr>
<?php echo $this->Form->create('Message', array('action' => 'reponse/'.$message_src['Message']['id'])); ?>
<?php echo $this->Form->input('content', array('label' => 'Reponse'));?>
<?php echo $this->Form->end(__('Send message')); ?>
</div>