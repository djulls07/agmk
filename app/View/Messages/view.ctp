<div id="message_view">
	<h1> Message from <?php echo $message['Message']['src_username'];?></h1>
	<p>
		<?php echo h($message['Message']['content']);?>
		<br />
		<small><?php echo $this->Html->link(h($message['Message']['src_username']), 
			array('controller' => 'users', 'action' => 'view', $message['Message']['src_id'])
		); ?></small>
	</p>
	<?php echo $this->Html->link('Respond',
		 array('controller'=>'messages', 'action' => 'reponse', $message['Message']['id'])); ?>
	<?php echo $this->Html->link('Back', array('action' => 'received')); ?>
</div>