<?php echo $this->Form->create('Article'); ?>
<fieldset>
	<legend> <?php echo __('Create article'); ?> </legend>
	<?php echo $this->Form->input('title'); ?>
	<?php echo $this->Form->input('game_id', array('label' => 'Game')); ?>
</fieldset>
<?php echo $this->Form->end(__('Create and edit it')); ?>
