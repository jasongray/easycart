<?php

class ContactController extends AppController{
	
	var $name = 'Contact';

	var $components = array('Email');
	
	function beforeFilter() {
	    parent::beforeFilter();
		$this->Auth->allowedActions = array('index'); 
	}
	
	function index(){
		
		if(isset($this->data)) {
			$this->Contact->set($this->data);
			if ($this->Contact->validates()) {
				//send email using the Email component
				/* SMTP Options 
				$this->Email->smtpOptions = array(
					'port'=>'587', 
					'timeout'=>'30',
					'host' => 'mail.johncogranites.com.au',
					'username'=>'info',
					'password'=>'PzfGMa-m($Pc'
				);
				
				/* Set delivery method 
				$this->Email->delivery = 'smtp';
				*/
				$this->Email->to = array(Configure::read('MySite.send_from') . '<' . Configure::read('MySite.send_email') . '> ');  
				$this->Email->bcc = array('jason@webwidget.com.au');  
				$this->Email->subject = $this->data['Contact']['subject'];
				$this->Email->from = $this->data['Contact']['name'] . '<' . $this->data['Contact']['email'] . '> ';
				$_message = $this->data['Contact']['message'];
				$_message .= "\n\nFrom: " . $this->data['Contact']['name'];
				$_message .= "\nEmail: " . $this->data['Contact']['email'];
				$_message .= "\nIP Address: " . $_SERVER['REMOTE_ADDR'];
				$_message .= "\nDate: " . date('d-M-Y H:i');
				if($this->Email->send($_message)){	
					unset($this->data);
					$this->Session->setFlash('Thanks for contacting us. Your message has been sent.', 'flash_success');
				}else{
					$this->Session->setFlash('Unable to send the email at this time.<br/>' . $this->Email->smtpError, 'flash_error');
				}
			}else{
				$this->Session->setFlash('Please correct any errors before continuing.', 'flash_error');
			}
			
		}
		
		$this->loadModel('Page');
		$p = $this->Page->find('first', array('conditions' => array('Page.class'=>'contact')));
		if($p){
			$title_for_layout = $p['Page']['title'];
			$path = (!empty($p['Page']['template']))? array($p['Page']['template']): array($page);
			$this->set(compact('p', 'title_for_layout'));
		}else{
			$title_for_layout = $p['Page']['title'] = 'Contact Us';
			$p['Page']['content'] = '';
			$this->set(compact('p', 'title_for_layout'));
		}
		
	}
}
