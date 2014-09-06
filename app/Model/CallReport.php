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
    
    /**
     * List of key-value to be displayed in gateway controller
     * @return array
     */
    public function _getCallReportString() {
        return array(
            'call_report_id' => array('name' => __('ID'), 'width' => 50, 'align' => CENTER_ALIGNMENT),
            'campaign_id' => array('name' => __('Campaign'), 'width' => 50, 'align' => CENTER_ALIGNMENT, 'sorting' => TRUE, 'funcData' => 'CampaignName'),
            'caller' => array('name' => __('From'), 'width' => 100, 'align' => CENTER_ALIGNMENT, 'sorting' => TRUE),
            'called' => array('name' => __('To'), 'width' => 100, 'align' => CENTER_ALIGNMENT, 'sorting' => TRUE),
            'start_time' => array('name' => __('Start Time'), 'width' => 100, 'align' => CENTER_ALIGNMENT, 'sorting' => TRUE),
            'end_time' => array('name' => __('End Time'), 'width' => 100, 'align' => CENTER_ALIGNMENT, 'sorting' => TRUE),
            'hangupcause' => array('name' => __('Hangup'), 'width' => 100, 'align' => CENTER_ALIGNMENT, 'sorting' => TRUE),
            'created_date' => array('name' => __('Created Date'), 'width' => 100, 'align' => CENTER_ALIGNMENT, 'sorting' => TRUE)
        );
    }
}

?>
