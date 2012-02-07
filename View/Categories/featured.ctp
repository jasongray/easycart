<?php echo $this->Html->script(array('jquery-ui'), array('inline' => false));?>
<?php echo $this->Html->scriptBlock("
$(document).ready(function(){
	$('#featured').accordion({
		header: 'h2',
		active: false
	});
});", array('inline' => false));?>
<div id="featured" class="inner">
<?php if(!empty($featured)){ ?>
	<div class="header"><h4>Featured Categories</h4></div>
<?php for($i=0;$i<count($featured);$i++){ 
	$c = $featured[$i];
	$_class = is_int($i/3)? ' class="first"': '';
?>
		<?php echo $this->Html->tag('h2', $this->Html->link($c['Category']['title'], array('controller' => 'categories', 'action' => 'view', $c['Category']['id'], 'title' => str_replace(' ', '-', $c['Category']['title'])), array('escape' => false)));?>
		<div>
			<?php if(!empty($c['Category']['image'])){ ?>
			<div class="content-image <?php echo $c['Category']['image_position'];?>"> 
				<?php echo $this->resize->image('categories/'.$c['Category']['image'], 100, 100, true); ?>
			</div>
			<?php } ?>
			<?php echo $this->XHtml->content($c['Category']['description'], true, $this->Html->link('View All ' . $c['Category']['title'] . ' Products &raquo;', array('controller' => 'categories', 'action' => 'view', $c['Category']['id'], 'title' => str_replace(' ', '-', $c['Category']['title'])), array('escape' => false)), array('class' => $c['Category']['class']));?>
			<br class="clear"/>
		</div>
<?php } ?>
<?php } ?>
<br class="clear"/>
</div>