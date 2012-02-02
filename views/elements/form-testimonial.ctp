<?php echo $form->create('Testimonial', array('id'=>'adminForm', 'class' => 'form label-inline'));?>

	<div class="portlet x8">

		<div class="portlet-header">

			<h4><?php echo __('Create/Edit Testimonial', true);?></h4>

		</div>

		<div class="portlet-content">

		<?php

		echo $this->Form->input('title', array('div' => 'field', 'class' => 'xlarge'));

		echo $this->Form->input('customer', array('div' => 'field', 'class' => 'large', 'size' => 90));

		echo $this->Form->input('event_date', array('label' => 'Event Date:', 'div' => 'field', 'type' => 'text', 'class' => 'datepicker'));

		echo $this->Form->input('full_text', array('div' => 'field', 'rows' => 30, 'cols' => 30, 'class' => 'tinymce'));

		?>

		<br class="clear"/>

		<div class="buttonrow">

		<?php

			echo $this->Form->hidden('id');

			echo $this->Form->hidden('slug');

			echo $this->Form->hidden('user_id', array('value' => $this->Session->read('Auth.User.id')));

			echo $this->Form->submit('Save', array('class'=>'btn', 'div' => false)); 

			echo $this->Html->link('Cancel', '/admin/testimonials/cancel', array('class' => 'btn btn-orange'));

			if(!empty($this->data['Testimonial']['id'])){

				echo $this->Html->link('Delete', '/admin/testimonials/delete/'.$this->data['Testimonial']['id'], array('class' => 'btn btn-grey'));

			}

		?>

		</div>

	</div>

</div>

<div class="portlet x4">

	<div class="portlet-header">

		<h4><?php echo __('Parameters', true);?></h4>

	</div>

	<div class="portlet-content">

		<?php

		echo $this->Form->input('published', array('label' => false, 'div' => 'field', 'type' => 'checkbox', 'before' => '<span class="label">Publish</span>'));

		echo '<hr/>';

		echo '<div class="controlset field">';

			echo '<span class="label">Show Name</span>';

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

		?>

		

		<br class="clear"/>

	</div>

</div>

<?php echo $form->end();?>