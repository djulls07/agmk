<?php echo $this->Form->create('Friendship') ; ?>

<?php echo $this->Form->input('username', array(
	'type' => 'text', 
	'label' => 'Friend Name',
	'autocomplete' => 'off',
	'class' => 'searchBar',
	'controller' => 'users',
	'action' => 'getusers',
	'handler' => 'getUsersHandler'
));?>
<div class="resultsSearchBar">
</div>

<?php echo $this->Form->input('user_id', array('type' => 'hidden', 'class' => 'inputAdd')); ?>

<?php echo $this->Form->end(__('Add Friend')); ?>

<?php 
$action = 'index';
if (isset ( $back ) 
	echo $this->Html->link('Back', array('controller'=>'users','action' => 'view', $back));
else
	echo $this->Html->link('Back', array('action' => 'index'));
?>