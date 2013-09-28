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
}

?>
