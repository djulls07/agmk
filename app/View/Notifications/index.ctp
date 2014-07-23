<div class="notifications">
<table>
<tr>
	<th>Notification</th>
	<th class="actions">Actions</th>
</tr>
<?php foreach($notifications as $notification): ?>
	<td><?php echo $notification['Notification']['content']; ?></td>
	<td class="actions">
		<?php echo $this->Form->postLink(
				'Accept',
				array(
					'controller' => $notification['Notification']['controller'],
					'action' => $notification['Notification']['action'],
					$notification['Notification']['id'],
					$notification['Notification']['param1'],
					$notification['Notification']['param2']
				),
				array('confirm' => 'Accept ?')
		); ?>
		<?php echo $this->Form->postLink(
				'Refuse',
				array(
					'controller' => $notification['Notification']['controller'],
					'action' => 'not'.$notification['Notification']['action'],
					$notification['Notification']['id'],
					$notification['Notification']['param1'],
					$notification['Notification']['param2']
				),
				array('confirm' => 'Want to refuse ?')
		); ?>
	</td>	
<?php endforeach; ?>
</table>
</div>