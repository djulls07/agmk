<div id="messages_s_r">
	<h1>Incoming messages</h1>
	<table>
		<tr>
			<th><?php echo $this->Paginator->sort('dest_username', 'From'); ?></th>
			<th><?php echo $this->Paginator->sort('src_username', 'To'); ?></th>
			<th><?php echo $this->Paginator->sort('content', 'Message'); ?></th>
			<th class="actions">Actions</th>
			<th>Send/Receive</th>
		</tr>
		<?php foreach($messages as $message) : ?>
		<tr>
			<td><?php echo $message['Message']['src_username'];?></td>
			<td><?php echo $message['Message']['dest_username'];?></td>
			<td><?php echo $message['Message']['content']; ?></td>
			<td>
				<?php echo $this->Html->link('Read', array('action' => 'view', $message['Message']['id'])); ?>
				Respond
			</td>
			<td><?php echo $message['Message']['created']; ?></td>
		</tr>
		<?php endforeach; ?>
	</table>
</div>