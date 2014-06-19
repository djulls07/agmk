<?php

App::uses('AppHelper', 'View/Helper');

class ConversationHelper extends AppHelper {

	public function createConversation($path) {
		$path = '/files/'.$path;
		$file = null;
		try {
			if (file_exists($path)) {
				$file = fopen($path, "r");
				flock($file, LOCK_SH);
			} else {
				$file = fopen($path, "x");
			}
			flock($file, LOCK_UN);
			fclose($file);
			$this->afficheForm();
		} catch (Exception $e) {
			die('Error: ' . $e->getMessage());
		}
	}

	public function afficheForm() {
		echo '<div class="tchat" style="display:none;">
		<h3> Team Tchat </h3>
		<div id="conversation" style="overflow:scroll; border:#000000 1px solid;">
		<!-- This part will be fill by javascript -->
		</div>';
		echo $this->Form->create('Conversation', array('id' => 'ConversationForm', 'myaction' => '/teams/saveTchat', 'idTeam' => $team['Team']['id']));
		echo $this->Form->input('message', array('label' => 'Message', 'id' => 'messageInput'));
		echo $this->Form->end(__('Send'));
		echo '</div>';
		echo $this->Html->script('conversation');
	}

}


?>