<div class="events view">
<h2><?php echo __('Event'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($event['Event']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($event['User']['id'], array('controller' => 'users', 'action' => 'view', $event['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Game'); ?></dt>
		<dd>
			<?php echo $this->Html->link($event['Game']['name'], array('controller' => 'games', 'action' => 'view', $event['Game']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($event['Event']['modified']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Date Debut'); ?></dt>
		<dd>
			<?php echo h($event['Event']['date_debut']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Date Fin'); ?></dt>
		<dd>
			<?php echo h($event['Event']['date_fin']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($event['Event']['created']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Event'), array('action' => 'edit', $event['Event']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Event'), array('action' => 'delete', $event['Event']['id']), null, __('Are you sure you want to delete # %s?', $event['Event']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Events'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Event'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Games'), array('controller' => 'games', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Game'), array('controller' => 'games', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Matches'), array('controller' => 'matches', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Match'), array('controller' => 'matches', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Results'), array('controller' => 'results', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Result'), array('controller' => 'results', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Teams'), array('controller' => 'teams', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Team'), array('controller' => 'teams', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Matches'); ?></h3>
	<?php if (!empty($event['Match'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Event Id'); ?></th>
		<th><?php echo __('Team1 Id'); ?></th>
		<th><?php echo __('Team2 Id'); ?></th>
		<th><?php echo __('Win Points'); ?></th>
		<th><?php echo __('Loose Points'); ?></th>
		<th><?php echo __('Date Team1 1'); ?></th>
		<th><?php echo __('Date Team1 2'); ?></th>
		<th><?php echo __('Date Team1 3'); ?></th>
		<th><?php echo __('Date Team2 1'); ?></th>
		<th><?php echo __('Date Team2 2'); ?></th>
		<th><?php echo __('Date Team2 3'); ?></th>
		<th><?php echo __('Real Date'); ?></th>
		<th><?php echo __('Team Win'); ?></th>
		<th><?php echo __('Screen Win'); ?></th>
		<th><?php echo __('Screen Alt'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($event['Match'] as $match): ?>
		<tr>
			<td><?php echo $match['id']; ?></td>
			<td><?php echo $match['event_id']; ?></td>
			<td><?php echo $match['team1_id']; ?></td>
			<td><?php echo $match['team2_id']; ?></td>
			<td><?php echo $match['win_points']; ?></td>
			<td><?php echo $match['loose_points']; ?></td>
			<td><?php echo $match['date_team1_1']; ?></td>
			<td><?php echo $match['date_team1_2']; ?></td>
			<td><?php echo $match['date_team1_3']; ?></td>
			<td><?php echo $match['date_team2_1']; ?></td>
			<td><?php echo $match['date_team2_2']; ?></td>
			<td><?php echo $match['date_team2_3']; ?></td>
			<td><?php echo $match['real_date']; ?></td>
			<td><?php echo $match['team_win']; ?></td>
			<td><?php echo $match['screen_win']; ?></td>
			<td><?php echo $match['screen_alt']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'matches', 'action' => 'view', $match['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'matches', 'action' => 'edit', $match['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'matches', 'action' => 'delete', $match['id']), null, __('Are you sure you want to delete # %s?', $match['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Match'), array('controller' => 'matches', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Results'); ?></h3>
	<?php if (!empty($event['Result'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Event Id'); ?></th>
		<th><?php echo __('Team Id'); ?></th>
		<th><?php echo __('Points'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($event['Result'] as $result): ?>
		<tr>
			<td><?php echo $result['id']; ?></td>
			<td><?php echo $result['event_id']; ?></td>
			<td><?php echo $result['team_id']; ?></td>
			<td><?php echo $result['points']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'results', 'action' => 'view', $result['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'results', 'action' => 'edit', $result['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'results', 'action' => 'delete', $result['id']), null, __('Are you sure you want to delete # %s?', $result['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Result'), array('controller' => 'results', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Teams'); ?></h3>
	<?php if (!empty($event['Team'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Leader Id'); ?></th>
		<th><?php echo __('Second Leader Id'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Tag'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($event['Team'] as $team): ?>
		<tr>
			<td><?php echo $team['id']; ?></td>
			<td><?php echo $team['leader_id']; ?></td>
			<td><?php echo $team['second_leader_id']; ?></td>
			<td><?php echo $team['name']; ?></td>
			<td><?php echo $team['tag']; ?></td>
			<td><?php echo $team['created']; ?></td>
			<td><?php echo $team['modified']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'teams', 'action' => 'view', $team['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'teams', 'action' => 'edit', $team['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'teams', 'action' => 'delete', $team['id']), null, __('Are you sure you want to delete # %s?', $team['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Team'), array('controller' => 'teams', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
