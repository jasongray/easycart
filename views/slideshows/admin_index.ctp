<?php $this->pageClass = 'slideshow';?>
<?php $paginator->options(array('url' => $this->passedArgs)); ?>
<div class="portlet x12">
<div class="portlet-header">
<h4><?php echo __('Slideshows', true);?></h4>
</div>
<div class="portlet-content">
	<div class="dataTables_filter">
	<?php echo $this->Html->link('<span></span> Add Slides', '/admin/slideshows/add', array('class'=>'btn-icon btn-grey btn-plus', 'escape' => false))?>
	</div>
	<table cellpadding="0" cellspacing="0" id="adminForm" class="display">
		<thead>
		<tr>
			<th class="icon">Id</th>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th colspan="2">Ordering</th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th class="actions"><?php __('Actions');?></th>
		</tr>
		</thead>
		<tbody>
		<?php
		$k = 1;
		for($i=0;$i<count($slideshows);$i++){ 
			$s = $slideshows[$i];
		?>
		<tr class="rowcontent<?php echo $k;?>">
			<td><?php echo $this->Html->link($s['Slideshow']['id'], '/admin/slideshows/edit/'.$s['Slideshow']['id'], array('class'=>'edit-link'));?></td>
			<td><?php echo $this->Html->link($s['Slideshow']['name'], '/admin/slideshows/edit/'.$s['Slideshow']['id']);?></td>
			<td><?php if($i != 0){ echo $this->Html->link($this->Html->image('admin/up_alt.png'), '/admin/slideshows/orderup/' . $s['Slideshow']['id'], array('escape'=>false));}?></td>
			<td><?php if($i < count($slideshows) - 1){ echo $this->Html->link($this->Html->image('admin/down_alt.png'), '/admin/slideshows/orderdown/' . $s['Slideshow']['id'], array('escape'=>false));}?></td>
			<td class="dates"><?php echo $s['Slideshow']['created']; ?>&nbsp;</td>
			<td class="dates"><?php echo $s['Slideshow']['modified']; ?>&nbsp;</td>
			<td class="actions">
				<?php echo $this->Html->link($this->Html->image('gr_edit.png', array('alt' => 'Edit')), array('action' => 'edit', $s['Slideshow']['id']), array('escape' => false)); ?>
				<?php echo $this->Html->link($this->Html->image('gr_delete.png', array('alt' => 'Delete')), array('action' => 'delete', $s['Slideshow']['id']), array('escape' => false), null, sprintf(__('Are you sure you want to delete # %s?', true), $s['Slideshow']['id'])); ?>
			</td>
		</tr>
		<?php $k = 1 - $k;
		} 
		?>
		</tbody>
	</table>
	<div class="dataTables_info"><?php echo $this->Paginator->counter(array('format' => __('Page %page% of %pages%', true)));?></div>
	<div class="dataTables_paginate paging_two_button">
		<?php echo $paginator->prev('', array('tag' => 'div', 'class' => 'paginate_enabled_previous'), NULL, array('tag' => 'div', 'class' => 'paginate_disabled_previous'));?>
		<?php echo $paginator->next('', array('tag' => 'div', 'class' => 'paginate_enabled_next'), NULL, array('tag' => 'div', 'class' => 'paginate_disabled_next'));?>
	</div>
</div>
</div>
</div>