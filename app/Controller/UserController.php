<?php

/**
 * UserController.php
 *
 * Manage user
 *
 * $Id: UserController.php 2013/03/23 ThucNd$
 * 
 */
App::uses('AppController', 'Controller');
App::uses('Sanitize', 'Utility');

/**
 * Admin Controller
 *
 */
class UserController extends AppController {

    const _HEADER_ = 'header';
    const _DEFAULT_WIDTH_ = '100%';

    public $layout = 'backend';
    public $name = 'user';
    public $uses = array('User', 'Gateway');
    public $javascripts = array('user');
    public $components = array('DataTableLogic', 'AppLogic', 'Session');

    function beforeFilter() {
        $this->pageTitle = __('Users');
        $this->request->data = Sanitize::clean($this->request->data, array('encode' => false));

        $this->columns = $this->_getUserString();
        $this->defaultSort = 'username';
        $this->defaultWidth = self::_DEFAULT_WIDTH_;
        $this->set('tblHeader', $this->columns);
        return parent::beforeFilter();
    }

    public function index() {
        
    }
    
    /*
     * Edit User Information
     */
    public function edit($id = null) {
        $user = $this->User->findByUserId($id);
        $gateways = $this->Gateway->find('all');
        $this->set('gateways', $gateways);
        $this->set('edit', true);
        $this->set('user_id', $id);
        $this->set('user',$user);
        
    }

    public function add() {
        $list = $this->Gateway->find('all');
        $this->set('gateways', $list);
    }

    /*
     * Update into database
     */

    public function save() {
        $this->layout = false;
        $ret = false;
        $errors = array();
        if (isset($this->request->data)) {
            $this->User->set($this->request->data);
            if (!$this->User->validates()) {
                foreach ($this->User->invalidFields() as $val) {
                    array_push($errors, $val[0]);
                }
            } else {
                if (strcmp($this->request->data['password'], $this->request->data['repassword']) === 0) {
                    $getUser = $this->User->findByUsername($this->request->data['username']);
                    if(count($getUser) > 0 ) {
                        array_push($errors, __('Username already exists'));
                    } else {
                        $this->request->data['password'] = md5($this->request->data['password']);
                        $ret = $this->AppLogic->save($this->request->data, $this->User);
                    }
                } else {
                    array_push($errors, __('Password is not the same as password confirm'));
                }
            }
        }
        
        if ($ret) {
            $this->Session->setFlash('Save sucess');
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
                $this->request->data['header'] === UserController::_HEADER_) {
            $status = 1;
        }

        $this->set('list', null);
        $this->set('status', STATUS_OK);
        $this->set('errors', null);
        $this->set('message', MESSAGE_OK);
    }

    /**
     * Process data table
     */
    public function process() {
        $this->layout = false;
        $jsonData = $this->DataTableLogic->processDataTable(
                $this->request->data, $this->User, $this->columns);


        $this->set(compact('jsonData'));
    }

    /**
     * List of key-value to be displayed in User controller
     * @return array
     */
    private function _getUserString() {
        return array(
            'tickbox' => array('name' => CHECK_BOX, 'width' => 20, 'align' => CENTER_ALIGNMENT),
            'editbox' => array('name' => __('Operations'), 'width' => 50, 'align' => CENTER_ALIGNMENT),
            'username' => array('name' => __('Name'), 'width' => 200, 'align' => LEFT_ALIGNMENT),
            'role' => array('name' => __('Role'), 'width' => 20, 'align' => CENTER_ALIGNMENT),
            'gateway_id' => array('name' => __('Gateway'), 'width' => 50, 'align' => CENTER_ALIGNMENT),
            'created_date' => array('name' => __('Created Date'), 'width' => 100, 'align' => LEFT_ALIGNMENT),
            'created_by' => array('name' => __('Created By'), 'width' => 100, 'align' => LEFT_ALIGNMENT)
        );
    }

}