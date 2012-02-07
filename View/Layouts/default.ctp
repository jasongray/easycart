<?php echo $this->Html->docType('html5'); ?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset(); ?>
	<title><?php echo $this->Html->pagetitle($title_for_layout);?></title>
	<?php
		echo $this->Html->meta('icon');
		echo $this->Html->meta('description', $metadesc_for_layout);
		echo $this->Html->meta('keywords', $metakw_for_layout);
		echo $this->Html->css(array('style', 'menu'));
	?>
</head>
<body>
<div id="header">
	<div class="container">
		<div class="x12">
			<div class="logo">
				<h1><?php echo $this->Html->link(Configure::read('MySite.site_name'), '/', array('escape' => false)); ?></h1>
					<?php echo $this->Form->submit('gr_cart.png', array('class' => 'ppcart', 'type' => 'image', 'value' => 'View Cart', 'div' => false, 'escape' => false));?>
			</div>
			<div class="menu">
				<?php echo $this->Menu->create('mainmenu', array('class' => 'mega-container'));?>
			</div>
		</div>
	</div>
</div>
<div id="content"<?php if(!empty($this->PageClass)){ echo ' class="'.$this->PageClass.'"';}?>>
	<div class="crumb-container">
	<?php echo $this->element('breadcrumbs');?>
	</div>
	<div class="container">
		<?php if( $this->Session->check('Message.flash') || $this->Session->check('Message.auth') ) { ?>
		<div class="x12">
			<?php echo $this->Session->flash();?><?php echo $this->Session->flash('auth');?>
		</div>
		<?php } ?>
		<?php echo $this->fetch('content');?>
		<br class="clear"/>
	</div>
</div>
<div id="footer">
	<div class="container">
	<?php echo $this->element('footer-copy', array('cache' => '+1 hour'));?>
	</div>
</div>
<div id="footer-copy">
	<div class="container">
	<div class="x12">
		<div class="inner">
			<p class="left"><?php echo Configure::read('MySite.site_name'); ?> &copy; <?php echo date('Y');?><?php echo $menu->create('footermenu', array('class' => 'footer-menu'));?></p>
			<p class="right">Site created by <?php echo $this->Html->link('Webwidget', 'http://webwidget.com.au')?></p>
		</div>
	</div>
	</div>
</div>
<?php //echo $this->element('sql_dump'); ?>
<?php echo $this->requestAction('visits/record', array('return'));?>
<?php echo $this->Html->script(array('jquery'));?>
<?php echo $this->fetch('script');; ?>
</body>
</html>