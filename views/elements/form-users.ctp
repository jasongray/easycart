<?php
echo $this->Form->input('username', array('div' => 'field'));
echo $this->Form->input('password', array('div' => 'field', 'value' => ''));
echo $this->Form->input('email', array('div' => 'field', 'class' => 'long'));	
echo $this->Form->input('group_id', array('div' => 'field'));
echo $this->Form->input('position', array('div' => 'field', 'class' => 'inline'));
echo $this->Form->input('firstname', array('div' => 'field', 'class' => 'inline'));
echo $this->Form->input('surname', array('div' => 'field', 'class' => 'inline'));
echo $this->Form->input('phone', array('div' => 'field', 'class' => 'inline'));
echo $this->Form->input('mobile', array('div' => 'field', 'class' => 'inline'));
echo $this->Form->input('fax', array('div' => 'field', 'class' => 'inline'));
?>
<hr/>
<?php
echo '<div class="controlset field">';
	echo '<span class="label">Show Profile</span>';
	echo $this->Form->input('public', array('type' => 'radio', 'options' => array('No', 'Yes'), 'div' => 'controlset-pad', 'legend' => false, 'separator' => '<br/>'));
echo '</div>';
echo $this->Form->input('profile', array('div' => 'field', 'label' => 'Public Profile', 'rows' => 15, 'cols' => 30, 'class' => 'tinymce'));
?>
<hr/>
<?php
echo $this->Form->input('bio', array('div' => 'field', 'label' => 'Email Signature', 'rows' => 15, 'cols' => 30, 'class' => 'tinymce', 'after' => '<p class="field_help">Setup the default email signature. Use a combination of {{Avatar}} {{Firstname}} {{Surname}} {{Email}} {{Phone}} {{Fax}} {{Mobile}} {{Position}} labels to represent the above fields.</p>'));
?>
<br class="clear"/>
<div class="buttonrow">
<?php
	echo $this->Form->hidden('id');
	echo $this->Form->submit('Save', array('class'=>'btn', 'div' => false)); 
	echo $this->Html->link('Cancel', '/admin/users/cancel', array('class' => 'btn btn-orange'));
	if(!empty($this->data['User']['id'])){
		echo $this->Html->link('Delete', '/admin/users/delete/'.$this->data['User']['id'], array('class' => 'btn btn-grey'));
	}
?>	
</div>