<?php
/**
* FrontendController.php
*
* Home Page
*
* $Id: FrontendController.php 2013/01/01 ThucNd$
* 
*/
App::uses('AppController', 'Controller');
/**
 * Frontend Controller
 *
 */
class FrontendController extends AppController {
    public $layout = 'frontend';
    public $name = 'frontend';
    public $uses = null;
    public $javascripts = array('jqPlot/jquery.jqplot.min','jqPlot/plugins/jqplot.pieRenderer.min','jqPlot/plugins/jqplot.donutRenderer.min', 'frontend');
    public $csss        = array('login');
    public $helpers = array('Role');
    public $components  = array('Session', 'CallRequest');

    function beforeFilter() {
        $this->pageTitle = __('Vndial');
        return parent::beforeFilter();
    }
    
    public function index() {
        
    }
    
    /*
     * Get Report information by Date Time
     */
    public function exec(){
        $this->layout = false;
        $params = $this->request->data;
        $params['uid'] = $this->Session->read('User.uid');
        $list = array();
       if(isset($this->request->data)) {
           $list = $this->CallRequest->searchReportByDateTime($params);
        }
        $status =  STATUS_NG;
        $message = MESSAGE_FAILURE;
        if(count($list) > 0){
            $status = STATUS_OK;
            $message = MESSAGE_OK;
        }

        $this->set('list', $list);
        $this->set('status', STATUS_OK);
        $this->set('errors', null);
        $this->set('message', $message);
    }

}
