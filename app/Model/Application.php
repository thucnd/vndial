<?php

/**
 * ApplicationModel.php
 *
 * Model to manipulate table broadcast_application
 *
 * $Id: ApplicationModel.php 2013/01/23 thucnd
 * 
 */
class Application extends AppModel {
    /**
     * Alias for application model
     *
     * @var string
     */
    public $name = 'Application';
    
    /**
     * Primary key for this model
     * @var string
     */
    public $primaryKey = 'app_id';

    /**
     * Database table name for application model
     *
     * @var string
     */
    public $useTable = 'broadcast_application';

    /**
     * Table name for application model
     * @var string 
     */
    public $table = 'broadcast_application';

    /**
     * Default order to be displayed on web inteface
     * @var array 
     */
    public $order = array(
        'Application.app_id ASC'
    );
    
    
    /**
     * Retrieve list of application with default <link>$order</link>
     * @return array List of application
     */
    public function getApplicationList() {
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
     * Get list of application by specific condition
     * @return array List of application by specific condition
     */
    public function getApplicationListByCondition() {
        return $this->getListByCondition();
    }
    
    /**
     * List of key-value to be displayed in gateway controller
     * @return array
     */
    public function _getApplicationString() {
        return array(
            'tickbox' => array('name' => CHECK_BOX, 'width' => 25, 'align' => CENTER_ALIGNMENT, 'funcBox' => 'TickBox'),
            'app_id' => array('name' => __('ID'), 'width' => 50, 'align' => LEFT_ALIGNMENT),
            'name' => array('name' => __('Name'), 'width' => 50, 'align' => LEFT_ALIGNMENT),
            'description' => array('name' => __('Description'), 'width' => 50, 'align' => LEFT_ALIGNMENT),
            'app_type_id' => array('name' => __('App Type'), 'width' => 50, 'align' => LEFT_ALIGNMENT),
            'b_leg' => array('name' => __('Last Name'), 'width' => 50, 'align' => LEFT_ALIGNMENT),
            'data' => array('name' => __('Data'), 'width' => 50, 'align' => LEFT_ALIGNMENT),
            'tts_id' => array('name' => __('TTS'), 'width' => 50, 'align' => LEFT_ALIGNMENT),
            'user_id' => array('name' => __('User'), 'width' => 50, 'align' => LEFT_ALIGNMENT),
            'created_date' => array('name' => __('Created Date'), 'width' => 50, 'align' => LEFT_ALIGNMENT),
            'created_by' => array('name' => __('Created By'), 'width' => 50, 'align' => LEFT_ALIGNMENT, 'funcData' => 'CreatedBy'),
            'editbox' => array('name' => __('Edit'), 'width' => 20, 'align' => CENTER_ALIGNMENT, 'funcBox' => 'EditBox'),
        );
    }
}

?>
