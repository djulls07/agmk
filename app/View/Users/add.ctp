<div class="users form">
<?php echo $this->Form->create('User'); ?>
	<fieldset>
		<legend><?php echo __('Add User'); ?></legend>
	<?php
		$this->Captcha->render($captchaSettings);
		echo $this->Form->input('username');
		echo $this->Form->input('password');
		echo $this->Form->input('passwordr', array('label'=>'Virify password', 'type'=>'password'));
		echo $this->Form->input('role', array('type' => 'hidden', 'value' => 'basic'));
		echo $this->Form->input('mail', array('type'=>'text'));
		echo $this->Form->input('mailr', array('label'=>'Verify Email'));
	?>
	
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

<script type="text/javascript">
	$(document).ready(function() {

		var formulaire = $('#UserAddForm');
		var pass1 = $("#UserPassword");
		var pass2 = $("#UserPasswordr");

		var mail1 = $("#UserMail");
		var mail2 = $("#UserMailr");

		pass2.blur(function() {
			if ($(this).val() != pass1.val()) {
				alert('Passwords doesnt match... please try again.');
			}
		});
		mail2.blur(function() {
			if ($(this).val() != mail1.val()) {
				alert('Emails doesnt match... please try again !');
			}
		});

		formulaire.submit(function() {
			var str = "";
			if (pass1.val()!=pass2.val()) {
				str += 'Passwords doesnt match... please try again.\n';
			}
			if (mail1.val() != mail2.val()) {
				str += 'Emails doesnt match... please try again.\n';
			}
			if (str == "") return true;
			else return false;
		});
	});
</script>
