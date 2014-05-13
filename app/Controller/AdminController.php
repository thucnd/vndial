<?php
/**
* AdminController.php
*
* Home Page
*
* $Id: AdminController.php 2013/03/23 ThucNd$
* 
*/

App::uses('AppController', 'Controller');

/**
 * Admin Controller
 *
 */
class AdminController extends AppController {

    public $layout = 'backend';
    public $name = 'admin';
    public $uses = null;
    public $javascripts = null;
    public $helpers = array('Role');

    function beforeFilter() {
        $this->pageTitle = __('Administrator');
        return parent::beforeFilter();
    }
    
    public function index() {
        
    }

}
