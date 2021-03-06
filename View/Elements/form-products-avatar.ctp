<div class="portlet x4">
	<div class="portlet-header">
		<h4><?php echo __('Product Image');?></h4>
	</div>
	<div class="portlet-content">
		<div class="avatar">
		<?php if( !empty($this->data['Product']['image']) ) { 
			echo $this->resize->image('products/'. $this->data['Product']['image'], 100, 100, false, array('alt' => ''));
			echo $this->Html->link($this->Html->image('admin/cancel.png', array('alt'=>'Remove')), '/admin/products/removeAvatar/'.$this->data['Product']['id'], array('escape' => false));
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