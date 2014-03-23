<?php

/**
 * SurveyController.php
 *
 * Manage contacts
 *
 * $Id: SurveyController.php 2013/01/23 thucnd$
 * 
 */
App::uses('AppController', 'Controller');
App::uses('Sanitize', 'Utility');

/**
 * Survey Controller
 *
 */
class SurveyController extends AppController {

    const _HEADER_ = 'header';
    const _DEFAULT_WIDTH_ = '100%';
    const _SURVEY_TARGET_ADD_ = 'add';
    const _SURVEY_TARGET_EDIT_ = 'edit';

    public $layout = 'frontend';
    public $name = 'survey';
    public $javascripts = array('survey');
    public $csss = array();

    /**
     * An array containing the class names of models this controller uses.
     * @var array 
     */
    public $uses = array('Survey', 'Recording', 'Response');

    /**
     * Component
     * @var array 
     */
    public $components = array('DataTableLogic', 'AppLogic', 'Session');

    function beforeFilter() {
        $this->pageTitle = $this->Survey->name;
        setcookie("s", null);
        setcookie("e", null);
        $this->request->data = Sanitize::clean($this->request->data, array('encode' => false));

        $this->columns = $this->_getSurveyString();
        $this->defaultSort = 'question';
        $this->defaultWidth = self::_DEFAULT_WIDTH_;
        $this->set('tblHeader', $this->columns);

        return parent::beforeFilter();
    }

    public function index() {
        
    }

    public function add() {
        $recordings = $this->AppLogic->getAllData($this->Recording);
        $this->set('recordings', $recordings);
    }

    /*
     * Edit Survey Information
     */

    public function edit($id = null) {
        $survey = $this->Survey->findBySurveyId($id);
        $recordings = $this->AppLogic->getAllData($this->Recording);
        $this->set('recordings', $recordings);
        $this->set('survey', $survey);
        $this->set('edit', true);
        $this->set('survey_id', $id);
    }

    /*
     * Update into database
     */

    public function save() {
        $this->layout = false;
        $ret = false;
        $errors = array();
        $params = $this->request->data;
        if (isset($this->request->data)) {
            if ($params['target'] === self::_SURVEY_TARGET_ADD_) {
                if (!isset($params['response'])) {
                    array_push($errors, __('Please add at least a respond'));
                    $this->set('status', STATUS_NG);
                    $this->set('errors', $errors);
                    $this->set('message', MESSAGE_FAILURE);
                    $this->render('exec');
                    return;
                }
            }

            $this->Survey->set($this->request->data);
            if (!$this->Survey->validates()) {
                foreach ($this->Survey->invalidFields() as $val) {
                    array_push($errors, $val[0]);
                }
            } else {
                $question = $this->AppLogic->save($this->request->data, $this->Survey);
                if (!empty($question)) {
                    $ret = true;
                    if ($params['target'] === self::_SURVEY_TARGET_ADD_) {
                        $respond = array();
                        foreach ($params['response'] as $key => $value) {
                            $data = array();
                            $data = json_decode(str_replace('\"', '"', $value), true);
                            $data['survey_id'] = $question['Survey']['survey_id'];
                            $data['created_by'] = $this->Session->read('User.uid');
                            $data['created_date'] = date("Y-m-d H:i:s", $_SERVER['REQUEST_TIME']);
                            array_push($respond, $data);
                        }
                        $this->Response->saveMany($respond);
                    }
                } else {
                    array_push($errors, __('Error while create new question'));
                    $ret = false;
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

    public function update() {
        $this->layout = false;
        $ret = false;
        if (isset($this->request->data)) {
            $ret = $this->AppLogic->save($this->request->data, $this->Response);
        }

        if ($ret) {
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
     * Get header
     */
    public function exec() {
        $this->layout = false;
        if (isset($this->request->data['header']) &&
                $this->request->data['header'] === SurveyController::_HEADER_) {
            $status = 1;
        }

        $this->set('list', null);
        $this->set('status', STATUS_OK);
        $this->set('errors', null);
        $this->set('message', MESSAGE_OK);
    }

    /**
     * Delete multi data
     */
    public function delete() {
        $this->layout = false;
        $ids = $this->request->data['ids'];
        $ret = false;

        if (isset($ids)) {
            $ret = $this->AppLogic->deleteMultiple($ids, $this->Survey);
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
                $this->request->data, $this->Survey, $this->columns);

        $this->set(compact('jsonData'));
    }

    /**
     * List of key-value to be displayed in gateway controller
     * @return array
     */
    private function _getSurveyString() {
        return array(
            'tickbox' => array('name' => CHECK_BOX, 'width' => 10, 'align' => LEFT_ALIGNMENT),
            'editbox' => array('name' => __('Operations'), 'width' => 100, 'align' => CENTER_ALIGNMENT),
            'question' => array('name' => __('Question'), 'width' => 100, 'align' => LEFT_ALIGNMENT, 'sorting' => TRUE),
            'description' => array('name' => __('Description'), 'width' => 100, 'align' => CENTER_ALIGNMENT, 'sorting' => TRUE),
            'recording_id' => array('name' => __('Recording'), 'width' => 100, 'align' => CENTER_ALIGNMENT, 'sorting' => TRUE),
            'created_date' => array('name' => __('Created Date'), 'width' => 100, 'align' => LEFT_ALIGNMENT, 'sorting' => TRUE),
            'created_by' => array('name' => __('Created By'), 'width' => 100, 'align' => LEFT_ALIGNMENT, 'sorting' => TRUE)
        );
    }

}
