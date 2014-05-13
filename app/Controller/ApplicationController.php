<?php

/**
 * ApplicationController.php
 *
 * Manage contacts
 *
 * $Id: ApplicationController.php 2013/01/23 khanhle$
 * 
 */
App::uses('AppController', 'Controller');
App::uses('Sanitize', 'Utility');

/**
 * Application Controller
 *
 */
class ApplicationController extends AppController {

    const _HEADER_ = 'header';
    const _DEFAULT_WIDTH_ = 800;

    public $layout = 'backend';
    public $name = 'application';
    public $javascripts = array('gateway');
    public $csss = array();
    // Load Role helper
    public $helpers = array('Role');
    /**
     * An array containing the class names of models this controller uses.
     * @var array 
     */
    public $uses = array('Application');
    /**
     * Component
     * @var array 
     */
    public $components = array('DataTableLogic', 'AppLogic');

    function beforeFilter() {
        $this->pageTitle = $this->Application->name;
        setcookie("s", null);
        setcookie("e", null);
        $this->request->data = Sanitize::clean($this->request->data, array('encode' => false));

        $this->columns = $this->_getApplicationString();
        $this->defaultWidth = self::_DEFAULT_WIDTH_;
        $this->set('tblHeader', $this->columns);

        return parent::beforeFilter();
    }

    public function index() {
        
    }

    public function add() {
        
    }

    public function exec() {
        $this->layout = false;
        if (isset($this->request->data['header']) &&
                $this->request->data['header'] === ApplicationController::_HEADER_) {
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

        if (isset($ids)) {
            $ret = $this->AppLogic->deleteMultiple($ids, $this->Application);
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
                $this->request->data, $this->Application, $this->columns);
        $this->set(compact('jsonData'));
    }

    /**
     * List of key-value to be displayed in gateway controller
     * @return array
     */
    private function _getApplicationString() {
        return array(
            'tickbox' => array('name' => CHECK_BOX, 'width' => 25, 'align' => LEFT_ALIGNMENT),
            'app_id' => array('name' => __('ID'), 'width' => 50, 'align' => LEFT_ALIGNMENT),
            'name' => array('name' => __('Name'), 'width' => 50, 'align' => LEFT_ALIGNMENT),
            'description' => array('name' => __('Description'), 'width' => 50, 'align' => LEFT_ALIGNMENT),
            'app_type_id' => array('name' => __('App Type'), 'width' => 50, 'align' => LEFT_ALIGNMENT),
            'b_leg' => array('name' => __('Last Name'), 'width' => 50, 'align' => LEFT_ALIGNMENT),
            'data' => array('name' => __('Data'), 'width' => 50, 'align' => LEFT_ALIGNMENT),
            'tts_id' => array('name' => __('TTS'), 'width' => 50, 'align' => LEFT_ALIGNMENT),
            'user_id' => array('name' => __('User'), 'width' => 50, 'align' => LEFT_ALIGNMENT),
            'created_date' => array('name' => __('Created Date'), 'width' => 50, 'align' => LEFT_ALIGNMENT),
            'created_by' => array('name' => __('Created By'), 'width' => 50, 'align' => LEFT_ALIGNMENT),
            'editbox' => array('name' => __('Edit'), 'width' => 20, 'align' => CENTER_ALIGNMENT),
        );
    }

}
