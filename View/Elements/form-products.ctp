<?php
echo $this->Form->input('title', array('div' => 'field', 'class' => 'large'));
echo $this->Form->input('sku', array('div' => 'field', 'class' => 'medium'));
echo $this->Form->input('price', array('div' => 'field', 'class' => 'small', 'after' => '<p class="field_help">Price including GST</p>'));
echo '<div class="controlset field">';
	echo '<span class="label">Allow "Add to Cart"</span>';
	echo $this->Form->input('allow_cart', array('type' => 'radio', 'options' => array('No', 'Yes'), 'div' => 'controlset-pad', 'legend' => false, 'separator' => '<br/>'));
echo '</div>';
echo '<div class="controlset field">';
	echo '<span class="label">Allow "View Details"</span>';
	echo $this->Form->input('allow_details', array('type' => 'radio', 'options' => array('No', 'Yes'), 'div' => 'controlset-pad', 'legend' => false, 'separator' => '<br/>'));
echo '</div>';
echo $this->Form->input('published', array('label' => '', 'div' => 'controlset field', 'type' => 'checkbox', 'before' => '<span class="label">Publish</span>'));
echo $this->Form->input('featured', array('label' => '', 'div' => 'controlset field', 'type' => 'checkbox', 'before' => '<span class="label">Feature Product</span>'));
echo $this->Form->input('category_id', array('div' => 'field', 'empty' => ''));
?>
<hr/>
<?php
echo $this->Form->input('introtext', array('div' => 'field', 'label' => 'Intro Text', 'rows' => 15, 'cols' => 30, 'class' => 'tinymce'));
echo $this->Form->input('description', array('div' => 'field', 'label' => 'Product Description', 'rows' => 45, 'cols' => 30, 'class' => 'tinymce'));
?>
<br class="clear"/>
<div class="buttonrow">
<?php
	echo $this->Form->hidden('id');
	echo $this->Form->submit('Save', array('class'=>'btn', 'div' => false)); 
	echo $this->Html->link('Cancel', '/admin/products/cancel', array('class' => 'btn btn-orange'));
	if(!empty($this->data['Product']['id'])){
		echo $this->Html->link('Delete', '/admin/products/delete/'.$this->data['Product']['id'], array('class' => 'btn btn-grey'));
	}
?>	
</div>