<?php $this->pageClass = 'news';?>
<?php $paginator->options(array('url' => $this->passedArgs)); ?>
<div class="portlet x12">
<div class="portlet-header">
<h4><?php echo __('News Articles', true);?></h4>
</div>
<div class="portlet-content">
	<div class="dataTables_filter">
	<?php echo $this->Html->link('<span></span> Add Article', '/admin/news/add', array('class'=>'btn-icon btn-blue btn-plus', 'escape' => false))?>
	</div>
	<table cellpadding="0" cellspacing="0" id="adminForm" class="display">
		<thead>
			<th class="icon">Status</th>
			<th class="icon">Published</th>
			<th><?php echo $this->Paginator->sort('Article title', 'title');?></th>
			<th><?php echo $this->Paginator->sort('author');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th class="actions"><?php __('Actions');?></th>
		</tr>
		</thead>
		<tbody>
		<?php
		$k = 1;
		for($i=0;$i<count($news);$i++){ 
			$article = $news[$i];
		?>
		<tr class="rowcontent<?php echo $k;?>">
			<td><?php echo $this->Html->link($article['News']['id'], '/admin/pages/edit/'.$article['News']['id'], array('class'=>'edit-link'));?></td>
			<td><?php if($article['News']['published'] == 1){$_er='';}else{$_er='un';} 
				echo $this->Html->image('gr_'.$_er.'published.png', array('alt'=>$_er.'published'));?></td>
		<td><?php echo $this->Html->link($article['News']['title'], '/admin/news/edit/'.$article['News']['id']); ?></td>
		<td><?php echo $article['News']['author']; ?></td>
		<td class="dates"><?php echo $article['News']['created']; ?></td>
		<td class="dates"><?php echo $article['News']['modified']; ?></td>
		<td class="actions">
			<?php echo $this->Html->link($this->Html->image('gr_edit.png', array('alt' => 'Edit')), array('action' => 'edit', $article['News']['id']), array('escape' => false)); ?>
			<?php echo $this->Html->link($this->Html->image('gr_delete.png', array('alt' => 'Delete')), array('action' => 'delete', $article['News']['id']), array('escape' => false), null, sprintf(__('Are you sure you want to delete # %s?', true), $article['News']['id'])); ?>
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