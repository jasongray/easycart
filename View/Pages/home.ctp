<?php $this->PageClass = 'home';?>
<?php echo $this->requestAction('slideshows/index', array('return'));?>
<?php //echo $this->requestAction('categories/featured', array('return'));?>
<?php echo $this->requestAction('products/featured', array('return'));?>
<div class="x12">
	<?php if($p){ ?>
		<?php if( !empty($p['Page']['show_title']) && $p['Page']['show_title'] == 1 ){ ?>
			<div class="header"><h2><?php if(!empty($p['Page']['page_title'])){ echo $p['Page']['page_title'];}else{ echo $p['Page']['title'];}?></h2></div>
		<?php } ?>
		<div class="content">
			<?php echo $this->XHtml->content($p['Page']['content'], false);?>
			<br class="clear"/>
		</div>
	<?php } ?>
</div>