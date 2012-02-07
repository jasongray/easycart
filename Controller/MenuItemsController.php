<?php
class MenuItemsController extends AppController {

	var $name = 'MenuItems';
	
	function beforeFilter() {
	    parent::beforeFilter();
	}

	function admin_index() {
		$id = $this->params['named']['menu_id'];
		if (!$id) {
			$this->Session->setFlash(__('Invalid menu selected'), 'flash_error');
			$this->redirect($this->referer());
		}
		$this->MenuItem->recursive = -1;
		$this->paginate = array(
			'conditions' => array(
				'MenuItem.menu_id' => $id
			),
			'order' => 'MenuItem.ordering ASC'
		);
		
		$rows = $this->paginate();
		$children = array();
		foreach ($rows as $v ){
			$pt = !empty($v['MenuItem']['parent'])? $v['MenuItem']['parent']: 0;
			$list = @$children[$pt] ? $children[$pt] : array();
			array_push( $list, $v );
			$children[$pt] = $list;
		}
		
		$list = $this->recurse( 0, '', array(), $children, max( 0, 10 ) );
		$list = array_values($list);
		$this->set('menuItems', $list);
		
	}

	function admin_cancel($id = null) {
		$this->Session->setFlash(__('Operation cancelled'), 'flash_info');
		$this->redirect(array('action' => 'index', 'menu_id' => $this->params['named']['menu_id']));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->MenuItem->recursive = -1;
			$_m = $this->MenuItem->find('first', array(
				'fields' => array(
					'MAX(MenuItem.ordering) as max_size'
				), 
				'conditions' => array(
					'MenuItem.menu_id' => $this->data['MenuItem']['menu_id']
				)
			));
			$this->data['MenuItem']['ordering'] = $_m[0]['max_size'] + 1;
			if($this->data['MenuItem']['controller'] === 'pages'){
				$this->data['MenuItem']['slug'] = $this->data['MenuItem']['action'];
				$this->data['MenuItem']['action'] = 'display';
			}elseif($this->data['MenuItem']['controller'] === 'products'){
				$this->data['MenuItem']['slug'] = $this->data['MenuItem']['action'];
				$this->data['MenuItem']['action'] = 'view';
			}elseif($this->data['MenuItem']['controller'] === 'categories'){
				$this->data['MenuItem']['slug'] = $this->data['MenuItem']['action'];
				if($this->data['MenuItem']['action'] != 'index'){
					$this->data['MenuItem']['action'] = 'view';
				}
			}elseif($this->data['MenuItem']['controller'] === 'assets'){
				$this->data['MenuItem']['slug'] = $this->data['MenuItem']['action'];
				$this->data['MenuItem']['action'] = 'download';
			}
			if(!isset($this->data['MenuItem']['action']) && empty($this->data['MenuItem']['action'])){
				$this->data['MenuItem']['action'] = 'index';
			}
			if($this->data['MenuItem']['action'] == 'index'){
				$this->data['MenuItem']['slug'] = '';
			}
			$this->MenuItem->create();
			if ($this->MenuItem->save($this->data)) {
				$this->Session->setFlash(__('The menu item has been saved'), 'flash_success');
				$this->redirect(array('action' => 'index', 'menu_id' => $this->data['MenuItem']['menu_id']));
			} else {
				$this->Session->setFlash(__('The menu item could not be saved. Please, try again.'), 'flash_error');
			}
		}
		$links = $this->findControllers();
		$slugs = array();
		$menus = $this->MenuItem->Menu->find('list');
		$parents = $this->MenuItem->find('list', array('conditions' => array('MenuItem.menu_id' => $this->params['named']['menu_id'])));
		$this->set(compact('menus', 'parents', 'links', 'slugs'));
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid menu item'), 'flash_error');
			$this->redirect(array('action' => 'index', 'menu_id' => $this->data['MenuItem']['menu_id']));
		}
		if (!empty($this->data)) {
			if($this->data['MenuItem']['controller'] === 'pages'){
				$this->data['MenuItem']['slug'] = $this->data['MenuItem']['action'];
				$this->data['MenuItem']['action'] = 'display';
			}elseif($this->data['MenuItem']['controller'] === 'products'){
				$this->data['MenuItem']['slug'] = $this->data['MenuItem']['action'];
				$this->data['MenuItem']['action'] = 'view';
			}elseif($this->data['MenuItem']['controller'] === 'categories'){
				$this->data['MenuItem']['slug'] = $this->data['MenuItem']['action'];
				if($this->data['MenuItem']['action'] != '0' && !empty($this->data['MenuItem']['action'])){
					$this->data['MenuItem']['action'] = 'view';
				}else{
					$this->data['MenuItem']['action'] = 'index';
				}
			}elseif($this->data['MenuItem']['controller'] === 'assets'){
				$this->data['MenuItem']['slug'] = $this->data['MenuItem']['action'];
				$this->data['MenuItem']['action'] = 'download';
			}
			if(empty($this->data['MenuItem']['action'])){
				$this->data['MenuItem']['action'] = 'index';
			}
			if($this->data['MenuItem']['action'] == 'index'){
				$this->data['MenuItem']['slug'] = '';
			}
			if ($this->MenuItem->save($this->data)) {
				$this->Session->setFlash(__('The menu item has been saved'), 'flash_success');
				$this->redirect(array('action' => 'index', 'menu_id' => $this->data['MenuItem']['menu_id']));
			} else {
				$this->Session->setFlash(__('The menu item could not be saved. Please, try again.'), 'flash_error');
			}
		}
		if (empty($this->data)) {
			$this->data = $this->MenuItem->read(null, $id);
		}
		$links = $this->findControllers();
		$slugs = $this->findViews($this->data['MenuItem']['controller']);
		$menus = $this->MenuItem->Menu->find('list');
		$parents = $this->MenuItem->find('list', array('conditions' => array('MenuItem.menu_id' => $this->data['MenuItem']['menu_id'])));
		$this->set(compact('menus', 'parents', 'links', 'slugs'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for menu item'), 'flash_error');
			$this->redirect(array('action'=>'index', 'menu_id' => $this->params['named']['menu_id']));
		}
		if ($this->MenuItem->delete($id)) {
			$this->Session->setFlash(__('Menu item deleted'), 'flash_success');
			$this->redirect(array('action'=>'index', 'menu_id' => $this->params['named']['menu_id']));
		}
		$this->Session->setFlash(__('Menu item was not deleted'), 'flash_error');
		$this->redirect(array('action' => 'index', 'menu_id' => $this->params['named']['menu_id']));
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
	
	function admin_getViews(){
		
		$this->layout = 'ajax';
		if(isset($this->params['named']['method'])){
			$this->set('options', $this->findViews($this->params['named']['method']));
		}
	}
	
	private function ordering( $dir, $id ){
		
		$menu_id = $this->params['named']['menu_id'];
		$this->MenuItem->recursive = -1;
		$_this = $this->MenuItem->find('first', array('conditions' => array('MenuItem.id' => $id)));
		
		if($dir < 0){
			$options = array(
				'conditions' => array(
					'MenuItem.ordering < ' . $_this['MenuItem']['ordering'],
					'MenuItem.menu_id' => $menu_id
				), 
				'order' => 'MenuItem.ordering DESC',
				'limit' => 1
			);
		}else{
			$options = array(
				'conditions' => array(
					'MenuItem.ordering > ' . $_this['MenuItem']['ordering'],
					'MenuItem.menu_id' => $menu_id
				),
				'order' => 'MenuItem.ordering ASC',
				'limit' => 1
			);
		}
		
		$_row = $this->MenuItem->find('first', $options);
		
		if($_row){
			$this->MenuItem->id = $id;
			$this->MenuItem->saveField('ordering', $_row['MenuItem']['ordering']);
			$this->MenuItem->id = $_row['MenuItem']['id'];
			$this->MenuItem->saveField('ordering', $_this['MenuItem']['ordering']);
		}else{
			$this->MenuItem->id = $id;
			$this->MenuItem->saveField('ordering', $_this['MenuItem']['ordering']);
		}
		$this->reorder();
		$this->redirect(array('action' => 'index', 'menu_id' => $menu_id));
			
	}
	
	private function reorder(){
		
		$menu_id = $this->params['named']['menu_id'];
		$this->MenuItem->recursive = -1;
		$_m = $this->MenuItem->find('all', array(
			'conditions' => array(
				'MenuItem.ordering >=0',
				'MenuItem.menu_id' => $menu_id
			),
			'order' => 'MenuItem.ordering'
		));
		
		if($_m){
			
			for ($i=0, $n=count($_m); $i < $n; $i++){
				if($_m[$i]['MenuItem']['ordering'] >= 0){
					if($_m[$i]['MenuItem']['ordering'] != $i+1){
						$_m[$i]['MenuItem']['ordering'] = $i+1;
						$this->MenuItem->id = $_m[$i]['MenuItem']['id'];
						$this->MenuItem->saveField('ordering', $_m[$i]['MenuItem']['ordering']);
					}
				}
			}
			
		}
		
	}
	
	private function recurse( $id, $indent, $list, &$children, $maxlevel=9999, $level=0, $type=1 ){
		if (@$children[$id] && $level <= $maxlevel)
		{
			foreach ($children[$id] as $v)
			{
				$id = $v['MenuItem']['id'];

				if ( $type ) {
					$pre 	= '<sup>|_</sup>&nbsp;';
					$spacer = '.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
				} else {
					$pre 	= '- ';
					$spacer = '...';
				}

				$pt = !empty($v['MenuItem']['parent'])? $v['MenuItem']['parent']: 0;
				if ( $pt == 0 ) {
					$txt 	= $v['MenuItem']['title'];
				} else {
					$txt 	= $pre . $v['MenuItem']['title'];
				}
				
				$list[$id]['MenuItem'] = $v['MenuItem'];
				$list[$id]['MenuItem']['treename'] = "$indent$txt";
				$list[$id]['MenuItem']['treename'] = $this->ampReplace($list[$id]['MenuItem']['treename']);
				$list[$id]['MenuItem']['treename'] = str_replace('"', '&quot;', $list[$id]['MenuItem']['treename']);
				$list[$id]['MenuItem']['children'] = count( @$children[$id] );
				$list = $this->recurse( $id, $indent . $spacer, $list, $children, $maxlevel, $level+1, $type );
			}
		}
		return $list;
	}
	
	private function ampReplace( $text ){
		$text = str_replace( '&&', '*--*', $text );
		$text = str_replace( '&#', '*-*', $text );
		$text = str_replace( '&amp;', '&', $text );
		$text = preg_replace( '|&(?![\w]+;)|', '&amp;', $text );
		$text = str_replace( '*-*', '&#', $text );
		$text = str_replace( '*--*', '&&', $text );
		
		return $text;
	}
	
	private function findControllers(){
		App::uses('Sanitize', 'Utility');
		$_path = ROOT . DS . APP_DIR . DS . 'controllers' . DS;
		$_folder = new Folder($_path);
		$_ignore = array(
			'app_controller.php', 
			'config_controller.php',
			'groups_controller.php',
			'adverts_controller.php',
			'menus_controller.php', 
			'menu_items_controller.php',
			'forms_controller.php', 
			'images_controller.php',
			'users_controller.php',
			'visits_controller.php',
			'components',
			'.DS_Store');
		$_list = $_folder->tree($_path, $_ignore);
		$_path = Sanitize::escape($_path);
		$_f = array();
		foreach($_list[1] as $f){
			$_name = str_replace("_controller.php", '', str_replace($_path, '', $f));
			$_f[$_name] = Inflector::humanize($_name);
		}
		return $_f;
	}
	
	private function findViews( $folder = false ){
		
		switch ($folder){
			case 'pages':
				$this->loadModel('Page');
				return $this->Page->find('list', array('fields' => array('Page.slug', 'Page.title'), 'conditions' => array('Page.published' => 1)));
			break;
			case 'assets':
				$this->loadModel('Asset');
				return $this->Asset->find('list', array('fields' => array('Asset.id', 'Asset.title'), 'conditions' => array('Asset.published' => 1)));
			break;
			case 'categories':
				$this->loadModel('Category');
				$_empty = array('0' => 'All');
				$_list = $this->Category->find('list', array('fields' => array('Category.id', 'Category.title'), 'conditions' => array('Category.published' => 1)));
				return array_merge( $_empty, $_list );
			break;
			case 'products':
				$this->loadModel('Product');
				return $this->Product->find('list', array('fields' => array('Product.id', 'Product.title'), 'conditions' => array('Product.published' => 1)));
			break;
			default:
				App::uses('Sanitize', 'Utility');
				$_path = ROOT . DS . APP_DIR . DS . 'views' . DS . $folder . DS;
				$_folder = new Folder($_path);
				$_ignore = array(
					'admin_index.ctp',
					'admin_images.ctp', 
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