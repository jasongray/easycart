<?php

class Contact extends AppModel {
	
	var $useTable = false;  // Not using the database, of course.

	// All the fancy validation you could ever want.
	var $validate = array(
	    'name' => array(
	        'rule' => '/.+/',
			'allowEmpty' => false,
	        'required' => true,
	    ),
		'subject' => array(
	        'rule' => '/.+/',
			'allowEmpty' => false,
	        'required' => true,
	    ),
		'email' => array(
	        'rule' => 'email',
			'message' => 'Please enter a valid email address',
	        'required' => true,
	    ),
	);

	// This is where the magic happens
	function schema() {
		return array (
			'name' => array('type' => 'string', 'length' => 60),
			'email' => array('type' => 'string', 'length' => 60),
			'message' => array('type' => 'text', 'length' => 2000),
			'subject' => array('type' => 'string', 'length' => 100),
		);
	}
}
