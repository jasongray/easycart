<?php if(!empty($c)){ ?>
<ul class="category-list">
<?php foreach($c as $_c){ ?>
	<li><?php echo $this->Html->link($_c['Category']['title'], array('controller' => 'categories', 'action' => 'view', $_c['Category']['id'], 'title' => str_replace(' ', '-', $_c['Category']['title'])));?></li>
<?php } ?>
</ul>
<?php } ?>