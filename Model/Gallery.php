<?php
class Gallery extends AppModel {
	var $name = 'Gallery';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $hasMany = array(
		'Image' => array(
			'className' => 'Image',
			'foreignKey' => 'gallery_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => 'ordering ASC',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);
}
?>