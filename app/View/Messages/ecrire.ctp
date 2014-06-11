<?php echo $this->Form->create('Message'); ?>
<?php 
	$label_dest="";
	if (isset ($user_dest) )
	{
		echo $this->Form->input('dest_id', array('type' => 'hidden', 'value'	=>	$user_dest['User']['id'], 'id' => 'dest_id'));
		echo $this->Form->input('dest_username', array('type'	=>	'hidden', 'value'	=>	''.$user_dest['User']['username'].'', 'autocomplete' => 'off', 'id' => 'MessageTo', 'label' => 'To'));
		$label_dest = " -> ".$user_dest['User']['username'];
	}
	else
	{
		echo $this->Form->input('dest_username', array('autocomplete' => 'off', 'id' => 'MessageTo', 'label' => 'To'));
		echo $this->Form->input('dest_id', array('type' => 'hidden', 'id' => 'dest_id'));
	}
		?>
<div id="results">
</div>

<?php echo $this->Form->input('content', array('type' => 'text', 'label' => 'Message '.$label_dest, 'rows' => 3)); ?>
<?php echo $this->Form->end(__('Send')); ?>

<?php echo $this->Html->script('ecrire'); ?>

<?php 
if (isset ($user_dest) )
	echo $this->Html->link('Back', array('controller'=>'users','action' => 'view', $user_dest['User']['id']));?>