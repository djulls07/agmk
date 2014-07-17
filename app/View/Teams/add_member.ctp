<?php echo $this->Form->create('Team', array('label' => 'ADD TeamMate', 'id' => 'formSearchBar', 'class'=>'form_auto_complete')); ?>
<?php 
echo $this->Form->input('name', 
	array(
		'label' => 'New teammate name',
		'class' => 'searchBar',
		'controller' => 'users',
		'action' => 'getusers',
		'callType' => 'get',
		'handler' => 'getUsersHandler',
		'autocomplete' => 'off'
	)); 
?>

<div class="resultsSearchBar">
	
</div>

<?php echo $this->Form->input('user_id', array('type' => 'hidden', 'class' => 'inputAdd')); ?>
<?php echo $this->Form->end(__('Add teammate')); ?>