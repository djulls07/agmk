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

		    	<?php 
		    		if ($id == 3) {
		    			echo $this->Form->input('Profile.'.$id.'sc2Id', array('id' => 'sc2Id', 'label' => 'Enter SC2 ID'));
		    			echo '<p> How DO I FIND IT: <br />';
		    			echo 'SURF TO: <a href="http://sc2ranks.com" target="_blanck"> sc2ranks.com</a><br />';
		    			echo ' Search for your account in the search bar.';
		    			echo ' Click to view your stats, in the adressbar you will have something like : '.
		    				 ' http://www.sc2ranks.com/character/eu/3216311/YourPseudo/hots/1v1. <br />'.
		    				 ' Your sc2 id is the number beetween region ( here "eu") and "YourPseudo"'.
		    				 ' here it is 3216311</p>';
		    			echo $this->Form->input('Profile.'.$id.'.region', array(
		    				'options' => array(
		    					'eu' => 'Europe',
		    					'us' => 'United States',
		    					'kr' => 'Korea'
		    				)
		    			));
		    		}

		    		if ($id == 2) {
		    			echo $this->Form->input('Profile.'.$id.'.region', array(
		    				'options' => array(
		    					'euw' => 'West Europe',
		    					'eune' => 'East Europe',
		    					'na' => 'United States',
		    					'kr' => 'Korea',
		    					'ru' => 'Russia'
		    				)
		    			));
		    		}
		    	?>
		    	<?php echo $this->Form->input('Profile.'.$id.'.pseudo'); ?>
		    	<?php echo $this->Form->input('Profile.'.$id.'.level', array('readonly' => 'readonly')); ?>
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
<?php echo $this->Html->script('verifProfile'); ?>