<?php

/**
 * CallRequestComponent.php
 *
 * 
 *
 * $Id: CallRequestComponent.php 554 2013-05-28 02:26:06Z thucnd $
 */
class CallRequestComponent extends Component {

    public $_recording;
    public $_tts;
    public $_controller;
    private $_DATABASE_CONFIG = array();

    const _CAMPAIGN_STATUS_START_ = 1;
    const _PLAY_AUDIO_ = 1;
    const _SURVEY_ = 2;
    const _TEXT_TO_SPEECH_ = 3;
    const _STATE_FIRST_APP_ = 0;
    const _STATE_END_APP_ = 99;

    function __construct() {
        error_reporting(0);
        App::import('Model', 'Recording');
        $this->_recording = new Recording;

        App::import('Model', 'Tts');
        $this->_tts = new Tts;

        // Load database connection
        App::uses('ConnectionManager', 'Model');
        $this->loadDatabaseConfig();
    }

    /**
     * Execute a sql and return result
     *
     * @param type $sql
     */
    function exeSqlQuery($sql, $flg = false) {
        try {
            $dbhandle = mysql_connect($this->_DATABASE_CONFIG['hostname'], $this->_DATABASE_CONFIG['username'], $this->_DATABASE_CONFIG['password']);
            $selected = mysql_select_db($this->_DATABASE_CONFIG['database'], $dbhandle);
        } catch (PDOException $e) {
            CustomLog::writeDebugLog("Unable to connect to MySQL");
            exit();
        }
        $result = array();
        try {
            $list = mysql_query($sql);

            if ($flg) {
                return array();
            }

            if (empty($list)) {
                return array();
            }


            //fetch data from the database
            while ($row = mysql_fetch_array($list, MYSQL_ASSOC)) {
                $result[] = $row;
            }
            //close the connection
            mysql_close($dbhandle);

            return $result;
        } catch (Exception $exc) {
            $this->log($exc->getTraceAsString());
        }
        return $result;
    }

    /**
     * loadDatabaseConfig
     */
    function loadDatabaseConfig() {
        // get database configuration
        $dataSource = ConnectionManager::getDataSource('default');

        $this->_DATABASE_CONFIG['username'] = $dataSource->config['login'];
        $this->_DATABASE_CONFIG['password'] = $dataSource->config['password'];
        $this->_DATABASE_CONFIG['hostname'] = $dataSource->config['host'];
        $this->_DATABASE_CONFIG['database'] = $dataSource->config['database'];
    }

