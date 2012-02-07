<?php
class Menu extends AppModel {
	var $name = 'Menu';
	var $displayField = 'title';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $hasMany = array(
		'MenuItem' => array(
			'className' => 'MenuItem',
			'foreignKey' => 'menu_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);
	
	var $validate = array(
		'unique' => array(
			'unique-rule1' => array(
				'rule' => 'notEmpty',
				'message' => 'Please create a unique name for the menu.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'unique-rule2' => array(
				'rule' => 'isUnique',
				'message' => 'Please create a unique name for the menu.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				'on' => 'create', // Limit validation to 'create' or 'update' operations
			)
		)
	);

}
?>