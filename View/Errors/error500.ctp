<?php $title_for_layout = '500 Server Malfunction';?>
<?php $this->pageClass = 'offline'?>
<div class="x12">
	<div class="inner">
		<div class="header"><h2><?php echo $title_for_layout;?></h2></div>
		<div class="content" style="height:500px;text-align:center;">
			<?php echo $this->Html->image('admin/bg_500.png', array('alt' => '404 Not Found'));?>
			<div style="float:right;width:500px;">
				<div class="note alert">
					<p><?php echo __('There appears to be a server malfunction and we cannot display the page currently. We apologise for this inconvenience and have notified the web admin of this error.'); ?></p>
				</div>
				<h4><?php echo $this->Html->link(__('Click here to return to the home page and try again.'), '/');?></h4>
			</div>
		</div>
	</div>
</div>