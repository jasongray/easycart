<?php
class User extends AppModel {
	
	var $name = 'User';
	var $displayField = 'username';
	var $actsAs = array('Acl' => array('type' => 'requester'));

	var $belongsTo = array(
		'UserStatus' => array(
			'className' => 'UserStatus',
			'foreignKey' => 'user_status_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Group' => array(
			'className' => 'Group',
			'foreignKey' => 'group_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
	
	function parentNode() {
	    if (!$this->id && empty($this->data)) {
	        return null;
	    }
	    if (isset($this->data['User']['group_id'])) {
		$groupId = $this->data['User']['group_id'];
	    } else {
	    	$groupId = $this->field('group_id');
	    }
	    if (!$groupId) {
		return null;
	    } else {
	        return array('Group' => array('id' => $groupId));
	    }
	}

	function beforeSave(){
		parent::beforeSave();
		if (isset($this->data['User']['password']) && $this->data['User']['password'] == 'bdcea2f511a10c8464d67af5b7efce5855f84e81'){
			// remove the blank hashed password!
			unset($this->data['User']['password']);
		}
		return true;
	}
	/*
	function hashPasswords($data) {
		if (isset($data['User']['password'])) {
			$salt = Configure::read('Security.salt');
			$blowfish_salt = '$2a$07$'.$salt.'$';
			$data['User']['password'] = crypt($data['User']['password'], $blowfish_salt);
			return $data;
		}
		return $data;
	}
	*/
}
?>