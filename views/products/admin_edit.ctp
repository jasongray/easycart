<?php $this->pageClass = 'products';?>
<?php echo $form->create('Product', array('id'=>'adminForm', 'class' => 'form label-inline', 'type' => 'file'));?>
<div class="portlet x8">
<div class="portlet-header">
<h4>Edit Product :: <?php echo $this->data['Product']['title'];?></h4>
</div>
<div class="portlet-content">
<?php echo $this->element('form-products');?>
</div>
</div>
<?php echo $this->element('form-products-avatar');?>
<?php echo $form->end();?>