<?php
class WalletsController extends AppController {
	
	public function beforeFilter() {
		$this->Auth->deny('all');
	}
	
	
}