<?php $this->Html->addCrumb('Testimonials', ''); ?>
<div class="x12">
	<div class="inner">
		<div class="header"><h2><?php echo __('Testimonials');?></h2></div>
		<div class="content">
		<?php if($t){ ?>
			<ul class="testimonial-list">
			<?php foreach($t as $n){ ?>
			<li>
				<h3><?php echo $this->Html->link($n['Testimonial']['title'], '/testimonials/view/'.$n['Testimonial']['slug']);?></h3>
				<div class="info-content">
					<blockquote>
						<?php echo $this->XHtml->content($n['Testimonial']['full_text'], true, $this->Html->link('Read More', '/testimonials/view/'.$n['Testimonial']['slug']));?>
						<span class="endquote">&nbsp;</span>
					</blockquote>
				</div>
			</li>
			<?php } ?>
			</ul>
		<?php } ?>
	</div>
</div>