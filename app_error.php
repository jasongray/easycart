<?php

class AppError extends ErrorHandler {
	
	var $helpers = array('Html', 'Form', 'Session', 'XHtml', 'menu', 'resize');

	function offline($params){
		$this->controller->set('name', $params['name']);
		$this->controller->set('code', $params['code']);
		$this->controller->set('message', $params['message']);
		$this->_outputMessage('offline');
	}

}