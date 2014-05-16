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
App::uses('Common', 'Lib');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
//-----------------------------------------
// Define message
define('MESSAGE_OK', __('success'));
define('MESSAGE_FAILURE', __('failure'));

//-----------------------------------------
// Define status
define('STATUS_OK', '1');
define('STATUS_NG', '0');


//-----------------------------------------
// Define checkbox
define('CHECK_BOX', '<input id="thead-tickbox" class="thead-tickbox" type="checkbox" name="thead-tickbox" value="thead-tickbox"><span class="lbl"></span>');
define('EDIT_BOX', '<input id="thead-tickbox" class="thead-tickbox" type="checkbox" name="thead-tickbox" value="thead-tickbox">');


//-----------------------------------------
// Define alignment for table
define('LEFT_ALIGNMENT', 'left');
define('RIGHT_ALIGNMENT', 'right');
define('CENTER_ALIGNMENT', 'center');

//-------------------------------------------
// Define Supper Admin
define('SUPPER_ADMIN', 1);

class AppController extends Controller {

    /**
     * List of all columns from model
     * @var array
     */
    public $columns = array();

    /**
     * Default column to be sorted
     * @var string 
     */
    public $defaultSort = 'name';

    /**
     * Default width for vndial table
     * @var int
     */
    public $defaultWidth = 1000;

    /**
     * Default height for vndial table
     * @var int 
     */
    public $defaultHeight = 300;
    public $components = array('Auth', 'Session', 'RoleLogic');
    public $helpers = array('Role');

    /**
     * beforeRender
     */
    function beforeRender() {
        $this->set('pageTitle', $this->pageTitle);

        $this->set('csss', $this->csss);
        $this->set('javascripts', $this->javascripts);
        $this->set('controller', $this->name);
        $this->set('defaultSort', $this->defaultSort);
        $this->set('defaultWidth', $this->defaultWidth);
        $this->set('defaultHeight', $this->defaultHeight);
    }

    public function beforeFilter() {
        if ($this->name !== 'plivo') {
            if ($this->layout == 'backend') {
                if (!$this->RoleLogic->checkPermission('admin_page')) {
                    $this->Session->setFlash(__("you don't have permission access"), 'default', array('class' => 'alert alert-error'));
                    $this->Session->write("redirect", '/');
                    $this->redirect('/login');
                }
                $this->Session->write("redirect", '/admin');
            } else {
                $this->Session->write("redirect", '/');
            }

            if ( !$this->RoleLogic->checkPermission($this->name . '_view')) {
                $this->Session->setFlash(__("you don't have permission access"), 'default', array('class' => 'alert alert-error'));
                $this->Session->write("redirect", '/');
                $this->redirect('/login');
            }
            $this->Session->write("redirect", '/admin');

            if (!$this->Auth->isLogin()) {
                $this->redirect('/login');
            }
        }
    }

}
