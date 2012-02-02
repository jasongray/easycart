<?php
class PagesController extends AppController {

	var $name = 'Pages';
	
	var $helpers = array('xHtml');
	
	function beforeFilter() {
	    parent::beforeFilter();
		$this->Auth->allowedActions = array('display', 'contact_info'); 
	}

	function display() {
		
		$path = func_get_args();
		
		$_m = array();
		$render = 'content';
		
		if( isset($this->params['slug'])){
			preg_match('/(?<id>\d+)\-(?<title>\w+)/', $this->params['slug'], $_m);
		}
		
		$count = count($_m);
		if ($count < 1) {
			$p = $this->Page->find('first', array('conditions' => array('front_page' => 1)));
			$render = 'home';
		}else{
			$p = $this->Page->find('first', array('conditions' => array('slug' => $this->params['slug'])));
		}
		/*
		$page = $subpage = $title_for_layout = null;
		
		if (!empty($path[0])) {
			$page = $path[0];
		}
		if (!empty($path[1])) {
			$subpage = $path[1];
		}
		if (!empty($path[$count - 1])) {
			$title_for_layout = Inflector::humanize($path[$count - 1]);
		}
		*/
		
		
		if($p){
			$title_for_layout = !empty($p['Page']['page_title']) && $p['Page']['show_title'] == 1 ? $p['Page']['page_title']: $p['Page']['title'];
			$render = (!empty($p['Page']['template']))? $p['Page']['template']: $render;
			$this->set(compact('p', 'title_for_layout'));
			$this->render($render);
		}
		
	}
	
	function contact_info(){
		$this->Page->recursive = -1;
		$p = $this->Page->find('first', array('conditions' => array('Page.title' => 'contact_info')));
		$this->set(compact('p'));
	}

	function admin_index() {
		$this->Page->recursive = 0;
		$this->set('pages', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid page', true), 'flash_error');
			$this->redirect(array('action' => 'index'));
		}
		$this->set('page', $this->Page->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			App::import('Core', 'Inflector');
			$_alias = (empty($this->data['Page']['slug']))? $this->data['Page']['title']: '';
			$_alias = Inflector::slug($_alias, '-');
			$this->Page->create();
			if ($this->Page->save($this->data)) {
				$this->data['Page']['slug'] = $this->Page->id.'-'.Inflector::slug($_alias, '-');
				$this->Page->saveField('slug', $this->data['Page']['slug']);
				$this->Session->setFlash(__('The page has been saved', true), 'flash_success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The page could not be saved. Please, try again.', true), 'flash_error');
			}
		}
		$templates = $this->findViews();
		$categories = $this->Page->Category->find('list');
		$this->set(compact('templates','categories'));
		
	}
	
	function admin_cancel($id = null) {
		$this->Session->setFlash(__('Operation cancelled', true), 'flash_info');
		$this->redirect(array('action' => 'index'));
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid page', true), 'flash_error');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			App::import('Core', 'Inflector');
			$this->data['Page']['slug'] = (empty($this->data['Page']['slug']))? $this->data['Page']['id'].'-'.Inflector::slug($this->data['Page']['title'], '-'): $this->data['Page']['slug'];
			if ($this->Page->save($this->data)) {
				$this->Session->setFlash(__('The page has been saved', true), 'flash_success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The page could not be saved. Please, try again.', true), 'flash_error');
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Page->read(null, $id);
		}
		$templates = $this->findViews();
		$categories = $this->Page->Category->find('list');
		$this->set(compact('templates','categories'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for page', true), 'flash_error');
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Page->delete($id)) {
			$this->Session->setFlash(__('Page deleted', true), 'flash_success');
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Page was not deleted', true), 'flash_error');
		$this->redirect(array('action' => 'index'));
	}
	
	function admin_published($id){
		
		$this->layout = 'admin';
		$this->render(false);
		$this->Page->id = $id;
		$this->Page->saveField('published', 0, false);
		$this->redirect(array('action' => 'index'));
			
	}
	
	function admin_notpublished($id){
		
		$this->layout = 'admin';
		$this->render(false);
		$this->Page->id = $id;
		$this->Page->saveField('published', 1, false);
		$this->redirect(array('action' => 'index'));
			
	}
	
	private function findViews( $folder = 'pages' ){
		
		switch ($folder){
			default:
				App::import('Core', 'Sanitize');
				$_path = ROOT . DS . APP_DIR . DS . 'views' . DS . $folder . DS;
				$_folder = new Folder($_path);
				$_ignore = array(
					'admin_index.ctp', 
					'admin_add.ctp',
					'admin_edit.ctp', 
					'admin_dashboard.ctp',
					'errors',
					'elements', 
					'helpers',
					'layouts',
					'menu',
					'menu_items',
					'scaffolds',
					'.DS_Store');
				$_list = $_folder->tree($_path, $_ignore);
				$_path = Sanitize::escape($_path);
				$_f = array();
				foreach($_list[1] as $f){
					$_name = str_replace(".ctp", '', str_replace($_path, '', $f));
					$_f[$_name] = $_name;
				}
				return $_f;
			break;
		}
		
	}
	
}
?>