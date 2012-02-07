<?php

App::uses('HtmlHelper', 'View/Helper');

class XhtmlHelper extends HtmlHelper{
	
	public function __construct(View $View, $settings = array()) {
		parent::__construct($View, $settings);
	}
	

	function trim($str, $cnt){
		
		$_array = str_word_count(strip_tags($str), 2);
		$_str = array();
		if(count($_array) > 0){
			foreach($_array as $k => $v){
				if($k < $cnt){
					$_str[] = $v;
				}
			}
		}
		return implode(' ', $_str);
		
	}
	
	function mailto($email, $attributes = array()){
		$a = '';
		if(Validation::email($email)){
			$_email = preg_split('/(\@)/', $email);	
			$b = '';
			if (is_array($attributes) && count($attributes) > 0){
				foreach ($attributes as $key => $val){
					$b .= ' ' . $key . '="' . $val . '"';
				}
			}
			$a = '<script type="text/javascript">'.PHP_EOL;
			$a .= '<!-- '.PHP_EOL;
			$a .= " var m = ('".$_email[0]."&#64;' + '".$_email[1]."');".PHP_EOL;
			$a .= "document.write('<a href=\"mailto:' + m + '\"".$b.">' + m + '</a>');".PHP_EOL;
			$a .= '//-->'.PHP_EOL;
			$a .= '</script>'.PHP_EOL;
			$a .= '<ins><noscript>'.PHP_EOL;
			$a .= '<p><em>Email address protected by JavaScript.</em></p>'.PHP_EOL;
			$a .= '</noscript></ins>'.PHP_EOL;
		}
		return $a;
		
	}
	
	function legend($value=''){
		
		$legend = '<legend>';
		
		if(isset($value)){
			$legend .= $value;
		}
		
		$legend .= '</legend>';
		return $legend;
		
	}
	
	function fieldset($pos,$attributes=array()){
	
		$_lg = '';
		switch($pos){
			default:
			case 'start':
			$fset = '<fieldset ';
			if (is_array($attributes) && count($attributes) > 0){
				if(isset($attributes['legend']) && !empty($attributes['legend'])){
					$_lg = $this->legend($attributes['legend']);
					unset($attributes['legend']);
				}
				foreach ($attributes as $key => $val){
					$fset .= ' '.$key.'="'.$val.'"';
				}
			}
			$fset .= '>' . $_lg;
			break;
			case 'end':
			$fset = '</fieldset>';
			break;
		}			
			
		return $fset;
		
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
	
	function iconImage($type){
		
		switch ($type) {
			default: $ext = 'default'; break;
			case 'application/pdf': $ext = 'pdf'; break;
			case 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet':
			case 'application/vnd.ms-excel': $ext = 'excel'; break;
			case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document':
			case 'application/msword': $ext = 'word'; break;
			case 'image/jpeg': 
			case 'image/jpg': $ext = 'jpg'; break;
			case 'image/png': $ext = 'png'; break;
			case 'image/gif': $ext = 'gif'; break;
		}
		return $ext;
	}
	
	function content( $text = false, $split = true, $link = '' ){
		if($text){
			if($split && preg_match('/\<hr id\=\"system-readmore\" \/\>/', $text)){
				$str = preg_split('/\<hr id\=\"system-readmore\" \/\>/', stripslashes($text));
				$lk = (!empty($link))? $this->Html->para(false, $link): '';
				return $str[0] . $lk; 
			}else{
				$lk = (!empty($link))? $this->Html->para(false, $link): '';
				return preg_replace('/\<hr id\=\"system-readmore\" \/\>/', '', stripslashes($text)) . $lk;
			}
		}
		return false;
	}
	
	
	function pagetitle($title_for_layout){
		$regexp = Configure::read('MySite.site_name_layout');
		if(Empty($regexp)){
			$regexp = '{site name} :: {model} :: {site name}';
		}
		return preg_replace(
			array('/\{site name\}/i', '/\{model\}/i', '/\{page title\}/i'), 
			array(Configure::read('MySite.site_name'), Inflector::classify($this->params['controller']), $title_for_layout), 
			$regexp);
		
	}
	


}