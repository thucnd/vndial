<?php

/**
 * SettingModel.php
 *
 * Model to manipulate table broadcast_voice_settings
 *
 * $Id: GatewayModel.php 2013/01/19 Thucnd$
 * 
 */
class Setting extends AppModel {

    /**
     * Alias for setting model
     *
     * @var string
     */
    public $name = 'setting';

    /**
     * Primary key for this model
     * @var string
     */
    public $primaryKey = 'key';

    /**
     * Database table name for setting model
     *
     * @var string
     */
    public $useTable = 'broadcast_voice_settings';

    /**
     * Table name for setting model
     * @var string 
     */
    public $table = 'broadcast_voice_settings';

    /**
     * Default order to be displayed on web inteface
     * @var array 
     */
    public $order = array(
        'setting.key ASC'
    );

    /**
     *
     * Validate fields  
     */
    public $validate = array(
    );

    /**
     * validates
     * 
     * @param type $data
     * @return boolean 
     */
    function validates($data = array()) {
        if (empty($data)) {
            $data = $this->data;
        }
        parent::validates($data);
        if (count($this->validationErrors) > 0) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * getSettingList
     * 
     * Get setting information
     * 
     * @return type 
     */
    public function getSettingList() {
        $list = $this->find('all');
        $data = array();
        foreach ($list as $key => $value) {
            $data[$value['setting']['key']] = $value['setting']['value'];
        }
        return $data;
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
     * Get list of setting by specific condition
     * @return array List of Setting by specific condition
     */
    public function getSettingListByCondition() {
        return $this->getListByCondition();
    }

}

?>
