<?php $this->Html->addCrumb('Categories', ''); ?>
<div class="main-content">
	<div class="column x12">
		<div class="header"><h2>Categories</h2></div>
		<div class="content">
		<?php if(!empty($categories)){ ?>
			<ul class="results-list">
		<?php foreach($categories as $c){ ?>
		<?php $_category_link = '/c/' . $c['Category']['id'] . '/' . str_replace(' ', '-', $c['Category']['title']);?>
				<li>
				<?php if(!empty($c['Category']['image'])){ echo $this->Html->link($this->resize->image('categories/' . $c['Category']['image'], 140, 140, array('alt' => $c['Category']['title'])), $_category_link, array('escape' => false));}?>
				<div class="product-detail">
				<?php echo $this->Html->tag('h2', $c['Category']['title'], array('class' => 'product'));?>
				</div>
				<?php echo $this->Html->link('View', $_category_link, array('class' => 'btn', 'escape' => false));?>
				<br class="clear"/>
				</li>
		<?php } ?>
			</ul>
		<?php } ?>
		</div>
	</div>
</div>