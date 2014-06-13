<div class="games form">
<?php echo $this->Form->create('Game'); ?>
	<fieldset>
		<legend><?php echo __('Add Game'); ?></legend>
	<?php
		echo $this->Form->input('name');

		echo $this->Form->input('category',array('options'=>CategoriesComponent::getCategoriesName()));
		
		echo $this->Form->input('a_background',array('type'=>'color'));
		echo $this->Form->input('a_color',array('type'=>'color'));
		echo $this->Form->input('a_hover_background',array('type'=>'color'));
		echo $this->Form->input('a_hover_color',array('type'=>'color'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Games'), array('action' => 'index')); ?></li>
	</ul>
</div>
