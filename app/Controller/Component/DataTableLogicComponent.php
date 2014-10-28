<?php
/**
 * GatewayLogicComponent.php
 *
 * Gateway logic
 *
 * $Id: GatewayLogicComponent.php 2013/01/22 thucnd$
 * 
 */
App::uses('Component', 'Controller');
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
        $jsonData = $this->_extractRows($jsonData, $rows, $model, $columns);

        return $jsonData;
    }

    /**
     * Extract row from fetched rows
     * @param array $jsonData
     * @param array $rows
     * @param collection $model
     * @param array $columns
     */
    private function _extractRows($jsonData, $rows, $model, $columns) {
        foreach ($rows as $row) {
            //If cell's elements have named keys, they must match column names
            //Only cell's with named keys and matching columns are order independent.
            $cell = array();
            foreach ($columns as $key => $column) {
                if(isset($column['funcBox']) && !is_null($column['funcBox'])) {
                    $cell[$key] = $this->{'get'.$column['funcBox']}($row, $model);
                } elseif(isset($column['funcData']) && !is_null($column['funcData'])) {
                    $cell[$key] = $this->{'get'. $column['funcData']}($row);
                } else {
                    $cell[$key] = $row[$model->name][$key];
                }
            }  
            // Don't display role as  Supper admin
            if ($model->name == 'Role') {
                if (isset($row['Role']['role_id']) && $row['Role']['role_id'] == SUPPER_ADMIN) {
                    continue;
                }
            }
            $entry = array('id' => $row[$model->name][$model->primaryKey],
                'cell' => $cell,
            );
            $jsonData['rows'][] = $entry;
        }
        return $jsonData;
    }    
    /**
     * Display Check Box
     * @param type $model
     * @return string
     */
    private function getTickBox($row, $model) {
        return sprintf(self::_TICK_BOX_, $row[$model->name][$model->primaryKey]);
    }    
    /**
     * Display Edit box
     * @param type $model
     * @return string
     */
    private function getEditBox($row, $model) {
        return sprintf(self::_EDIT_BOX_, strtolower($model->name) . '/edit/' . $row[$model->name][$model->primaryKey], strtolower($model->name) . '/del/' . $row[$model->name][$model->primaryKey]);
    }    
    /**
     * Display Campaign Box
     * @param type $model
     * @return string
     */
    private function getCampBox($row, $model) {
        return sprintf(self::_CAMP_BOX_,
                        strtolower($model->name) . '/start/' . $row[$model->name][$model->primaryKey],
                        strtolower($model->name) . '/pause/' . $row[$model->name][$model->primaryKey],
                        strtolower($model->name) . '/stop/' . $row[$model->name][$model->primaryKey],
                        strtolower($model->name) . '/edit/' . $row[$model->name][$model->primaryKey],
                        strtolower($model->name) . '/del/' . $row[$model->name][$model->primaryKey]
                );
    }    
    /**
     * Display Created By
     * @param type $row
     * @return string
     */
    private function getCreatedBy($row) {
        return $row['User']['username'];
    }    
    /**
     * Get Contact Group Name
     * @param type $row
     * @return type
     */
    private function getGroupName($row){
        return $row['ContactGroup']['name'];
    }
    /**
     * Get Recording Name
     * @param type $row
     * @return string
     */
    private function getRecordingName($row){
        return $row['Recording']['name'];
    }    
    /**
     * Get Campaign Name
     * @param type $row
     * @return string
     */
    private function getCampaignName($row){
        return $row['Campaign']['name'];
    }
    /**
     * Get Gateway Name
     * @param type $row
     * @return string
     */
    private function getGatewayName($row){
        return $row['Gateway']['name'];
    }
    /**
     * Get Role Name
     * @param type $row
     * @return string
     */
    private function getRoleName($row){
        return $row['Role']['role_name'];
    }
    /**
     * Display Status
     * @param type $row
     * @return string
     */
    private function getStatus($row){  
        App::uses('CampaignStatus', 'Model');
        return CampaignStatus::$fields[$row['Campaign']['status']];
    }
    /**
     * Display Campaign Type
     * @param type $row
     */
    private function getCampaignType($row){
        App::uses('CampaignType', 'Model');
        return CampaignType::$fields[$row['Campaign']['camp_type_id']];
    }
}
?>
