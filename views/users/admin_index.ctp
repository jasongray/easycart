<?php $this->pageClass = 'users';?>
<?php $paginator->options(array('url' => $this->passedArgs)); ?>
<div class="portlet x12">
<div class="portlet-header">
<h4><?php __('Users');?></h4>
</div>
<div class="portlet-content">
	<div class="dataTables_filter">
	<?php echo $this->Html->link('<span></span> Add User', '/admin/users/add', array('class'=>'btn-icon btn-green btn-plus', 'escape' => false))?>
	</div>
	<?php if( $users ){?>
	<?php $grp = 0;?>
	<?php foreach( $users as $user ){ ?>
	<?php if($user['Group']['id'] != $grp ){ ?>
		<?php if($grp != 0){?>
	</div>
		<?php } ?>
	<div class="department">
		<h2><?php echo $user['Group']['name'];?></h2>
	<?php } ?>
		<div class="user-card">
			<div class="avatar">
			<?php if( empty($user['User']['image']) ) { 
				echo $this->Html->image('admin/avatar.jpg', array('alt' => ''));
			} else {
				echo $this->resize->image('users/'. $user['User']['image'], 60, 60, false, array('alt' => ''));
			}?>
			</div>
			<div class="details">
				<p><strong><?php echo $user['User']['surname']; ?>, <?php echo $user['User']['firstname']; ?></strong><br/><?php echo $user['User']['mobile']; ?><br/><?php echo $this->XHtml->mailto($user['User']['email']); ?><br/><?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $user['User']['id'])); ?></p>
			</div> 
		</div>
	<?php $grp = $user['Group']['id'];?>
	<?php } ?>
	<?php } ?>
</div>
</div>
</div>
