<div id="content_special" class="content_special_inscription">
	<span id="content_special_titre">INSCRIPTION</span>

	<?php echo $this->Form->create('User'); ?>
		<table>
			<?php
				echo "<tr><td>Username</td><td>".$this->Form->input('username', array('label' => false))."</td></tr>";
				echo "<tr><td>Password</td><td>".$this->Form->input('password', array('label' => false))."</td></tr>";
				echo "<tr><td>Confirm Password</td><td>".$this->Form->input('passwordr', array('label' => false, 'type'=>'password'))."</td></tr>";
				echo "<tr><td>Email</td><td>".$this->Form->input('mail', array('label' => false, 'type'=>'text'))."</td></tr>";
				echo "<tr><td>Confirm Email</td><td>".$this->Form->input('mailr', array('label' => false, 'type'=>'text'))."</td></tr>";
				echo $this->Form->input('role', array('type' => 'hidden', 'value' => 'basic'));
				$this->Captcha->render($captchaSettings);
			?>
			<?php echo "<tr><td></td><td style='text-align:center'>".$this->Form->end(__(' '))."</td></tr>"; ?>
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
