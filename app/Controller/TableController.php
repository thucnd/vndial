<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class TableController extends AppController {
    
    public $layout = 'table';
    public $name = 'table';
    public $uses = null;
    public $javascripts = null;
    public $uses = array('Survey', 'Recording', 'Response');
    public $components = array('DataTableLogic', 'AppLogic', 'Session');
    
    function beforeFilter() {
        //$this->Auth->requireNoAuth('index', 'backoffice_index');
        $this->pageTitle = 'Login';
        setcookie("s", null);
        setcookie("e", null);
        return parent::beforeFilter();
    }
    
    public function index() {
    }
    
     /**
     * Process data table
     */
    public function process() {
        $this->layout = false;
        $jsonData = $this->DataTableLogic->processDataTable(
                $this->request->data, $this->Survey, $this->columns);

        $this->set(compact('jsonData'));
    }

    /**
     * List of key-value to be displayed in gateway controller
     * @return array
     */
    private function _getSurveyString() {
        return array(
            'tickbox' => array('name' => CHECK_BOX, 'width' => 10, 'align' => LEFT_ALIGNMENT),
            'editbox' => array('name' => __('Operations'), 'width' => 100, 'align' => CENTER_ALIGNMENT),
            'question' => array('name' => __('Question'), 'width' => 100, 'align' => LEFT_ALIGNMENT),
            'description' => array('name' => __('Description'), 'width' => 100, 'align' => CENTER_ALIGNMENT),
            'recording_id' => array('name' => __('Recording'), 'width' => 100, 'align' => CENTER_ALIGNMENT),
            'created_date' => array('name' => __('Created Date'), 'width' => 100, 'align' => LEFT_ALIGNMENT),
            'created_by' => array('name' => __('Created By'), 'width' => 100, 'align' => LEFT_ALIGNMENT)
        );
    }
}
