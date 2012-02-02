		<?php if($news){ ?>
		<ul class="news-list">
			<?php foreach($news as $n){ ?>
				<li>
					<?php echo $this->Html->tag('h3', $this->Html->link($n['News']['title'], '/news/view/'.$n['News']['slug']));?>
					<?php echo $this->Html->para(null, $this->XHtml->trim($n['News']['intro_text'], 130) . '...');?>
					<?php echo $this->Html->link('Read More', array('controller' => 'news', 'action' => 'view', $n['News']['slug']));?>
				</li>
		<?php	} ?>
		</ul>
		<?php }?>
