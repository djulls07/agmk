<?php if ($phase2==0): ?>
	<?php echo $this->Form->create('User');?>

	<?php echo $this->Form->input('mail', array('type'=>'text'));?>

	<?php echo $this->Form->end("Help me. I've got no brain");?>
<?php endif; ?>

<?php if ($phase2==1): ?>

	<?php echo $this->Form->create('User');?>

	<?php echo $this->Form->input('password');?>

	<?php echo $this->Form->input('passwordr', array('type'=>'password')); ?>

	<?php echo $this->Form->input('e', array('type'=>'hidden', 'value'=>$passnc));?>

	<?php echo $this->Form->input('h', array('type'=>'hidden', 'value'=>$hash));?>

	<?php echo $this->Form->end("Help me. I've got no brain");?>

<?php endif; ?>