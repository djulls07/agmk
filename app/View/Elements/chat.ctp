<?php if (AuthComponent::user('id')): ?>
	<div id="agmk_chat">
		<div id="menu_agmk_chat">
		</div>
		<div id="content_agmk_chat">
		
			<!-- display onglets here -->
			<div id="onglets_agmk_chat">
				<ul id="liste_onglets_agmk_chat">
					<li ><a class="hideable" href="#onglet-1_agmk_chat">Onglet 1</a></li>
				</ul>		
			</div>
		</div>
		<div id="form_agmk_chat">
			<form action="#">
				<input id="input_form_agmk_chat" type="text" value="type messages/commands here" />
				<input type="submit" value="send" />
			</form>
		</div>
	</div>
	<?php echo $this->Html->script('chat'); ?>
	<?php echo $this->Html->css("chat"); ?>
<?php endif;?>