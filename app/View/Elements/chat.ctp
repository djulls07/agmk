<div id="agmk_chat", userId="<?=AuthComponent::user('id');?>">
	<div id="agmk_chat_frame">
		<ul id="frame">
			<li id="contacts_chat"> </li>
			<li id="team_chat">
				<ul><li>premier</li><li>deuxieme</li></ul>
			</li>
		</ul>
	</div>
	<div id="barre_action" userId="<?php echo AuthComponent::user('id'); ?>">
		<ul id="menu_frame">
			<li class="hideAndShow" idBalise="contacts_chat">
				Friends
			</li>
			<li class="hideAndShow" idBalise="team_chat">
				Teams
			</li>
		</ul>
	</div>
</div>
<?php echo $this->Html->script("chat"); ?>
<?php echo $this->Html->css("chat"); ?>