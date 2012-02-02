<?php
class TestimonialsController extends AppController {

	var $name = 'Testimonials';
	
	function beforeFilter() {
	    parent::beforeFilter();
		$this->Auth->allowedActions = array('index', 'view', 'genlist');
	}

	function index() {
		$this->Testimonial->recursive = 0;
		$this->paginate = array(
			'conditions' => array(
				'Testimonial.published' => 1),
			'order' => array(
				'Testimonial.event_date DESC'),
			'limit' => 5
		);
		$this->set('t', $this->paginate());
	}
	
	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid testimonials', true), 'flash_error');
			$this->redirect(array('action' => 'index'));
		}
		$this->set('t', $this->Testimonial->find('first', array('conditions' => array(
			'Testimonial.published' => 1,
			'Testimonial.id' => $id))
		));
	}
	
	function genlist(){
		$this->Testimonial->recursive = 0;
		$this->set('t', $this->Testimonial->find('all', array('conditions' => array('Testimonial.published' => 1))));
	}

	function admin_index() {
		$this->Testimonial->recursive = 0;
		$this->paginate = array(
			'order' => array(
				'Testimonial.created DESC'),
			'limit' => 20
		);
		$this->set('t', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid testimonials', true), 'flash_error');
			$this->redirect(array('action' => 'index'));
		}
		$this->set('t', $this->Testimonial->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			App::import('Core', 'Inflector');
			$_alias = (empty($this->data['Testimonial']['slug']))? $this->data['Testimonial']['title']: '';
			$_alias = Inflector::slug($_alias, '-');
			$this->Testimonial->create();
			if ($this->Testimonial->save($this->data)) {
				$this->data['Testimonial']['slug'] = $this->Testimonial->id.'-'.Inflector::slug($_alias, '-');
				$this->Testimonial->saveField('slug', $this->data['Testimonial']['slug']);
				$this->Session->setFlash(__('The testimonial has been saved', true), 'flash_success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The testimonial could not be saved. Please, try again.', true), 'flash_error');
			}
		}
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid testimonial', true), 'flash_error');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			App::import('Core', 'Inflector');
			$this->data['Testimonial']['slug'] = (empty($this->data['Testimonial']['slug']))? $this->data['Testimonial']['id'].'-'.Inflector::slug($this->data['Testimonial']['title'], '-'): $this->data['Testimonial']['slug'];
			//pr($this->data);exit;
			if ($this->Testimonial->save($this->data)) {
				$this->Session->setFlash(__('The testimonial has been saved', true), 'flash_success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The testimonial could not be saved. Please, try again.', true), 'flash_error');
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Testimonial->read(null, $id);
		}
	}
	
	function admin_cancel($id = null) {
		$this->Session->setFlash(__('Operation cancelled', true), 'flash_info');
		$this->redirect(array('action' => 'index'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for testimonial', true), 'flash_error');
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Testimonial->delete($id)) {
			$this->Session->setFlash(__('Testimonial deleted', true), 'flash_success');
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Testimonial was not deleted', true), 'flash_error');
		$this->redirect(array('action' => 'index'));
	}
}
?>