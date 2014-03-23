<?php

/**
 * CallRequestController.php
 *
 * Manage contacts
 *
 * $Id: CallRequestController.php 2013/01/23 thucnd$
 * 
 */
App::uses('AppController', 'Controller');
App::uses('Sanitize', 'Utility');

/**
 * CallRequest Controller
 *
 */
class CallRequestController extends AppController {

    const _HEADER_ = 'header';
    const _DEFAULT_WIDTH_ = '100%';

    public $layout = 'frontend';
    public $name = 'call_request';
    public $javascripts = array();
    public $csss = array();

    /**
     * An array containing the class names of models this controller uses.
     * @var array 
     */
    public $uses = array('CallRequest');

    /**
     * Component
     * @var array 
     */
    public $components = array('DataTableLogic', 'AppLogic');

    function beforeFilter() {
        $this->pageTitle = $this->CallRequest->name;
        setcookie("s", null);
        setcookie("e", null);
        $this->request->data = Sanitize::clean($this->request->data, array('encode' => false));

        $this->columns = $this->_getCallRequestString();
        $this->defaultSort = 'caller';
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
                $this->request->data['header'] === CallRequestController::_HEADER_) {
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
            $ret = $this->AppLogic->deleteMultiple($ids, $this->CallRequest);
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
                $this->request->data, $this->CallRequest, $this->columns);
        
        
        $this->set(compact('jsonData'));
    }

    /**
     * List of key-value to be displayed in gateway controller
     * @return array
     */
    private function _getCallRequestString() {
        return array(
            'call_request_id' => array('name' => __('ID'), 'width' => 50, 'align' => CENTER_ALIGNMENT),
            'campaign_id' => array('name' => __('Campaign'), 'width' => 100, 'align' => CENTER_ALIGNMENT, 'sorting' => TRUE),
            'caller' => array('name' => __('Caller'), 'width' => 100, 'align' => CENTER_ALIGNMENT, 'sorting' => TRUE),
            'called' => array('name' => __('Called'), 'width' => 100, 'align' => CENTER_ALIGNMENT, 'sorting' => TRUE),
            'status' => array('name' => __('Status'), 'width' => 50, 'align' => CENTER_ALIGNMENT, 'sorting' => TRUE),
            'retries' => array('name' => __('Retries'), 'width' => 50, 'align' => CENTER_ALIGNMENT, 'sorting' => TRUE),
            'start_time' => array('name' => __('Start Time'), 'width' => 100, 'align' => CENTER_ALIGNMENT, 'sorting' => TRUE),
            'end_time' => array('name' => __('End Time'), 'width' => 100, 'align' => CENTER_ALIGNMENT, 'sorting' => TRUE),
            'hangup' => array('name' => __('Hangup'), 'width' => 50, 'align' => CENTER_ALIGNMENT, 'sorting' => TRUE),
            'created_date' => array('name' => __('Created Date'), 'width' => 100, 'align' => CENTER_ALIGNMENT, 'sorting' => TRUE)
        );
    }

}
