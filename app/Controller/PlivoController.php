<?php

/**
 * PlivoController.php
 *
 * Manage roles
 *
 * $Id: PlivoController.php 2013/06/11 ThucNd$
 * 
 */
App::uses('AppController', 'Controller');
App::uses('Sanitize', 'Utility');
App::uses('plivohelper.php', 'Vendor/plivo');
App::uses('File', 'Utility');

/**
 * Plivo Controller
 *
 */
class PlivoController extends AppController {
    const _HEADER_ = 'header';
    const _DEFAULT_WIDTH_ = '100%';
    public $layout = 'voip';
    public $name = 'plivo';
    public $uses = array('Recording', 'Setting');
    public $javascripts = null;
    public $components = array('DataTableLogic', 'AppLogic', 'Session', 'PlivoLogic', 'SettingLogic', 'CallRequest');

    function beforeFilter() {
        error_reporting(0);
        return parent::beforeFilter();
    }

    public function test() {
        $this->layout = false;
        $params = array();
        $this->PlivoLogic->makeCall($params);
        $this->render('exec');
    }

    public function make_call($app_id) {
        $this->layout = false;
        $params = array();
        $this->PlivoLogic->makeCall($params);
        $this->render('exec');
    }

    /**
     * play_audio
     * 
     * Play file wave
     * 
     * @param type $app_id 
     */
    public function play_audio($app_id) {
        $this->layout = false;
        $this->PlivoLogic->playAudio($app_id);
        $this->render('exec');
    }

    /**
     * text_to_speech
     * 
     * Text To Speech
     * @param type $app_id 
     */
    public function tts($app_id) {
        $this->layout = false;
        $params = array();
        $params['data'] = 'hello hello hello hello hello hello';
        $this->PlivoLogic->textToSpeech($params);
        $this->render('exec');
    }

    /**
     * get_digit
     * 
     * Get Digit
     * @param type $app_id 
     */
    public function get_digit($app_id) {
        $this->layout = false;
        $params = array();
        $audio = $this->Recording->findByRecordingId($app_id);
        $data = $this->Setting->getSettingList();

        $filePath = $this->SettingLogic->getSettingInfo($data, 'audio_path', '/usr/local/files/');
        $params['file_path'] = $filePath . $audio['Recording']['path'];
        $this->PlivoLogic->getDigit($params);
        $this->render('exec');
    }

    /**
     * record_audio
     * Record file wave
     * 
     * @param type $app_id 
     */
    public function record_audio($app_id) {
        $this->layout = false;
        $params = array();
        $this->PlivoLogic->recordAudio($params);
        $this->render('exec');
    }

    /**
     * hang_up
     * 
     * Hang up
     * 
     * @param type $app_id 
     */
    public function hang_up() {
        try {
            $params = array();
            $params = $this->request->data;
            $this->CallRequest->updateReport($params);
            $this->CallRequest->removeCallRequest($params);
            $this->PlivoLogic->hangup();
        } catch (Exception $exc) {
            $this->log('Error hangup controller' . $exc->getTraceAsString());
        }
        $this->render('exec');
    }

    /**
     * app_controller
     * @param type $app_id 
     */
    public function app_controller($app_id) {
        try {
            $this->layout = false;
            $params = $this->request->data;
            $this->CallRequest->updateReport($params);
            $this->PlivoLogic->app($app_id);
            $this->render('exec');
        } catch (Exception $exc) {
            $this->log('Error app controller' . $exc->getTraceAsString());
        }
    }

}
