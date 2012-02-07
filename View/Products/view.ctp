<?php $this->Html->addCrumb('Categories', array('controller' => 'categories', 'action' => 'index')); ?>
<?php $this->Html->addCrumb($product['Category']['title'], array('controller' => 'categories', 'action' => 'view', $product['Category']['id'], 'title' => str_replace(' ', '-', $product['Category']['title']))); ?>
<?php $this->Html->addCrumb($product['Product']['title'], ''); ?>
<div class="x12">
	<div class="inner">
		<div class="header"><h2><?php echo $product['Product']['title'];?></h2></div>
		<div class="content">
			<?php if(!empty($product['Product']['image'])){ echo $this->resize->image('products/'.$product['Product']['image'], 400, 400, true, array('class' => 'product-image')); } ?>
			<div class="cart-wrapper">
				<?php echo $this->Html->tag('h4', $product['Product']['title']);?>
				<?php echo $this->Html->tag('h5', $this->Html->link($product['Category']['title'], array('controller' => 'categories', 'action' => 'view', $product['Category']['id'], 'title' => str_replace(' ', '-', $product['Category']['title']))));?>
				<span class="price">$<?php echo preg_replace('/\.[0-9]+/', '<span class="price-cents">$0</span>', number_format($product['Product']['price'], 2)); ?></span>
				<?php if($product['Product']['allow_cart'] == 1){?>
				<form target="paypal" action="https://www.paypal.com/cgi-bin/webscr" method="post">
				<div class="input">
					<label for="s-qty">Qty:</label>
					<input type="text" name="quantity" id="s-qty" value="1" class="mini"/>
				</div>
				<div class="input">
					<input type="submit" id="SubmitName" class="btn" value="Add to Cart" />
					<input type="hidden" name="cmd" value="_cart"/>
					<input type="hidden" name="business" value="<?php echo Configure::read('MySite.paypal_acc');?>"/>
					<input type="hidden" name="lc" value="AU"/>
					<input type="hidden" id="item_name" name="item_name" value="<?php echo $product['Product']['title'];?>"/>
					<input type="hidden" id="item_number" name="item_number" value="<?php echo $product['Product']['sku'];?>"/>
					<input type="hidden" id="amount" name="amount" value="<?php echo $product['Product']['price'];?>"/>
					<input type="hidden" name="currency_code" value="AUD"/>
					<input type="hidden" name="cn" value="Add special instructions to the seller"/>
					<input type="hidden" name="no_shipping" value="2"/>
					<input type="hidden" name="weight_unit" value="kgs"/>
					<input type="hidden" name="add" value="1"/>
					<input type="hidden" name="return" value="http://boatsignsonline.com.au"/>
					<input type="hidden" name="cancel_return" value="http://boatsignsonline.com.au<?php echo $this->here;?>"/>
				</div>
				</form>
				<?php } ?>
			</div>
			<div class="content-text">
				<?php echo $this->Html->tag('h3', 'Product Description');?>
				<?php echo $product['Product']['description'];?>
			</div>
		</div>
	</div>
</div>