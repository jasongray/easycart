<?php $this->pageClass = 'users';?>
<?php echo $form->create('User', array('id'=>'adminForm', 'class' => 'form label-inline', 'type' => 'file'));?>
<div class="portlet x8">
<div class="portlet-header">
<h4><?php echo __('Create User');?></h4>
</div>
<div class="portlet-content">
<?php echo $this->element('form-users');?>
</div>
</div>
<?php echo $this->element('form-users-avatar');?>
<?php echo $form->end();?>