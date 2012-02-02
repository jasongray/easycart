<?php
echo $this->Form->input('title', array('div' => 'field', 'class' => 'large'));
echo $this->Form->input('published', array('label' => '', 'div' => 'controlset field', 'type' => 'checkbox', 'before' => '<span class="label">Publish Content</span>'));
echo $this->Form->input('featured', array('label' => '', 'div' => 'controlset field', 'type' => 'checkbox', 'before' => '<span class="label">Feature Category</span>'));
echo '<div class="controlset field">';
	echo '<span class="label">Show Image</span>';
	echo $this->Form->input('show_image', array('type' => 'radio', 'options' => array('No', 'Yes'), 'div' => 'controlset-pad', 'legend' => false, 'separator' => '<br/>'));
echo '</div>';
echo $this->Form->input('image_position', array('type' => 'select', 'options' => array('left' => 'left', 'right' => 'right'), 'empty' => '', 'div' => 'field'));
echo '<div class="controlset field">';
	echo '<span class="label">Show Text</span>';
	echo $this->Form->input('show_text', array('type' => 'radio', 'options' => array('No', 'Yes'), 'div' => 'controlset-pad', 'legend' => false, 'separator' => '<br/>'));
echo '</div>';
echo $this->Form->input('class', array('div' => 'field', 'class' => 'small', 'label' => 'Feature class'));
echo $this->Form->input('description', array('div' => 'field', 'label' => 'Text', 'rows' => 15, 'cols' => 30, 'class' => 'tinymce'));
?>
<br class="clear"/>
<div class="buttonrow">
<?php
	echo $this->Form->hidden('id');
	echo $this->Form->submit('Save', array('class'=>'btn', 'div' => false)); 
	echo $this->Html->link('Cancel', '/admin/categories/cancel', array('class' => 'btn btn-orange'));
	if(!empty($this->data['Category']['id'])){
		echo $this->Html->link('Delete', '/admin/categories/delete/'.$this->data['Category']['id'], array('class' => 'btn btn-grey'));
	}
?>	
</div>