<div id="onglets">
	<ul>
		<li><a href="#onglet-1">Leagues</a></li>
		<li><a href="#onglet-2">Tournaments</a></li>
		<li><a href="#onglet-3">Others</a></li>
	</ul>
	<div id="onglet-1">
		<h2><?php echo __('Events'); ?></h2>
			<table cellpadding="0" cellspacing="0">
			<tr>
				<th><?php echo $this->Paginator->sort('id'); ?></th>
				<th><?php echo $this->Paginator->sort('user_id'); ?></th>
				<th><?php echo $this->Paginator->sort('game_id'); ?></th>
				<th><?php echo $this->Paginator->sort('modified'); ?></th>
				<th><?php echo $this->Paginator->sort('date_debut'); ?></th>
				<th><?php echo $this->Paginator->sort('date_fin'); ?></th>
				<th><?php echo $this->Paginator->sort('created'); ?></th>
				<th class="actions"><?php echo __('Actions'); ?></th>
			</tr>
			<?php foreach ($events as $event): ?>
			<?php if ($event['Event']['type'] == 'league'): ?>
			<tr>
				<td><?php echo h($event['Event']['id']); ?>&nbsp;</td>
				<td>
					<?php echo $this->Html->link($event['User']['id'], array('controller' => 'users', 'action' => 'view', $event['User']['id'])); ?>
				</td>
				<td>
					<?php echo $this->Html->link($event['Game']['name'], array('controller' => 'games', 'action' => 'view', $event['Game']['id'])); ?>
				</td>
				<td><?php echo h($event['Event']['modified']); ?>&nbsp;</td>
				<td><?php echo h($event['Event']['date_debut']); ?>&nbsp;</td>
				<td><?php echo h($event['Event']['date_fin']); ?>&nbsp;</td>
				<td><?php echo h($event['Event']['created']); ?>&nbsp;</td>
				<td class="actions">
					<?php echo $this->Html->link(__('View'), array('action' => 'view', $event['Event']['id'])); ?>
					<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $event['Event']['id'])); ?>
					<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $event['Event']['id']), array(), __('Are you sure you want to delete # %s?', $event['Event']['id'])); ?>
				</td>
			</tr>
		<?php endif; ?>
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
	<div id="onglet-2">

	</div>
	<div id="onglet-3">

	</div>
</div>

<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Create Event'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Matches'), array('controller' => 'matches', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('My Teams'), array('controller' => 'teams', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Create Team'), array('controller' => 'teams', 'action' => 'add')); ?> </li>
	</ul>
</div>

<script type="text/javascript">
	jQuery(document).ready(function() {
		$("#onglets").tabs();
	});
</script>