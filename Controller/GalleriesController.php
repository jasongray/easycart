<?php
class GalleriesController extends AppController {

	var $name = 'Galleries';
	
	function beforeFilter() {
	    parent::beforeFilter();
		$this->Auth->allowedActions = array('index', 'view'); 
	}

	function index() {
		$this->Gallery->recursive = 1;
		$this->paginate = array(
			'conditions' => array('Gallery.published' => 1),
			'limit' => 10,
			'order' => array('Gallery.created' => 'asc')
		);
		$this->set('galleries', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid gallery'), 'flash_error');
			$this->redirect(array('action' => 'index'));
		}
		$this->set('gallery', $this->Gallery->read(null, $id));
	}

	function admin_index() {
		$this->Gallery->recursive = 0;
		$this->set('galleries', $this->paginate());
	}

	function admin_cancel($id = null) {
		$this->Session->setFlash(__('Operation cancelled'), 'flash_info');
		$this->redirect(array('action' => 'index'));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->data['Gallery']['user_id'] = $this->Session->read('Auth.User.id');
			$this->Gallery->create();
			if ($this->Gallery->save($this->data)) {
				$this->Session->setFlash(__('The gallery has been saved'), 'flash_success');
				$this->redirect(array('action' => 'edit', $this->Gallery->id));
			} else {
				$this->Session->setFlash(__('The gallery could not be saved. Please, try again.'), 'flash_error');
			}
		}
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid gallery'), 'flash_error');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Gallery->save($this->data)) {
				$this->Session->setFlash(__('The gallery has been saved'), 'flash_success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The gallery could not be saved. Please, try again.'), 'flash_error');
			}
		}
		if (empty($this->data)) {
			$this->Gallery->recursive = 0;
			$this->data = $this->Gallery->read(null, $id);
		}
		$this->set('images', $this->Gallery->Image->find('all', array('conditions' => array('gallery_id' => $id), 'order' => 'Image.ordering ASC')));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for gallery'), 'flash_error');
			$this->redirect(array('action'=>'index'));
		}
		$_files = $this->Gallery->Image->find('all', array('conditions' => array('gallery_id' => $id)));
		if($_files){
			foreach($_files as $f){
				$____file = WWW_ROOT . 'img/galleries/' . $f['Image']['gallery_id'] . '/' . $f['Image']['file'];
				if(file_exists($____file)){
					unlink($____file);
					$this->Gallery->Image->delete($f['Image']['id']);
				}
			}
		}
		if ($this->Gallery->delete($id)) {
			rmdir(WWW_ROOT . 'img/galleries/' . $id);
			$this->Session->setFlash(__('Gallery deleted'), 'flash_success');
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Gallery was not deleted'), 'flash_error');
		$this->redirect(array('action' => 'index'));
	}
	
	function admin_images($id = null) {
		$this->layout = 'ajax';
		if (!$id) {
			$this->Session->setFlash(__('Invalid gallery'), 'flash_error');
		}
		$this->set('images', $this->Gallery->Image->find('all', array('conditions' => array('gallery_id' => $id), 'order' => 'ordering ASC')));
	}
	
	function admin_addImage(){
		
		$_result = '';
		if(!empty($this->data)){
			$tempFile = $this->data['Image']['upload']['tmp_name'];
			$targetPath = WWW_ROOT . 'img/galleries/'.$this->data['Image']['gallery_id'];
			if(!is_dir($targetPath)){
				mkdir($targetPath, 0777);
				//chown($targetPath, 'everyone');
			}
			$___fileinfo = pathinfo($this->data['Image']['upload']['name']);
			$this->data['Image']['file'] = time() . md5($this->data['Image']['upload']['name']) . '.' . $___fileinfo['extension'];
			$targetFile =  str_replace('//','/',$targetPath) . '/' . $this->data['Image']['file'];

			if(move_uploaded_file($tempFile,$targetFile)){

				$this->uploadresize($targetFile);

				if($this->Gallery->Image->save($this->data['Image'])){
					$this->Session->setFlash(__('Successfully added image to the gallery'), 'flash_success');
					//$_result = '<script type="text/javascript">refreshGallery(); sortableImages();</script>';
				}else{
					$this->Session->setFlash(__('Failed to save file'), 'flash_error');
				}
			}else{
				$this->Session->setFlash(__('Failed to move uploaded file'), 'flash_error');
			}
		}
		//$this->set('_result', $_result);
		$this->redirect(array('action' => 'edit', $this->data['Image']['gallery_id']));
	}
	
	function admin_sortImages(){

		$this->autoRender = false;
		if(isset($_GET['GImages']) && !empty($_GET['GImages']) && !empty($_GET['gallery_id'])){
			$data['Gallery']['id'] = $_GET['gallery_id'];
			foreach($_GET['GImages'] as $pos => $id){
				$this->Gallery->Image->create();
				$data['Image']['ordering'] = $pos;
				$data['Image']['id'] = $id;
				$this->Gallery->Image->save($data);
			}
		}
  		
	}
	
	function admin_removeImage($id = false){
		
		$this->autoRender = false;
		if ($id) {
			$_img = $this->Gallery->Image->read(array('gallery_id', 'file'), $id);
			$____file = WWW_ROOT . 'img/galleries/' . $_img['Image']['gallery_id'] . '/' . $_img['Image']['file'];
			if($_img && file_exists($____file)){
				unlink($____file);
			}
			if ($this->Gallery->Image->delete($id)) {
				echo '1';
				exit;
			}
		}
		echo 'Unable to delete image.';
		exit;
		
	}

	private function uploadresize($file, $width = 1024, $height = 768){
		
		$types = array(1 => "gif", "jpeg", "png", "swf", "psd", "wbmp"); // used to determine image type

		$size = getimagesize($file);

		if(($size[1]/$height) > ($size[0]/$width)){  // $size[0]:width, [1]:height, [2]:type
			$width = ceil(($size[0]/$size[1]) * $height);
		}else{ 
			$height = ceil($width / ($size[0]/$size[1]));
		}

		$image = call_user_func('imagecreatefrom'.$types[$size[2]], $file);

		if (function_exists("imagecreatetruecolor") && ($temp = imagecreatetruecolor ($width, $height))) {
			if ($types[$size[2]] == 'png' || $types[$size[2]] == 'gif'){
				if ($types[$size[2]] == 'gif') {
					imagealphablending($temp, false);
					imagesavealpha($temp, true);
					$trans_colour = imagecolorallocatealpha($temp, 0, 0, 0, 127);
					imagefilledrectangle($temp, 0, 0, $width, $height, $trans_colour);
					imagecolortransparent($temp, $trans_colour);
				} else {
					imagesavealpha($temp, true);
					$trans_colour = imagecolorallocatealpha($temp, 0, 0, 0, 127);
					imagefill($temp, 0, 0, $trans_colour);
				}
			}
			
			imagecopyresampled ($temp, $image, 0, 0, 0, 0, $width, $height, $size[0], $size[1]);
		
		} else {
		
			$temp = imagecreate ($width, $height);
			imagecopyresized ($temp, $image, 0, 0, 0, 0, $width, $height, $size[0], $size[1]);

		}

		call_user_func("image".$types[$size[2]], $temp, $file);
		imagedestroy ($image);
		imagedestroy ($temp);

		return true;		

	}
	

}
?>