<?php echo '<?xml version="1.0" encoding="utf-8"?>';?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title><?php echo $title_for_layout;?></title>
 	<?php echo $this->Html->css(array('admin/screen.css', 'admin/plugin.css', 'admin/custom.css', 'admin/login.css'));?>
</head>
<body>
	<div id="login">
		<h1 id="title"><?php echo $this->Html->link('', '/');?></h1>
		<div id="login-body" class="clearfix"> 
			<?php echo $content_for_layout;?>
		</div>
		<p class="footer">&copy; <?php echo date('Y');?> Webwidget Pty Ltd. Version 1.0.0</p>
	</div>
</body>
</html>