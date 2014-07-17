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
		$ongletsChann = explode(";", $chat['Chat']['onglets_channels']);
		foreach($ongletsChann as $k=>$v) {
			$ongletsChan[$k] = explode(',', $v);
		}
		if ($ongletsChan == null) {
			echo '{"reponse" : "none"}';
			exit();
		}
		$nbOnglets = count($ongletsChan);
		echo json_encode(array('nb_onglets'=>$nbOnglets, 'ongletsChan'=>$ongletsChan));
		exit();
	}
	
	public function isAuthorized($user) {
		if ($this->action === "channels") {
			return true;
		}
		return parent::isAuthorized($user);
	}
	
	
}