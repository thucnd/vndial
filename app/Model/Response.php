<?php

/**
 * ResponseModel.php
 *
 * Model to manipulate table broadcast_survey_response
 *
 * $Id: ResponseModel.php 2013/01/19 khanhle$
 * 
 */
class Response extends AppModel {

    /**
     * Alias for response model
     *
     * @var string
     */
    public $name = 'Response';
    
    /**
     * Primary key for this model
     * @var string
     */
    public $primaryKey = 'response_id';

    /**
     * Database table name for response model
     *
     * @var string
     */
    public $useTable = 'broadcast_survey_response';

    /**
     * Table name for response model
     * @var string 
     */
    public $table = 'broadcast_survey_response';

    /**
     * Default order to be displayed on web inteface
     * @var array 
     */
    public $order = array(
        'Response.response_id ASC',
    );
    

    /**
     * Retrieve list of response with default <link>$order</link>
     * @return array List of response
     */
    public function getResponseList() {
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
     * Get list of response by specific condition
     * @return array List of Response by specific condition
     */
    public function getResponseListByCondition() {
        return $this->getListByCondition();
    }
}

?>
