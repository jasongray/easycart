<?php $this->pageClass = 'categories';?>
<?php echo $form->create('Category', array('id'=>'adminForm', 'class' => 'form label-inline', 'type' => 'file'));?>
<div class="portlet x8">
<div class="portlet-header">
<h4>Add Category</h4>
</div>
<div class="portlet-content">
<?php echo $this->element('form-category');?>
</div>
</div>
<?php echo $this->element('form-category-avatar');?>
<?php echo $form->end();?>