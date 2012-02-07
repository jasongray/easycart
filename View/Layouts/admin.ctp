<?php echo '<?xml version="1.0" encoding="utf-8"?>';?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title>Admin :: <?php echo $title_for_layout;?></title>
 	<?php echo $this->Html->css(array('admin/screen', 'admin/plugin', 'admin/custom', 'jquery.ui'));?>
	<?php if(!empty($this->css)){ echo $this->css;}?>
</head>
<body>
	<div id="wrapper">
		<div id="top">
			<div id="header">
				<h1><?php echo $this->Html->link('Webwidget Admin', '/admin');?></h1>
				<div id="info">
					<h4>Welcome <?php echo $this->Session->read('Auth.User.firstname');?></h4>
					<p>Logged in as <?php echo $this->Session->read('Auth.User.position')?><br/><?php echo $this->Html->link('Logout', '/users/logout');?></p>
					<?php 
					$_user = $this->Session->read('Auth.User');
					if( empty($_user['image']) ) { 
						echo $this->Html->image('admin/avatar.jpg', array('alt' => ''));
					} else {
						echo $this->resize->image('users/'. $_user['image'], 60, 60, false, array('alt' => ''));
					}?>
				</div>
			</div>
			<?php echo $this->element('admin-nav');?>
		</div>
		<div id="content" class="xfluid">
			<?php if( $this->Session->check('Message.flash') || $this->Session->check('Message.auth') ) { ?>
			<div class="x12">
				<?php echo $this->Session->flash();?><?php echo $this->Session->flash('auth');?>
			</div>
			<?php } ?>
			<?php echo $content_for_layout;?>
		</div>
		<div id="footer">
			<p><?php echo date("Y");?> &copy; Webwidget Pty Ltd<br/>All Rights Reserved. Version 1.0.0</p>
		</div>
		<?php echo $this->element('sql_dump'); ?>
	</div>
	<?php echo $this->Html->scriptBlock('var _baseurl = \'' . $this->webroot . '\';');?>
	<?php echo $this->Html->script(array('jquery', 'jquery-ui', 'admin/slate.js', 'admin/slate.portlet.js', 'plugin.js', 'tiny_mce/jquery.tinymce.js', 'jtinymce', 'jgeneral'));?>
	<?php echo $this->Html->scriptBlock('$(function () {
		slate.init ();
		slate.portlet.init ();	
	});');?>
	<?php echo $scripts_for_layout;?>
</body>
</html>