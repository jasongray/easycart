<?php $this->Html->addCrumb($title_for_layout, ''); ?>
<div class="x12">
	<div class="inner">
	<div class="header"><h2><?php echo $title_for_layout;?></h2></div>
	<div class="content">
		<?php if(!empty($categories)){ ?>
			<ul class="results-list">
			<?php for($i=0;$i<count($categories);$i++){ 
				$c = $categories[$i];
				$_class = is_int($i/3)? ' class="first"': '';
			?>
				<li<?php echo $_class;?>>
				<?php echo $this->Html->tag('h2', $this->Html->link($c['Category']['title'], array('controller' => 'categories', 'action' => 'view', $c['Category']['id'], 'title' => str_replace(' ', '-', $c['Category']['title']))), array('class' => 'product'));?>
				<?php if( !empty($c['Category']['show_image']) && $c['Category']['show_image'] == 1 ){ ?>
					<?php if(!empty($c['Category']['image'])){ ?>
					<div class="content-image <?php echo $c['Category']['image_position'];?>"> 
						<?php echo $this->resize->image('categories/'.$c['Category']['image'], 200, 200, true); ?>
					</div>
					<?php } ?>
				<?php } ?>
				<div class="product-detail">
				<?php echo $this->XHtml->content($c['Category']['description'], true, $this->Html->link('View More &raquo;', array('controller' => 'categories', 'action' => 'view', $c['Category']['id'], 'title' => str_replace(' ', '-', $c['Category']['title'])), array('class' => 'btn', 'escape' => false)));?>
				<br class="clear"/>
				</div>
				<br class="clear"/>
				</li>
		<?php } ?>
			</ul>
		<?php } ?>
		<br class="clear"/>
	</div>
	</div>
</div>