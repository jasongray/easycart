<div class="portlet x4">
	<div class="portlet-header">
		<h4><?php echo __('Add Asset');?></h4>
	</div>
	<div class="portlet-content">
		<?php echo $this->Form->input('Asset.title', array('div' => 'field', 'class' => 'medium'));?>
		<?php echo $this->Form->input('Asset.file', array('type' => 'file'));?>
		<br class="clear"/>
		<div class="buttonrow">
			<button class="btn">Upload File</button>
		</div>
	</div> 
</div>