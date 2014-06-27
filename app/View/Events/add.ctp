
<div id="onglets">
	<ul>
		<li><a href="#onglet-1">League</a></li>
		<li><a href="#onglet-2">Tournament</a></li>
		<li><a href="#onglet-3">New Format</a></li>
	</ul>

	<div id="onglet-1">
			<?php echo $this->Form->create('Event'); ?>
				<fieldset>
					<legend><?php echo __('Create League'); ?></legend>
				<?php
					echo $this->Form->input('user_id', array('type'=>'hidden', 'value' => AuthComponent::user('id')));
					echo $this->Form->input('game_id');
					echo $this->Form->input('min_teams', array('label' => 'Min nb of teams'));
					echo $this->Form->input('date_debut', array('type' => 'text' ,'class' => 'datepick'));
					echo $this->Form->input('date_fin', array('type' => 'text' ,'class' => 'datepick'));
					echo $this->Form->input('nb_seasons', array('type' => 'text', 'label' => 'Nb Season'));
					echo $this->Form->input('type', array('value' => 'league', 'type' => 'hidden'));
					//echo $this->Form->input('Team');
				?>
				<div id="addToForm"></div>
				</fieldset>
			<?php echo $this->Form->end(__('Submit')); ?>
	</div>

	<div id="onglet-2">
	<!--contenu -->
	</div>
	<div id="onglet-3">
	<!--contenu -->
	</div>
</div>

<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Event'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('My Teams'), array('controller' => 'teams', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Create Team'), array('controller' => 'teams', 'action' => 'add')); ?> </li>
	</ul>
</div>

<?php echo $this->Html->script('eventsCalendar'); ?>