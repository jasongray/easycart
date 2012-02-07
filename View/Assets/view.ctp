<?php $this->Html->addCrumb('Categories', array('controller' => 'categories', 'action' => 'index')); ?>
<?php $this->Html->addCrumb($products[0]['Category']['title'], ''); ?>
<div class="main-content">
	<div class="column x12">
		<div class="header"><h2><?php echo $products[0]['Category']['title']?></h2></div>
		<div class="content">
		<?php if(!empty($products)){ ?>
			<ul class="results-list">
		<?php foreach($products as $p){ ?>
		<?php $_product_link = '/p/' . $p['Product']['id'] . '/' . str_replace(' ', '-', $p['Product']['title']);?>
				<li>
				<?php echo $this->Html->link($this->resize->image('products/' . $p['Product']['image'], 140, 140, array('alt' => $p['Product']['title'])), $_product_link, array('escape' => false));;?>
				<div class="product-detail">
					<?php echo $this->Html->tag('h2', $p['Product']['title'], array('class' => 'product'));?>
					<?php echo $p['Product']['introtext'];?>
				</div>
				<?php echo $this->Html->link('View', $_product_link, array('class' => 'btn', 'escape' => false));?>
				<br class="clear"/>
				</li>
		<?php } ?>
			</ul>
		<?php } ?>
		</div>
	</div>
</div>