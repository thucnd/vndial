<?php

/**
 * CampaignController.php
 *
 * Manage campaigns
 *
 * $Id: TtsController.php 2013/03/16 thucnd$
 * 
 */
App::uses('AppController', 'Controller');
App::uses('Sanitize', 'Utility');

/**
 * Campaign Controller
 *
 */
class CampaignController extends AppController {

    const _HEADER_ = 'header';
    const _DEFAULT_WIDTH_ = '100%';
    const _CAMPAIGN_PLAY_AUDIO_ = 1;
    const _CAMPAIGN_SURVEY_ = 2;
    const _CAMPAIGN_TEXT_TO_SPEECH_ = 3;
    
    const _CAMPAIGN_START_DATE_WRONG_ = -1;
    const _CAMPAIGN_END_DATE_WRONG_ = -2;
    const _CAMPAIGN_START_TIME_WRONG_ = -3;
    const _CAMPAIGN_END_TIME_WRONG_ = -4;
    const _CAMPAIGN_DATE_TIME_WRONG_ = -5;
    
    const _CAMPAIGN_ACTIVE_ = 1;
    const _CAMPAIGN_PAUSED_ = 2;
    const _CAMPAIGN_STOP_ = 3;

    public $layout = 'frontend';
    public $name = 'campaign';
    public $javascripts = array('campaign');
    public $csss = array();

    /**
     * An array containing the class names of models this controller uses.
     * @var array 
     */
    public $uses = array('Campaign', 'CampaignType', 'Recording', 'Tts', 'ContactGroup', 'Gateway', 'Survey');

    /**
     * Component
     * @var array 
     */
    public $components = array('DataTableLogic', 'AppLogic', 'Session', 'CampaignLogic');

    function beforeFilter() {
        $this->pageTitle = __('Campaigns');
        $this->request->data = Sanitize::clean($this->request->data, array('encode' => false));

        $this->columns = $this->_getCampaignString();
        $this->defaultSort = 'name';
        $this->defaultWidth = self::_DEFAULT_WIDTH_;
        $this->set('tblHeader', $this->columns);

        return parent::beforeFilter();
    }

    public function index() {
        
    }

    public function add() {
        $groups = $this->AppLogic->getAllData($this->ContactGroup);
        $gateways = $this->AppLogic->getAllData($this->Gateway);
        $recordings = $this->AppLogic->getAllData($this->Recording);
        $data = $this->CampaignLogic->getData($recordings, $this->Recording, 'name');
        $this->set('groups', $groups);
        $this->set('gateways', $gateways);
        $this->set('data', $data);
    }

    /*
     * Edit Campaign Information
     */

    public function edit($id = null) {
        $campaign = $this->Campaign->findByCampaignId($id);
        $groups = $this->AppLogic->getAllData($this->ContactGroup);
        $gateways = $this->AppLogic->getAllData($this->Gateway);
        if (intval($campaign['Campaign']['camp_type_id']) === 1) {
            $list = $this->AppLogic->getAllData($this->Recording);
            $data = $this->CampaignLogic->getData($list, $this->Recording, 'name');
            
        } elseif (intval($campaign['Campaign']['camp_type_id']) === 2) {
            $list = $this->AppLogic->getAllData($this->Survey);
            $data = $this->CampaignLogic->getData($list, $this->Survey, 'question');
            
        } elseif (intval($campaign['Campaign']['camp_type_id']) === 3) {
            $list = $this->AppLogic->getAllData($this->Tts);
            $data = $this->CampaignLogic->getData($list, $this->Tts, 'name');
        }
        
        $this->set('data', $data);
        $this->set('groups', $groups);
        $this->set('gateways', $gateways);
        $this->set('edit', true);
        $this->set('campaign_id', $id);
        $this->set('campaign', $campaign);
    }

    /*
     * Update into database
     */

