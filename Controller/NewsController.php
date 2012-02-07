<?php
class NewsController extends AppController {

	var $name = 'News';
	
	function beforeFilter() {
	    parent::beforeFilter();
		$this->Auth->allowedActions = array('index', 'summary', 'view', 'archive', 'latest');
	}

	function index() {
		$this->News->recursive = 0;
		if(!empty($this->params['named'])){
			$_year = !empty($this->params['named']['year'])? $this->params['named']['year']: date('Y');
			$_month = !empty($this->params['named']['month'])? $this->params['named']['month']: date('m');
			$_interval = "DATE_FORMAT(News.start_publish, '%c%Y') = '$_month$_year'";
		}else{
			$_interval = 'NOW() BETWEEN News.start_publish AND IF(News.end_publish = 0, DATE_ADD(NOW(), INTERVAL 30 DAY), News.end_publish)';
		}
		
		$this->paginate = array(
			'conditions' => array(
				'News.published' => 1, $_interval),
			'order' => array(
				'News.created DESC'),
			'limit' => 5
		);
		$this->set('news', $this->paginate());
		$this->archive();
	}
	
	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid news'), 'flash_error');
			$this->redirect(array('action' => 'index'));
		}
		$_p = $this->News->find('first', array('conditions' => array(
			'News.published' => 1,
			'NOW() BETWEEN News.start_publish AND IF(News.end_publish = 0, DATE_ADD(NOW(), INTERVAL 30 DAY), News.end_publish)', 
			'News.id' => $id)));
		if($_p && !empty($_p['News']['title'])){
			$this->set('title_for_layout', $_p['News']['title']);
		}
		$this->set('p', $_p);
		$this->archive();
	}
	
	function latest(){
		$this->News->recursive = 0;
		$this->set('news', $this->News->find('all', array('conditions' => array('News.published' => 1), 'order' => 'News.created DESC')));
	}
	
	function archive(){
		$this->News->virtualFields = array('a' => "DATE_FORMAT(start_publish, '%b %Y')", 'y' => 'YEAR(start_publish)', 'm' => 'MONTH(start_publish)');
		$_a = $this->News->find('all', array(
			'fields' => array('a', 'y', 'm'),
			'conditions' => array(
				'News.published' => 1),
			'group' => 'YEAR(start_publish), MONTH(start_publish)'));
		$this->set('archive', $_a);
	}

	function admin_index() {
		$this->News->recursive = 0;
		$this->paginate = array(
			'order' => array(
				'News.created DESC'),
			'limit' => 20
		);
		$this->set('news', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid news'), 'flash_error');
			$this->redirect(array('action' => 'index'));
		}
		$this->set('news', $this->News->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			App::uses('Inflector', 'Utility');
			$_alias = (empty($this->data['News']['slug']))? $this->data['News']['title']: '';
			$_alias = Inflector::slug($_alias, '-');
			$this->News->create();
			if ($this->News->save($this->data)) {
				$this->data['News']['slug'] = $this->News->id.'-'.Inflector::slug($_alias, '-');
				$this->News->saveField('slug', $this->data['News']['slug']);
				$this->Session->setFlash(__('The news has been saved'), 'flash_success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The news could not be saved. Please, try again.'), 'flash_error');
			}
		}
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid news'), 'flash_error');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			App::uses('Inflector', 'Utility');
			$this->data['News']['slug'] = (empty($this->data['News']['slug']))? $this->data['News']['id'].'-'.Inflector::slug($this->data['News']['title'], '-'): $this->data['News']['slug'];
			//pr($this->data);exit;
			if ($this->News->save($this->data)) {
				$this->Session->setFlash(__('The news has been saved'), 'flash_success');
			//	$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The news could not be saved. Please, try again.'), 'flash_error');
			}
		}
		if (empty($this->data)) {
			$this->data = $this->News->read(null, $id);
		}
	}
	
	function admin_cancel($id = null) {
		$this->Session->setFlash(__('Operation cancelled'), 'flash_info');
		$this->redirect(array('action' => 'index'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for news'), 'flash_error');
			$this->redirect(array('action'=>'index'));
		}
		if ($this->News->delete($id)) {
			$this->Session->setFlash(__('News deleted'), 'flash_success');
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('News was not deleted'), 'flash_error');
		$this->redirect(array('action' => 'index'));
	}
}
?>