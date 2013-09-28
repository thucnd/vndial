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
    public $javascripts = null;
    public $csss        = array('login');

    function beforeFilter() {
        $this->pageTitle = __('Vndial');
        return parent::beforeFilter();
    }
    
    public function index() {
        
    }

}
