<?php $this->Html->addCrumb('News', array('controller' => 'news', 'action' => 'index')); ?>
<?php $this->Html->addCrumb($p['News']['title'], ''); ?>
<div class="x9">
	<div class="inner">
	<div class="header"><h2 class="product"><?php echo $this->Html->link($p['News']['title'], '/news/view/'.$p['News']['slug']);?></h2></div>
		<div class="content">
			<div class="contenttable">
				<?php if($p['News']['show_author'] || $p['News']['show_created']){ ?>
				<div class="info-box">
				<?php if($p['News']['show_author']){ ?>
				<span class="author"><?php echo $p['News']['author'];?></span>
				<?php } ?>
				<?php if($p['News']['show_created']){ ?>
				<span class="created"><?php echo date('jS M Y', strtotime($p['News']['created']));?></span>
				<?php } ?>
				</div>
				<?php } ?>
				<?php echo stripslashes($p['News']['full_text']);?>
				<?php if($p['News']['show_modified'] && !empty($p['News']['show_modified'])){ ?>
				<div class="info-box bottom-box">
				<span class="modified">Last Modified: <?php echo date('jS M Y', strtotime($p['News']['modified']));?></span>
				</div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>
<div class="x3">
	<div class="inner">
		<div class="header"><h2>Archive</h2></div>
		<div class="content">
		<?php if($archive){?>
			<ul class="archive">
			<?php foreach($archive as $a){?>
				<li><?php echo $this->Html->link($a['News']['a'], array('controller' => 'news', 'year' => $a['News']['y'], 'month' => $a['News']['m']));?></li>
			<?php }?>
			</ul>
		<?php }?>
		</div>
	</div>
</div>