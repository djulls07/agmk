<div class="notifications">
<ul>
	<?php foreach($notifications as $notification): ?>
		<li>
			<?php echo $this->Form->postLink(
				$notification['Notification']['content'],
				array(
					'controller' => $notification['Notification']['controller'],
					'action' => $notification['Notification']['action'],
					$notification['Notification']['id'],
					$notification['Notification']['param1'],
					$notification['Notification']['param2']
				),
				array('confirm' => 'Want to add this friend ?')
			); ?>
		</li>
	<?php endforeach; ?>
</ul>
</div>