    public function save() {
        $this->layout = false;
        $ret = false;
        $errors = array();
        if (isset($this->request->data)) {
            $checkTime = $this->CampaignLogic->checkTimeRange($this->request->data);
            if ($checkTime === self::_CAMPAIGN_START_DATE_WRONG_) {
                array_push($errors, __('please select start date'));
            } else if ($checkTime === self::_CAMPAIGN_END_DATE_WRONG_) {
                array_push($errors, __('please select end date'));
            } else if ($checkTime === self::_CAMPAIGN_START_TIME_WRONG_) {
                array_push($errors, __('please select start time'));
            } else if ($checkTime === self::_CAMPAIGN_END_TIME_WRONG_) {
                array_push($errors, __('please select end time'));
            } else if ($checkTime === self::_CAMPAIGN_DATE_TIME_WRONG_) {
                array_push($errors, __('Start time must be less than end time'));
            } else {
                $this->request->data['start_at'] = date ("Y-m-d H:i:s", strtotime($this->request->data['start_date'] . ' ' . $this->request->data['start_time'])) ;
                $this->request->data['stop_at'] = date ("Y-m-d H:i:s", strtotime($this->request->data['stop_date'] . ' ' . $this->request->data['end_time'])) ;
                
                $this->Campaign->set($this->request->data);
                if (!$this->Campaign->validates()) {
                    foreach ($this->Campaign->invalidFields() as $val) {
                        array_push($errors, $val[0]);
                    }
                } else {
                    $ret = $this->AppLogic->save($this->request->data, $this->Campaign);
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
    }

    public function exec() {
        $this->layout = false;
        if (isset($this->request->data['header']) &&
                $this->request->data['header'] === CampaignController::_HEADER_) {
            $status = 1;
        }

        $this->set('list', null);
        $this->set('status', STATUS_OK);
        $this->set('errors', null);
        $this->set('message', MESSAGE_OK);
    }
    
    /**
     * start Campaign
     * @param type $camp_id 
     */
    public function start($camp_id= null) {
        $data = array(
            'status' => self::_CAMPAIGN_ACTIVE_,
            'modified_date' => date("Y-m-d H:i:s", $_SERVER['REQUEST_TIME'])
        );
        
        $this->Campaign->read(null, $camp_id);
        $this->Campaign->set($data);
        $this->Campaign->save();
        $this->redirect('/campaign');
    }
    
    /**
     * Pause Campaign
     * @param type $camp_id 
     */
    public function pause($camp_id = null) {
        $data = array(
            'status' => self::_CAMPAIGN_PAUSED_,
            'modified_date' => date("Y-m-d H:i:s", $_SERVER['REQUEST_TIME'])
        );
        
        $this->Campaign->read(null, $camp_id);
        $this->Campaign->set($data);
        $this->Campaign->save();
        $this->redirect('/campaign');
    }
    
    /*
     *  Stop campaign
     */
    public function stop($camp_id= null) {
        $data = array(
            'status' => self::_CAMPAIGN_STOP_,
            'modified_date' => date("Y-m-d H:i:s", $_SERVER['REQUEST_TIME'])
        );
        
        $this->Campaign->read(null, $camp_id);
        $this->Campaign->set($data);
        $this->Campaign->save();
        $this->redirect('/campaign');
    }

    public function update() {
        $this->layout = false;
        if (intval($this->request->data['campaign_type_id']) === self::_CAMPAIGN_PLAY_AUDIO_) {
            $list = $this->AppLogic->getAllData($this->Recording);
        } elseif (intval($this->request->data['campaign_type_id']) === self::_CAMPAIGN_SURVEY_) {
            $list = $this->AppLogic->getAllData($this->Survey);
        } elseif (intval($this->request->data['campaign_type_id']) === self::_CAMPAIGN_TEXT_TO_SPEECH_) {
            $list = $this->AppLogic->getAllData($this->Tts);
        }
        $this->set('list', $list);
        $this->set('status', STATUS_OK);
        $this->set('errors', null);
        $this->set('message', MESSAGE_OK);
        $this->render('exec');
    }

    public function delete() {
        $this->layout = false;
        $ids = $this->request->data['ids'];
        $ret = false;

        if (isset($ids)) {
            $ret = $this->AppLogic->deleteMultiple($ids, $this->Campaign);
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
            $ret = $this->Campaign->delete($id);
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
        $this->redirect('/campaign');
    }

    /**
     * Process data table
     */
    public function process() {
        $this->layout = false;
        $jsonData = $this->DataTableLogic->processDataTable(
                $this->request->data, $this->Campaign, $this->columns);

        $this->set(compact('jsonData'));
    }

    /**
     * List of key-value to be displayed in Tts controller
     * @return array
     */
    private function _getCampaignString() {
        return array(
            'tickbox' => array('name' => CHECK_BOX, 'width' => 20, 'align' => CENTER_ALIGNMENT),
            'campbox' => array('name' => __('Operations'), 'width' => 130, 'align' => CENTER_ALIGNMENT),
            'status' => array('name' => __('Status'), 'width' => 50, 'align' => CENTER_ALIGNMENT, 'sorting' => TRUE),
            'name' => array('name' => __('Name'), 'width' => 205, 'align' => CENTER_ALIGNMENT, 'sorting' => TRUE),
            'caller' => array('name' => __('Caller name'), 'width' => 100, 'align' => CENTER_ALIGNMENT, 'sorting' => TRUE),
            'camp_type_id' => array('name' => __('Type'), 'width' => 100, 'align' => CENTER_ALIGNMENT, 'sorting' => TRUE),
            'start_at' => array('name' => __('Start time'), 'width' => 100, 'align' => CENTER_ALIGNMENT, 'sorting' => TRUE),
            'stop_at' => array('name' => __('Stop time'), 'width' => 100, 'align' => CENTER_ALIGNMENT, 'sorting' => TRUE)
        );
    }

}
