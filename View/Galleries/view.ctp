<?php

$this->Html->addCrumb(__('Galleries'), '/galleries'); 
$this->Html->addCrumb($gallery['Gallery']['title'], ''); 
echo $this->Html->css(array('lightbox'));

echo $this->Html->script(array('jlightbox'), array('inline' => false));

echo $this->Html->scriptBlock("

$(function() {

	$('.gallery a').lightBox({

		imageLoading:	'".$this->webroot."/img/lightbox/lightbox-ico-loading.gif',

		imageBtnClose:'".$this->webroot."/img/lightbox/lightbox-btn-close.gif',

		imageBtnPrev:	'".$this->webroot."/img/lightbox/lightbox-btn-prev.gif',

		imageBtnNext:	'".$this->webroot."/img/lightbox/lightbox-btn-next.gif',

		fixedNavigation:true

	});

});", array('inline' => false));

?>

<div class="content-box bx100">

	<div class="inner">

	<div class="header"><h2><?php echo __('Gallery');?> :: <?php echo $gallery['Gallery']['title'];?></h2></div>

	<div class="content">
		
		<?php echo $this->Html->link('Back to gallery list', '/galleries', array('class' => 'backlink'));?>

		<?php if(count($gallery['Image']) > 0){ ?>

		<ul class="gallery">

		<?php foreach($gallery['Image'] as $g){ ?>

			<li>

				<div class="gallery-wrapper">

				<?php echo $this->Html->link($this->resize->image('galleries/'.$g['gallery_id'].'/'.$g['file'], 150, 150, true), $this->resize->image('galleries/'.$g['gallery_id'].'/'.$g['file'], 600, 400, true, array(), true), array('title' => $g['caption'], 'escape' => false));?>

				</div>

			</li>

		<?php } ?>

		</ul>

		<?php } ?>

	</div>

	<br class="clear"/>

	</div>

</div>