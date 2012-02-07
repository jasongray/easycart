<?php if(!empty($t)){ ?>
<ul class="testimonial-list">
<?php foreach($t as $_t){ ?>
	<li><blockquote><?php echo $this->XHtml->trim($_t['Testimonial']['full_text'], 200);?>... <cite><?php echo $_t['Testimonial']['customer'];?></cite> <?php echo $this->Html->link('Read More', array('controller' => 'testimonials', 'action' => 'view', $_t['Testimonial']['slug']));?></blockquote>
	</li>
<?php } ?>
</ul>
<?php echo $this->Html->link('Read All Testimonials', array('controller' => 'testimonials', 'action' => 'index'), array('class' => 'right'));?>
<?php } ?>