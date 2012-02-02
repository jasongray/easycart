<?php

class AppController extends Controller {
	
	var $components = array(
		'Auth' => array(
	            'flashElement' => 'flash_error'
		), 'Acl', 'Ssl', 'Session', 'Email');
	var $helpers = array('Html', 'Javascript', 'Form', 'Session', 'XHtml', 'menu', 'resize');
	
	function beforeFilter() {
		
		$this->Auth->authenticate = ClassRegistry::init('User');
		$this->Auth->authorize = 'actions';
		$this->Auth->loginAction = array('controller' => 'users', 'action' => 'login', 'admin' => false, 'plugin' => false);
		$this->Auth->logoutRedirect = array('controller' => 'users', 'action' => 'login', 'admin' => false);
		$this->Auth->loginRedirect = array('controller' => 'users', 'action' => 'dashboard', 'admin' => 'admin');
		$this->mysite();
		
		
		
	}
	
	function beforeRender(){
		
		if( isset( $this->params['prefix'] ) && $this->params['prefix'] === 'admin' && $this->layout != 'ajax' ) {
			$this->layout = 'admin';
		}
		if($this->name != 'CakeError'){
			$this->menutitles();
		}else{
			$this->set('metadesc_for_layout', '');
			$this->set('metakw_for_layout', '');
		}
		
		/*
		if( isset( $this->params['prefix'] ) && $this->params['prefix'] === 'admin'){
			$this->Ssl->force();
		}else{
			$this->Ssl->unforce();
		}
		*/
		
	}
	
	private function mysite(){
		
		if(Configure::read('MySite.offline') == 1 && !isset( $this->params['prefix']) && $this->params['action'] != 'login' && $this->params['action'] != 'logout' ){
			$this->cakeError('offline', array(
				'code' => '403',
				'name' => __('Site Offline', true),
				'message' => Configure::read('MySite.offline_msg'),
				'base' => ''
			));
			$this->set('title_for_layout', 'Site Offline');
			$this->set('metadesc_for_layout', '');
			$this->set('metakw_for_layout', '');
		}
		
		if(Configure::read('MySite.debug') == 1){
			Configure::write('debug', 2);
		}else{
			Configure::write('debug', 0);
		}
		
		if(Configure::read('MySite.smtp') == 1){
			$this->Email->delivery = 'smtp';
			$_options = array();
			$_options['timeout'] = '30';
			$_options['port'] = Configure::read('MySite.smtp_port') != ''? Configure::read('MySite.smtp_port'): '25';
			$_options['host'] = Configure::read('MySite.smtp_host') != ''? Configure::read('MySite.smtp_host'): '';
			$_options['username'] = Configure::read('MySite.smtp_username') != ''? Configure::read('MySite.smtp_username'): '';
			$_options['password'] = Configure::read('MySite.smtp_password') != ''? Configure::read('MySite.smtp_password'): '';
			$_options['client'] = Configure::read('MySite.smtp_client') != ''? Configure::read('MySite.smtp_client'): '';
			$this->Email->smtpOptions = $_options;
		}
		
	}
	
	private function menutitles(){
		$_url = isset($this->params['url']['url'])? $this->params['url']['url']: '';
		if($_url === '/'){
			$_controller = '';
			$_action = 'index';
		}else{
			$_controller = $this->params['controller'];
			$_action = $this->params['action'];
		}
		$_model = Inflector::classify($this->params['controller']);
		$_me = $this->$_model->query("SELECT * FROM `menu_items` WHERE `controller` = '$_controller' AND `action` = '$_action' LIMIT 1");
		if($_me){
			$_m = $_me[0];
			if($_m['menu_items']['show_title'] == 1){
				$this->set('title_for_layout', $_m['menu_items']['page_title']);
			}
			if(!empty($_m['menu_items']['page_meta'])){
				$this->set('metadesc_for_layout', $_m['menu_items']['page_meta']);
			} else {
				$this->set('metadesc_for_layout', Configure::read('MySite.meta_description'));
			}
			if(!empty($_m['menu_items']['page_kw'])){
				$this->set('metakw_for_layout', $_m['menu_items']['page_kw']);
			} else {
				$this->set('metakw_for_layout', Configure::read('MySite.meta_keywords'));
			}
		}else{
			$this->set('title_for_layout', Inflector::humanize(Inflector::tableize($this->params['controller'])));
			$this->set('metadesc_for_layout', Configure::read('MySite.meta_description'));
			$this->set('metakw_for_layout', Configure::read('MySite.meta_keywords'));
		}
	}

}