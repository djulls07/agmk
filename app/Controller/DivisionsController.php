<?php
class DivisionsController extends AppController {

	public function beforeFilter() {
		$this->Auth->deny('all');
	}
}

?>