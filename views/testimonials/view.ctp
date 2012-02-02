<?php $this->Html->addCrumb('Testimonials', array('controller' => 'testimonials', 'action' => 'index')); ?>
<?php $this->Html->addCrumb($t['Testimonial']['title'], ''); ?>
<div class="x12">
	<div class="inner">
		<div class="header"><h2><?php echo __('Testimonial ' . $t['Testimonial']['title'], true);?></h2></div>
		<div class="content">
		<?php if($t){ ?>
			<ul class="testimonial-list">
			<li>
				<div class="info-content">
					<blockquote>
					<?php echo $this->XHtml->content($t['Testimonial']['full_text'], false);?>
						<span class="endquote">&nbsp;</span>
					</blockquote>
				</div>
				<?php if($t['Testimonial']['show_author'] == 1 || $t['Testimonial']['show_created'] == 1 || $t['Testimonial']['show_modified'] == 1){ ?>
				<div class="info-box">
					<?php //echo $this->Html->link(__('More', true), '/testimonials/view/'.$t['Testimonial']['slug'], array('class' => 'read-more btn'));?>
					<?php if($t['Testimonial']['show_author'] == 1){ ?>
					<span class="author"><?php echo __('Customer : ', true) . $this->Html->tag('cite', $t['Testimonial']['customer']);?></span>
					<?php } ?>
					<?php if($t['Testimonial']['show_created'] == 1){ ?>
					<span class="created"><?php echo __('Created : ', true) . date('jS M Y', strtotime($t['Testimonial']['created']));?></span>
					<?php } ?>
					<?php if($t['Testimonial']['show_modified'] == 1){ ?>
					<span class="modified"><?php echo __('Modified : ', true) . date('jS M Y', strtotime($t['Testimonial']['modified']));?></span>
					<?php } ?>
				</div>
			</li>
			<?php } ?>
			</ul>
		<?php } ?>
	</div>
</div>