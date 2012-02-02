<?php


class menuHelper extends Helper{

	var $helpers = array('Html');
	
	function create($menuname = false, $htmlAttributes = array(), $type = 'ul', $tags = true ){
	
		if($menuname){
			
			App::import('Controller', 'Menus');
			$Menu = new MenusController;
			$Menu->constructClasses();
			
			if( $links = $Menu->load($menuname, $tags)){
			
				$this->tags['ul'] = '<ul%s>%s</ul>';
				$this->tags['ol'] = '<ol%s>%s</ol>';
				$this->tags['li'] = '<li%s>%s</li>';
				$this->tags['span'] = '<span%s>%s</span>';
				
				$out = array();
				
				foreach($links as $l){
				/*
					$_base = explode('/', str_replace($this->base, '', $this->url($l['MenuItem']['url'])));
					$_url = explode('/', str_replace($this->base, '', $this->here));
				
					if($_base[1] === $_url[1]){
						$out[] = sprintf($this->tags['li'], ' id="current"', $this->Html->link($l['MenuItem']['title'], $l['MenuItem']['url']));
					}else{
						$out[] = sprintf($this->tags['li'], '', $this->Html->link($l['MenuItem']['title'], $l['MenuItem']['url']));
					}*/
					if($l['MenuItem']['children'] > 0){
						$class = array('class' => 'mega-tab');
					}else{
						if(empty($l['MenuItem']['class'])){
							$class = array('class' => 'mega-link');
						}else{
							$class = array('class' => 'mega-link '.$l['MenuItem']['class']);
						}
						
					}
					
					$url = array();
					if(!empty($l['MenuItem']['controller'])){
						$url['controller'] = $l['MenuItem']['controller'];
						if(!empty($l['MenuItem']['action']) && $l['MenuItem']['action'] != 'display' && $l['MenuItem']['action'] != 'index'){
							$url['action'] = $l['MenuItem']['action'];
						}
						if(!empty($l['MenuItem']['slug'])){
							$url[] = $l['MenuItem']['slug'];
						}
					}
					$url = '/' . implode('/', $url);
					
					if(!empty($l['MenuItem']['url'])){
						$url = $l['MenuItem']['url'];
					}
					
					if(str_replace($this->base, '', $this->here) == $url){
						$class = array_merge_recursive($class, array('class' => 'current'));
						$class['class'] = $class['class'][0] . ' ' . $class['class'][1];
					}
					
					$out[] = preg_replace( '/\$link/', $this->Html->link($l['MenuItem']['title'], $url, $class), $l['MenuItem']['link']);
				
				}
				
				$tmp = implode("\n", $out);
				return $this->output(sprintf($this->tags[$type], $this->_parseAttributes($htmlAttributes), $tmp));
				
			}
			
			
		}
		
	
	}
	
	function getCrumbs($separator = '&raquo;', $startText = false) {

		if (!empty($this->Html->_crumbs)) {
			$rtn = '<ul>';
			$out = array();
			if ($startText) {
				$out[] = '<li>' . $this->Html->link($startText, '/') . '</li>';
			}

			foreach ($this->Html->_crumbs as $crumb) {
				if (!empty($crumb[1])) {
					$out[] = '<li>' . $this->Html->link($crumb[0], $crumb[1], $crumb[2]) . '</li>';
				} else {
					$out[] = '<li class="current">' . $crumb[0] . '</li>';
				}
			}
			$rtn .= join('<li>'.$separator.'</li>', $out) . '</ul>';
			return $rtn;
		} else {
			return null;
		}

	}
	
	
}