<?php


class productsController extends AppController{
	
	var $name = 'Products';
	
	var $paginate = array(
		'limit' => 20,
		'order' => array('title' => 'asc')
	);
	
	function beforeFilter() {
	    parent::beforeFilter();
		$this->Auth->allowedActions = array('index', 'featured', 'view');
	}
	
	function index(){
	
		$this->paginate = array(
			'conditions' => array('Product.published' => 1),
			'limit' => 12,
			'order' => array('Product.ordering' => 'asc')
		);
		
		$this->set('products', $this->paginate('Product'));
	
	}
	
	function view($id = false){
		
		$_results = array();
		if($id){
			$_results = $this->Product->findById($id);
			$this->set('title_for_layout', $_results['Product']['title']);
		}
		$this->set('product', $_results);
	
	}
	
	function featured(){
	
		$this->set('featured', $this->Product->find('all', array('conditions' => array('Product.published' => 1, 'Product.featured' => 1))));
	
	}
	
	
	function admin_index() {
		$this->Product->recursive = 0;
		$this->paginate = array(
			'order' => 'Product.ordering ASC'
		);
		$this->set('products', $this->paginate());
	}

	function admin_add() {
		if (!empty($this->data)) {
			unset($this->data['Product']['image']);
			$_m = $this->Product->find('first', array(
				'fields' => array(
					'MAX(Product.ordering) as max_size'
				)
			));
			$this->data['Product']['ordering'] = $_m[0]['max_size'] + 1;
			$this->Product->create();
			if ($this->Product->save($this->data)) {
				$this->saveAvatar($this->data['Product']['id']);
				$this->Session->setFlash(__('The product has been saved', true), 'flash_success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The product could not be saved. Please, try again.', true), 'flash_error');
			}
		}
		$categories = $this->Product->Category->find('list');
		$this->set(compact('categories'));
	}
	
	function admin_cancel($id = null) {
		$this->Session->setFlash(__('Operation cancelled', true), 'flash_info');
		$this->redirect(array('action' => 'index'));
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid product', true), 'flash_error');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			pr($this->data);
			unset($this->data['Product']['image']);
			if ($this->Product->save($this->data)) {
				$this->saveAvatar($this->data['Product']['id']);
				$this->Session->setFlash(__('The product has been saved', true), 'flash_success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The product could not be saved. Please, try again.', true), 'flash_error');
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Product->read(null, $id);
		}
		$categories = $this->Product->Category->find('list');
		$this->set(compact('categories'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for product', true), 'flash_error');
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Product->delete($id)) {
			$this->Session->setFlash(__('Product deleted', true), 'flash_success');
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Product was not deleted', true), 'flash_error');
		$this->redirect(array('action' => 'index'));
	}
	
	function admin_orderup($id = false){
		if($id){
			$this->ordering(-1, $id);
		}
	}
	
	function admin_orderdown($id = false){
		if($id){
			$this->ordering(1, $id);
		}
	}
	
	function admin_saveorder(){
		$this->autorender = false;
		$this->reorder();
	}
	
	private function ordering( $dir, $id ){
		
		$this->Product->recursive = -1;
		$_this = $this->Product->find('first', array('conditions' => array('Product.id' => $id)));
		
		if($dir < 0){
			$options = array(
				'conditions' => array(
					'Product.ordering < ' . $_this['Product']['ordering']
				), 
				'order' => 'Product.ordering DESC',
				'limit' => 1
			);
		}else{
			$options = array(
				'conditions' => array(
					'Product.ordering > ' . $_this['Product']['ordering']
				),
				'order' => 'Product.ordering ASC',
				'limit' => 1
			);
		}
		
		$_row = $this->Product->find('first', $options);
		
		if($_row){
			$this->Product->id = $id;
			$this->Product->saveField('ordering', $_row['Product']['ordering']);
			$this->Product->id = $_row['Product']['id'];
			$this->Product->saveField('ordering', $_this['Product']['ordering']);
		}else{
			$this->Product->id = $id;
			$this->Product->saveField('ordering', $_this['Product']['ordering']);
		}
		$this->reorder();
		$this->redirect(array('action' => 'index'));
			
	}
	
	private function reorder(){
		
		$this->Product->recursive = -1;
		$_m = $this->Product->find('all', array(
			'conditions' => array(
				'Product.ordering >= 0'
			),
			'order' => 'Product.ordering'
		));
		
		if($_m){
			
			for ($i=0, $n=count($_m); $i < $n; $i++){
				if($_m[$i]['Product']['ordering'] >= 0){
					if($_m[$i]['Product']['ordering'] != $i+1){
						$_m[$i]['Product']['ordering'] = $i+1;
						$this->Product->id = $_m[$i]['Product']['id'];
						$this->Product->saveField('ordering', $_m[$i]['Product']['ordering']);
					}
				}
			}
			
		}
		
	}
	
	private function saveAvatar($id = false){
		
		if($this->data['Image']['file']['error'] != 4){
			
			$tempFile = $this->data['Image']['file']['tmp_name'];
			$targetPath = WWW_ROOT . 'img/products';
		
			if(!is_dir($targetPath)){
				mkdir($targetPath, 0766);
			}
			$___fileinfo = pathinfo($this->data['Image']['file']['name']);
			$__data['file'] = time() . md5($this->data['Image']['file']['name']) . '.' . $___fileinfo['extension'];
			$targetFile =  str_replace('//','/',$targetPath) . '/' . $__data['file'];
			if(move_uploaded_file($tempFile,$targetFile)){
				$this->Product->saveField('image', $__data['file']);
			}else{
				$_result = '<p class="error">Failed to move uploaded file.</p>';
			}
		}
		
	}
	
	function admin_removeAvatar( $id = false ){
		$this->layout = 'ajax';
		$this->render(false);
		$this->Session->setFlash(__('Product image was not removed', true), 'flash_error');
		if ($id) {
			$_img = $this->Product->read('image', $id);
			if($_img && file_exists(WWW_ROOT . 'img/products/' . $_img['Product']['image'])){
				unlink(WWW_ROOT . 'img/products/' . $_img['Product']['image']);
			}
			if ($this->Product->saveField('image', '')) {
				$this->Session->setFlash(__('Product image was removed', true), 'flash_success');
			}
		}
		$this->redirect(array('action' => 'edit', $id));
		
	}

}