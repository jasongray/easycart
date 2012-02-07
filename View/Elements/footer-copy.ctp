<div class="x12">
	<ul class="footer-list">
		<li>
			<h2>Latest News</h2>
			<?php echo $this->requestAction(array('controller' => 'news', 'action' => 'latest'), array('return'));?>
		</li>
		<li>
			<h2>Testimonials</h2>
			<?php echo $this->requestAction(array('controller' => 'testimonials', 'action' => 'genlist'), array('return'));?>
		</li>
		<li>
			<h2>Contact Us</h2>
			<?php echo $this->requestAction(array('controller' => 'pages', 'action' => 'contact_info'), array('return'));?>
		</li>
	</ul>
</div>