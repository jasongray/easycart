<?php
$title_for_layout = $p['Page']['title'];
$this->pageClass = $p['Page']['class'];
$this->Html->addCrumb($p['Page']['title'], ''); 
?>
<div class="x12">
	<div class="inner">
	<?php if( !empty($p['Page']['show_title']) && $p['Page']['show_title'] == 1 ){ ?>
	<div class="header"><h2><?php if(!empty($p['Page']['page_title'])){ echo $p['Page']['page_title'];}else{ echo $p['Page']['title'];}?></h2></div>
	<?php } ?>
	<div class="content">
		<?php if($p['Page']['show_author'] || $p['Page']['show_created'] || $p['Page']['show_modified']){ ?>
		<div class="info-box">
		<span class="pubcat">Published in <?php echo $this->Html->link($p['Category']['title'], array('controller' => 'categories', 'action' => 'view', $p['Category']['id'], 'title' => str_replace(' ', '-', $p['Category']['title'])));?></span>
		<?php if($p['Page']['show_author']){ ?>
		<span class="author"><?php echo $p['Page']['author'];?></span>
		<?php } ?>
		<?php if($p['Page']['show_created']){ ?>
		<span class="created"><?php echo date('jS M Y', strtotime($p['Page']['created']));?></span>
		<?php } ?>
		</div>
		<?php } ?>
		<?php echo $this->XHtml->content($p['Page']['content'], false);?>
		<?php if($p['Page']['show_modified'] && !empty($p['Page']['show_modified'])){ ?>
		<div class="info-box bottom-box">
		<span class="modified">Last Modified: <?php echo date('jS M Y', strtotime($p['Page']['modified']));?></span>
		</div>
		<?php } ?>
		<br class="clear"/>
	</div>
	</div>
</div>