<?php

/**
 * RecordingController.php
 *
 * Manage Audio files
 *
 * $Id: RecordingController.php 2013/01/31 thucnd$
 * 
 */
App::uses('AppController', 'Controller');
App::uses('Sanitize', 'Utility');

/**
 * Recording Controller
 *
 */
class RecordingController extends AppController {

    const _HEADER_ = 'header';
    const _DEFAULT_WIDTH_ = '100%';

    public $layout = 'frontend';
    public $name = 'recording';
    public $javascripts = array('recording', 'webtoolkit.aim');
    public $csss = array();

    /**
     * An array containing the class names of models this controller uses.
     * @var array 
     */
    public $uses = array('Recording', 'Setting');

    /**
     * Component
     * @var array 
     */
    public $components = array('DataTableLogic', 'AppLogic', 'Session', 'SettingLogic');

    function beforeFilter() {
        $this->pageTitle = $this->Recording->name;
        setcookie("s", null);
        setcookie("e", null);
        $this->request->data = Sanitize::clean($this->request->data, array('encode' => false));

        $this->columns = $this->_getRecordingString();
        $this->defaultSort = 'name';
        $this->defaultWidth = self::_DEFAULT_WIDTH_;

        $this->set('tblHeader', $this->columns);

        return parent::beforeFilter();
    }

    public function index() {
        $this->pageTitle = 'Audio files';
    }

    /* Create new contact */

    public function add() {
        $this->pageTitle = 'Create new gateway';
    }

    public function exec() {
        $this->layout = false;
        if (isset($this->request->data['header']) &&
                $this->request->data['header'] === RecordingController::_HEADER_) {
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
        $errors = array();
        try {
            $allowedExts = array("audio/mpeg", "audio/x-wav", "audio/wav");
            if (isset($this->request->data)) {
                if ($_FILES["audio_path"]["error"] > 0) {
                    array_push($errors, __('upload error'));
                    if (isset($this->request->data['recording_id'])) {
                        $ret = $this->AppLogic->save($this->request->data, $this->Recording);
                    }
                } else if(!in_array($_FILES["audio_path"]["type"], $allowedExts)) {
                    $this->log($_FILES["audio_path"]["type"]);
                    array_push($errors, __('Invalid file'));
                } else {
                    $this->request->data['size'] = $_FILES['audio_path']['size'] / 1024 . " Kb";
                    $this->request->data['path'] = time() . '_' . preg_replace('/\s+/', '_', strtolower($_FILES['audio_path']['name']));
                    $this->request->data['type'] = $_FILES["audio_path"]["type"];

                    $data = $this->Setting->getSettingList();
                    $path = $this->SettingLogic->getSettingInfo($data, 'audio_path', 'files/');
                    $this->log('tmp:'.$_FILES["audio_path"]["tmp_name"]);
                    $this->log('path:'.$path . $this->request->data['path']);
                    move_uploaded_file($_FILES["audio_path"]["tmp_name"], $path . $this->request->data['path']);

                    $this->Recording->set($this->request->data);
                    if (!$this->Recording->validates()) {
                        foreach ($this->Recording->invalidFields() as $val) {
                            array_push($errors, $val[0]);
                        }
                    } else {
                        $ret = $this->AppLogic->save($this->request->data, $this->Recording);
                    }
                }
            }

            if ($ret) {
                $this->Session->setFlash('Save sucess', 'default', array('class' => 'alert alert-success'));
                $this->set('status', STATUS_OK);
                $this->set('errors', null);
                $this->set('message', MESSAGE_OK);
            } else {
                $this->set('status', STATUS_NG);
                $this->set('errors', $errors);
                $this->set('message', MESSAGE_FAILURE);
            }
        } catch (Exception $exc) {
            $this->log($exc->getTraceAsString());
        }
    }

    /* Edit group */

    public function edit($recording_id = null) {
        $recording = $this->Recording->findByRecordingId($recording_id);
        $this->set('recording', $recording);
        $this->set('recording_id', $recording_id);
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
            $ret = $this->AppLogic->deleteMultiple($ids, $this->Recording);
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
            $ret = $this->Recording->delete($id);
        }

        if ($ret) {
            $this->Session->setFlash('Delete sucess', 'default', array('class' => 'alert alert-success'));
            $this->set('status', STATUS_OK);
            $this->set('errors', null);
            $this->set('message', MESSAGE_OK);
        } else {
            $this->Session->setFlash('Error while delete data', 'default', array('class' => 'alert alert-error'));
            $this->set('status', STATUS_NG);
            $this->set('errors', null);
            $this->set('message', MESSAGE_FAILURE);
        }
        $this->redirect('/recording');
    }

    /**
     * Process data table
     */
    public function process() {
        $this->layout = false;
        $jsonData = $this->DataTableLogic->processDataTable(
                $this->request->data, $this->Recording, $this->columns);
        $this->set(compact('jsonData'));
    }

    /**
     * List of key-value to be displayed in gateway controller
     * @return array
     */
    private function _getRecordingString() {
        return array(
            'tickbox' => array('name' => CHECK_BOX, 'width' => 25, 'align' => CENTER_ALIGNMENT),
            'editbox' => array('name' => __('Operations'), 'width' => 100, 'align' => CENTER_ALIGNMENT),
            'name' => array('name' => __('Name'), 'width' => 100, 'align' => LEFT_ALIGNMENT, 'sorting' => TRUE),
            'description' => array('name' => __('Description'), 'width' => 100, 'align' => CENTER_ALIGNMENT, 'sorting' => TRUE),
            'type' => array('name' => __('Type'), 'width' => 100, 'align' => LEFT_ALIGNMENT, 'sorting' => TRUE),
            'path' => array('name' => __('Path'), 'width' => 200, 'align' => LEFT_ALIGNMENT, 'sorting' => TRUE),
            'size' => array('name' => __('Length'), 'width' => 100, 'align' => LEFT_ALIGNMENT, 'sorting' => TRUE),
            'created_date' => array('name' => __('Created Date'), 'width' => 100, 'align' => LEFT_ALIGNMENT, 'sorting' => TRUE)
        );
    }

}
