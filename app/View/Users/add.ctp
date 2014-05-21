<div class="users form">
<?php echo $this->Form->create('User'); ?>
	<fieldset>
		<legend><?php echo __('Add User'); ?></legend>
	<?php
		$this->Captcha->render($captchaSettings);
		echo $this->Form->input('username');
		echo $this->Form->input('password');
		echo $this->Form->input('role', array('type' => 'hidden', 'value' => 'basic'));
	?>
	<div id="edit_profiles">    
	    <?php foreach ($games as $id => $game) : ?>
			<div class="edit_profile">
		    	<legend> Profile <?= $game ?> : </legend>
		    	<?php echo $this->Form->input('Profile.'.$id.'.pseudo'); ?>
		    	<?php echo $this->Form->input('Profile.'.$id.'.level'); ?>
		    	<?php echo $this->Form->input('Profile.'.$id.'.game_name', array('type' => 'hidden', 'value' => $game))
		    	;?>
		    	<?php echo $this->Form->input('Profile.'.$id.'.game_id', array('type' => 'hidden', 'value' => $id)); ?>
		    </div>
		<?php endforeach; ?>
	</div>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>

<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link('Go home', array('controller' => 'articles')); ?></li>
		<li><?php echo $this->Html->link('Reset', array('action' => 'add')); ?></li>
	</ul>
</div>