<?php $this->pageClass = 'users';?>
<?php $_name = (empty($this->data['User']['firstname']) || empty($this->data['User']['surname']))? $this->data['User']['username']: implode(' ', array($this->data['User']['firstname'], $this->data['User']['surname']));?>
<?php echo $form->create('User', array('id'=>'adminForm', 'class' => 'form label-inline', 'type' => 'file'));?>
<div class="portlet x8">
<div class="portlet-header">
<h4>Edit User :: <?php echo $_name;?></h4>
</div>
<div class="portlet-content">
<?php echo $this->element('form-users');?>
</div>
</div>
<?php echo $this->element('form-users-avatar');?>
<?php echo $form->end();?>