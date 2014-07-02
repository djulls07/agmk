<div class="matches index">
	<h2><?php echo __('Matches'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('event_id'); ?></th>
			<th><?php echo $this->Paginator->sort('team1_id'); ?></th>
			<th><?php echo $this->Paginator->sort('team2_id'); ?></th>
			<th><?php echo $this->Paginator->sort('win_points'); ?></th>
			<th><?php echo $this->Paginator->sort('loose_points'); ?></th>
			<th><?php echo $this->Paginator->sort('date_team1_1'); ?></th>
			<th><?php echo $this->Paginator->sort('date_team1_2'); ?></th>
			<th><?php echo $this->Paginator->sort('date_team1_3'); ?></th>
			<th><?php echo $this->Paginator->sort('date_team2_1'); ?></th>
			<th><?php echo $this->Paginator->sort('date_team2_2'); ?></th>
			<th><?php echo $this->Paginator->sort('date_team2_3'); ?></th>
			<th><?php echo $this->Paginator->sort('real_date'); ?></th>
			<th><?php echo $this->Paginator->sort('team_win'); ?></th>
			<th><?php echo $this->Paginator->sort('screen_win'); ?></th>
			<th><?php echo $this->Paginator->sort('screen_alt'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($matches as $match): ?>
	<tr>
		<td><?php echo h($match['Match']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($match['Event']['id'], array('controller' => 'events', 'action' => 'view', $match['Event']['id'])); ?>
		</td>
		<td><?php echo h($match['Match']['team1_id']); ?>&nbsp;</td>
		<td><?php echo h($match['Match']['team2_id']); ?>&nbsp;</td>
		<td><?php echo h($match['Match']['win_points']); ?>&nbsp;</td>
		<td><?php echo h($match['Match']['loose_points']); ?>&nbsp;</td>
		<td><?php echo h($match['Match']['date_team1_1']); ?>&nbsp;</td>
		<td><?php echo h($match['Match']['date_team1_2']); ?>&nbsp;</td>
		<td><?php echo h($match['Match']['date_team1_3']); ?>&nbsp;</td>
		<td><?php echo h($match['Match']['date_team2_1']); ?>&nbsp;</td>
		<td><?php echo h($match['Match']['date_team2_2']); ?>&nbsp;</td>
		<td><?php echo h($match['Match']['date_team2_3']); ?>&nbsp;</td>
		<td><?php echo h($match['Match']['real_date']); ?>&nbsp;</td>
		<td><?php echo h($match['Match']['team_win']); ?>&nbsp;</td>
		<td><?php echo h($match['Match']['screen_win']); ?>&nbsp;</td>
		<td><?php echo h($match['Match']['screen_alt']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $match['Match']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $match['Match']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $match['Match']['id']), array(), __('Are you sure you want to delete # %s?', $match['Match']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Match'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Events'), array('controller' => 'events', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Event'), array('controller' => 'events', 'action' => 'add')); ?> </li>
	</ul>
</div>
