<?php $members = $team['User'];
//a remplacer en changeant requete dans controller.
	$nbMembers = 0;
	foreach($members as $member) {
		if ($member['TeamsUser']['actif'] == 1)
			$nbMembers++;
	}
?>
<h1>Team <?php echo $team['Team']['name']; ?></h1>
<nav>
	<?php echo $this->Html->link('Add Member', array('action' => 'addMember', $team['Team']['id'])); ?> |
	<?php echo $this->Html->link('Add Roster/Game', 
		array('controller' => 'teamprofiles', 'action' => 'add', $team['Team']['id'])); ?> |
	<?php echo $this->Html->link('Back', array('action' => 'index')); ?>
</nav>

<br />
<div id="viewTeam">
	<h3>Team Resume</h3>
	<table id="resume">
		<tr style="background:#aaa;">
			<th>Agamek points</th>
			<th>Members in team</th>
			<th class="actions">Actions</th>
		</tr>
		<tr>
			<td>0</td>
			<td><?php echo $nbMembers; ?></td>
			<td class="Actions">Action1</td>
		</tr>
	</table>
	<br />
	<?php foreach($team['Teamprofile']  as $teamProfile) : ?>
		<h3>Roster <?php echo $teamProfile['game_name']; ?></h3>
		<nav>
			<?php if (AuthComponent::user('id') == $team['Team']['leader_id']) {
				echo $this->Form->postLink('Delete Roster', array(
						'controller' => 'teamprofiles',
						'action' => 'delete',
						$teamProfile['id'],
						$team['Team']['id']
					),
					array('confirm' => 'Are you sure ?')
				);
				echo ' | ';
			}?> 
			<?php if (AuthComponent::user('id') == $teamProfile['roster_leader_id'] ||
					AuthComponent::user('id') == $team['Team']['leader_id']) {
				echo $this->Html->link('Manage Roster', array(
					'controller' => 'teamprofiles',
					'action' => 'manage',
					$teamProfile['id']
				));
				echo ' | ';
			}?>
		</nav>

		<br />
		<table id="rosterStats">
			<caption><?php echo $teamProfile['game_name'];?> Roster stats</caption>
			<tr style="background:#aaa;">
				<th>Event</th>
				<th>Match</th>
				<th>Result</th>
				<th>Agamek points</th>
				<th>Match Type</th>
			</tr>
			<!-- foreachmatchs/events played mettre stat des matchs du roster-->
		</table>

		<table id="rosterMembers">
			<caption><?php echo $teamProfile['game_name']; ?> Roster Members</caption>
			<tr style="background:#aaa;">
				<th>Name</th>
				<th>Pseudo</th>
				<th>Level</th>
				<th>Role</th>
				<th class="actions"> Actions</th>
			</tr>
			<?php if ($teamProfile['roster'] != null) : ?>
				<?php foreach($teamProfile['roster'] as $member) : ?>
				<?php 
					if ($member['User']['id'] == $teamProfile['roster_leader_id']) {
						echo '<tr style="background:#bcb;">';
					} else {
						echo '<tr>';
					}
				?>
					<td>
						<?php echo $this->Html->image($member['User']['avatar'], array('width' => '50'));?>
						<?php echo $member['User']['username']; ?>
					</td>
					<td>
						<?php 
							if($member['Profile']['pseudo'] != null){
								echo $member['Profile']['pseudo'];
							} else {
								echo 'Unknown';
							}
						?>
					</td>
					<td>
						<?php 
							if($member['Profile']['level'] != null){
								echo $member['Profile']['level'];
							} else {
								echo 'Unknown';
							}
						?>
					</td>

					<td>
						<?php
						if ($member['User']['id'] == $teamProfile['roster_leader_id']) {
							echo 'Roster Leader';
						} else {
							echo 'Normal';
						}
						?>
					</td>

					<td class="actions">
						<?php 
						if ((AuthComponent::user('id') == $team['Team']['leader_id'] || 
							AuthComponent::user('id') == $teamProfile['roster_leader_id']) &&
							$member['User']['id'] != $teamProfile['roster_leader_id']) {

							echo $this->Form->postLink('Make him leader of this Roster',
								array('controller' => 'teamprofiles',
									'action' => 'makeLeaderRoster',
								 	$teamProfile['id'],
								 	$member['User']['id'],
								 	$team['Team']['id']
								),
								array('confirm' => 'Are you sure ?')
							);
						}
						?>
						<?php 
						if (AuthComponent::user('id') == $team['Team']['leader_id'] || 
							AuthComponent::user('id') == $teamProfile['roster_leader_id']) {
							echo $this->Form->postLink('Eject from roster',
								array('controller' => 'teamprofiles',
									'action' => 'ejectFromRoster',
								 	$teamProfile['id'],
								 	$member['User']['id'],
								 	$team['Team']['id']
								),
								array('confirm' => 'Are you sure ?')
							);
						}
						?>
					</td>
				</tr>
				<?php endforeach; ?>
			<?php endif; ?>
		</table>
	<?php endforeach; ?>
	<br />

	<h3>Active Members</h3>
	<table id="teamMembers">
		<tr style="background:#aaa;">
			<th>Name</th>
			<th>Notes</th>
			<th>In the team since</th>
			<th class="actions">Actions</th>
		</tr>

		<?php foreach($members as $m) : ?>
		<?php if ($m['TeamsUser']['actif'] == 1) : ?>
			<tr <?php if ($team['Team']['leader_id'] == $m['id']) echo 'style="background:#bcb;"';?>>
				<td>
					<?php echo $this->Html->image($m['avatar'], array('width' => '50'));?>
					<?php echo $this->Html->link($m['username'], 
						array('controller' => 'users', 'action' => 'view', $m['id']));
					?>
				</td>
				<td>
					<?php if ($team['Team']['leader_id'] == $m['id']) {
						echo 'LEADER';
					} else {
						echo 'MEMBER';
					}
					?>
				</td>
				<td>
					<?php echo $m['TeamsUser']['created']; ?>
				</td>
				<td class="actions">
					<?php 
						if(AuthComponent::user('id') == $m['id'] && 
							AuthComponent::user('id') != $team['Team']['leader_id']) {
								echo $this->Form->postLink('Leave', 
									array('action' => 'leave', $team['Team']['id']),
									array('confirm' => 'Sure you want to leave '.$team['Team']['name'].' team ?')
								);
						}
					?>
					<?php
						if ($team['Team']['leader_id'] == AuthComponent::user('id')) {
							echo $this->Html->link('Add To Roster...', 
								array('controller' => 'teamprofiles',
									'action' => 'addToRoster',
								 	$m['id'], 
								 	$team['Team']['id']
								)
							);
						}

					?>

					<?php
						if ($team['Team']['leader_id'] == AuthComponent::user('id')
							&& $m['id'] != $team['Team']['leader_id']) {
							echo $this->Form->postLink('Eject', 
								array('controller' => 'teams', 'action' => 'eject', $team['Team']['id'], $m['id']),
								array('confirm' => 'Are you sure ?')
							);
						} else if ($team['Team']['leader_id'] == AuthComponent::user('id')) {
							echo $this->Form->postLink('Eject', 
								array('controller' => '#', 'action' => '#'),
								array('confirm' => 'Are you sure ?')
							);
						}
					?>
					
				</td>
			</tr>
		<?php endif; ?>
		<?php endforeach; ?>
	</table>

	<h3>Members which has been invited</h3>
	<table id="teamMembersNotActif">
		<tr style="background:#aaa;">
			<th>Name</th>
			<th>Notes</th>
			<th>Invitation date</th>
			<th class="actions">Actions</th>
		</tr>

		<?php foreach($members as $m) : ?>
		<?php if ($m['TeamsUser']['actif'] == 0) : ?>
			<tr>
				<td>
					<?php echo $this->Html->image($m['avatar'], array('width' => '50'));?>
					<?php echo $this->Html->link($m['username'], 
						array('controller' => 'users', 'action' => 'view', $m['id']));
					?>
				</td>
				<td>
					FUTURE MEMBER ?!
				</td>
				<td>
					<?php echo $m['TeamsUser']['created']; ?>
				</td>
				<td class="actions">
					<?php
						if ($team['Team']['leader_id'] == AuthComponent::user('id')
							&& $m['id'] != $team['Team']['leader_id']) {
							echo $this->Form->postLink('Eject', 
								array('controller' => 'teams', 'action' => 'eject', $team['Team']['id'], $m['id']),
								array('confirm' => 'Are you sure ?')
							);
						}
					?>
				</td>
			</tr>
		<?php endif; ?>
		<?php endforeach; ?>
	</table>
</div>