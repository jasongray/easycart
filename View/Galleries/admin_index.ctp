<?php $this->pageClass = 'galleries';?>
<?php $paginator->options(array('url' => $this->passedArgs)); ?>
<div class="portlet x12">
<div class="portlet-header">
<h4><?php echo __('Galleries');?></h4>
</div>
<div class="portlet-content">
<div class="dataTables_wrapper">
<div class="dataTables_filter">
<?php echo $this->Html->link('<span></span> Create Gallery', '/admin/galleries/add', array('class'=>'btn-icon btn-teal btn-plus', 'escape' => false))?>
</div>
	<table cellpadding="0" cellspacing="0" id="adminForm" class="display">
		<thead>
			<th class="icon">Id</th>
			<th class="icon">Published</th>
			<th><?php echo $this->Paginator->sort('Title', 'title');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
		</tr>
		</thead>
		<tbody>
		<?php
		$k = 1;
		for($i=0;$i<count($galleries);$i++){ 
			$g = $galleries[$i];
		?>
		<tr class="rowcontent<?php echo $k;?>">
		<td class="dates"><?php echo $this->Html->link($g['Gallery']['id'], '/admin/menus/edit/'.$g['Gallery']['id'], array('class'=>'edit-link'));?></td>
		<td class="dates"><?php if($g['Gallery']['published'] == 1){$_er='';}else{$_er='un';} 
			echo $this->Html->image('gr_'.$_er.'published.png', array('alt'=>$_er.'published'));?></td>
		<td><?php echo $this->Html->link($g['Gallery']['title'], '/admin/galleries/edit/'.$g['Gallery']['id']); ?></td>
		<td class="dates"><?php echo $g['Gallery']['created']; ?></td>
		<td class="dates"><?php echo $g['Gallery']['modified']; ?></td>
		<td class="actions">
			<?php echo $this->Html->link($this->Html->image('gr_edit.png', array('alt' => 'Edit')), array('action' => 'edit', $g['Gallery']['id']), array('escape' => false)); ?>
			<?php echo $this->Html->link($this->Html->image('gr_delete.png', array('alt' => 'Delete')), array('action' => 'delete', $g['Gallery']['id']), array('escape' => false), null, sprintf(__('Are you sure you want to delete # %s?'), $g['Gallery']['id'])); ?>
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