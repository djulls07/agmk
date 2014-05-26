<div id="messages_r">
	<h1>
		<?php echo $this->Html->link('Inbox', array('action' => 'received')); ?>
	</h1>
	<nav>
		<?php echo $this->Html->link('Got to Outbox', array('action' => 'sent')); ?>
	</nav>
	<?php echo $this->Paginator->numbers(); ?>
	<table>
		<tr>
			<th><?php echo $this->Paginator->sort('src_username', 'From'); ?></th>
			<th><?php echo $this->Paginator->sort('content', 'Message'); ?></th>
			<th class="actions">Actions</th>
			<th><?php echo $this->Paginator->sort('created', 'Date'); ?></th>
		</tr>
		<?php foreach($messages as $message) : ?>
		<tr <?php if (($message['Message']['open_dest']==0)) {
			echo 'style="background:#aaa;"';
		}?>
		>
			<td><?php echo h($message['Message']['src_username']); ?></td>
			<td><?php echo h(substr($message['Message']['content'], 0, 25)) . '...'; ?></td>
			<td>
				<?php echo $this->Html->link('Read', array('action' => 'view', $message['Message']['id'])); ?>
				<?php echo $this->Html->link('Respond', array('action' => 'reponse', $message['Message']['id'])); ?>
			</td>
			<td><?php echo $message['Message']['created']; ?></td>
		</tr>
		<?php endforeach; ?>
	</table>
</div>