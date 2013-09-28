<?php

/**
 * ContactController.php
 *
 * Manage contacts
 *
 * $Id: ContactController.php 2013/01/23 khanhle$
 * @update: 2013/01/31 thucnd$
 * 
 */
App::uses('AppController', 'Controller');
App::uses('Sanitize', 'Utility');

/**
 * Contact Controller
 *
 */
class ContactController extends AppController {

    const _HEADER_ = 'header';
    const _DEFAULT_WIDTH_ = '100%';

    public $layout = 'frontend';
    public $name = 'contact';
    public $javascripts = array('contact');
    public $csss = array();

    /**
     * An array containing the class names of models this controller uses.
     * @var array 
     */
    public $uses = array('Contact','ContactGroup');

    /**
     * Component
     * @var array 
     */
    public $components = array('DataTableLogic', 'AppLogic');

    function beforeFilter() {
        $this->pageTitle = $this->Contact->name;
        setcookie("s", null);
        setcookie("e", null);
        $this->request->data = Sanitize::clean($this->request->data, array('encode' => false));

        $this->columns = $this->_getContactString();
        $this->defaultSort = 'first_name';
        $this->defaultWidth = ContactController::_DEFAULT_WIDTH_;

        $this->set('tblHeader', $this->columns);

        return parent::beforeFilter();
    }

    public function index() {
    }
    
    /* Create new contact */
    public function add() {
        // Need to upate date to call follow user ID
        $list = $this->ContactGroup->find('all');
        $this->set('groups', $list);
    }

    public function exec() {
        $this->layout = false;
        if (isset($this->request->data['header']) &&
                $this->request->data['header'] === ContactController::_HEADER_) {
            $status = 1;
        }

        $this->set('list', null);
        $this->set('status', STATUS_OK);
        $this->set('errors', null);
        $this->set('message', MESSAGE_OK);
    }
    
    /* store in database */
    public function save() {
        $this->layout = false;
        $ret = false;
        if(isset($this->request->data)) {
            $ret = $this->AppLogic->save($this->request->data, $this->Contact);
        }
        
        if($ret) {
            $this->set('status', STATUS_OK);
            $this->set('errors', null);
            $this->set('message', MESSAGE_OK);
        }else{
            $this->set('status', STATUS_NG);
            $this->set('errors', null);
            $this->set('message', MESSAGE_FAILURE);
        }
    }
    
    /* Edit group */
    public function edit($contact_id = null) {
        $contact = $this->Contact->findByContactId($contact_id);
        $groups = $this->ContactGroup->find('all');
        $this->set('groups', $groups);
        $this->set('contact', $contact);
        $this->set('contact_id', $contact_id);
        $this->set('edit', true);
    }

    /*
     *  Delete contact
     */
    public function delete() {
        $this->layout = false;
        $ids = $this->request->data['ids'];
        $ret = false;

        if (isset($ids)) {
            $ret = $this->AppLogic->deleteMultiple($ids, $this->Contact);
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
     * Process data table
     */
    public function process() {
        $this->layout = false;
        $jsonData = $this->DataTableLogic->processDataTable(
                $this->request->data, $this->Contact, $this->columns);
        
        
        $this->set(compact('jsonData'));
    }

    /**
     * List of key-value to be displayed in gateway controller
     * @return array
     */
    private function _getContactString() {
        return array(
            'tickbox' => array('name' => CHECK_BOX, 'width' => 15, 'align' => CENTER_ALIGNMENT),
            'editbox' => array('name' => __('Operations'), 'width' => 50, 'align' => CENTER_ALIGNMENT),
            'group_id' => array('name' => __('Group name'), 'width' => 80, 'align' => CENTER_ALIGNMENT),
            'first_name' => array('name' => __('First Name'), 'width' => 80, 'align' => CENTER_ALIGNMENT),
            'last_name' => array('name' => __('Last Name'), 'width' => 80, 'align' => CENTER_ALIGNMENT),
            'company' => array('name' => __('Company'), 'width' => 80, 'align' => CENTER_ALIGNMENT),
            'address' => array('name' => __('Address'), 'width' => 80, 'align' => CENTER_ALIGNMENT),
            'phone' => array('name' => __('Phone'), 'width' => 80, 'align' => CENTER_ALIGNMENT),
            'email' => array('name' => __('Email'), 'width' => 155, 'align' => CENTER_ALIGNMENT),
            'created_date' => array('name' => __('Created Date'), 'width' => 100, 'align' => CENTER_ALIGNMENT)
        );
    }

}
