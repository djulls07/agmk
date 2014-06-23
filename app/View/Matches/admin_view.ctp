<div class="matches view">
<h2><?php echo __('Match'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($match['Match']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Event'); ?></dt>
		<dd>
			<?php echo $this->Html->link($match['Event']['id'], array('controller' => 'events', 'action' => 'view', $match['Event']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Team1 Id'); ?></dt>
		<dd>
			<?php echo h($match['Match']['team1_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Team2 Id'); ?></dt>
		<dd>
			<?php echo h($match['Match']['team2_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Win Points'); ?></dt>
		<dd>
			<?php echo h($match['Match']['win_points']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Loose Points'); ?></dt>
		<dd>
			<?php echo h($match['Match']['loose_points']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Date Team1 1'); ?></dt>
		<dd>
			<?php echo h($match['Match']['date_team1_1']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Date Team1 2'); ?></dt>
		<dd>
			<?php echo h($match['Match']['date_team1_2']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Date Team1 3'); ?></dt>
		<dd>
			<?php echo h($match['Match']['date_team1_3']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Date Team2 1'); ?></dt>
		<dd>
			<?php echo h($match['Match']['date_team2_1']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Date Team2 2'); ?></dt>
		<dd>
			<?php echo h($match['Match']['date_team2_2']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Date Team2 3'); ?></dt>
		<dd>
			<?php echo h($match['Match']['date_team2_3']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Real Date'); ?></dt>
		<dd>
			<?php echo h($match['Match']['real_date']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Team Win'); ?></dt>
		<dd>
			<?php echo h($match['Match']['team_win']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Screen Win'); ?></dt>
		<dd>
			<?php echo h($match['Match']['screen_win']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Screen Alt'); ?></dt>
		<dd>
			<?php echo h($match['Match']['screen_alt']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Match'), array('action' => 'edit', $match['Match']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Match'), array('action' => 'delete', $match['Match']['id']), null, __('Are you sure you want to delete # %s?', $match['Match']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Matches'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Match'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Events'), array('controller' => 'events', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Event'), array('controller' => 'events', 'action' => 'add')); ?> </li>
	</ul>
</div>
