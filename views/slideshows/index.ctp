<?php if($slideshows){ ?>
<?php echo $this->Html->script(array('jcycle'), array('inline' => false));?>
<?php echo $this->Html->scriptBlock("
$(document).ready(function(){
	$('.slides').cycle({
		fx:'fade',
		speed:2000,
		timeout:7000,
		pager: '.pager',
		cleartype: 0,
		after: function() {
			var innertext = $(this).find('img').attr('alt');
			if(innertext != ''){
				$('.caption').html('<div class=\"caption-inner\">'+innertext+'</div>').fadeIn('slow');
			}else{
				$('.caption').empty().fadeOut('slow');
			}
		}
	});
});", array('inline' => false));?>
<div id="slideshow">
	<div class="slidecontainer">

	<ul class="slides">
	<?php foreach($slideshows as $s){?>
		<li title="<?php echo $s['Slideshow']['name'];?>"><?php echo $this->resize->image('slideshows/'.$s['Slideshow']['image'], 920, 400, true, array('alt' => $s['Slideshow']['alt']));?></li>
	<?php } ?>
	</ul>
	<div class="ss-header">
		<div class="caption"></div>
		<div class="pager"></div>
	</div>
	</div>
</div>
<?php } ?>