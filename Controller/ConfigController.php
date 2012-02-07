<?php
class ConfigController extends AppController {

	var $name = 'Config';
	
	function beforeFilter() {
	    parent::beforeFilter();
		//$this->Auth->allowedActions = array('*');
	}
	
	function admin_index(){
		
		if(!empty($this->data)){
			$this->saveToFile($this->data['Config']);
		}
		include_once APP . DS . 'config' . DS . 'my.site.config.php';
		$vars = new MySite();
		foreach($vars as $k => $v){
			$this->data['Config'][$k] = $v;
		}
		
	}
	
	function admin_cancel($id = null) {
		$this->Session->setFlash(__('Operation cancelled'), 'flash_info');
		$this->redirect('/admin/users/dashboard');
	}
	
	private function saveToFile( $data = false ){
		if($data){
			$file = APP . DS . 'config' . DS . 'my.site.config.php';
			if (is_writable($file)) {
				$handle = fopen($file, 'w');
				$txt = "<?php\n
class MySite extends Object{\n\n";
				foreach($data as $k => $v){
					$txt .= "var $$k = '$v';\n";
				}
				$txt .= "
}\n
?>\n";
				if (fwrite($handle, $txt) === FALSE) {
					$this->Session->setFlash(__('Could not save config information to file.'), 'flash_warning');
					return false;
				}
				fclose($handle);
				$this->Session->setFlash(__('Config information saved.'), 'flash_success');
				$this->redirect('/admin/users/dashboard');
			} else {
				$this->Session->setFlash(__('Config file is not writeable. Please correct the issue and try again!'), 'flash_error');
				return false;
			}
		} else {
			$this->Session->setFlash(__('No data can be saved.'), 'flash_error');
			return false;
		}
		
	}

}
?>