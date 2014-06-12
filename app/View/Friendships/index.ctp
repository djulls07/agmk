<div id="friendlist">
	<?php echo $this->html->link('Add new friend', array('action' => 'add')); ?>
	<?php echo $this->Paginator->numbers(); ?>
	<table>
		<tr>
			<th><?php echo $this->Paginator->sort('username', 'Pseudo');?></th>
			<th>Status</th>
			<th class="actions">Action</th>
		</tr>

		<?php foreach($friendships as $friend): ?>
			<tr>
				<td>
					<?php echo $this->Html->image($friend['User']['avatar'], array(
						'width' => '35',
						'url' => array('controller' => 'users', 'action' => 'view', $friend['User']['id'])
					)); ?>
					<?php echo $this->Html->link($friend['User']['username'], array(
						'controller' => 'users', 'action' => 'view', $friend['User']['id']
					)); ?>
				</td>
				<td>
					<?php if ($friend['User']['connected']) {
						echo 'CONNECTED';
					} else {
						echo 'NOT CONNECTED';
					}
					?>
				</td>
				<td class="actions">
					<?php echo $this->Html->link('Send message', array(
						'controller' => 'messages',
						'action' => 'ecrire?To='.$friend['User']['id']
					));?>
					<?php echo $this->Form->postLink('Delete friend',
						array('controller' => 'friendships', 'action' => 'delete', 
							$friend['User']['id'], 
							$friend['User']['username']),
							array("confirm" => 'Are you sure ?')
					);?>
				</td>
			</tr>
		<?php endforeach; ?>
	</table>
</div>