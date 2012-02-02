<div class="portlet x4">
	<div class="portlet-header">
		<h4><?php echo __('User Avatar', true);?></h4>
	</div>
	<div class="portlet-content">
		<div class="avatar">
		<?php if( empty($this->data['User']['image']) ) { 
			echo $this->Html->image('v1_8/avatar.jpg', array('alt' => ''));
		} else {
			echo $this->resize->image('users/'. $this->data['User']['image'], 60, 60, false, array('alt' => ''));
			echo $this->Html->link($this->Html->image('admin/cancel.png', array('alt'=>'Remove')), '/admin/users/removeAvatar/'.$this->data['User']['id'], array('escape' => false));
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