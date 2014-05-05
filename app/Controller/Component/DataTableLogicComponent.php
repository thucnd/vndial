<?php

/**
 * GatewayLogicComponent.php
 *
 * Gateway logic
 *
 * $Id: GatewayLogicComponent.php 2013/01/22 khanhle$
 * 
 */
App::uses('Component', 'Controller');

/**
 * Gateway logic
 *
 */
class DataTableLogicComponent extends Component {

    const _TICK_BOX_ = '<input class="child-tickbox" type="checkbox" name="%s" value=""><span class="lbl"></span>';
    const _EDIT_BOX_ = '
                            <a class="edit btn btn-mini btn-info" href="%s"><i class="icon-edit"></i></a>
                            <a class="edit btn btn-mini btn-danger" href="%s"><i class="icon-trash "></i></a>
                        ';
    const _CAMP_BOX_ = '
                            <a class="edit btn btn-mini" href="%s"><i class="icon-play bigger-120"></i></a>
                            <a class="edit btn btn-mini" href="%s"><i class="icon-pause bigger-120"></i></a>
                            <a class="edit btn btn-mini" href="%s"><i class="icon-stop bigger-120"></i></a>
                            <a class="edit btn btn-mini btn-info" href="%s"><i class="icon-edit bigger-120"></i></a>
                            <a class="edit btn btn-mini btn-danger" href="%s"><i class="icon-trash bigger-120"></i></a>
                        ';
    
    /**
     * An array containing the class names of models this controller uses.
     * @var array 
     */
    public $uses = array('Recording', 'Tts');

    /**
     * Component
     * @var array 
     */
    public $components = array('DataTableLogic', 'AppLogic', 'Session', 'CampaignLogic');


    /**
     * Process data table for each request
     * @param array $params
     * @param collection $model
     * @param array $columns
     * @return array Json data
     */
    public function processDataTable($params, $model, $columns) {
        // get request params
        $page = isset($params['page']) ? $params['page'] : 1;
        $rp = isset($params['rp']) ? $params['rp'] : 10;
        $sortname = isset($params['sortname']) ? $params['sortname'] : 'name';
        $sortorder = isset($params['sortorder']) ? $params['sortorder'] : 'desc';
        $query = isset($params['query']) ? $params['query'] : false;
        $qtype = isset($params['qtype']) ? $params['qtype'] : false;
        // searching
        if ($query && !strstr($qtype, 'box')) {
            $model->conditions = array(
                sprintf(
                        '%s.%s like', $model->name, $qtype
                ) => $query . '%');
        }

        if (!strstr($sortname, 'box')) {
            $model->order = array(sprintf('%s.%s %s', $model->name, $sortname, $sortorder));
        }

        $model->offset = (($page - 1) * $rp);
        $model->limit = $rp;

        $total = $model->countRecords();
        $rows = $model->getListByCondition();

        $jsonData = array('page' => $page, 'total' => $total, 'rows' => array());
        $this->_extractRows($jsonData, $rows, $model, $columns);

        return $jsonData;
    }

    /**
     * Extract row from fetched rows
     * @param array $jsonData
     * @param array $rows
     * @param collection $model
     * @param array $columns
     */
    private function _extractRows(&$jsonData, $rows, $model, $columns) {
        foreach ($rows as $row) {
            //If cell's elements have named keys, they must match column names
            //Only cell's with named keys and matching columns are order independent.
            $cell = array();
            foreach ($columns as $key => $_value) {
                if (!strstr($key, 'box')) {
                    $cell[$key] = $row[$model->name][$key];
                }
            }
            $cell['tickbox'] = sprintf(self::_TICK_BOX_, $row[$model->name][$model->primaryKey]);
            
            // Edit box
            if (array_key_exists('editbox', $columns)) {
                $cell['editbox'] = sprintf(self::_EDIT_BOX_, strtolower($model->name) . '/edit/' . $row[$model->name][$model->primaryKey], strtolower($model->name) . '/del/' . $row[$model->name][$model->primaryKey]);
            }
            
            // Campaign box
            if (array_key_exists('campbox', $columns)) {
                $cell['campbox'] = sprintf(self::_CAMP_BOX_,
                        strtolower($model->name) . '/start/' . $row[$model->name][$model->primaryKey],
                        strtolower($model->name) . '/pause/' . $row[$model->name][$model->primaryKey],
                        strtolower($model->name) . '/stop/' . $row[$model->name][$model->primaryKey],
                        strtolower($model->name) . '/edit/' . $row[$model->name][$model->primaryKey],
                        strtolower($model->name) . '/del/' . $row[$model->name][$model->primaryKey]
                );
            }

            // Dispaly user 
            if (array_key_exists('created_by', $columns)) {
                $cell['created_by'] = '';
                $cell['created_by'] = $row['User']['username'];
            }
            
            // Display group for contact management
            if (array_key_exists('group_id', $columns)) {
                $cell['group_id'] = '';
                $cell['group_id'] = $row['ContactGroup']['name'];
            }
            
            // Display Recording
            if (array_key_exists('recording_id', $columns)) {
                $cell['recording_id'] = '';
                $cell['recording_id'] = $row['Recording']['name'];
            }
            
            // Display Campaign status
            if ($model->name === 'Campaign') {
                $arrStatus = array(1 => __('START'), 2 => __('PAUSED'), 3 => __('STOP'));
                $cell['status'] ='';
                $cell['status'] = $arrStatus[$row[$model->name]['status']];
                
                // Display Campaign Type
                $arrType = array(1 => __('Play audio'), 2 => __('Survey'), 3 => __('Text to speech'));
                $cell['camp_type_id'] ='';
                $cell['camp_type_id'] = $arrType[$row[$model->name]['camp_type_id']];
            }
            
            // Display Callrequest
            if ($model->name === 'CallRequest') {
                if (array_key_exists('campaign_id', $columns)) {
                    $cell['campaign_id'] = $row['Campaign']['name'];
                }
            }
            
            // Display CallReport
            if ($model->name === 'CallReport') {
                if (array_key_exists('campaign_id', $columns)) {
                    $cell['campaign_id'] = $row['Campaign']['name'];
                }
            }
            
            // Don't display role as  Supper admin
            if ($model->name == 'Role') {
                if (isset($row['Role']['role_id']) && $row['Role']['role_id'] == 1) {
                    continue;
                }
            }

            $entry = array('id' => $row[$model->name][$model->primaryKey],
                'cell' => $cell,
            );
            $jsonData['rows'][] = $entry;
        }
    }

}

?>
