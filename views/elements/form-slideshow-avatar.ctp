<div class="portlet x4">
	<div class="portlet-header">
		<h4><?php echo __('Slide Image', true);?></h4>
	</div>
	<div class="portlet-content">
		<div class="avatar">
		<?php if( !empty($this->data['Slideshow']['image']) ) { 
			echo $this->resize->image('slideshows/'. $this->data['Slideshow']['image'], 100, 100, true, array('alt' => ''));
			echo $this->Html->link($this->Html->image('admin/cancel.png', array('alt'=>'Remove')), '/admin/slideshows/removeAvatar/'.$this->data['Slideshow']['id'], array('escape' => false));
		}?>
		</div>
		<?php echo $this->Form->input('Image.file', array('type' => 'file'));?>
		<div class="buttonrow">
			<button class="btn">Upload File</button>
		</div>
		<br class="clear"/>
		<div class="notification warning">
		<?php echo __('For best results, ensure your image is roughly 920 x 400 pixels.');?>
		</div>
	</div> 
</div>