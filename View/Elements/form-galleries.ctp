<?php
if(!empty($this->data['Gallery']['id'])){
	$_title = __('Edit Gallery') . ' :: ' . $this->data['Gallery']['title'];
}else{
	$_title = __('Add Gallery');
}
if(isset($_result) && !empty($_result)){
	echo $_result;
}
?>
<?php echo $this->Form->create('Gallery', array('id'=>'adminForm', 'class' => 'form label-inline'));?>
	<div class="portlet x4">
		<div class="portlet-header">
			<h4><?php echo __('Gallery');?></h4>
		</div>
		<div class="portlet-content">
			<?php
				echo $this->Form->input('title', array('div' => 'field'));
				echo $this->Form->input('published', array('label' => '', 'div' => 'controlset field', 'type' => 'checkbox', 'before' => '<span class="label">Publish Gallery</span>'));
			?>
			<br class="clear"/>
			<div class="buttonrow">
			<?php
				echo $this->Form->hidden('id');
				echo $this->Form->submit('Save', array('class'=>'btn', 'div' => false)); 
				echo $this->Html->link('Cancel', '/admin/galleries/cancel', array('class' => 'btn btn-orange'));
				if(!empty($this->data['Gallery']['id'])){
					echo $this->Html->link('Delete', '/admin/galleries/delete/'.$this->data['Gallery']['id'], array('class' => 'btn btn-grey'));
				}
			?>	
			</div>
		</div>
	</div>
<?php echo $this->Form->end(); ?>
	<?php if(!empty($this->data['Gallery']['id'])){ ?>
	<?php echo $this->Form->create('Gallery', array('url' => 'addImage', 'id'=>'adminForm', 'class' => 'form label-inline', 'type' => 'file'));?>
	<div id="gallery-wrapper" class="portlet x8" style="float:right;">
		<div class="portlet-header">
			<h4><?php echo __('Images');?></h4>
		</div>
		<div class="portlet-content">
		<?php //$this->requestAction('admin/galleries/images/'.$this->data['Gallery']['id']);?>
		<?php if($images){ ?>
			<ul id="sortable-images" class="gallery">
		<?php foreach($images as $i){ ?>
				<li id="GImages-<?php echo $i['Image']['id'];?>">
					<div class="handle">
					<?php echo $this->resize->image('galleries/'.$this->data['Gallery']['id'].'/'.$i['Image']['file'], 200, 200, true);?>
					</div>
					<div class="actions">
					<?php
					echo $this->Html->link(__('Move'), '#', array('class'=>'btn btn-orange btn-small btn-move', 'escape' => false));
					echo $this->Html->link(__('Delete'), '/admin/galleries/removeImage/' . $i['Image']['id'], array('class'=>'btn btn-red btn-small cancelbtn', 'escape' => false));
					?>
					</div>
				</li>
		<?php } ?>
			</ul>
		<?php } ?>
		<br class="clear"/>
		</div>
	</div>
	<div class="portlet x4" style="float:left;clear:left;">
		<div class="portlet-header">
			<h4><?php echo __('Upload Image');?></h4>
		</div>
		<div class="portlet-content">
			<?php echo $this->Form->input('Image.caption', array('div' => 'field'));?>
			<?php echo $this->Form->input('Image.upload', array('type' => 'file'));?>
			<?php echo $this->Form->hidden('Image.gallery_id', array('value' => $this->data['Gallery']['id']));?>
			<div class="buttonrow">
				<?php echo $this->Form->submit('Upload File', array('class'=>'btn btn-pink', 'div' => false)); ?>
			</div>
			<br class="clear"/>
		</div> 
	</div>
	<?php echo $this->Form->end(); ?>
	<?php } ?>