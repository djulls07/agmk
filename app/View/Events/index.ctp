<div id="onglets">
	<ul>
		<li><a href="#onglet-1">Subscribed Events</a></li>
		<li><a href="#onglet-2">Leagues</a></li>
		<li><a href="#onglet-3">Tournaments</a></li>
	</ul>
	
	<div id="onglet-1">
	<h3><?php echo __('Subscibed Events'); ?></h3>
			<table cellpadding="0" cellspacing="0">
			<tr>
				<th>Name</th>
				<th>Game</th>
				<th>Begin Date</th>
				<th>Ending Date</th>
				<th>Team subscribed</th>
				<th class="actions"><?php echo __('Actions'); ?></th>
			</tr>
			<?php foreach ($subscribed as $event): ?>
			<tr>
				<td>
					<?php echo $this->Html->link($event['Event']['name'], array('controller' => 'events', 'action' => 'view', $event['Event']['id'])); ?>
				</td>
				<td>
					<?php echo $this->Html->link($event['Game']['name'], array('controller' => 'games', 'action' => 'view', $event['Game']['id'])); ?>
				</td>
				<td><?php echo h($event['Event']['date_debut']); ?>&nbsp;</td>
				<td><?php echo h($event['Event']['date_fin']); ?>&nbsp;</td>
				<td><?php echo h($event['EventTeam']['Team']['name']) ; ?></td>
				<td class="actions">
					<?php echo $this->Html->link(__('View'), array('action' => 'view', $event['Event']['id'])); ?>
					<?php echo 'UnSub';?>
					<?php if ($event['Event']['user_id'] == AuthComponent::user('id')) : ?>
					<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $event['Event']['id'])); ?>
					<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $event['Event']['id']), array(), __('Are you sure you want to delete # %s?', $event['Event']['id'])); ?>
				</td>
			</tr>
		<?php endif; ?>
		<?php endforeach; ?>
	</table>
	</div>
	<div id="onglet-2">
		<h3><?php echo __('Leagues'); ?></h3>
			<table cellpadding="0" cellspacing="0">
			<tr>
				<th><?php echo $this->Paginator->sort('name'); ?></th>
				<th><?php echo $this->Paginator->sort('game_id'); ?></th>
				<th><?php echo $this->Paginator->sort('date_debut'); ?></th>
				<th><?php echo $this->Paginator->sort('date_fin'); ?></th>
				<th class="actions"><?php echo __('Actions'); ?></th>
			</tr>
			<?php foreach ($events as $event): ?>
			<?php if ($event['Event']['type'] == 'league'): ?>
			<tr>
				<td>
					<?php echo $this->Html->link($event['Event']['name'], array('controller' => 'events', 'action' => 'view', $event['Event']['id'])); ?>
				</td>
				<td>
					<?php echo $this->Html->link($event['Game']['name'], array('controller' => 'games', 'action' => 'view', $event['Game']['id'])); ?>
				</td>
				<td><?php echo h($event['Event']['date_debut']); ?>&nbsp;</td>
				<td><?php echo h($event['Event']['date_fin']); ?>&nbsp;</td>
				<td class="actions">
					<?php echo $this->Html->link(__('View'), array('action' => 'view', $event['Event']['id'])); ?>
					<?php echo '<a class="sub" href="#" eventId="'.$event['Event']['id'].
						'" eventName="'.$event['Event']['name'].'"> Subscribe </a>' ;?>
					<?php if ($event['Event']['user_id'] == AuthComponent::user('id')) : ?>
					<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $event['Event']['id'])); ?>
					<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $event['Event']['id']), array(), __('Are you sure you want to delete # %s?', $event['Event']['id'])); ?>
					<?php endif; ?>
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

<div id="dialog" style="display:none;">
	<?php echo $this->Form->create('Event', array('action' => 'addTeam'));?>
	<?php echo $this->Form->input('teams', array('label' => 'Choose Team')); ?>
</div>

<script type="text/javascript">
	jQuery(document).ready(function() {
		$("#onglets").tabs();
		var dialog = $("#dialog");
		var subscribe = jQuery(".sub");
		jQuery.each(subscribe, function () {
			jQuery(this).on("click", function() {
				dialog.dialog(
					{
						autoOpen: false ,
				 		modal: true,
				 		width: 600,
				 		buttons: [{
							text: "Send",
							click: function() {
								jQuery("#EventAddTeamForm").submit();

							}
						}],
						title: "Subscribe to "+jQuery(this).attr('eventName'),
						close: function() {
							
						}
				 	}
				);
				jQuery('#EventAddTeamForm').append('<input name="data[Event][eventId]" type="hidden" value="'+jQuery(this).attr('eventId')+'"></input>');
				dialog.dialog('open');
			});
		});
	});
</script>