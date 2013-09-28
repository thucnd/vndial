<?php

/**
 * PlivoComponent.php
 *
 * 
 *
 * $Id: PlivoComponent.php 554 2013-06-13 02:26:06Z thucnd $
 */
require_once VENDORS . 'plivo/plivohelper.php';

class PlivoLogicComponent extends Component {

    public $_VOIP_CONFIG = array();
    public $callQueue = array();
    public $callState = array();
    public $helpers = array('App');
    public $_campaignModel;
    public $_appModel;
    public $SettingLogic;
    public $CallRequestComponent;

    const _STATE_FIRST_APP_ = 0;
    const _STATE_END_APP_ = 99;

    function __construct() {
        // load setting Model
        App::import('Model', 'Setting');
        $this->_settingModel = new Setting;

        App::import('Model', 'Application');
        $this->_appModel = new Application;

        // Load setting
        App::uses('SettingLogicComponent', 'Controller/Component');
        $collection = new ComponentCollection();
        $this->SettingLogic = new SettingLogicComponent($collection);
        
        App::uses('CallRequestComponent', 'Controller/Component');
        $collection = new ComponentCollection();
        $this->CallRequestComponent = new CallRequestComponent($collection);

        // load voip configure
        $this->loadVoipConfig();
    }

    /**
     *  loadVoipConfig
     */
    function loadVoipConfig() {
        $data = $this->CallRequestComponent->getSettingList();
        $this->_VOIP_CONFIG['broadcast_app_root'] = $this->SettingLogic->getSettingInfo($data, 'broadcast_app_root', 'http://127.0.0.1');
        $this->_VOIP_CONFIG['plivo_address'] = $this->SettingLogic->getSettingInfo($data, 'plivo_address', '127.0.0.1');
        $this->_VOIP_CONFIG['plivo_port'] = $this->SettingLogic->getSettingInfo($data, 'plivo_port', '8088');
        $this->_VOIP_CONFIG['plivo_account'] = $this->SettingLogic->getSettingInfo($data, 'plivo_account', 'XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX');
        $this->_VOIP_CONFIG['plivo_password'] = $this->SettingLogic->getSettingInfo($data, 'plivo_password', 'YYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYY');
        $this->_VOIP_CONFIG['audio_path'] = $this->SettingLogic->getSettingInfo($data, 'audio_path', '/files');
    }

