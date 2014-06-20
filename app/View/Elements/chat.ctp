<div id="agmk_chat" style="width:100%;">
	<div style="width:20%; max-height:400px;">
		<li id="contacts_chat" style="padding:3px; width:100%; display:none; background:rgba(255,255,255,0.6);">
		</li>
	</div>
	<div style="width:100%; background:rgba(157,134,183,0.6);" id="barre_action" userId="<?php echo AuthComponent::user('id'); ?>">
		<ul>
			<ul>
				<li class="hideAndShow" idBalise="contacts_chat" style="width:20%;"><a href="#">Friends</a></li>
			</ul>
		</ul>
	</div>
</div>
<?php echo $this->Html->script("chat"); ?>