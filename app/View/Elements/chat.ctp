<div id="agmk_chat", userUsername="<?=AuthComponent::user('username');?>" userId="<?=AuthComponent::user('id');?>" chatState="<?=AuthComponent::user('chat_state');?>">
	<div id="agmk_chat_frame">
		<ul id="frame">
			<li id="contacts_chat"> </li>
			<li id="team_chat"></li>
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
<div style="display:none;" id="contain">
</div>
<?php echo $this->Html->script("chat"); ?>
<?php echo $this->Html->css("chat"); ?>