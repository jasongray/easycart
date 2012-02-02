<?php


class MenusController extends AppController{
	
	var $name = 'Menu';
	
	var $helpers = array('menu');
	
	function beforeFilter() {
	    parent::beforeFilter();
		$this->Auth->allowedActions = array('load'); 
	}
	
	function load( $menu = false, $tags = true ){
		
		if($menu){
			$m = $this->Menu->find('first', array('conditions' => array('Menu.unique' => $menu, 'Menu.published' => 1)));
			$_menu = $this->Menu->MenuItem->find('all', array('conditions' => array('MenuItem.menu_id' => $m['Menu']['id'], 'MenuItem.published' => 1), 'order' => 'MenuItem.parent ASC, MenuItem.ordering'));
			
			$children = array();
			foreach ($_menu as $v ){
				$pt = !empty($v['MenuItem']['parent'])? $v['MenuItem']['parent']: 0;
				$list = @$children[$pt] ? $children[$pt] : array();
				array_push( $list, $v );
				$children[$pt] = $list;
			}

			$list = $this->recurse($tags,  0, '', array(), $children, max( 0, 10 ) );
			$list = array_values($list);
			
			return $list;
		}
		exit; //to stop rendering a view
		
	}
	
	function admin_index() {
		$this->Menu->recursive = -1;
		$this->set('menus', $this->paginate());
	}


	function admin_add() {
		if (!empty($this->data)) {
			$this->Menu->create();
			if ($_id = $this->Menu->save($this->data)) {
				$this->Session->setFlash(__('The menu has been created', true), 'flash_success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The menu could not be saved. Please, try again.', true), 'flash_error');
			}
		}
	}
	
	function admin_cancel($id = null) {
		$this->Session->setFlash(__('Operation cancelled', true), 'flash_info');
		$this->redirect(array('action' => 'index'));
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid menu', true), 'flash_error');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			unset($this->data['User']['image']);
			if ($this->Menu->save($this->data)) {
				$this->Session->setFlash(__('The menu has been saved', true), 'flash_success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The menu could not be saved. Please, try again.', true), 'flash_error');
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Menu->read(null, $id);
		}
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for menu', true), 'flash_error');
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Menu->delete($id)) {
			$this->Session->setFlash(__('User deleted', true), 'flash_success');
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('User was not deleted', true), 'flash_error');
		$this->redirect(array('action' => 'index'));
	}
	
	
	private function recurse( $tags, $id, $indent, $list, &$children, $maxlevel=9999, $level=0, $type=1, $kids=0 ){
		if (@$children[$id] && $level <= $maxlevel)
		{
			$k=0;
			$_cls = '';
			foreach ($children[$id] as $v)
			{
				$id = $v['MenuItem']['id'];
				$pt = !empty($v['MenuItem']['parent'])? $v['MenuItem']['parent']: 0;
				$list[$id] = $v;
				$list[$id]['MenuItem']['children'] = count( @$children[$id] );
				$kids = $kids - 1;
				$pre = '';
				$post = '';
						
				if($tags){		
					if( count( @$children[$id] ) != 0 ) {
						//$_cls = ( $_currentId == $id )? ' selected': '';
						//$_cls = $this->makeSelected( $id, $children, $_currentId, $_cls );
						$pre = "<li class=\"mega$_cls\">";
						$post = "\n<div class=\"mega-content mega-menu\">\n<ul class=\"$_cls\">";
					} else {
						$pre = "<li class=\"mega\">";
						$post = "</li>";
						if( $kids == 0 ) {
							$post = $post . "\n</ul>\n</div>\n";
						}
					}
				}
				$list[$id]['MenuItem']['link'] = $pre . '$link' . $post;
				$list = $this->recurse( $tags, $id, $indent, $list, $children, $maxlevel, $level+1, $type, count( @$children[$id] ) );
				$k++;
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
	
	private function makeSelected( $id, $children, $_currentId, $_cls = '' ) {
		
		if( @$children[$id] ) {
			foreach( @$children[$id] as $_c ) {
				$id = $_c['MenuItem']['id'];
				$_cls = ( $_currentId == $id )? ' selected': $_cls;
				$_cls = $this->makeSelected( $id, $children, $_currentId, $_cls );
			}
		}
		
		return $_cls;
		
	}


}