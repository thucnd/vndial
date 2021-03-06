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
    const _EDIT_ = 1;

    public $layout = 'backend';
    public $name = 'user';
    public $uses = array('User', 'Gateway', 'Role');
    public $javascripts = array('user');
    public $components = array('DataTableLogic', 'AppLogic', 'Session');
    // Load Role helper
    public $helpers = array('Role');

    function beforeFilter() {
        $this->pageTitle = __('Users');
        $this->request->data = Sanitize::clean($this->request->data, array('encode' => false));
        $this->columns = $this->User->_getUserString();
        $this->defaultSort = 'username';
        $this->defaultWidth = self::_DEFAULT_WIDTH_;
        $this->set('tblHeader', $this->columns);
        return parent::beforeFilter();
    }

    public function index() {    
    }    
    
    /*
     * Create new user
     */
    public function add() {
        $uid = $this->Session->read('User.uid');
        // Get user information
        $user = $this->User->findByUserId($uid);
        //Get Role list
        $roles = $this->Role->find('all');
        // Get gateway list
        $list = $this->Gateway->find('all');
        $this->set('gateways', $list);
        $this->set('roles', $roles);
        $this->set('user', $user);
    }

    /*
     * Edit User Information
     */
    public function edit($id = null) {
        // Get user information
        $user = $this->User->findByUserId($id);
        // Get Role list
        $roles = $this->Role->find('all');
        // Get gateway list
        $gateways = $this->Gateway->find('all');
        $this->set('gateways', $gateways);
        $this->set('edit', true);
        $this->set('user_id', $id);
        $this->set('user', $user);
        $this->set('roles', $roles);
        $this->set('edit', true);
    }

    /**
     * info
     * Display user information
     * @param type $id
     */
    public function info($tab = 1) {
        $this->layout = 'frontend';
        // Get user information
        $user = $this->User->findByUserId($this->Session->read('User.uid'));
        $this->set('tab', $tab);
        $this->set('user', $user);
    }

    /**
     * updateinfo
     */
    public function updateinfo() {
        if ($this->request->is('post')) {
             if ($this->AppLogic->update($this->request->data['UserDetail'], $this->User)) {
                $this->Session->setFlash(__('Update success'), 'default', array('class' => 'alert alert-success'));
            } else {
                $this->Session->setFlash(__('Unable to update your changes.'), 'default', array('class' => 'alert alert-error'));
            }
        }
        
        if($this->request->data['edit'] == self::_EDIT_) {
            $this->redirect(array('action' => 'index'));
        } else {
            $this->redirect(array('action' => 'info'));
        }
    }
    
    /*
     * Change password
     */
    public function updatepassword() {
        if ($this->request->is('post')) {
            if (strcmp($this->request->data['UserPassword']['password'], $this->request->data['UserPassword']['repassword']) === 0) {
                    $getUser = $this->User->findByPassword($this->request->data['UserPassword']['old_password']);
                    if (count($getUser) > 0) {
                        $this->Session->setFlash(__('Old password is wrong'), 'default', array('class' => 'alert alert-error'));
                    } else {
                        $this->request->data['UserPassword']['password'] = md5($this->request->data['UserPassword']['password']);
                        $ret = $this->AppLogic->update($this->request->data['UserPassword'], $this->User);
                        $this->Session->setFlash(__('Change password success'), 'default', array('class' => 'alert alert-success'));
                    }
                } else {
                    $this->Session->setFlash(__('Password is not the same as password confirm'), 'default', array('class' => 'alert alert-error'));
                }
        }
        
        if($this->request->data['edit'] == self::_EDIT_) {
            $this->redirect(array('action' => 'index'));
        } else {
            $this->redirect(array('action' => 'info/2'));
        }
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
            $ret = $this->AppLogic->deleteMultiple($ids, $this->User);
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
            $user = $this->User->findByUserId($id);
            if(count($user) > 0 && $user["User"]["role"] != 1) {
                $ret = $this->User->delete($id);
            } else {
                $this->Session->setFlash("This account can't delete ", 'default', array('class' => 'alert alert-error'));
                $this->set('status', STATUS_NG);
                $this->set('message', MESSAGE_FAILURE);
                $this->redirect('/user');
            }
         
        }
        if ($ret) {
            $this->Session->setFlash('Delete sucess', 'default', array('class' => 'alert alert-success'));
            $this->set('status', STATUS_OK);
            $this->set('message', MESSAGE_OK);
        } else {
            $this->Session->setFlash('Error while delete data', 'default', array('class' => 'alert alert-error'));
            $this->set('status', STATUS_NG);
            $this->set('message', MESSAGE_FAILURE);
        }
        
        $this->set('errors', null);        
        $this->redirect('/user');
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
                    if (count($getUser) > 0) {
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

    /**
     * Get Information
     */
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
}
