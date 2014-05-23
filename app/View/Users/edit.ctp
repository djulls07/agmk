<div class="users form">
<?php echo $this->Form->create('User'); debug($user); ?>
	<fieldset>
		<legend><?php echo __('Edit User'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('username');
		echo $this->Form->input('password');
		//echo $this->Form->input('role');
	?>
		<div class="input select">
			<label for="UsernewsParPage">News par page</label>
			<select name="data[User][newsParPage]" id="UsernewsParPage"><option value="5">5</option><option value="10">10</option><option value="15">15</option><option value="20">20</option><option value="0">&infin;</option></select>
		</div>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li>
			<?php
				echo $this->Form->postLink(
					'Delete',
					array('action' => 'delete', $this->Form->value('id')),
					array('confirm' => 'Are you sure ?')
	            );
                ?>
		</li>
		<li><?php echo $this->Html->link(__('List Users'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Posts'), array('controller' => 'posts', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Post'), array('controller' => 'posts', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Profiles'), array('controller' => 'profiles', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Profile'), array('controller' => 'profiles', 'action' => 'add')); ?> </li>
	</ul>
</div>
