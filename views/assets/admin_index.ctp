<?php $this->pageClass = 'assets';?>
<?php $paginator->options(array('url' => $this->passedArgs)); ?>
<?php echo $form->create('Asset', array('id'=>'adminForm', 'class' => 'form label-inline', 'type' => 'file', 'url' => '/admin/assets/add'));?>
<div class="portlet x8">
	<div class="portlet-header">
		<h4><?php echo __('Assets', true);?></h4>
	</div>
	<div class="portlet-content">
	<?php if( $files ){ ?>
		<table cellpadding="0" cellspacing="0" id="adminForm" class="display">
			<thead>
			<tr>
				<th>&nbsp;</th>
				<th><?php echo $this->Paginator->sort('title');?></th>
				<th><?php echo __('File Type');?></th>
				<th class="actions"><?php __('Actions');?></th>
			</tr>
			</thead>
			<tbody>
		<?php 
		$k = 1;
		for($i=0;$i<count($files);$i++){ 
			$f = $files[$i]; ?>
			<tr class="rowcontent<?php echo $k;?>">
				<td><?php 
			if( strstr($f['Asset']['mime'], 'image') ){ 
				echo $this->resize->image(array('full' => $f['Asset']['fullpath']), 30, 30, true);
			} else {
				echo $this->resize->image('media-icons/'.$this->XHtml->iconImage($f['Asset']['mime']).'.png', 30, 30, true);
			}?></td>
				<td><?php echo $f['Asset']['title'];?></td>
				<td><?php echo strtoupper($this->XHtml->iconImage($f['Asset']['mime']));?></td>
				<td class="actions">	
					<?php echo $this->Html->link($this->Html->image('gr_edit.png', array('alt' => 'Edit')), array('action' => 'edit', $f['Asset']['id']), array('escape' => false)); ?>
					<?php echo $this->Html->link($this->Html->image('gr_delete.png', array('alt' => 'Delete')), array('action' => 'delete', $f['Asset']['id']), array('escape' => false), null, sprintf(__('Are you sure you want to delete # %s?', true), $f['Asset']['id'])); ?>
				</td>
			</tr>
		<?php } ?>	
		</table>
	<?php } ?>
		<div class="dataTables_info"><?php echo $this->Paginator->counter(array('format' => __('Page %page% of %pages%', true)));?></div>
		<div class="dataTables_paginate paging_two_button">
			<?php echo $paginator->prev('', array('tag' => 'div', 'class' => 'paginate_enabled_previous'), NULL, array('tag' => 'div', 'class' => 'paginate_disabled_previous'));?>
			<?php echo $paginator->next('', array('tag' => 'div', 'class' => 'paginate_enabled_next'), NULL, array('tag' => 'div', 'class' => 'paginate_disabled_next'));?>
		</div>
	</div>
</div>
<?php echo $this->element('form-asset-add');?>
<?php echo $form->end();?>