<?php if(!empty($featured)){ ?>
<div class="x12">
	<div class="inner">
		<div class="header"><h4>Featured Products</h4></div>
		<div class="content">
			<ul class="product-list">
	<?php for($i=0;$i<count($featured);$i++){ 
		$c = $featured[$i];
		$_class = is_int($i/3)? ' class="first"': '';
	?>
		<li<?php echo $_class;?>>
		<?php if($c['Product']['allow_details'] == 1){?>
		<?php echo $this->Html->tag('h2', $this->Html->link($c['Product']['title'], array('controller' => 'products', 'action' => 'view', $c['Product']['id'], 'title' => str_replace(' ', '-', $c['Product']['title']))), array('class' => 'product'));?>
		<?php if(!empty($c['Product']['image'])){ echo $this->Html->link($this->resize->image('products/' . $c['Product']['image'], 100, 100, true, array('alt' => $c['Product']['title'], 'class' => 'image-link')), array('controller' => 'products', 'action' => 'view', $c['Product']['id'], 'title' => str_replace(' ', '-', $c['Product']['title'])), array('escape' => false));}?>
		<?php }else{ ?>
		<?php echo $this->Html->tag('h2', $c['Product']['title'], array('class' => 'product'));?>
		<?php if(!empty($c['Product']['image'])){ echo $this->resize->image('products/' . $c['Product']['image'], 100, 100, array('alt' => $c['Product']['title']), array('class' => 'image-link', 'escape' => false));}?>
		<?php } ?>	
		<div class="product-details">
		<?php echo $this->Html->tag('h5', $this->Html->link($c['Category']['title'], array('controller' => 'categories', 'action' => 'view', $c['Category']['id'], 'title' => str_replace(' ', '-', $c['Category']['title']))));?>
		<?php echo stripslashes($c['Product']['introtext']);?>
		<?php if($c['Product']['allow_cart'] == 1){?>
		<span class="price">$<?php echo preg_replace('/\.[0-9]+/', '<span class="price-cents">$0</span>', number_format($c['Product']['price'], 2)); ?></span>
		<form target="paypal" action="https://www.paypal.com/cgi-bin/webscr" method="post">
		<input type="submit" id="SubmitName" class="btn" value="Add to Cart" />
		<input type="hidden" name="cmd" value="_cart"/>
		<input type="hidden" name="business" value="<?php echo Configure::read('MySite.paypal_acc');?>"/>
		<input type="hidden" name="lc" value="AU"/>
		<input type="hidden" id="item_name" name="item_name" value="<?php echo $c['Product']['title'];?>"/>
		<input type="hidden" id="item_number" name="item_number" value="<?php echo $c['Product']['sku'];?>"/>
		<input type="hidden" id="amount" name="amount" value="<?php echo $c['Product']['price'];?>"/>
		<input type="hidden" name="currency_code" value="AUD"/>
		<input type="hidden" name="cn" value="Add special instructions to the seller"/>
		<input type="hidden" name="no_shipping" value="2"/>
		<input type="hidden" name="weight_unit" value="kgs"/>
		<input type="hidden" name="add" value="1"/>
		<input type="hidden" name="return" value="http://boatsignsonline.com.au"/>
		<input type="hidden" name="cancel_return" value="http://boatsignsonline.com.au<?php echo $this->here;?>"/>
		</form>
		<?php } ?>
		<?php if($c['Product']['allow_details'] == 1){?>
		<?php echo $this->Html->para(false, $this->Html->link('View More &raquo;', array('controller' => 'products', 'action' => 'view', $c['Product']['id'], 'title' => str_replace(' ', '-', $c['Product']['title'])), array('escape' => false)));?>
		<?php } ?>
		<br class="clear"/>
		</div>
		</li>
<?php } ?>
	</ul>
	</div>
</div>
<?php } ?>