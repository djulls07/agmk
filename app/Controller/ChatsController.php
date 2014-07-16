<?php

class ChatsController extends AppController {
	
	public function beforeFilter() {
		$this->Auth->deny('all');
	}
	
	public function channels() {
		$this->request->allowMethod('ajax');
		$chat = $this->Chat->findById($this->Auth->user('chat_id'));
		if ($chat == null) {
			echo '{"reponse" : "null"}';
			exit();
		}
		$channels = explode(";", $chat['Chat']['channels']);
		if ($channels == null) {
			echo '{"reponse" : "none"}';
			exit();
		}
		$nbChan = count($channels);
		echo json_encode(array('nb_channels'=>$nbChan, 'channels'=>$channels));
		exit();
	}
	
	public function isAuthorized($user) {
		if ($this->action === "channels") {
			return true;
		}
		return parent::isAuthorized($user);
	}
	
	
}