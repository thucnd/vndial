<?php
/**
 * CallReportController.php
 *
 * Manage contacts
 *
 * $Id: CallReportController.php 2013/01/23 ThucNd
 * 
 */
App::uses('AppController', 'Controller');
App::uses('Sanitize', 'Utility');

class CallReportController extends AppController {
    const _HEADER_ = 'header';
    const _DEFAULT_WIDTH_ = '100%';
    public $layout = 'frontend';
    public $name = 'call_report';
    public $javascripts = array('gateway');
    public $csss = array();
    // Load Role helper
    public $helpers = array('Role');
    /**
     * An array containing the class names of models this controller uses.
     * @var array 
     */
    public $uses = array('CallReport');

    /**
     * Component
     * @var array 
     */
    public $components = array('DataTableLogic', 'AppLogic');

    function beforeFilter() {
        $this->pageTitle = $this->CallReport->name;
        setcookie("s", null);
        setcookie("e", null);
        $this->request->data = Sanitize::clean($this->request->data, array('encode' => false));
        $this->columns = $this->CallReport->_getCallReportString();
        $this->defaultSort = 'caller';
        $this->defaultWidth = self::_DEFAULT_WIDTH_;
        $this->set('tblHeader', $this->columns);
        return parent::beforeFilter();
    }

    public function index() {
    }

    public function add() {
    }

    /**
     * Get header information
     */
    public function exec() {
        $this->layout = false;
        if (isset($this->request->data['header']) &&
                $this->request->data['header'] === CallReportController::_HEADER_) {
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
            $ret = $this->AppLogic->deleteMultiple($ids, $this->CallReport);
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
                $this->request->data, $this->CallReport, $this->columns);
        $this->set(compact('jsonData'));
    }
}
