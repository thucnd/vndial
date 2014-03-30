<?php

/**
 * ContactGroupController.php
 *
 * Manage groups
 *
 * $Id: ContactGroupController.php 2013/01/23 khanhle$
 * @update: 2013/01/31 thucnd$
 * 
 */
App::uses('AppController', 'Controller');
App::uses('Sanitize', 'Utility');

/**
 * ContactGroup Controller
 *
 */
class ContactGroupController extends AppController {
    const _HEADER_ = 'header';
    const _DEFAULT_WIDTH_ = '100%';

    public $layout = 'frontend';
    public $name = 'contact_group';
    public $javascripts = array('group');
    public $csss = array();

    /**
     * An array containing the class names of models this controller uses.
     * @var array 
     */
    public $uses = array('ContactGroup');

    /**
     * Component
     * @var array 
     */
    public $components = array('DataTableLogic', 'AppLogic');

    function beforeFilter() {
        $this->pageTitle = $this->ContactGroup->name;
        setcookie("s", null);
        setcookie("e", null);
        $this->request->data = Sanitize::clean($this->request->data, array('encode' => false));

        $this->columns = $this->_getContactGroupString();
        $this->defaultWidth = ContactGroupController::_DEFAULT_WIDTH_;

        $this->set('tblHeader', $this->columns);

        return parent::beforeFilter();
    }

    /* Manage group */
    public function index() {
        
    }
    
    /* Create new group */
    public function add() {
        
    }
    
    /* Edit group */
    public function edit($group_id = null) {
        $list = $this->ContactGroup->findByGroupId($group_id);
        $this->set('group', $list);
        $this->set('group_id', $group_id);
        $this->set('edit', true);
    }

    public function exec() {
        $this->layout = false;
        if (isset($this->request->data['header']) &&
                $this->request->data['header'] === ContactGroupController::_HEADER_) {
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
            $ret = $this->AppLogic->save($this->request->data, $this->ContactGroup);
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

    public function delete() {
        $this->layout = false;
        $ids = $this->request->data['ids'];
        $ret = false;

        if (isset($ids)) {
            $ret = $this->AppLogic->deleteMultiple($ids, $this->ContactGroup);
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
                $this->request->data, $this->ContactGroup, $this->columns);
        
        
        $this->set(compact('jsonData'));
    }

    /**
     * List of key-value to be displayed in gateway controller
     * @return array
     */
    private function _getContactGroupString() {
        return array(
            'tickbox' => array('name' => CHECK_BOX, 'width' => 25, 'align' => CENTER_ALIGNMENT),
            'editbox' => array('name' => __('Operations'), 'width' => 50, 'align' => CENTER_ALIGNMENT),
            'name' => array('name' => __('Name'), 'width' => 100, 'align' => CENTER_ALIGNMENT, 'sorting' => TRUE),
            'description' => array('name' => __('Description'), 'width' => 100, 'align' => CENTER_ALIGNMENT, 'sorting' => TRUE),
            'created_date' => array('name' => __('Created Date'), 'width' => 100, 'align' => CENTER_ALIGNMENT, 'sorting' => TRUE)
        );
    }
}

?>
