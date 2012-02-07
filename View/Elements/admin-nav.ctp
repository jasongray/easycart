<?php
global $html; 
if( !isset( $this->pageClass ) ) {
	$this->pageClass = '';
}
function navmenu($pclass, $navitem){
	if($pclass == $navitem){
		return ' mega-current';
	}
	return false;
}
?>
		<div id="nav">	
			<ul class="mega-container mega-grey">
				<li class="mega<?php echo navmenu($this->pageClass,'dashboard');?>"><?php echo $this->Html->link('Dashboard', '/admin/users/dashboard', array('class' => 'mega-link'));?></li>
				<li class="mega"><?php echo $this->Html->link('Components', '/', array('onclick'=>'return false;', 'class' => 'mega-tab'));?>
				<div class="mega-content mega-menu ">
					<ul>
						<li class="<?php echo navmenu($this->pageClass,'categories');?>"><?php echo $this->Html->link('Categories', '/admin/categories');?></li>
						<li class="<?php echo navmenu($this->pageClass,'products');?>"><?php echo $this->Html->link('Product Manager', '/admin/products');?></li>
						<li class="<?php echo navmenu($this->pageClass,'slideshow');?>"><?php echo $this->Html->link('Slideshow', '/admin/slideshows');?></li>
						<li class="<?php echo navmenu($this->pageClass,'news');?>"><?php echo $this->Html->link('News Article', '/admin/news');?></li>
						<li class="<?php echo navmenu($this->pageClass,'assets');?>"><?php echo $this->Html->link('Asset Manager', '/admin/assets');?></li>
						<li class="<?php echo navmenu($this->pageClass,'galleries');?>"><?php echo $this->Html->link('Gallery Manager', '/admin/galleries');?></li>
						<li class="<?php echo navmenu($this->pageClass,'testimonials');?>"><?php echo $this->Html->link('Testimonials', '/admin/testimonials');?></li>
					</ul>
				</div>
				</li>
				<li class="mega<?php echo navmenu($this->pageClass,'pages');?>"><?php echo $this->Html->link('Content', '/admin/pages', array('class' => 'mega-link'));?></li>
				<li class="mega<?php echo navmenu($this->pageClass,'users');?>"><?php echo $this->Html->link('Users', '/admin/users', array('class' => 'mega-link'));?></li>
				<li class="mega<?php echo navmenu($this->pageClass,'menus');?>"><?php echo $this->Html->link('Menu Manager', '/admin/menus', array('class' => 'mega-link'));?></li>
				<?php if($this->Session->read('Auth.User.group_id') == 1){ ?>
				<li class="mega<?php echo navmenu($this->pageClass,'permissions');?>"><?php echo $this->Html->link('ACL', '/', array('onclick'=>'return false;', 'class' => 'mega-tab'));?>
				<div class="mega-content mega-menu ">
					<ul>
						<li class="<?php echo navmenu($this->pageClass,'groups');?>"><?php echo $this->Html->link('Groups', '/admin/groups');?></li>
						<li class="<?php echo navmenu($this->pageClass,'aros');?>"><?php echo $this->Html->link('Roles', array('admin' => true, 'plugin' => 'acl', 'controller' => 'aros', 'action' =>'users'));?></li>
						<li class="<?php echo navmenu($this->pageClass,'acos');?>"><?php echo $this->Html->link('Permissions', array('admin' => true, 'plugin' => 'acl', 'controller' => 'aros', 'action' => 'user_permissions'));?></li>
						<li class="<?php echo navmenu($this->pageClass,'perms');?>"><?php echo $this->Html->link('Global Permissions', array('admin' => true, 'plugin' => 'acl', 'controller' => 'aros', 'action' => 'role_permissions'));?></li>
					</ul>
				</div>
				</li>
				<?php } ?>
				<li class="mega<?php echo navmenu($this->pageClass,'config');?>"><?php echo $this->Html->link('System Config', '/admin/config', array('class' => 'mega-link'));?></li>
			</ul>
		</div>
