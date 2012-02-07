<?php $this->pageClass = 'menus';?>
<?php $paginator->options(array('url' => $this->passedArgs)); ?>
<div class="portlet x12">
<div class="portlet-header">
<h4><?php echo __('Menu Items');?></h4>
</div>
<div class="portlet-content">
<div class="dataTables_wrapper">
<div class="dataTables_length">
</div>
<div class="dataTables_filter">
<?php echo $this->Html->link('<span></span> Add Items', '/admin/menuItems/add/menu_id:'.$this->passedArgs['menu_id'], array('class'=>'btn-icon btn-teal btn-plus', 'escape' => false))?>
</div>
	<table cellpadding="0" cellspacing="0" id="adminForm" class="display">
		<thead>
			<th class="icon">Id</th>
			<th class="icon">Published</th>
			<th><?php echo $this->Paginator->sort('Title', 'title');?></th>
			<th colspan="2">Ordering</th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
		</tr>
		</thead>
		<tbody>
		<?php
		$k = 1;
		for($i=0;$i<count($menuItems);$i++){ 
			$menu = $menuItems[$i];
		?>
		<tr class="rowcontent<?php echo $k;?>">
		<td><?php echo $this->Html->link($menu['MenuItem']['id'], '/admin/menuItems/edit/' . $menu['MenuItem']['id'] . '/menu_id:' . $this->passedArgs['menu_id'], array('class'=>'edit-link'));?></td>
		<td><?php if($menu['MenuItem']['published'] == 1){$_er='';}else{$_er='un';} 
			echo $this->Html->image('gr_'.$_er.'published.png', array('alt'=>$_er.'published'));?></td>
		<td><?php echo $this->Html->link($menu['MenuItem']['treename'], '/admin/menuItems/edit/' . $menu['MenuItem']['id'] . '/menu_id:' . $this->passedArgs['menu_id'], array('escape' => false)); ?></td>
		<td><?php if($i != 0){ echo $this->Html->link($this->Html->image('admin/up_alt.png'), '/admin/menuItems/orderup/' . $menu['MenuItem']['id'] . '/menu_id:' . $this->passedArgs['menu_id'], array('escape'=>false));}?></td>
		<td><?php if($i < count($menuItems) - 1){ echo $this->Html->link($this->Html->image('admin/down_alt.png'), '/admin/menuItems/orderdown/' . $menu['MenuItem']['id'] . '/menu_id:' . $this->passedArgs['menu_id'], array('escape'=>false));}?></td>
		<td class="dates"><?php echo $menu['MenuItem']['created']; ?></td>
		<td class="dates"><?php echo $menu['MenuItem']['modified']; ?></td>
		<td class="actions">
			<?php echo $this->Html->link($this->Html->image('gr_edit.png', array('alt' => 'Edit')), array('action' => 'edit', $menu['MenuItem']['id'] . '/menu_id:' . $this->passedArgs['menu_id']), array('escape' => false)); ?>
			<?php echo $this->Html->link($this->Html->image('gr_delete.png', array('alt' => 'Delete')), array('action' => 'delete', $menu['MenuItem']['id'] . '/menu_id:' . $this->passedArgs['menu_id']), array('escape' => false), null, sprintf(__('Are you sure you want to delete # %s?'), $menu['MenuItem']['id'])); ?>
		</td>
	</tr>
	<?php $k = 1 - $k;
	} 
	?>
	</table>
	<div class="dataTables_info"><?php echo $this->Paginator->counter(array('format' => __('Page %page% of %pages%')));?></div>
	<div class="dataTables_paginate paging_two_button">
		<?php echo $paginator->prev('', array('tag' => 'div', 'class' => 'paginate_enabled_previous'), NULL, array('tag' => 'div', 'class' => 'paginate_disabled_previous'));?>
		<?php echo $paginator->next('', array('tag' => 'div', 'class' => 'paginate_enabled_next'), NULL, array('tag' => 'div', 'class' => 'paginate_disabled_next'));?>
	</div>
</div>
</div>
</div>