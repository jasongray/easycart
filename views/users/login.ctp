<?php echo $this->Form->create('User', array('id'=>'login_form'));?>
<div class="contnt_front">
	<div class="pad">
		<?php echo $this->Session->flash('auth', true, array('class'=>'notification failure'));?>
		<?php echo $this->Session->flash();?>
		<div class="field">
			<label>Username:</label>
			<div class=""><span class="input">
			<?php echo $this->Form->input('username', array('div'=>false,'label'=>false,'class'=>'text','id'=>'login_username'));?>
			</span></div>
		</div>
		<div class="field">
			<label>Password:</label>
			<div class=""><span class="input">
			<?php echo $this->Form->input('password', array('div'=>false,'label'=>false,'class'=>'text')); //,'id'=>'login_password'));?>
			<?php /* <a style="" href="javascript:;" id="forgot_my_password">Forgot password?</a> */ ?>
			</span></div>
		</div>
		<div class="field">
			<span class="label">&nbsp;</span>
			<div class="">
			<?php echo $this->Form->button('Login', array('div'=>false, 'class'=>'btn')); ?>
			</div>
		</div>
	</div>
</div>
<?php
echo $this->Form->end();
?>