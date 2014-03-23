<?php

/**
 * RoleController.php
 *
 * Manage roles
 *
 * $Id: RoleController.php 2013/04/23 ThucNd$
 * 
 */
App::uses('AppController', 'Controller');
App::uses('Sanitize', 'Utility');

/**
 * Role Controller
 *
 */
class RoleController extends AppController {

    const _HEADER_ = 'header';
    const _DEFAULT_WIDTH_ = '100%';

    public $layout = 'backend';
    public $name = 'role';
    public $uses = array('Role');
    public $javascripts = array('role');
    public $components = array('DataTableLogic', 'AppLogic', 'Session', 'RoleLogic');

    function beforeFilter() {
        $this->pageTitle = __('Roles');
        $this->request->data = Sanitize::clean($this->request->data, array('encode' => false));

        $this->columns = $this->_getRoleString();
        $this->defaultSort = 'role_name';
        $this->defaultWidth = self::_DEFAULT_WIDTH_;
        $this->set('tblHeader', $this->columns);
        return parent::beforeFilter();
    }

    public function index() {
        
    }

    /*
     * Edit Role Information
     */

    public function edit($id = null) {
        $role = $this->Role->findByRoleId($id);
        $permissions = $this->RoleLogic->getPermissionParams();
        $chkPermissions = explode(":-", $role['Role']['role_permissions']);
        $this->set('permissions', $permissions);
        $this->set('chkPermissions', $chkPermissions);
        $this->set('edit', true);
        $this->set('role_id', $id);
        $this->set('role', $role);
    }

    public function add() {
        $permissions = $this->RoleLogic->getPermissionParams();
        $this->set('permissions', $permissions);
    }

    /*
     * Update into database
     */

    public function save() {
        $this->layout = false;
        $ret = false;
        $errors = array();
        if (isset($this->request->data)) {
            if (isset($this->request->data['chkRole'])) {
                $rolePermission = implode(':-', $this->request->data['chkRole']);
                $this->request->data['role_permissions'] = $rolePermission;
            }
            $this->Role->set($this->request->data);
            if (!$this->Role->validates()) {
                foreach ($this->Role->invalidFields() as $val) {
                    array_push($errors, $val[0]);
                }
            } else {
                $ret = $this->AppLogic->save($this->request->data, $this->Role);
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
                $this->request->data['header'] === RoleController::_HEADER_) {
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
                $this->request->data, $this->Role, $this->columns);


        $this->set(compact('jsonData'));
    }

    /**
     * List of key-value to be displayed in User controller
     * @return array
     */
    private function _getRoleString() {
        return array(
            'tickbox' => array('name' => CHECK_BOX, 'width' => 30, 'align' => CENTER_ALIGNMENT),
            'editbox' => array('name' => __('Operations'), 'width' => 100, 'align' => CENTER_ALIGNMENT),
            'role_name' => array('name' => __('Role name'), 'width' => 200, 'align' => CENTER_ALIGNMENT, 'sorting' => TRUE)
        );
    }

}
