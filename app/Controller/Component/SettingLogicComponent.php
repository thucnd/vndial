<?php

/**
 * SettingComponent.php
 *
 * 
 *
 * $Id: SettingComponent.php 554 2013-03-06 02:26:06Z thucnd $
 */
class SettingLogicComponent extends Component {

    public $components = array('RequestHandler', 'Session');
    public $_settingModel;

    function __construct() {
        App::import('Model', 'Setting');
        $this->_settingModel = new Setting;
    }
    
    /**
     * updateSetting
     * 
     * Update setting information
     * 
     * @param type $key
     * @param type $value
     * @return boolean
     */
    function updateSetting($key, $value) {
        try {
            $sql = "insert into broadcast_voice_settings 
                                                    values('" . $key . "','" . $value . "') 
                                                    ON DUPLICATE KEY UPDATE 
                                                        value='" . $value . "'";
            $this->_settingModel->query($sql);
            $this->_settingModel->commit();
            return TRUE;
        } catch (PDOException $err) {
            $this->log('error_code:' . $err->getCode(), 'debug');
            $this->log('error_message:' . $err->getMessage(), 'debug');
            return FALSE;
        }
        return TRUE;
    }
    
    /**
     * saveSetting
     * 
     * Save information about setting
     * 
     * @param type $params
     * @return boolean
     */
    function saveSetting($params) {
        
        if(!$this->validate($params)) {
            return FALSE;
        }
        
        foreach ($params as $key => $value) {
            $this->updateSetting($key, $value);
        }
        return true;
    }
    
    /**
     * validate
     * 
     * validate params
     * 
     * @param type $params
     * @return boolean
     */
    function validate($params) {
        foreach ($params as $key => $value) {
            if($value === null || trim($value) === '') {
                return FALSE;
            }
        }
        return true;
    }
    
    /**
     * getSettingList
     * 
     * Get setting information
     * 
     * @return type 
     */
    public function getSettingList() {
        $list = $this->_settingModel->find('all');
        $data = array();
        foreach ($list as $key => $value) {
            $data[$value['setting']['key']] = $value['setting']['value'];
        }
        return $data;
    }
    
    /**
     *
     * getSettingInfo
     * 
     * Get setting information
     * 
     * @param type $Settings
     * @param type $key
     * @param type $default
     * @return type 
     */
    function getSettingInfo($Settings, $key, $default='') {
        if(array_key_exists($key,$Settings)) {
            return $Settings[$key];
        } else {
            return $default;
        }
    }

}

?>