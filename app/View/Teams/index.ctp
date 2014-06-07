<h1>Teams</h1>
<nav>
	<?php echo $this->Html->link('Create NEW TEAM', array('action' => 'add')); ?> |
</nav>
<hr>
<br />
<div id="myteams">
	<h3>My Teams</h3>
	<?php //echo $this->Html->link('Create new team', array('controller' => 'teams', 'action' => 'add')); ?>
	<table>
		<tr>
			<th> Team Name </th>
			<th> Team Tag </th>
			<th> Game </th>
			<th>Your Role</th>
			<th> Created </th>
			<th class="actions"> Actions </th>
		</tr>
		<?php foreach($teams as $team) : ?>

		<tr>
			<td> 
				<?php 
					echo $this->Html->link($team['Team']['name'], array(
					'controller' => 'teams', 
					'action' => 'view', 
					$team['Team']['id']));
				?>
			</td>
			<td> <?= $team['Team']['tag']; ?> </td>
			<td> 
				<?php 
					echo $this->Html->link($team['Game']['name'], array(
					'controller' => 'articles', 
					'action' => 'index', 
					$team['Game']['id']));
				?> 
			</td>
			<td>
				<?php 
					if ($team['Team']['leader_id'] == AuthComponent::user('id'))
						echo 'LEADER';
					else
						echo 'Member';
				?>
			</td>
			<td> <?= $team['Team']['created']; ?> </td>
			<td class="actions"> 
				<?php echo $this->Html->link('View Team', array('action' => 'view', $team['Team']['id'])); ?>
				<?php echo $this->Form->postLink('Delete',
						array('controller' => 'teams', 'action' => 'delete', $team['Team']['id']),
						array('confirm' => 'Are you sure ?')
					); ?>
			</td>
		</tr>

		<?php endforeach; ?>
	</table>
</div>