<?php

/**
 * CallRequestShell.php
 *
 * Get all calls request and update
 *
 * $Id: CallRequestShell.php 2013/05/28 thucnd$
 * 
 */
App::uses('Shell', 'Console');
App::uses('ComponentCollection', 'Controller');
App::uses('CallRequestComponent', 'Controller/Component');

class CallRequestShell extends AppShell {

    private $_callRequestLogic = null;
    public $uses = array('Campaign', 'Contact', 'CallRequest', 'Application');

    const _CAMPAIGN_STATUS_START_ = 1;

    function startup() {
        $collection = new ComponentCollection();
        $this->_callRequestLogic = new CallRequestComponent();
    }

    /**
     *  Main program
     */
    public function main() {
        $this->out('Start update calls into queue !!!');
        $campaigns = $this->_callRequestLogic->getCallRequestQueue();

        $data = array();
        foreach ($campaigns as $campaign) {
            $callRequest = array();
            if (intval($campaign['phone']) > 0) {
                $callRequest['campaign_id'] = $campaign['campaign_id'];
                $callRequest['user_id'] = $campaign['created_by'];
                $callRequest['caller'] = $campaign['caller'];
                $callRequest['called'] = $campaign['phone'];
                $callRequest['status'] = 0;
                $callRequest['created_date'] = date("Y-m-d H:i:s", $_SERVER['REQUEST_TIME']);

                // Create new application
                $app = array();
                $list = $this->_callRequestLogic->getAppInfo($campaign);
                if (count($list) > 0) {
                    if (!in_array($campaign['campaign_id'], $data)) {
                        $i= 0;
                        foreach ($list as $value) {
                            $this->Application->create();
                            $app = $this->Application->save($value);
                            
                            if($i === 0) {
                                $this->Campaign->id = $campaign['campaign_id'];
                                $this->Campaign->saveField('app_id', $app['Application']['app_id']);
                            }
                            $i++;
                        }
                        array_push($data, $campaign['campaign_id']);
                    }

                    // Create new call request
                    $this->CallRequest->create();
                    $this->CallRequest->save($callRequest);
                }
            }
        }

        foreach ($data as $value) {
            $this->Campaign->id = $value;
            $this->Campaign->saveField('flg_on', 1);
        }
        $this->out('End process !!!');
    }

}
