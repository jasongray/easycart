<?php $this->pageClass = 'config';?>
<div class="portlet x12">
	<div class="portlet-header">
		<h4><?php echo __('Configuration');?></h4>
	</div>
	<div class="portlet-content">
		<?php 
		echo $this->Form->create('Config', array('id'=>'adminForm', 'class' => 'form label-inline', 'url' => '/admin/config'));
		
		echo $this->Html->tag('h3', 'Site Settings');
		
		echo $this->Form->input('site_name', array('div' => 'field', 'class' => 'large'));
		echo $this->Form->input('site_name_layout', array('div' => 'field', 'class' => 'large', 'label' => 'Regular Expression for the title layout.', 'after' => '<p class="tiny">{page title} for page title, {model} for model name, {site name} for site name</p>'));
		echo $this->Form->input('meta_description', array('div' => 'field', 'class' => 'large', 'cols' => 20, 'rows' => 10, 'label' => 'Global Meta Description'));
		echo $this->Form->input('meta_keywords', array('div' => 'field', 'class' => 'large', 'cols' => 20, 'rows' => 10, 'label' => 'Global Meta Keywords'));
		echo '<div class="controlset field">';
			echo '<span class="label">Site Offline?</span>';
			echo $this->Form->input('offline', array('type' => 'radio', 'options' => array('No', 'Yes'), 'div' => 'controlset-pad', 'legend' => false, 'separator' => '<br/>'));
		echo '</div>';
		echo $this->Form->input('offline_msg', array('div' => 'field', 'class' => 'large', 'cols' => 20, 'rows' => 4, 'label' => 'Offline message'));
		?><hr/>
		<?php 
		echo $this->Html->tag('h3', 'Shopping Cart Settings');
		echo '<div class="controlset field">';
			echo '<span class="label">Paypal Account</span>';
			echo $this->Form->input('paypal_acc', array('type' => 'text', 'class' => 'xlarge', 'label' => false));
		echo '</div>';
		?><hr/>
		<?php 
		echo $this->Html->tag('h3', 'Debug Settings');
		echo '<div class="controlset field">';
			echo '<span class="label">Debug System</span>';
			echo $this->Form->input('debug', array('type' => 'radio', 'options' => array('No', 'Yes'), 'div' => 'controlset-pad', 'legend' => false, 'separator' => '<br/>'));
		echo '</div>';
		?><hr/>
		<?php 
		echo $this->Html->tag('h3', 'Mail Settings');
		
		echo $this->Form->input('send_email', array('div' => 'field', 'class' => 'large', 'label' => 'Mail from'));
		echo $this->Form->input('send_from', array('div' => 'field', 'class' => 'large', 'label' => 'From name'));
		echo '<div class="controlset field">';
			echo '<span class="label">Use SMTP?</span>';
			echo $this->Form->input('smtp', array('type' => 'radio', 'options' => array('No', 'Yes'), 'div' => 'controlset-pad', 'legend' => false, 'separator' => '<br/>'));
		echo '</div>';
		echo $this->Form->input('smtp_port', array('div' => 'field', 'class' => 'small', 'label' => 'SMTP Port'));
		echo $this->Form->input('smtp_host', array('div' => 'field', 'class' => 'large', 'label' => 'SMTP Host'));
		echo $this->Form->input('smtp_username', array('div' => 'field', 'class' => 'medium', 'label' => 'SMTP Username'));
		echo $this->Form->input('smtp_password', array('div' => 'field', 'class' => 'medium', 'type' => 'password', 'label' => 'SMTP Password'));
		echo $this->Form->input('smtp_client', array('div' => 'field', 'class' => 'medium', 'label' => 'SMTP Client Helo'));
		?><hr/>
		<br class="clear"/>
		<div class="buttonrow">
		<?php
		echo $this->Form->submit('Save', array('class'=>'btn', 'div' => false)); 
		echo $this->Html->link('Cancel', '/admin/config/cancel', array('class' => 'btn btn-orange'));
		?>
		</div>
		<?php echo $this->Form->end(); ?>
	</div>
</div>