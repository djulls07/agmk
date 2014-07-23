<h1>Teams</h1>
<nav>
	<?php echo $this->Html->link('Create NEW TEAM', array('action' => 'add')); ?> |
</nav>

<br />
<div id="myteams">
	<h3>My Teams</h3>
	<?php //echo $this->Html->link('Create new team', array('controller' => 'teams', 'action' => 'add')); ?>
	<table>
		<tr>
			<th> Team Name </th>
			<th> Team Tag </th>
			<th>Your Role</th>
			<th> Created </th>
			<th class="actions"> Actions </th>
			<th class="actions">Alpha Team</th> 
		</tr>
		<?php foreach($teams as $team) : ?>
		<?php 
			if (AuthComponent::user('alpha_team_id') == $team['Team']['id']) {
				echo '<tr style="background:#aaa;">';
			} else {
				echo '<tr>';
			}
		?>		
			<td> 
				<?php 
					echo $this->Html->link($team['Team']['name'], array(
					'controller' => 'teams', 
					'action' => 'view', 
					$team['Team']['id']));
				?>
			</td>
			<td> <?= h($team['Team']['tag']); ?> </td>
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
				<?php 
					echo $this->Form->postLink('Delete',
						array('controller' => 'teams', 'action' => 'delete', $team['Team']['id']),
						array('confirm' => 'Are you sure ?')
					);
				?>
			</td>
			<td class="actions">
				<?php
				if (AuthComponent::user('alpha_team_id') != $team['Team']['id']) {
					echo $this->Form->postLink('Make it Alpha',
						array('controller' => 'users', 'action' => 'alpha', $team['Team']['id']),
						array('confirm' => 'Make '.$team['Team']['name'].' your Alpha Team ?')
					);
				} else {
					echo 'This is your ALPHA team';
				}
				?>
			</td>
		</tr>

		<?php endforeach; ?>
	</table>
</div>