<div class="portlet x4">
	<div class="portlet-header">
		<h4><?php echo __('Category Image', true);?></h4>
	</div>
	<div class="portlet-content">
		<div class="avatar">
		<?php if( !empty($this->data['Category']['image']) ) { 
			echo $this->resize->image('categories/'. $this->data['Category']['image'], 100, 100, true, array('alt' => ''));
			echo $this->Html->link($this->Html->image('admin/cancel.png', array('alt'=>'Remove')), '/admin/categories/removeAvatar/'.$this->data['Category']['id'], array('escape' => false));
		}?>
		</div>
		<?php echo $this->Form->input('Image.file', array('type' => 'file'));?>
		<div class="buttonrow">
			<button class="btn">Upload File</button>
		</div>
		<br class="clear"/>
		<div class="notification warning">
		<?php echo __('For best results, ensure your image is square.');?>
		</div>
	</div> 
</div>