<div id="content_special">
	<span id="content_special_titre">INSCRIPTION</span>

	<?php echo $this->Form->create('User'); ?>
		<table>
			<?php
				echo "<tr><td>Username</td><td>".$this->Form->input('username', array('label' => false))."</td></tr>";
				echo "<tr><td>Password</td><td>".$this->Form->input('password', array('label' => false))."</td></tr>";
				echo "<tr><td>Confirm Password</td><td>".$this->Form->input('password', array('label' => false))."</td></tr>";
				echo "<tr><td>Email</td><td>".$this->Form->input('mail', array('label' => false))."</td></tr>";
				echo "<tr><td>Confirm Email</td><td>".$this->Form->input('mail', array('label' => false))."</td></tr>";
				echo $this->Form->input('role', array('type' => 'hidden', 'value' => 'basic'));
				$this->Captcha->render($captchaSettings);
			?>
			<?php echo "<tr><td colspan='2'>".$this->Form->end(__(' '))."</td></tr>"; ?>
		</table>
	<!--<div class="actions">
		<h3><?php echo __('Actions'); ?></h3>
		<ul>
			<li><?php echo $this->Html->link('Go home', array('controller' => 'articles')); ?></li>
			<li><?php echo $this->Html->link('Reset', array('action' => 'add')); ?></li>
		</ul>
	</div>-->
	<?php echo $this->Html->script('verifProfile'); ?>
</div>
