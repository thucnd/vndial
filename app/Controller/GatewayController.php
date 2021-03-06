<?php
/**
 * GatewayController.php
 *
 * Manage gateways
 *
 * $Id: GatewayController.php 2013/01/16 ThucNd$
 * 
 */
App::uses('AppController', 'Controller');
App::uses('Sanitize', 'Utility');

class GatewayController extends AppController {

    const _HEADER_ = 'header';
    const _DEFAULT_WIDTH_ = '100%';
    public $layout = 'backend';
    public $name = 'gateway';
    public $javascripts = array('gateway');
    public $csss = array();
    // Load Role helper
    public $helpers = array('Role');

    /**
     * An array containing the class names of models this controller uses.
     * @var array 
     */
    public $uses = array('Gateway');

    /**
     * Component
     * @var array 
     */
    public $components = array('DataTableLogic', 'AppLogic','Session');

    function beforeFilter() {        
        $this->pageTitle = $this->Gateway->name;
        setcookie("s", null);
        setcookie("e", null);
        $this->request->data = Sanitize::clean($this->request->data, array('encode' => false));
        $this->defaultWidth = self::_DEFAULT_WIDTH_;
        $this->columns = $this->Gateway->_getGatewayString();
        $this->defaultSort = 'name';
        $this->defaultWidth = self::_DEFAULT_WIDTH_;
        $this->set('tblHeader', $this->columns);
        return parent::beforeFilter();
    }

    public function index() {
    }

    /*
     *  Create new Gateway
     */
    public function add() {        
    }
    
    /*
     * Edit Gateway Information
     */
    public function edit($id = null) {
        $Gateway = $this->Gateway->findByGatewayId($id);
        $this->set('edit', true);
        $this->set('gateway_id', $id);
        $this->set('gateway',$Gateway);
    }

    /**
     * Get Header
     */
    public function exec() {
        $this->layout = false;
        if (isset($this->request->data['header']) &&
                $this->request->data['header'] === GatewayController::_HEADER_) {
            $status = 1;
        }        
        $this->set('list', null);
        $this->set('status', STATUS_OK);
        $this->set('errors', null);
        $this->set('message', MESSAGE_OK);
    }
    
    public function delete() {
        $this->layout = false;
        $ids = $this->request->data['ids'];
        $ret = false;
        
        if(isset($ids)) {
            $ret = $this->AppLogic->deleteMultiple($ids, $this->Gateway);
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
    
    /*
     * Update into database
     */
    public function save() {
        $this->layout = false;
        $ret = false;
        $errors = array();
        if(isset($this->request->data)) {
            $this->Gateway->set($this->request->data);
            if(!$this->Gateway->validates()) {
                foreach($this->Gateway->invalidFields() as $val) {
                    array_push($errors, $val[0]);
                }
            }else{
                $ret = $this->AppLogic->save($this->request->data, $this->Gateway);
            }
        }
        if($ret) {
            $this->Session->setFlash('Save sucess');
            $this->set('status', STATUS_OK);
            $this->set('errors', null);
            $this->set('message', MESSAGE_OK);
        }else{
            $this->set('status', STATUS_NG);
            $this->set('errors', $errors);
            $this->set('message', MESSAGE_FAILURE);
        }
    }

    /**
     * Process data table
     */
    public function process() {
        $this->layout = false;
        $jsonData = $this->DataTableLogic->processDataTable(
                $this->request->data, $this->Gateway, $this->columns);
        
        $this->set(compact('jsonData'));
    }
}
