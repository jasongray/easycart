<?php
class CategoriesController extends AppController {

	var $name = 'Categories';
	
	function beforeFilter() {
	    parent::beforeFilter();
		$this->Auth->allowedActions = array('index', 'view', 'featured', 'genlist'); 
	}
	
	function index(){
		$this->Category->recursive = 0;
		$this->paginate = array(
			'conditions' => array('Category.published' => 1),
			'order' => 'Category.ordering ASC'
		);
		$this->set('categories', $this->paginate());
	}
	
	function view($id = null){
		$this->Category->recursive = -2;
		if (!$id) {
			$this->Session->setFlash(__('Invalid category', true), 'flash_error');
			$this->redirect($this->referer());
		}
		$cat = $this->Category->read('', $id);
		$this->set('title_for_layout', $cat['Category']['title']);
		$this->set('category', $cat);
		
		App::Import('Model', 'Product');
		$this->Product = new Product;
		$this->paginate['Product'] = array(
			'conditions' => array(
				'Product.category_id' => $id,
				'Product.published' => 1
			),
			'order' => 'Product.ordering ASC',
			'limit' => 12
		);
		$this->set('products', $this->paginate('Product'));
		
		App::Import('Model', 'Page');
		$this->Page = new Page;
		$this->set('pages', $this->Page->find('all', array(
			'conditions' => array(
				'Page.category_id' => $id,
				'Page.published' => 1
			),
			'order' => 'Page.created ASC')));
		
	}
	
	function featured(){
		$this->set('featured', $this->Category->find('all', array('conditions' => array('Category.published' => 1, 'Category.featured' => 1), 'order' => 'Category.ordering ASC')));
	}
	
	function genlist(){
		$this->Category->recursive = -1;	
		$this->set('c', $this->Category->find('all', array('conditions' => array('Category.published' => 1))));
	}

	function admin_index() {
		$this->Category->recursive = 0;
		$this->paginate = array(
			'order' => 'Category.ordering ASC'
		);
		$this->set('categories', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid category', true), 'flash_error');
			$this->redirect(array('action' => 'index'));
		}
		$this->set('category', $this->Category->read(null, $id));
	}
	
	function admin_cancel($id = null) {
		$this->Session->setFlash(__('Operation cancelled', true), 'flash_info');
		$this->redirect(array('action' => 'index'));
	}

	function admin_add() {
		if (!empty($this->data)) {
			unset($this->data['Category']['image']);
			$_m = $this->Category->find('first', array(
				'fields' => array(
					'MAX(Category.ordering) as max_size'
				)
			));
			$this->data['Category']['ordering'] = $_m[0]['max_size'] + 1;
			$this->Category->create();
			if ($this->Category->save($this->data)) {
				$this->saveImage($this->data['Category']['id']);
				$this->Session->setFlash(__('The category has been saved', true), 'flash_success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The category could not be saved. Please, try again.', true), 'flash_error');
			}
		}
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid category', true), 'flash_error');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			unset($this->data['Category']['image']);
			if ($this->Category->save($this->data)) {
				$this->saveImage($this->data['Category']['id']);
				$this->Session->setFlash(__('The category has been saved', true), 'flash_success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The category could not be saved. Please, try again.', true), 'flash_error');
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Category->read(null, $id);
		}
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for category', true), 'flash_error');
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Category->delete($id)) {
			$this->Session->setFlash(__('Category deleted', true), 'flash_success');
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Category was not deleted', true), 'flash_error');
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
		$this->reorder();
	}
	
	private function ordering( $dir, $id ){
		
		$this->Category->recursive = -1;
		$_this = $this->Category->find('first', array('conditions' => array('Category.id' => $id)));
		
		if($dir < 0){
			$options = array(
				'conditions' => array(
					'Category.ordering < ' . $_this['Category']['ordering']
				), 
				'order' => 'Category.ordering DESC',
				'limit' => 1
			);
		}else{
			$options = array(
				'conditions' => array(
					'Category.ordering > ' . $_this['Category']['ordering']
				),
				'order' => 'Category.ordering ASC',
				'limit' => 1
			);
		}
		
		$_row = $this->Category->find('first', $options);
		
		if($_row){
			$this->Category->id = $id;
			$this->Category->saveField('ordering', $_row['Category']['ordering']);
			$this->Category->id = $_row['Category']['id'];
			$this->Category->saveField('ordering', $_this['Category']['ordering']);
		}else{
			$this->Category->id = $id;
			$this->Category->saveField('ordering', $_this['Category']['ordering']);
		}
		$this->reorder();
		$this->redirect(array('action' => 'index'));
			
	}
	
	private function reorder(){
		
		$this->Category->recursive = -1;
		$_m = $this->Category->find('all', array(
			'conditions' => array(
				'Category.ordering >= 0'
			),
			'order' => 'Category.ordering'
		));
		
		if($_m){
			
			for ($i=0, $n=count($_m); $i < $n; $i++){
				if($_m[$i]['Category']['ordering'] >= 0){
					if($_m[$i]['Category']['ordering'] != $i+1){
						$_m[$i]['Category']['ordering'] = $i+1;
						$this->Category->id = $_m[$i]['Category']['id'];
						$this->Category->saveField('ordering', $_m[$i]['Category']['ordering']);
					}
				}
			}
			
		}
		
	}
	
	
	private function saveImage($id = false){
		
		if($this->data['Image']['file']['error'] != 4){
			
			$tempFile = $this->data['Image']['file']['tmp_name'];
			$targetPath = WWW_ROOT . 'img/categories';
		
			if(!is_dir($targetPath)){
				mkdir($targetPath, 0766);
			}
			$___fileinfo = pathinfo($this->data['Image']['file']['name']);
			$__data['file'] = time() . md5($this->data['Image']['file']['name']) . '.' . $___fileinfo['extension'];
			$targetFile =  str_replace('//','/',$targetPath) . '/' . $__data['file'];
			if(move_uploaded_file($tempFile,$targetFile)){
				$this->Category->saveField('image', $__data['file']);
			}else{
				$_result = '<p class="error">Failed to move uploaded file.</p>';
			}
		}
		
	}
	
	function admin_removeAvatar( $id = false ){
		$this->layout = 'ajax';
		$this->render(false);
		$this->Session->setFlash(__('Image was not removed', true), 'flash_error');
		if ($id) {
			$_img = $this->Category->read('image', $id);
			if($_img && file_exists(WWW_ROOT . 'img/categories/' . $_img['Category']['image'])){
				unlink(WWW_ROOT . 'img/categories/' . $_img['Category']['image']);
			}
			if ($this->Category->saveField('image', '')) {
				$this->Session->setFlash(__('Image was removed', true), 'flash_success');
			}
		}
		$this->redirect(array('action' => 'edit', $id));
		
	}
}
?>