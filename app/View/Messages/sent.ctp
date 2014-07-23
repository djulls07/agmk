<div id="messages_r">
	<h1>
		<?php echo $this->Html->link('Outbox', array('action' => 'sent')); ?>
	</h1>
	<nav>
		<?php echo $this->Html->link('Go to Inbox', array('action' => 'received')); ?> |
		<?php echo $this->Html->link('New message', array('action' => 'ecrire')); ?>
	</nav>
	<?php echo $this->Paginator->numbers(); ?>
	<table>
		<tr>
			<th><?php echo $this->Paginator->sort('src_username', 'To'); ?></th>
			<th><?php echo $this->Paginator->sort('content', 'Message'); ?></th>
			<th class="actions">Actions</th>
			<th><?php echo $this->Paginator->sort('created', 'Date'); ?></th>
			<th>Status</th>
		</tr>
		<?php foreach($messages as $message) : ?>
		<tr>
			<td><?php echo h($message['Message']['dest_username']); ?></td>
			<td><?php echo h(substr($message['Message']['content'], 0, 25)) . '...'; ?></td>
			<td>
				<?php echo $this->Html->link('Read', array('action' => 'view', $message['Message']['id'])); ?>
			</td>
			<td><?php echo $message['Message']['created']; ?></td>
			<td>
				<small><?php if (($message['Message']['open_dest']==1)) {
						echo 'OPENED BY ' . $this->Html->link($message['Message']['dest_username'],
							array('controller' => 'user', 'action' => 'view', $message['Message']['dest_id']));
					} else {
						echo 'NOT OPENED BY ' . $this->Html->link($message['Message']['dest_username'],
							array('controller' => 'user', 'action' => 'view', $message['Message']['dest_id']));	
					}
				?>
			</small></td>
		</tr>
		<?php endforeach; ?>
	</table>
</div>