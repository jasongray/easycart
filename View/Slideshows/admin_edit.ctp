<?php $this->pageClass = 'slideshow';?>
<?php echo $form->create('Slideshow', array('id'=>'adminForm', 'class' => 'form label-inline', 'type' => 'file'));?>
<div class="portlet x8">
<div class="portlet-header">
<h4>Edit Slideshow</h4>
</div>
<div class="portlet-content">
<?php echo $this->element('form-slideshow');?>
</div>
</div>
<?php echo $this->element('form-slideshow-avatar');?>
<?php echo $form->end();?>