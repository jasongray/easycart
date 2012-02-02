<?php $this->pageClass = 'pages';?>
<?php $paginator->options(array('url' => $this->passedArgs)); ?>
<div class="portlet x12">
<div class="portlet-header">
<h4><?php echo __('Content', true);?></h4>
</div>
<div class="portlet-content">
<div class="dataTables_wrapper">
<div class="dataTables_length">
</div>
<div class="dataTables_filter">
<?php echo $this->Html->link('<span></span> Add Content', '/admin/pages/add', array('class'=>'btn-icon btn-teal btn-plus', 'escape' => false))?>
</div>
	<table cellpadding="0" cellspacing="0" id="adminForm" class="display">
		<thead>
			<th class="icon">Id</th>
			<th class="icon">Published</th>
			<th><?php echo $this->Paginator->sort('Content title', 'title');?></th>
			<th><?php echo $this->Paginator->sort('Front Page', 'front_page');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th class="actions"><?php __('Actions');?></th>
		</tr>
		</thead>
		<tbody>
		<?php
		$k = 1;
		for($i=0;$i<count($pages);$i++){ 
			$page = $pages[$i];
		?>
		<tr class="rowcontent<?php echo $k;?>">
		<td><?php echo $this->Html->link($page['Page']['id'], '/admin/pages/edit/'.$page['Page']['id'], array('class'=>'edit-link'));?></td>
		<td><?php if($page['Page']['published'] == 1){$_er='';}else{$_er='un';} 
			echo $this->Html->image('gr_'.$_er.'published.png', array('alt'=>$_er.'published'));?></td>
		<td><?php echo $this->Html->link($page['Page']['title'], '/admin/pages/edit/'.$page['Page']['id']); ?></td>
		<td><?php if($page['Page']['front_page'] == 1){ echo $this->Html->image('gr_featured.png', array('alt'=>'Featured'));}?></td>
		<td class="dates"><?php echo $page['Page']['created']; ?></td>
		<td class="dates"><?php echo $page['Page']['modified']; ?></td>
		<td class="actions">
			<?php echo $this->Html->link($this->Html->image('gr_edit.png', array('alt' => 'Edit')), array('action' => 'edit', $page['Page']['id']), array('escape' => false)); ?>
			<?php echo $this->Html->link($this->Html->image('gr_delete.png', array('alt' => 'Delete')), array('action' => 'delete', $page['Page']['id']), array('escape' => false), null, sprintf(__('Are you sure you want to delete # %s?', true), $page['Page']['id'])); ?>
		</td>
	</tr>
	<?php $k = 1 - $k;
	} 
	?>
	</table>
	<div class="dataTables_info"><?php echo $this->Paginator->counter(array('format' => __('Page %page% of %pages%', true)));?></div>
	<div class="dataTables_paginate paging_two_button">
		<?php echo $paginator->prev('', array('tag' => 'div', 'class' => 'paginate_enabled_previous'), NULL, array('tag' => 'div', 'class' => 'paginate_disabled_previous'));?>
		<?php echo $paginator->next('', array('tag' => 'div', 'class' => 'paginate_enabled_next'), NULL, array('tag' => 'div', 'class' => 'paginate_disabled_next'));?>
	</div>
</div>
</div>
</div>