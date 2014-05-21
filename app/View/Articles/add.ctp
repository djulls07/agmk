<?php echo $this->Form->create('Article'); ?>
<fieldset>
	<legend> <?php echo __('Create article'); ?> </legend>
	<?php echo $this->Form->input('title'); ?>
	<?php echo $this->Form->input('Game'); ?>
</fieldset>
<?php echo $this->Form->end(__('Create and edit it')); ?>
