<?php
class VisitsController extends AppController {

	var $name = 'Visits';
	
	function beforeFilter() {
	    parent::beforeFilter();
		$this->Auth->allowedActions = array('record'); 
	}
	
	function record(){
		$this->autorender = false;
		$data['ip'] = $_SERVER['REMOTE_ADDR'];
		$data['page'] = $_SERVER['REQUEST_URI'];
		//$this->Visit->deleteAll(array('Visit.created < DATE_SUB(NOW(), INTERVAL 100 DAY)'), false);
		$this->Visit->create();
		$this->Visit->save($data);
		$this->render(false);
	}

}
?>