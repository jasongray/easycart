<?php
class SlideshowsController extends AppController {

	var $name = 'Slideshows';
	
	function beforeFilter() {
	    parent::beforeFilter();
		$this->Auth->allowedActions = array('index');
	}

	function index() {
		$this->Slideshow->recursive = 0;
		$this->set('slideshows', $this->Slideshow->find('all', array('conditions' => array('Slideshow.published' => 1), 'order' => 'Slideshow.ordering')));
	}
	
	function admin_index() {
		$this->Slideshow->recursive = 0;
		$this->paginate = array('order' => 'Slideshow.ordering');
		$this->set('slideshows', $this->paginate());
	}

	function admin_add() {
		if (!empty($this->data)) {
			unset($this->data['Slideshow']['image']);
			$_m = $this->Slideshow->find('first', array(
				'fields' => array(
					'MAX(Slideshow.ordering) as max_size'
				)
			));
			$this->data['Slideshow']['ordering'] = $_m[0]['max_size'] + 1;
			$this->Slideshow->create();
			if ($this->Slideshow->save($this->data)) {
				$this->saveImage($this->data['Slideshow']['id']);
				$this->Session->setFlash(__('The slideshow has been saved', true), 'flash_success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The slideshow could not be saved. Please, try again.', true), 'flash_error');
			}
		}
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid slideshow', true), 'flash_error');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			unset($this->data['Slideshow']['image']);
			if ($this->Slideshow->save($this->data)) {
				$this->saveImage($this->data['Slideshow']['id']);
				$this->Session->setFlash(__('The slideshow has been saved', true), 'flash_success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The slideshow could not be saved. Please, try again.', true), 'flash_error');
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Slideshow->read(null, $id);
		}
	}
	
	function admin_cancel($id = null) {
		$this->Session->setFlash(__('Operation cancelled', true), 'flash_info');
		$this->redirect(array('action' => 'index'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for slideshow', true), 'flash_error');
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Slideshow->delete($id)) {
			$this->Session->setFlash(__('Slideshow deleted', true), 'flash_success');
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Slideshow was not deleted', true), 'flash_error');
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
		
		$this->Slideshow->recursive = -1;
		$_this = $this->Slideshow->find('first', array('conditions' => array('Slideshow.id' => $id)));
		
		if($dir < 0){
			$options = array(
				'conditions' => array(
					'Slideshow.ordering < ' . $_this['Slideshow']['ordering']
				), 
				'order' => 'Slideshow.ordering DESC',
				'limit' => 1
			);
		}else{
			$options = array(
				'conditions' => array(
					'Slideshow.ordering > ' . $_this['Slideshow']['ordering']
				),
				'order' => 'Slideshow.ordering ASC',
				'limit' => 1
			);
		}
		
		$_row = $this->Slideshow->find('first', $options);
		
		if($_row){
			$this->Slideshow->id = $id;
			$this->Slideshow->saveField('ordering', $_row['Slideshow']['ordering']);
			$this->Slideshow->id = $_row['Slideshow']['id'];
			$this->Slideshow->saveField('ordering', $_this['Slideshow']['ordering']);
		}else{
			$this->Slideshow->id = $id;
			$this->Slideshow->saveField('ordering', $_this['Slideshow']['ordering']);
		}
		$this->reorder();
		$this->redirect(array('action' => 'index'));
			
	}
	
	private function reorder(){
		
		$this->Slideshow->recursive = -1;
		$_m = $this->Slideshow->find('all', array(
			'conditions' => array(
				'Slideshow.ordering >= 0'
			),
			'order' => 'Slideshow.ordering'
		));
		
		if($_m){
			
			for ($i=0, $n=count($_m); $i < $n; $i++){
				if($_m[$i]['Slideshow']['ordering'] >= 0){
					if($_m[$i]['Slideshow']['ordering'] != $i+1){
						$_m[$i]['Slideshow']['ordering'] = $i+1;
						$this->Slideshow->id = $_m[$i]['Slideshow']['id'];
						$this->Slideshow->saveField('ordering', $_m[$i]['Slideshow']['ordering']);
					}
				}
			}
			
		}
		
	}
	
	
	private function saveImage($id = false){
		
		if($this->data['Image']['file']['error'] != 4){
			
			$tempFile = $this->data['Image']['file']['tmp_name'];
			$targetPath = WWW_ROOT . 'img/slideshows';
		
			if(!is_dir($targetPath)){
				mkdir($targetPath, 0766);
			}
			$___fileinfo = pathinfo($this->data['Image']['file']['name']);
			$__data['file'] = time() . md5($this->data['Image']['file']['name']) . '.' . $___fileinfo['extension'];
			$targetFile =  str_replace('//','/',$targetPath) . '/' . $__data['file'];
			if(move_uploaded_file($tempFile,$targetFile)){
				$this->Slideshow->saveField('image', $__data['file']);
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
			$_img = $this->Slideshow->read('image', $id);
			if($_img && file_exists(WWW_ROOT . 'img/users/' . $_img['Slideshow']['image'])){
				unlink(WWW_ROOT . 'img/slideshow/' . $_img['Slideshow']['image']);
			}
			if ($this->Slideshow->saveField('image', '')) {
				$this->Session->setFlash(__('Image was removed', true), 'flash_success');
			}
		}
		$this->redirect(array('action' => 'edit', $id));
		
	}
	
}
?>