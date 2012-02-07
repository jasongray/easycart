<?php
class AssetsController extends AppController {

	var $name = 'Assets';
	
	function beforeFilter() {
	    parent::beforeFilter();
		$this->Auth->allowedActions = array('download'); 
	}
	
	function download( $id = false ){
		if( $id ){
			$this->layout = 'ajax';
			$file = $this->Asset->read(null, $id);
			$file['Asset']['name'] = array_pop(explode(DS, $file['Asset']['fullpath']));
			//if(strstr($file['Asset']['mime'], 'pdf')){
			//	$this->set('file', $file['Asset']);
			//}else{
				header('Content-type: ' . $file['Asset']['mime']);
				header('Content-Disposition: inline; filename="' . $file['Asset']['name'] . '"');
				header('Content-Transfer-Encoding: binary');
				header('Content-Length: ' . $file['Asset']['size']);
				header('Cache-Control: "no-cache, must-revalidate"');
				header('Accept-Ranges: bytes');
				@readfile($file['Asset']['fullpath']);
				exit;
			//}
		} else {
			$this->redirect('/');
		}
		
	}

	function admin_index() {
		$this->Asset->recursive = 0;
		$this->set('files', $this->paginate());
	}
	
	function admin_cancel($id = null) {
		$this->Session->setFlash(__('Operation cancelled'), 'flash_info');
		$this->redirect(array('action' => 'index'));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->Asset->create();
			if ($this->saveFile($this->data)) {
				$this->Session->setFlash(__('The files has been saved'), 'flash_success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The files could not be saved. Please, try again.'), 'flash_error');
				$this->redirect(array('action' => 'index'));
			}
		}
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid files'), 'flash_error');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			unset($this->data['Asset']['file']);
			if ($this->Asset->save($this->data)) {
				$this->saveFile($this->data['Asset']['id']);
				$this->Session->setFlash(__('The files has been saved'), 'flash_success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The files could not be saved. Please, try again.'), 'flash_error');
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Asset->read(null, $id);
		}
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for files'), 'flash_error');
			$this->redirect(array('action'=>'index'));
		}
		if ($this->removeFile($id, true)) {
			$this->Session->setFlash(__('Assets deleted'), 'flash_success');
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Assets was not deleted'), 'flash_error');
		$this->redirect(array('action' => 'index'));
	}
		
	private function saveFile($data){
		
		if($data['Asset']['file']['error'] != 4){
			
			$tempFile = $data['Asset']['file']['tmp_name'];
			$targetPath = WWW_ROOT . 'files';
		
			if(!is_dir($targetPath)){
				mkdir($targetPath, 0766);
			}
			$___fileinfo = pathinfo($data['Asset']['file']['name']);
			$newdata['Asset']['file'] = str_replace(' ', '-', $data['Asset']['file']['name']);
			$targetFile =  str_replace('//','/',$targetPath) . '/' . $newdata['Asset']['file'];
			if(move_uploaded_file($tempFile,$targetFile)){
				$newdata['Asset']['title'] = empty($data['Asset']['title'])? $newdata['Asset']['file']: $data['Asset']['title'];
				$newdata['Asset']['fullpath'] = $targetFile;
				$newdata['Asset']['mime'] = $data['Asset']['file']['type'];
				$newdata['Asset']['size'] = $data['Asset']['file']['size'];
				$newdata['Asset']['user_id'] = $this->Session->read('Auth.User.id');
				$newdata['Asset']['published'] = 1;
				if($this->Asset->save($newdata)){
					return true;
				}
			}
		}
		return false;
	}
	
	private function removeFile( $id = false, $db = false ){
		
		if ($id) {
			$_img = $this->Asset->read('fullpath', $id);
			if($_img && file_exists($_img['Asset']['fullpath'])){
				unlink($_img['Asset']['fullpath']);
			}
			if ( $db ){
				if ($this->Asset->delete($id)) {
					return true;
				}
			} else {
				$this->Asset->saveField('fullpath', '');
				return true;
			}
		}
		return false;
		
	}
}
?>