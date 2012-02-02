<?php echo $form->create('News', array('id'=>'adminForm', 'class' => 'form label-inline'));?>
	<div class="portlet x8">
		<div class="portlet-header">
			<h4><?php echo __('Article Content', true);?></h4>
		</div>
		<div class="portlet-content">
		<?php
		echo $this->Form->input('title', array('div' => 'field', 'class' => 'large', 'size' => 90));
		echo $this->Form->input('intro_text', array('div' => 'field', 'rows' => 10, 'cols' => 30, 'class' => 'tinymce'));
		echo $this->Form->input('full_text', array('div' => 'field', 'rows' => 30, 'cols' => 30, 'class' => 'tinymce'));
		?>
		<br class="clear"/>
		<div class="buttonrow">
		<?php
			echo $this->Form->hidden('id');
			echo $this->Form->hidden('slug');
			echo $this->Form->submit('Save', array('class'=>'btn', 'div' => false)); 
			echo $this->Html->link('Cancel', '/admin/news/cancel', array('class' => 'btn btn-orange'));
			if(!empty($this->data['News']['id'])){
				echo $this->Html->link('Delete', '/admin/news/delete/'.$this->data['News']['id'], array('class' => 'btn btn-grey'));
			}
		?>
		</div>
	</div>
</div>
<div class="portlet x4">
	<div class="portlet-header">
		<h4><?php echo __('Article Parameters', true);?></h4>
	</div>
	<div class="portlet-content">
		<?php
		echo $this->Form->input('published', array('label' => false, 'div' => 'field', 'type' => 'checkbox', 'before' => '<span class="label">Publish</span>'));
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
		
		<br class="clear"/>
	</div>
</div>
<?php echo $form->end();?>