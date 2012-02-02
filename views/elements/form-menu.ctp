<?php
if(!empty($this->data['Group']['id'])){
	$_title = __('Edit Group', true) . ' :: ' . $this->data['Group']['name'];
}else{
	$_title = __('Add Group', true);
}
?>
<?php echo $form->create('Menu', array('id'=>'adminForm', 'class' => 'form label-inline'));?>
	<div class="portlet x4">
		<div class="portlet-header">
			<h4><?php echo __('Menu Information', true);?></h4>
		</div>
		<div class="portlet-content">
		<?php
			echo $this->Form->input('title', array('div' => 'field'));
			echo $this->Form->input('unique', array('div' => 'field'));
			echo $this->Form->input('published', array('label' => '', 'div' => 'controlset field', 'type' => 'checkbox', 'before' => '<span class="label">Publish Content</span>'));
		?>
			<br class="clear"/>
			<div class="buttonrow">
			<?php
				echo $this->Form->hidden('id');
				echo $this->Form->submit('Save', array('class'=>'btn', 'div' => false)); 
				echo $this->Html->link('Cancel', '/admin/menus/cancel', array('class' => 'btn btn-orange'));
				if(!empty($this->data['Menu']['id'])){
					echo $this->Html->link('Delete', '/admin/menus/delete/'.$this->data['Menu']['id'], array('class' => 'btn btn-grey'));
				}
			?>	
			</div>
		</div>
	</div>
<?php 	echo $form->end(); ?>