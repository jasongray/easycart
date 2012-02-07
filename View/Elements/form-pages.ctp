<?php
if(!empty($this->data['Page']['id'])){
	$_title = __('Edit Content') . ' :: ' . $this->data['Page']['title'];
}else{
	$_title = __('Add Content');
}
?>
<?php echo $this->Html->script(array('tiny_mce/jquery.tinymce.js', 'jtinymce', 'properties'), array('inline' => false));?>
<?php echo $form->create('Page', array('id'=>'adminForm', 'class' => 'form label-inline'));?>
<div class="portlet x4">
	<div class="portlet-header">
		<h4><?php echo __('Content Information');?></h4>
	</div>
	<div class="portlet-content">
	<?php
		echo $this->Form->input('title', array('div' => 'field', 'class' => 'long', 'label' => 'Content Title'));
		echo $this->Form->input('template', array('div' => 'field', 'options' => $templates));
		echo $this->Form->input('class', array('div' => 'field'));
		echo $this->Form->input('category_id', array('div' => 'field', 'empty' => ''));
		echo $this->Form->input('published', array('label' => '', 'div' => 'controlset field', 'type' => 'checkbox', 'before' => '<span class="label">Publish Content</span>'));
		echo '<div class="controlset field">';
			echo '<span class="label">Front page article?</span>';
			echo $this->Form->input('front_page', array('type' => 'radio', 'options' => array('No', 'Yes'), 'div' => 'controlset-pad', 'legend' => false, 'separator' => '<br/>'));
		echo '</div>';
		echo '<hr/>';
		$_author = empty($this->data['News']['author'])? $this->Session->read('Auth.User.firstname') . ' ' . $this->Session->read('Auth.User.surname'): $this->data['News']['author'];
		echo $this->Form->input('author', array('label' => 'Author', 'div' => 'field', 'value' => $_author));
		echo '<div class="controlset field">';
			echo '<span class="label">Show Author</span>';
			echo $this->Form->input('show_author', array('type' => 'radio', 'options' => array('No', 'Yes'), 'div' => 'controlset-pad', 'legend' => false, 'separator' => '<br/>'));
		echo '</div>';
		echo '<hr>';
		echo '<div class="controlset field">';
			echo '<span class="label">Show Created Date</span>';
			echo $this->Form->input('show_created', array('type' => 'radio', 'options' => array('No', 'Yes'), 'div' => 'controlset-pad', 'legend' => false, 'separator' => '<br/>'));
		echo '</div>';
		echo '<div class="controlset field">';
			echo '<span class="label">Show Modified Date</span>';
			echo $this->Form->input('show_modified', array('type' => 'radio', 'options' => array('No', 'Yes'), 'div' => 'controlset-pad', 'legend' => false, 'separator' => '<br/>'));
		echo '</div>';
		echo '<hr>';
		$_date = empty($this->data['News']['start_publish'])? date('Y-m-d H:i:s'): $this->data['News']['start_publish'];
		echo $this->Form->input('start_publish', array('label' => 'Start Publish Date:', 'div' => 'field', 'type' => 'text', 'class' => 'datepicker', 'value' => $_date));
		echo $this->Form->input('end_publish', array('label' => 'End Publish Date:', 'div' => 'field', 'type' => 'text', 'class' => 'datepicker'));
	?>
		<hr/>
	<?php
		echo $this->Form->input('page_title', array('div' => 'field', 'class' => 'long', 'label' => 'Page Title'));
		echo $this->Form->input('show_title', array('label' => '', 'div' => 'controlset field', 'type' => 'checkbox', 'before' => '<span class="label">Show Page Title</span>'));
		echo $this->Form->input('page_meta', array('label' => false, 'div' => 'field', 'rows' => 6, 'cols' => 20, 'class' => '', 'label' => 'Meta Description'));
		echo $this->Form->input('page_kw', array('label' => false, 'div' => 'field', 'rows' => 6, 'cols' => 20, 'class' => '', 'label' => 'Meta Keywords'));
	?>
		<br class="clear"/>
		<div class="buttonrow">
		<?php
			echo $this->Form->hidden('id');
			echo $this->Form->hidden('slug');
			echo $this->Form->submit('Save', array('class'=>'btn', 'div' => false)); 
			echo $this->Html->link('Cancel', '/admin/pages/cancel', array('class' => 'btn btn-orange'));
			if(!empty($this->data['Page']['id'])){
				echo $this->Html->link('Delete', '/admin/pages/delete/'.$this->data['Page']['id'], array('class' => 'btn btn-grey'));
			}
		?>	
		</div>
	</div>
</div>
<div class="portlet x8">
	<div class="portlet-header">
		<h4><?php echo $_title;?></h4>
	</div>
	<div class="portlet-content">
	<?php
		echo $this->Form->input('content', array('label' => false, 'div' => 'field', 'rows' => 50, 'cols' => 30, 'class' => 'tinymce'));
	?>
	</div>
</div>
<?php echo $form->end();?>