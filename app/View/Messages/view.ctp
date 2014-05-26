<div id="message_view">
	<p>
		<?php echo h($message['Message']['content']);?>
		<br />
		<small><?php echo $this->Html->link(h($message['Message']['src_username']), 
			array('controller' => 'users', 'action' => 'view', $message['Message']['src_id'])
		); ?></small>
	</p>
</div>