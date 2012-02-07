<?php
class Product extends AppModel {
	var $name = 'Product';
	var $displayField = 'title';
	
	var $belongsTo = array(
		'Category' => array(
			'className' => 'Category',
			'foreignKey' => 'category_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
?>