    /**
     * getCallRequestList
     * 
     * @param type $params
     * @return array 
     */
    public function getCallRequestList($params) {
        $list = array();
        try {
            $sql = '
            SELECT 
                    call_request_id,
                    user_id,
                    campaign_id,
                    caller,
                    called,
                    status,
                    retries
            FROM call_requests
            WHERE retries < 4 AND campaign_id = ' . $params['campaign_id']
            ;

            $list = $this->exeSqlQuery($sql);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
        return $list;
    }

    /**
     * getCampaignList
     * 
     * @param type $params
     * @return type 
     */
    public function getCampaignList() {
        $list = array();
        try {
            $sql = '
                SELECT
                        camp.campaign_id,
                        camp.caller,
                        camp.status,
                        camp.camp_type_id,
                        camp.app_type_id,
                        camp.repeat_total,
                        camp.app_id,
                        cnt.phone,
                        gate.gateways,
                        gate.gateway_codecs,
                        gate.gateway_timeouts,
                        gate.gateway_retries,
                        gate.gateway_originates
                FROM campaigns camp
                INNER JOIN contacts cnt
                    ON cnt.group_id = camp.group_id
                INNER JOIN voice_gateways gate
                    ON gate.gateway_id = camp.a_leg
                WHERE camp.status = ' . self::_CAMPAIGN_STATUS_START_
                    . ' GROUP BY camp.campaign_id '
            ;

            $list = $this->exeSqlQuery($sql);
        } catch (Exception $exc) {
            $this->log('Error code: ' . $exc->getTraceAsString());
        }
        return $list;
    }

    /**
     * getAppInfo
     * @param type $params
     * @return array 
     */
    public function getAppInfo($params) {
        $list = array();
        try {
            switch (intval($params['camp_type_id'])) {
                case self::_PLAY_AUDIO_:
                    $list = $this->getPlayAudioList($params);
                    break;
                case self::_TEXT_TO_SPEECH_:
                    $list = $this->getTtsList($params);
                    break;
                default:
                    break;
            }
        } catch (Exception $exc) {
            $this->log('Error code: ' . $exc->getTraceAsString());
        }

        return $list;
    }

    /**
     * getPlayAudioList
     * 
     * @param type $params
     * @return string 
     */
    public function getPlayAudioList($params) {
        $data = array();
        try {
            $files = $this->_recording->findAllByRecordingId($params['app_type_id']);
            $appParam = array();

            // Get Params
            $appParam['target'] = 'playAudio';
            $appParam['file_name'] = $files[0]['Recording']['path'];
            $data[0]['current'] = STATE_FIRST_APP;
            $data[0]['params'] = json_encode($appParam);
            $data[0]['next'] = STATE_END_APP;
            $data[0]['campaign_id'] = $params['campaign_id'];
        } catch (Exception $exc) {
            $this->log('Error code: ' . $exc->getTraceAsString());
        }
        return $data;
    }

    /**
     * getTtsList
     * @param type $params 
     * @return string 
     */
    public function getTtsList($params) {
        $data = array();
        try {
            $tts = $this->_tts->findByTtsId($params['app_type_id']);
            $appParam = array();

            // Get Params
            $appParam['target'] = 'textToSpeech';
            $appParam['data'] = $tts['Tts']['text_data'];
            $data[0]['current'] = STATE_FIRST_APP;
            $data[0]['params'] = json_encode($appParam);
            $data[0]['next'] = STATE_END_APP;
            $data[0]['campaign_id'] = $params['campaign_id'];
        } catch (Exception $exc) {
            $this->log('Error code: ' . $exc->getTraceAsString());
        }

        return $data;
    }

    /**
     * getCallRequestList
     * 
     * @param type $params
     * @return type 
     */
    public function getCallRequestQueue() {
        $list = array();
        try {
            $sql = "
                SELECT
                        camp.campaign_id,
                        camp.caller,
                        camp.status,
                        camp.camp_type_id,
                        camp.app_type_id,
                        camp.repeat_total,
                        camp.created_by,
                        cnt.phone
                FROM campaigns camp
                INNER JOIN contacts cnt
                    ON cnt.group_id = camp.group_id
                WHERE status = " . self::_CAMPAIGN_STATUS_START_ . " AND flg_on = 0
                
             "
            ;

            $list = $this->exeSqlQuery($sql);
        } catch (Exception $exc) {
            $this->log('Error code: ' . $exc->getTraceAsString());
        }
        return $list;
    }

    /**
     * getApplicationInfo
     * @param type $app_id
     * @return type 
     */
    public function getApplicationInfo($app_id) {
        $list = array();
        try {
            $sql = "
                SELECT
                        *
                FROM broadcast_application 
                WHERE app_id = $app_id
             "
            ;

            $list = $this->exeSqlQuery($sql);
        } catch (Exception $exc) {
            $this->log('Error code: ' . $exc->getTraceAsString());
        }
        return $list;
    }

    /**
     * getAppNext
     * @param type $app_id 
     */
    function getAppNext($params) {
        $list = array();
        try {
            $params[0]['campaign_id'] = 13;
            $sql = "
                SELECT
                        app_id
                FROM broadcast_application 
                WHERE campaign_id = " . $params[0]['campaign_id']
                    . " AND current=" . $params[0]['next']
            ;
            $list = $this->exeSqlQuery($sql);
            if (count($list) > 0) {
                return $list[0]['app_id'];
            }
        } catch (Exception $exc) {
            $this->log('Error code:' . $exc->getTraceAsString());
        }
        return 0;
    }

    /**
     * getSettingList
     * 
     * @return type 
     */
    public function getSettingList() {
        $data = array();
        try {
            $sql = "
                SELECT
                        *
                FROM broadcast_voice_settings "
            ;
            $list = $this->exeSqlQuery($sql);

            foreach ($list as $key => $value) {
                $data[$value['key']] = $value['value'];
            }
        } catch (Exception $exc) {
            $this->log('Error code:' . $exc->getTraceAsString());
        }

        return $data;
    }

    /**
     * insReport
     * 
     * @param type $params 
     */
    public function insReport($params) {
        try {

            $sql = "
                INSERT INTO call_reports (user_id, campaign_id, caller, called, aLegrequestuuid, start_time, created_date)
                VALUES (
                     " . $params['user_id'] . "
                    ," . $params['campaign_id'] . "
                    ,'" . $params['from'] . "'
                    ,'" . $params['to'] . "'
                    ,'" . $params['aLegrequestuuid'] . "'
                    ,'" . date("Y-m-d H:i:s", $_SERVER['REQUEST_TIME']) . "'
                    ,'" . date("Y-m-d H:i:s", $_SERVER['REQUEST_TIME']) . "'
                )";

            $this->exeSqlQuery($sql, true);
        } catch (Exception $exc) {
            $this->log('Error code:' . $exc->getTraceAsString());
        }
    }

    /**
     * updateReport
     * 
     * @param type $params 
     */
    public function updateReport($params) {
        try {
            $sql = "
                UPDATE 
                    call_reports 
                SET
                    direction = '" . $this->escapeValue($params['Direction']) . "'
                   ,caller = '" . $this->escapeValue($params['From']) . "'
                   ,called = '" . $this->escapeValue($params['To']) . "'
                   ,callername = '" . $this->escapeValue($params['CallerName']) . "'
                   ,call_status = '" . $this->escapeValue($params['CallStatus']) . "'
                   ,aLeguuid = '" . $this->escapeValue($params['ALegUUID']) . "'
                   ,calluuid = '" . $this->escapeValue($params['CallUUID']) . "'
                   ,hangupcause = '" . $this->escapeValue($params['HangupCause']) . "'
                   ,end_time = '" . date("Y-m-d H:i:s", $_SERVER['REQUEST_TIME']) . "'
                WHERE
                    aLegrequestuuid = '" . $params['ALegRequestUUID'] . "'
            ";
            $this->exeSqlQuery($sql, true);
        } catch (Exception $exc) {
            $this->log('Error code:' . $exc->getTraceAsString());
        }
    }

    /**
     * updateCallRequest
     * 
     * @param type $params 
     */
    public function updateCallRequest($params) {
        try {
            if (!isset($params['retries']) || $params['retries'] == '' || is_null($params['retries'])) {
                $params['retries'] = 0;
            } else {
                $params['retries'] = intval($params['retries']) + 1;
            }

            $sql = "
                UPDATE 
                    call_requests
                SET
                    retries = " . $params['retries'] . "
                   ,requestuuid = '" . $this->escapeValue($params['aLegrequestuuid']) . "'
                   ,start_time = '" . date("Y-m-d H:i:s", $_SERVER['REQUEST_TIME']) . "'
                WHERE
                    call_request_id = " . $params['call_request_id'] . "
            ";
             $this->exeSqlQuery($sql, true);
        } catch (Exception $exc) {
            $this->log('Error code:' . $exc->getTraceAsString());
        }
    }

    /**
     * removeCallRequest
     * 
     * @param type $params 
     */
    function removeCallRequest($params) {
        try {
            $sql = "
                DELETE
                FROM 
                    call_requests
                WHERE
                    requestuuid = '" . $params['ALegRequestUUID'] . "'
            ";
            $this->exeSqlQuery($sql, true);
        } catch (Exception $exc) {
            $this->log('Error code:' . $exc->getTraceAsString());
        }
    }

    /**
     * escapeValue
     * 
     * @param type $params
     * @return string 
     */
    function escapeValue($params) {
        try {
            if (!isset($params)) {
                return 'NULL';
            }
            if (is_null($params) || $params === '') {
                return 'NULL';
            }
            return $params;
        } catch (Exception $exc) {
            return 'NULL';
        }
        return 'NULL';
    }

}

?>