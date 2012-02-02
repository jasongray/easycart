<?php $this->Html->addCrumb('News', ''); ?>
<div class="x9">
	<div class="inner">
	<div class="header"><h2>Recent Articles</h2></div>
	<div class="content">
		<ul class="news-list">
		<?php if($news){
			foreach($news as $n){ ?>
				<li>
					<?php echo $this->Html->tag('h3', $this->Html->link($n['News']['title'], '/news/view/'.$n['News']['slug']), array('class' => 'product'));?>
					<?php if($n['News']['show_author'] || $n['News']['show_created'] || $n['News']['show_modified']){ ?>
					<div class="info-box">
					<?php if($n['News']['show_author']){ ?>
					<span class="author"><?php echo $n['News']['author'];?></span>
					<?php } ?>
					<?php if($n['News']['show_created']){ ?>
					<span class="created"><?php echo date('jS M Y', strtotime($n['News']['created']));?></span>
					<?php } ?>
					<?php if($n['News']['show_modified']){ ?>
					<span class="modified"><?php echo date('jS M Y', strtotime($n['News']['modified']));?></span>
					<?php } ?>
					</div>
					<?php } ?>
					<div class="content">
					<?php echo $this->XHtml->content($n['News']['intro_text'], true, $this->Html->link('Read More...', '/news/view/'.$n['News']['slug']));?>
					</div>
				</li>
		<?php	}
		}?>
		</ul>
		<br class="clear"/>
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
		<br class="clear"/>
		</div>
	</div>
</div>