    /**
     * makeCall
     * 
     * @param type $params 
     */
    function makeCall($params) {
        $application_root = $this->_VOIP_CONFIG['broadcast_app_root'];
        $plivo_server = $this->_VOIP_CONFIG['plivo_address'];
        $plivo_port = $this->_VOIP_CONFIG['plivo_port'];
        $AccountSid = $this->_VOIP_CONFIG['plivo_account'];
        $AuthToken = $this->_VOIP_CONFIG['plivo_password'];


        $REST_API_URL = "http://$plivo_server:$plivo_port";
        $ApiVersion = 'v0.1';

        // Instantiate a new Plivo Rest Client
        $client = new PlivoRestClient($REST_API_URL, $AccountSid, $AuthToken, $ApiVersion);

        // ========================================================================
        # Define Channel Variable - http://wiki.freeswitch.org/wiki/Channel_Variables
        $extra_dial_string = "bridge_early_media=true,hangup_after_bridge=true";

        // codecs
        if ($params['gateway_codecs'] !== '') {
            $codecs = $params['gateway_codecs'];
        } else {
            $codecs = "'PCMA,PCMU'";
        }

        // timeouts
        if ($params['gateway_timeouts'] !== '') {
            $timeouts = $params['gateway_timeouts'];
        } else {
            $timeouts = "10";
        }

        // Retries
        if ($params['gateway_retries'] !== '') {
            $retries = $params['gateway_retries'];
        } else {
            $retries = "1";
        }

        # Initiate a new outbound call to user/1000 using a HTTP POST
        $call_params = array(
            'From' => $params['caller'], # Caller Id
            'To' => $params['called'], # User Number to Call
            'Gateways' => $params['gateways'], # Gateway string to try dialing our separated by comma. First in list will be tried first
            'GatewayCodecs' => $codecs, # Codec string as needed by FS for each gateway separated by comma
            'GatewayTimeouts' => $timeouts, # Seconds to timeout in string for each gateway separated by comma
            'GatewayRetries' => $retries, # Retry String for Gateways separated by comma, on how many times each gateway should be retried
            'ExtraDialString' => $extra_dial_string,
            'AnswerUrl' => $application_root . "/plivo/app_controller/" . $params['app_id'] . '/',
            'HangupUrl' => $application_root . "/plivo/hang_up/",
            'RingUrl' => "http://127.0.0.1:5000/ringing/"
        );

        try {
      
            // Initiate call
            $response = $client->call($call_params);
            $data = array();
            $data['user_id'] = $params['user_id'];
            $data['from'] = $params['caller'];
            $data['to'] = $params['called'];
            $data['campaign_id'] = $params['campaign_id'];
            $data['aLegrequestuuid'] = $response->Response->RequestUUID;
            $data['retries'] = $params['retries'];
            $data['call_request_id'] = $params['call_request_id'];
            $this->CallRequestComponent->updateCallRequest($data);
            $this->CallRequestComponent->insReport($data);
            print_r($response);
        } catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
            $this->log('error: ' . $e->getMessage());
            exit(0);
        }
    }

    /**
     * appController
     * @param type $app_id 
     */
    function app($app_id) {
        try {
            if (intval($app_id) === self::_STATE_END_APP_) {
                $this->hangup();
            } else {
                $data = $this->getAppInfo($app_id);
                $this->{$data['params']['target']}($data);
            }
        } catch (Exception $exc) {
            $this->log('Error app:' . $exc->getTraceAsString());
        }
    }

    /**
     * playAudio
     * 
     * Play file wave
     * 
     * @param type $params 
     */
    function playAudio($params) {
        try {
            $application_root = $this->_VOIP_CONFIG['broadcast_app_root'];
            $url_action = $application_root . "/plivo/app_controller/" . $params['next'] . "/";
            $path = $this->_VOIP_CONFIG['audio_path'] . $params['params']['file_name'];

            $response = '<?xml version="1.0" encoding="UTF-8"?>
                        <Response>
                            <Play>' . $path . '</Play>
                            <Redirect>' . $url_action . '</Redirect>
                        </Response>';
            echo $response;
        } catch (Exception $exc) {
            $this->log('Error play audio:' . $exc->getTraceAsString());
        }
    }

    /**
     *  hangup
     * 
     * 
     * @param type $params 
     */
    function hangup() {
        // $data is empty for hangup
        $response = '<?xml version="1.0" encoding="UTF-8"?>
              <Response>
              <Hangup />
              </Response>';
        echo $response;
    }

    /**
     * textToSpeech
     * 
     * @param type $params 
     */
    function textToSpeech($params) {
        $application_root = $this->_VOIP_CONFIG['broadcast_app_root'];
        $url_action = $application_root . "/plivo/app_controller/" . $params['next'] . "/";
        
        // get app data
        $url_action = "$url_action";
        $response = '<?xml version="1.0" encoding="UTF-8"?>
                <Response>
                <Speak>' . $params['params']['data'] . '</Speak>
                <Redirect>' . $url_action . '</Redirect>
                </Response>';
        echo $response;
    }

    /**
     * getDigit
     * 
     * @param type $params 
     */
    function getDigit($params) {
        $application_root = $this->_VOIP_CONFIG['broadcast_app_root'];

        $response = '<?xml version="1.0" encoding="UTF-8"?>
          <Response>
              <GetDigits action="' . $application_root . '/plivo/app_controller/1" method="POST">
                  <Play>' . $params['file_path'] . '</Play>
              </GetDigits>
              <Speak>Input not received. Bye bye!</Speak>
          </Response>';
        echo $response;
    }

    /**
     * recordAudioFile
     * 
     * @param type $params 
     */
    function recordAudio($params) {
        $application_root = $this->_VOIP_CONFIG['broadcast_app_root'];

        $response = '<?xml version="1.0" encoding="UTF-8"?>
                <Response>
                <Record action="' . $application_root . '/plivo/app_controller/1" method="POST" playBeep="true"/>
                <Say>I did not hear a recording.  Goodbye.</Say>
                </Response>';
        echo $response;
    }

    /**
     * getAppInfo
     * @param type $app_id 
     */
    function getAppInfo($app_id) {
        $list = array();
        $data = array();
        try {
            $list = $this->CallRequestComponent->getApplicationInfo($app_id);
            if (intval($list[0]['next']) !== self::_STATE_END_APP_) {
                $nextId = $this->CallRequestComponent->getAppNext($list);
            } else {
                $nextId = self::_STATE_END_APP_;
            }

            $data['params'] = json_decode($list[0]['params'], TRUE);
            $data['next'] = $nextId;
            
        } catch (Exception $exc) {
            $this->log('Error code:' . $exc->getTraceAsString());
        }
        return $data;
    }
}

?>