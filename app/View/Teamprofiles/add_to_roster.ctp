<h1>Add player to Roster</h1>
<h3>Add player: <?php echo $user['User']['username']; ?> to <?php echo $team['Team']['name']; ?> </h3>
<?php echo $this->Form->create('Teamprofile'); ?>

<?php echo $this->Form->input('game_id', array('label' => 'Roster')); ?>

<?php echo $this->Form->end(__('Add')); ?>