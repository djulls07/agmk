<div id="content_special" class="content_special_login">
	<span id="content_special_titre">LOGIN</span>
	
	<?php echo $this->Session->flash('auth'); ?>
	<?php echo $this->Form->create('User'); ?>
		<table>
			<?php
				echo "<tr><td>Username</td><td>".$this->Form->input('username', array('label' => false))."</td>
						<td rowspan='2' style='text-align : right'> <input type='submit' value=' '> </td>
				</tr>";
				echo "<tr><td>Password</td><td>".$this->Form->input('password', array('label' => false))."</td>";			
			?>
		</table>
	</form>
	<p><small><?php echo $this->Html->link('I am a noobs and got no brain...( password recovery )', array('action'=>'recoverpassword')) ?></small></p>
<p> <br> </p>
<!--
  Below we include the Login Button social plugin. This button uses
  the JavaScript SDK to present a graphical Login button that triggers
  the FB.login() function when clicked.
-->
<fb:login-button id="fbbutton" scope="public_profile,email" onlogin="checkLoginState();">
</fb:login-button>
<p><small>
<a href="#" id="fbbuttonout" style="display:none;" onclick="logoutfb()">Disconnect from Facebook & FbAgameKapp</a>
</small></p>

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
</script>
<?php echo $this->Html->script("fbLog"); ?>

