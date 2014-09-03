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
<?php echo $this->Form->end(__('Login')); ?>
<h2><?php echo $this->Html->link('Got no brain, help me !', array('action'=>'recoverpassword')); ?></h2>
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