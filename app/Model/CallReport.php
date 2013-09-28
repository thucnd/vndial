<?php

/**
 * CallReportModel.php
 *
 * Model to manipulate table broadcast_call_reports
 *
 * $Id: CallReportModel.php 2013/09/22 thucnd$
 * 
 */
class CallReport extends AppModel {
     public $belongsTo = array(
        'Campaign' => array(
            'className' => 'Campaign',
            'fields' => 'name',
            'foreignKey' => 'campaign_id'
        )
    );
    /**
     * Alias for CallReport model
     *
     * @var string
     */
    public $name = 'CallReport';
    
    /**
     * Primary key for this model
     * @var string
     */
    public $primaryKey = 'call_report_id';

    /**
     * Database table name for call_report model
     *
     * @var string
     */
    public $useTable = 'call_reports';

    /**
     * Table name for call_report model
     * @var string 
     */
    public $table = 'call_reports';

    /**
     * Default order to be displayed on web inteface
     * @var array 
     */
    public $order = array(
        'CallReport.call_report_id DESC'
    );
    
    
    /**
     * Retrieve list of call_report with default <link>$order</link>
     * @return array List of call_report
     */
    public function getCallReportList() {
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
     * Get list of call_report by specific condition
     * @return array List of call_report by specific condition
     */
    public function getCallReportListByCondition() {
        return $this->getListByCondition();
    }
}

?>
