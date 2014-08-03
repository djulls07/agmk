<h1>Team
<?php echo $this->Html->link($teamProfile['Teamprofile']['Team']['name'], array(
	'controller' => 'teams', 'action' => 'view', $teamProfile['Teamprofile']['team_id']
));?> -- 
Manage Roster 
<?php echo $teamProfile['Teamprofile']['game_name']; ?>
</h1>

<nav>
	<?php echo $this->Html->link('Back', 
		array('controller' => 'teams', 'action' => 'view', $teamProfile['Teamprofile']['team_id']));
	?> |
</nav>

<h3>Roster</h3>
<table>
	<caption> PLAYERS IN ROSTER </caption>
	<tr>
		<th>Name</th>
		<th>Pseudo</th>
		<th>Level</th>
		<th>Role</th>
		<th class="actions">Actions</th>
	</tr>
	<?php foreach($teamProfile['Teamprofile']['roster'] as $id) : ?>
		<?php if (!isset($teamProfile['Users'][$id]['User']['username'])) continue; ?>
		<tr style="background:#ccc;">
			<td><?php echo h($teamProfile['Users'][$id]['User']['username']); ?></td>
			<td><?php echo h($teamProfile['Users'][$id]['Profile']['pseudo']); ?></td>
			<td><?php echo $teamProfile['Users'][$id]['Profile']['level']; ?></td>
			<td><?php echo ($id==$teamProfile['Teamprofile']['roster_leader_id']) ? 'LEADER' : 'NORMAL' ;?></td>
			<td class="actions"><?php echo $this->Form->postLink('Eject', 
				array(
					'controller' => 'teamprofiles', 
					'action' => 'ejectFromRoster', 
					$teamProfile['Teamprofile']['id'],
					$id,
					$teamProfile['Teamprofile']['Team']['id']
				),
				array('confirm' => 'Are you sure ?')
			);
			?></td>
		</tr>
	<?php endforeach; ?>
</table>

<table>
	<caption> NOT IN ROSTER </caption>
	<tr>
		<th>Name</th>
		<th>Pseudo</th>
		<th>Level</th>
		<th>Role</th>
		<th class="actions">Actions</th>
	</tr>
	<?php foreach($teamProfile['Users'] as $id => $v): ?>
		<?php if (!isset($teamProfile['Teamprofile']['roster'][$id])) : ?>
		<tr>
			<td><?php echo h($teamProfile['Users'][$id]['User']['username']); ?></td>
			<td><?php echo isset($teamProfile['Users'][$id]['Profile']['pseudo']) ?
				h($teamProfile['Users'][$id]['Profile']['pseudo']) : 'NO GAME PROFILE' ;?></td>
			<td><?php echo ($teamProfile['Users'][$id]['Profile']['level']) ? 
				$teamProfile['Users'][$id]['Profile']['level'] : 'NO GAME PROFILE'; ?></td>
			<td><?php echo ($id==$teamProfile['Teamprofile']['roster_leader_id']) ? 'LEADER' : 'NORMAL' ;?></td>
			<td class="actions">
				<?php echo $this->Form->postLink('Add to Roster', array(
					'controller' => 'teamprofiles',
					'action' => 'addToRosterById',
					$id,
					$teamProfile['Teamprofile']['id']
				));?>
			</td>
		</tr>
		<?php endif; ?>
	<?php endforeach; ?>
</table>