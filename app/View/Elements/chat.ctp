<?php if (AuthComponent::user('id')): ?>
<?php 
	$cs = SessionComponent::read('chatstate');
	if (isset($cs) && $cs == true) {
		$open = 'open';
	} else {
		$open = 'close';
	}
?>
	<div id="agmk_chat" state="<?php echo $open; ?>">
		<div id="menu_agmk_chat">
			<ul id="menu_liste_agmk_chat">
				<li class="libutton" id="new_onglet_agmk_chat"> <input class="action button_agmk_chat" type="image" src="/img/chat/add.png" alt="New" /></li>
				<li class="libutton" id="max_agmk_chat"><input class="action button_agmk_chat" type=image src="/img/chat/maximize.png" alt="Max" /></li>
				<li class="libutton" id="close_agmk_chat"><input class="action button_agmk_chat" type="image" src="/img/chat/minimize.png" alt="Close" /></li>
			</ul>
		</div>
		<div id="content_agmk_chat">
		
			<!-- display onglets here -->
			<div id="onglets_agmk_chat">
				<ul id="liste_onglets_agmk_chat">
					<li ><a class="hideable" href="#onglet-1_agmk_chat">Onglet 1</a></li>
				</ul>
				<div class="hideable" id="onglet-1_agmk_chat"></div>		
			</div>
		</div>
		<div id="form_agmk_chat">
			<form action="#">
				<input id="input_form_agmk_chat" type="text" value="type messages/commands here" />
				<input type="submit" value="send" />
			</form>
		</div>
	</div>
	
	<div id="agmk_chat_min">
		<ul>
			<li class="button_agmk_chat_min">
				<input type="button" class="actions" value="Open chat" />
			</li>
		</ul>
	</div>
	<?php echo $this->Html->script('chat'); ?>
	<?php echo $this->Html->css("chat"); ?>
<?php endif;?>