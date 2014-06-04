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
		    			echo '<small>How do i find it: <br />'.
		    			'Surf '.$this->Html->link('http://eu.battle.net/sc2/', 'http://eu.battle.net/sc2/') . 
		    			' OR '. $this->Html->link('http://us.battle.net/sc2/', 'http://us.battle.net/sc2/') . 
		    			' And login with your data. '.
		    			'Then proceed and click on your profile avatar. '.
		    			'On the next page in the adressbar there will be a number of about 6 or 7 digits. '.
		    			'This is your web-id. '.
		    			'Example: http://us.battle.net/sc2/en/profile/999000/1/DayNine/ -> ID is 999000</small>';
		    			echo $this->Form->input('Profile.'.$id.'sc2Id', array('id' => 'sc2Id', 'label' => 'Enter SC2 ID'));
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