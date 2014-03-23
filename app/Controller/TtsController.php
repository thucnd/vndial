<?php

/**
 * TtsController.php
 *
 * Manage contacts
 *
 * $Id: TtsController.php 2013/01/23 thucnd$
 * 
 */
App::uses('AppController', 'Controller');
App::uses('Sanitize', 'Utility');

/**
 * Tts Controller
 *
 */
class TtsController extends AppController {

    const _HEADER_ = 'header';
    const _DEFAULT_WIDTH_ = '100%';

    public $layout = 'frontend';
    public $name = 'tts';
    public $javascripts = array('tts');
    public $csss = array();

    /**
     * An array containing the class names of models this controller uses.
     * @var array 
     */
    public $uses = array('Tts', 'Country');

    /**
     * Component
     * @var array 
     */
    public $components = array('DataTableLogic', 'AppLogic','Session');

    function beforeFilter() {
        $this->pageTitle = __('Text to speech');
        $this->request->data = Sanitize::clean($this->request->data, array('encode' => false));

        $this->columns = $this->_getTtsString();
        $this->defaultSort = 'name';
        $this->defaultWidth = self::_DEFAULT_WIDTH_;
        $this->set('tblHeader', $this->columns);

        return parent::beforeFilter();
    }

    public function index() {
        
    }

    public function add() {
        $countries = $this->Country->find('all');
        $this->set('countries', $countries);
    }
    
    /*
     * Edit Tts Information
     */
    public function edit($id = null) {
        $Tts = $this->Tts->findByTtsId($id);
        $countries = $this->Country->find('all');
        $this->set('countries', $countries);
        $this->set('edit', true);
        $this->set('tts_id', $id);
        $this->set('tts',$Tts);
        
    }

    /*
     * Update into database
     */

    public function save() {
        $this->layout = false;
        $ret = false;
        $errors = array();
        if (isset($this->request->data)) {
            $this->Tts->set($this->request->data);
            if (!$this->Tts->validates()) {
                foreach ($this->Tts->invalidFields() as $val) {
                    array_push($errors, $val[0]);
                }
            } else {
                $ret = $this->AppLogic->save($this->request->data, $this->Tts);
            }
        }
        if ($ret) {
            $this->Session->setFlash('Save sucess', 'default', array('class' => 'alert alert-success'));
            $this->set('status', STATUS_OK);
            $this->set('errors', null);
            $this->set('message', MESSAGE_OK);
        } else {
            $this->set('status', STATUS_NG);
            $this->set('errors', $errors);
            $this->set('message', MESSAGE_FAILURE);
        }
        $this->render('exec');
    }

    public function exec() {
        $this->layout = false;
        if (isset($this->request->data['header']) &&
                $this->request->data['header'] === TtsController::_HEADER_) {
            $status = 1;
        }

        $this->set('list', null);
        $this->set('status', STATUS_OK);
        $this->set('errors', null);
        $this->set('message', MESSAGE_OK);
    }
    
    /**
     * delele
     * 
     * Delete record using Ajax 
     */
    public function delete() {
        $this->layout = false;
        $ids = $this->request->data['ids'];
        $ret = false;

        if (isset($ids)) {
            $ret = $this->AppLogic->deleteMultiple($ids, $this->Tts);
        }

        if ($ret) {
            $this->set('status', STATUS_OK);
            $this->set('errors', null);
            $this->set('message', MESSAGE_OK);
        } else {
            $this->set('status', STATUS_NG);
            $this->set('errors', null);
            $this->set('message', MESSAGE_FAILURE);
        }
    }
    
    /**
     * Del
     * 
     * Delete record by Id
     * @param type $id 
     */
    public function del($id = null) {
        $ret = false;
        if (isset($id)) {
            $ret = $this->Tts->delete($id);
        }
        if ($ret) {
            $this->Session->setFlash('Delete sucess', 'default', array('class' => 'alert alert-success'));
            $this->set('status', STATUS_OK);
            $this->set('errors', null);
            $this->set('message', MESSAGE_OK);
        } else {
            $this->Session->setFlash('Error while delete data', 'default', array('class' => 'alert alert-error'));
            $this->set('status', STATUS_NG);
            $this->set('errors', null);
            $this->set('message', MESSAGE_FAILURE);
        }
        $this->redirect('/tts');
    }
    
    /**
     * Process data table
     */
    public function process() {
        $this->layout = false;
        $jsonData = $this->DataTableLogic->processDataTable(
                $this->request->data, $this->Tts, $this->columns);


        $this->set(compact('jsonData'));
    }

    /**
     * List of key-value to be displayed in Tts controller
     * @return array
     */
    private function _getTtsString() {
        return array(
            'tickbox' => array('name' => CHECK_BOX, 'width' => 30, 'align' => CENTER_ALIGNMENT),
            'editbox' => array('name' => __('Operations'), 'width' => 80, 'align' => CENTER_ALIGNMENT),
            'name' => array('name' => __('Name'), 'width' => 150, 'align' => CENTER_ALIGNMENT, 'sorting' => TRUE),
            'text_data' => array('name' => __('Data'), 'width' => 150, 'align' => CENTER_ALIGNMENT, 'sorting' => TRUE),
            'language' => array('name' => __('Language'), 'width' => 80, 'align' => CENTER_ALIGNMENT, 'sorting' => TRUE),
            'created_date' => array('name' => __('Created Date'), 'width' => 120, 'align' => CENTER_ALIGNMENT, 'sorting' => TRUE)
        );
    }

}
