<?php
class UsersController extends AppController {

	var $name = 'Users';
	
	function beforeFilter() {
	    parent::beforeFilter();
		$this->Auth->allowedActions = array('login', 'logout');
	}
	
	function login() {
		$this->layout = 'admin_login';
		if ($this->Session->read('Auth.User')) {
			$this->Session->setFlash('You are logged in!', 'flash_success');
			$this->redirect('/', null, false);
		}
	}
	
	function logout(){
		$this->layout = 'admin_login';
		$this->Session->setFlash('You are now logged out!', 'flash_success');
		$this->redirect($this->Auth->logout());
		
	}
	
	function admin_dashboard(){
		$this->set('title_for_layout', 'Dashboard');
		
		$info = array();
		
		$this->loadModel('Category');
		$this->Category->recursive = -1;
		$this->Category->virtualFields = array('ccnt' => 'COUNT(Category.id)');
		$_c = $this->Category->find('first', array('fields' => array('ccnt'), 'conditions' => array('Category.published' => 1)));
		
		$this->loadModel('Product');
		$this->Product->recursive = -1;
		$this->Product->virtualFields = array('pcnt' => 'COUNT(Product.id)');
		$_p = $this->Product->find('first', array('fields' => array('pcnt'), 'conditions' => array('Product.published' => 1)));
		
		$this->loadModel('Visit');
		$this->Visit->virtualFields = array(
			'vcnt' => 'COUNT(Visit.id)',
			'ucnt' => 'COUNT(DISTINCT(Visit.ip))',
			'tcnt' => '(SELECT COUNT(Visit.id) FROM visits AS Visit WHERE DATE(Visit.created) BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 DAY) AND DATE_ADD(CURDATE(), INTERVAL 1 DAY))',
			'tunt' => '(SELECT COUNT(DISTINCT(Visit.ip)) FROM visits AS Visit WHERE DATE(Visit.created) BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 DAY) AND DATE_ADD(CURDATE(), INTERVAL 1 DAY))'
		);
		$_s = $this->Visit->find('first');
		$info = array_merge($_c, $_p, $_s);
		
		// gather info for graph
		$graph = $this->User->query("SELECT (SELECT COUNT(DISTINCT(`pa`.`ip`)) FROM `visits` AS `pa` WHERE DATE(`pa`.`created`) = DATE(`pp`.`created`)) AS PropCnt, DATE(`pp`.`created`) AS `date` FROM `visits` AS `pp` GROUP BY DATE(`pp`.`created`) ORDER BY DATE(`pp`.`created`) ASC LIMIT 30");
		
		$this->set(compact('info', 'graph'));
		
	}

	function admin_index() {
		$this->User->recursive = 0;
		$this->paginate = array(
			'conditions' => array(
				'User.hidden' => 0
			),
			'order' => 'Group.id ASC, User.surname ASC'
		);
		$this->set('users', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid user', true), 'flash_error');
			$this->redirect(array('action' => 'index'));
		}
		$this->set('user', $this->User->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			unset($this->data['User']['image']);
			$this->User->create();
			if ($this->User->save($this->data)) {
				$this->saveAvatar($this->data['User']['id']);
				$this->Session->setFlash(__('The user has been saved', true), 'flash_success');
				$this->redirect(array('action' => 'edit', $this->data['User']['id']));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.', true), 'flash_error');
			}
		}
		$userStatuses = $this->User->UserStatus->find('list');
		$groups = $this->User->Group->find('list');
		$this->set(compact('userStatuses', 'groups'));
	}
	
	function admin_cancel($id = null) {
		$this->Session->setFlash(__('Operation cancelled', true), 'flash_info');
		$this->redirect(array('action' => 'index'));
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid user', true), 'flash_error');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			unset($this->data['User']['image']);
			if ($this->User->save($this->data)) {
				$this->saveAvatar($this->data['User']['id']);
				$this->Session->setFlash(__('The user has been saved', true), 'flash_success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.', true), 'flash_error');
			}
		}
		if (empty($this->data)) {
			$this->data = $this->User->read(null, $id);
			if($this->Session->read('Auth.User.group_id') > $this->data['User']['group_id']){
				$this->Session->setFlash(__('You are not authorised to edit users who have a higher permission level than yourself.', true), 'flash_error');
				$this->redirect(array('action' => 'index'));
			}
		}
		$userStatuses = $this->User->UserStatus->find('list');
		$groups = $this->User->Group->find('list');
		$this->set(compact('userStatuses', 'groups'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for user', true), 'flash_error');
			$this->redirect(array('action'=>'index'));
		}
		if ($this->User->delete($id)) {
			$this->Session->setFlash(__('User deleted', true), 'flash_success');
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('User was not deleted', true), 'flash_error');
		$this->redirect(array('action' => 'index'));
	}
	
	private function saveAvatar($id = false){
		
		if($this->data['Image']['file']['error'] != 4){
			
			$tempFile = $this->data['Image']['file']['tmp_name'];
			$targetPath = WWW_ROOT . 'img/users';
		
			if(!is_dir($targetPath)){
				mkdir($targetPath, 0766);
			}
			$___fileinfo = pathinfo($this->data['Image']['file']['name']);
			$__data['file'] = time() . md5($this->data['Image']['file']['name']) . '.' . $___fileinfo['extension'];
			$targetFile =  str_replace('//','/',$targetPath) . '/' . $__data['file'];
			if(move_uploaded_file($tempFile,$targetFile)){
				$this->User->saveField('image', $__data['file']);
			}else{
				$_result = '<p class="error">Failed to move uploaded file.</p>';
			}
		}
		
	}
	
	function admin_removeAvatar( $id = false ){
		$this->layout = 'ajax';
		$this->render(false);
		$this->Session->setFlash(__('User avatar was not removed', true), 'flash_error');
		if ($id) {
			$_img = $this->User->read('image', $id);
			if($_img && file_exists(WWW_ROOT . 'img/users/' . $_img['User']['image'])){
				unlink(WWW_ROOT . 'img/users/' . $_img['User']['image']);
			}
			if ($this->User->saveField('image', '')) {
				$this->Session->setFlash(__('User avatar was removed', true), 'flash_success');
			}
		}
		$this->redirect(array('action' => 'edit', $id));
		
	}
	
}
?>