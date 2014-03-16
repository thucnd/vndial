<?php

/**
 * CampaignComponent.php
 *
 * 
 *
 * $Id: CampaignComponent.php 554 2013-04-29 02:26:06Z thucnd $
 */
class CampaignLogicComponent extends Component {

    public $components = array('RequestHandler', 'Session');
    public $_campaignModel;

    function __construct() {
        App::import('Model', 'Campaign');
        $this->_campaignModel = new Campaign;
    }
    
    /**
     *
     * Check start time and end time
     * 
     * @param type $params
     * @return true or false if fails 
     */
    function  checkTimeRange($params) {

        if (!isset($params['start_date']) || $params['start_date'] == null) {
            return -1;
        }
        
        if (!isset($params['stop_date']) || $params['stop_date'] == null) {
            return -2;
        }
        
        if (!isset($params['start_time']) || $params['start_time'] == null) {
            return -3;
        }
        
        if (!isset($params['end_time']) || $params['end_time'] == null) {
            return -4;
        }
        
        $startTime = $params['start_date'] . ' ' . $params['start_time'];
        $emdTime = $params['stop_date'] . ' ' . $params['end_time'];
        
        if(strtotime($startTime) > strtotime($emdTime)) {
            return -5;
        }
        return 1;
    }
    
    /**
     * getData
     * @param type $data
     * @param type $model
     * @return array 
     */
    function getData($data, $model, $column) {
        $list = array();
        $i=0;
        foreach ($data as $key => $value) {
            $list[$i]['key'] = $value[$model->name][$model->primaryKey];
            $list[$i]['name'] = $value[$model->name][$column];
            $i++;
        }
        return $list;
    }
          
}

?>