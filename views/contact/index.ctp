<?php $this->Html->addCrumb($p['Page']['title'], '');?>
<div class="x12">
	<?php if( !empty($p['Page']['content'])){ ?>
	<div class="inner">
		<?php if( !empty($p['Page']['show_title']) && $p['Page']['show_title'] == 1 ){ ?>
		<div class="header"><h2><?php echo $p['Page']['title'];?></h2></div>
		<?php } ?>
		<div class="content">
			<?php echo stripslashes($p['Page']['content']);?>
		</div>
		<br class="clear"/>
	</div>
	<?php } ?>
	<div class="inner">
		<div class="header"><h2>Send us an enquiry</h2></div>
		<div class="content">
			<?php
			echo $form->create('Contact', array('url' => '/contact', 'action' => 'index', 'id' => 'ContactIndexForm'));
			echo $form->input('name', array('label' => 'Your name:', 'class' => 'required'));
			echo $form->input('email', array('label' => 'Your email:', 'class' => 'required'));
			echo $form->input('subject', array('label' => 'Subject:', 'class' => 'required'));
			echo $form->input('message', array('label' => 'Your message:', 'cols' => 35, 'rows' => 6));
			echo $form->end('Send');
			?>
		</div>
		<br class="clear"/>
	</div>
</div>