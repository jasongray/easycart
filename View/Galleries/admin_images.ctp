<?php if($images){ ?>
	<ul id="sortable-images" class="gallery">
<?php foreach($images as $i){ ?>
		<li id="GImages-<?php echo $i['Gallery']['id'];?>">
			<div class="handle">
			<?php echo $this->resize->image('galleries/'.$this->data['Gallery']['id'].'/'.$i['Image']['file'], 100, 100, true);?>
			</div>
			<div class="actions">
			<?php
			echo $this->Html->link(__('Move'), '#', array('class'=>'btn btn-orange btn-small btn-move', 'escape' => false));
			echo $this->Html->link(__('Delete'), '/admin/galleries/removeImage/' . $i['Image']['id'], array('class'=>'btn btn-red btn-small cancelbtn', 'escape' => false));
			?>
			</div>
		</li>
<?php } ?>
	</ul>
<?php } ?>