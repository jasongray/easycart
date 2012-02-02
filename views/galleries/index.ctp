<?php

$this->Html->addCrumb(__('Galleries', true), ''); 

?>

<div class="content-box bx100">

	<div class="inner">

	<div class="header"><h2><?php echo __('Galleries', true);?></h2></div>

	<div class="content">

		<?php if($galleries){ ?>

		<ul id="galleries">

		<?php foreach($galleries as $g){ ?>

			<?php $cnt = (count($g['Image']) > 4)? 'mpl': 'sgl';?>

			<li>

				<div class="gallery-wrapper">

					<?php echo $this->Html->link($this->resize->image('galleries/'.$g['Gallery']['id'].'/'.$g['Image'][0]['file'], 210, 210, true), '/galleries/view/'.$g['Gallery']['id'], array('escape' => false));?>

				</div>
				<span><?php echo $this->Html->link($g['Gallery']['title'], '/galleries/view/'.$g['Gallery']['id']);?><br/><em><?php echo count($g['Image']) . __(' image(s)', true);?></em></span>

			</li>

		<?php } ?>

		</ul>

		<?php } ?>

		<br class="clear"/>

	</div>

	</div>

</div>