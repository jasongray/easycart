<?php
echo $this->Form->input('name', array('div' => 'field', 'class' => 'large'));
echo $this->Form->input('published', array('label' => '', 'div' => 'controlset field', 'type' => 'checkbox', 'before' => '<span class="label">Publish Content</span>'));
echo $this->Form->input('alt', array('div' => 'field', 'class' => 'xlarge', 'label' => 'Caption'));
?>
<br class="clear"/>
<div class="buttonrow">
<?php
	echo $this->Form->hidden('id');
	echo $this->Form->submit('Save', array('class'=>'btn', 'div' => false)); 
	echo $this->Html->link('Cancel', '/admin/slideshows/cancel', array('class' => 'btn btn-orange'));
	if(!empty($this->data['Slideshow']['id'])){
		echo $this->Html->link('Delete', '/admin/slideshows/delete/'.$this->data['Slideshow']['id'], array('class' => 'btn btn-grey'));
	}
?>	
</div>