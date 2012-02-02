<?php
if(!empty($this->data['MenuItem']['id'])){
	$_title = __('Edit Menu Item', true) . ' :: ' . $this->data['MenuItem']['title'];
}else{
	$_title = __('Add Menu Item', true);
}
?>
<?php echo $form->create('MenuItem', array('id'=>'adminForm', 'class' => 'form label-inline'));?>
	<div class="portlet x6">
		<div class="portlet-header">
			<h4><?php echo __('Menu Information', true);?></h4>
		</div>
		<div class="portlet-content">
		<?php
			echo $this->Form->input('title', array('div' => 'field'));
			echo $this->Form->input('class', array('div' => 'field', 'label' => 'Menu class attribute'));
			echo $this->Form->input('published', array('label' => '', 'div' => 'controlset field', 'type' => 'checkbox', 'before' => '<span class="label">Publish Content</span>'));
			echo $this->Form->input('parent', array('div' => 'field', 'label' => 'Parent', 'options' => $parents, 'selected' => $this->data['MenuItem']['parent'], 'empty' => ''));
			echo $this->Form->input('menu_id', array('div' => 'field', 'label' => 'Menu selection', 'options' => $menus, 'selected' => $this->passedArgs['menu_id'], 'empty' => ''));
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
				echo $this->Form->submit('Save', array('class'=>'btn', 'div' => false)); 
				echo $this->Html->link('Cancel', '/admin/menuItems/cancel/menu_id:'.$this->passedArgs['menu_id'], array('class' => 'btn btn-orange'));
				if(!empty($this->data['MenuItem']['id'])){
					echo $this->Html->link('Delete', '/admin/menuItems/delete/' . $this->data['MenuItem']['id'] . '/menu_id:' . $this->passedArgs['menu_id'], array('class' => 'btn btn-grey'));
				}
			?>	
			</div>
		</div>
	</div>
	<div class="portlet x6">
		<div class="portlet-header">
			<h4><?php echo __('Menu Parameters', true);?></h4>
		</div>
		<div class="portlet-content">
			<?php
				echo $this->Form->input('controller', array('div' => 'field', 'label' => 'Select link', 'options' => $links, 'selected' => $this->data['MenuItem']['controller'], 'empty' => ''));
				echo $this->Form->input('action', array('div' => 'field', 'label' => 'Select page', 'options' => $slugs, 'selected' => $this->data['MenuItem']['slug'], 'empty' => '', 'type' => 'select'));
			?>
			<hr/>
			<?php echo $this->Form->input('url', array('div' => 'field', 'class' => 'xlarge'));?>
		</div>
	</div>
<?php 	echo $form->end(); ?>
<?php echo $this->Html->scriptBlock("
$(document).ready(function(){
	$('#MenuItemController').change(function(){
		var method = $(this).val();
		if(method!=''){
			$.ajax({
				type:'GET',
				cache:false,
				url:_baseurl+'admin/menuItems/getViews/method:'+method,
				success:function(html){
					$('#MenuItemAction').html(html);
				}
			});
		}
		return false;
	});
});
" , array('inline' => false));?>
