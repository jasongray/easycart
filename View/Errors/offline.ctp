<?php $title_for_layout = $code . ' Offline';?>
<?php $this->pageClass = 'offline'?>
<div class="x12">
	<div class="inner">
		<div class="header"><h2><?php echo $name;?></h2></div>
		<div class="content" style="height:500px;text-align:center;">
			<?php echo $this->Html->image('admin/bg_offline.png', array('alt' => 'Site Offline'));?>
			<div style="float:right;width:500px;">
				<div class="note alert">
					<p><?php echo __($message); ?></p>
				</div>
			</div>
		</div>
	</div>
</div>