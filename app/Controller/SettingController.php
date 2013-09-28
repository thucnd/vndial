<?php

/**
 * SettingController.php
 *
 * Voice settings
 *
 * $Id: SettingController.php 2013/02/01 thucnd$
 * 
 */
App::uses('AppController', 'Controller');
App::uses('Sanitize', 'Utility');

/**
 * Setting Controller
 *
 */
class SettingController extends AppController {
    public $layout = 'backend';
    public $name = 'setting';
    public $javascripts = array('setting');
    public $helpers = array('App');
    public $csss = null;

    /**
     * An array containing the class names of models this controller uses.
     * @var array 
     */
    public $components = array('SettingLogic');

    /**
     * Component
     * @var array 
     */

    function beforeFilter() {
        return parent::beforeFilter();
    }

    function index() {
    }
    
    /*
     *  Plivo configuration 
     */
    function plivo_config() {
        $data = $this->SettingLogic->getSettingList();
        $this->set('data', $data);
    }
    
    /*
     *  audio configuration
     */
    function audio() {
        $data = $this->SettingLogic->getSettingList();
        $this->set('data', $data);
    }


    /*
     *  Plivo save information about configuration
     */
    public function plivo_save() {
        $this->layout = false;
        $ret = false;
        $errors = array();
        if($this->request->is('post')){
            $params = $this->request->data;
            $ret = $this->SettingLogic->saveSetting($this->request->data);
        }
        
        if($ret) {
            $this->set('status', STATUS_OK);
            $this->set('errors', null);
            $this->set('message', __('Save sucess'));
        }else{
            $errors[0] = __('value of config is not emty');
            $this->set('status', STATUS_NG);
            $this->set('errors', $errors);
            $this->set('message', MESSAGE_FAILURE);
        }
    }
}
