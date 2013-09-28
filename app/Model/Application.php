<?php

/**
 * ApplicationModel.php
 *
 * Model to manipulate table broadcast_application
 *
 * $Id: ApplicationModel.php 2013/01/23 khanhle$
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
}

?>
