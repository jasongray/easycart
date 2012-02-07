<?php $title_for_layout = '404 Page Not Found';?>
<?php $this->pageClass = 'offline'?>
<div class="x12">
	<div class="inner">
		<div class="header"><h2><?php echo $title_for_layout;?></h2></div>
		<div class="content" style="height:500px;text-align:center;">
			<?php echo $this->Html->image('admin/bg_404.png', array('alt' => '404 Not Found'));?>
			<div style="float:right;width:500px;">
				<div class="note warn">
					<p><?php echo __('The requested URL cannot be found. The page you were looking for has either been removed, had its named changed or is temporarily unavailable.'); ?></p>
				</div>
				<h4><?php echo $this->Html->link(__('Click here to return to the home page and try again.'), '/');?></h4>
			</div>
		</div>
	</div>
</div>