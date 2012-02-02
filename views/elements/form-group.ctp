<?php
if(!empty($this->data['Group']['id'])){
	$_title = __('Edit Group', true) . ' :: ' . $this->data['Group']['name'];
}else{
	$_title = __('Add Group', true);
}
?>
<?php echo $form->create('Group', array('id'=>'adminForm', 'class' => 'form label-inline'));?>
	<div class="portlet x4">
		<div class="portlet-header">
			<h4><?php echo __('Group Information', true);?></h4>
		</div>
		<div class="portlet-content">
		<?php
			echo $this->Form->input('name', array('div' => 'field'));
		?>
			<br class="clear"/>
			<div class="buttonrow">
			<?php
				echo $this->Form->hidden('id');
				echo $this->Form->submit('Save', array('class'=>'btn', 'div' => false)); 
				echo $this->Html->link('Cancel', '/admin/groups/cancel', array('class' => 'btn btn-orange'));
				if(!empty($this->data['Group']['id'])){
					echo $this->Html->link('Delete', '/admin/groups/delete/'.$this->data['Group']['id'], array('class' => 'btn btn-grey'));
				}
			?>	
			</div>
		</div>
	</div>
<?php 	echo $form->end(); ?>