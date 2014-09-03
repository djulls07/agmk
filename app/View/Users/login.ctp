<div class="users form">
<?php echo $this->Session->flash('auth'); ?>
<?php echo $this->Form->create('User'); ?>
    <fieldset>
        <legend>
            <?php echo __('Please enter your username and password'); ?>
        </legend>
        <?php echo $this->Form->input('username');
        echo $this->Form->input('password');
    ?>
    </fieldset>
    <p><?php echo $this->Html->link('I am a noobs and got no brain...( password recovery )', array('action'=>'recoverpassword')); ?>
    </p>
<?php echo $this->Form->end(__('Login')); ?>
<h3>Connect via Facebook:</h3>
<div class="fb-login-button" data-max-rows="1" data-size="large" data-show-faces="false" data-auto-logout-link="false"> SOON</div>
<p><strong>AgameK.org has been reset today( Alpha start ), please re-create account</strong></p>
</div>
<script type="text/javascript">
$(document).ready(function() {

	var username = $("#UserUsername");
	var password = $("#UserPassword");
	var form = $("#UserLoginForm");
	var htmlForm = form.html();
	var b = false;

	form.on('submit', function() {
		if (b) {
			return b;
		}
		$.ajax({
	        url: 'http://agamek.org/forum/login.php?action=in',
	        type: 'POST',
	        data: { 'form_sent' : 1, 'req_username' : username.val(), 'req_password':password.val() },
	        success: function (data) {
	          //data = $.parseJSON(data);
	         // form.empty();
	          //form.html("<h2 style=\"text-align:center;\"> You have been succesfully connected to the forum, connection to site...</h2>");
	          b = true;
	          form.submit();

	        },
	        error: function() {
	        	alert("Error forum log")
	        },
	        datatype: 'json'  
	    });
	    return b;
	});

});
</script