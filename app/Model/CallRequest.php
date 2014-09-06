<?php

/**
 * CallRequestModel.php
 *
 * Model to manipulate table broadcast_call_requests
 *
 * $Id: CallRequestModel.php 2013/01/23 khanhle$
 * 
 */
class CallRequest extends AppModel {
    public $belongsTo = array(
        'Campaign' => array(
            'className' => 'Campaign',
            'fields' => 'name',
            'foreignKey' => 'campaign_id'
        ),
        'User' => array(
            'className' => 'User',
            'fields' => 'username',
            'foreignKey' => 'user_id'
        )
    );
    
    /**
     * Alias for CallRequest model
     *
     * @var string
     */
    public $name = 'CallRequest';
    
    /**
     * Primary key for this model
     * @var string
     */
    public $primaryKey = 'call_request_id';

    /**
     * Database table name for call_request model
     *
     * @var string
     */
    public $useTable = 'call_requests';

    /**
     * Table name for call_request model
     * @var string 
     */
    public $table = 'call_requests';

    /**
     * Default order to be displayed on web inteface
     * @var array 
     */
    public $order = array(
        'CallRequest.call_request_id ASC',
        'CallRequest.caller ASC'
    );
    
    
    /**
     * Retrieve list of call_request with default <link>$order</link>
     * @return array List of call_request
     */
    public function getCallRequestList() {
        return $this->find('all');
    }

    /**
     * Total number of records
     * @return int Total number of records in this model
     */
    public function countRecords() {
        $total = $this->find('count');
        
        return $total;
    }

    /**
     * Get list of call_request by specific condition
     * @return array List of call_request by specific condition
     */
    public function getCallRequestListByCondition() {
        return $this->getListByCondition();
    }
    
    /**
     * List of key-value to be displayed in gateway controller
     * @return array
     */
    public function _getCallRequestString() {
        return array(
            'call_request_id' => array('name' => __('ID'), 'width' => 50, 'align' => CENTER_ALIGNMENT),
            'campaign_id' => array('name' => __('Campaign'), 'width' => 100, 'align' => CENTER_ALIGNMENT, 'sorting' => TRUE, 'funcData' => 'CampaignName'),
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

?>
