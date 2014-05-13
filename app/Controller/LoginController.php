<?php
/**
* LoginController.php
*
* Login into system
*
* $Id: login_controller.php 2013/01/01 ThucNd$
* 
*/
App::uses('AppController', 'Controller');
/**
 * Login Controller
 *
 */
class LoginController extends AppController {
    public $layout = 'default';
    public $name = 'login';
    public $uses = array('User');
    public $javascripts = array('login');
    public $csss        = array('login');    
    public $components  = array('DataTableLogic', 'AppLogic', 'Auth', 'Session');

    function beforeFilter() {
        $this->pageTitle = 'Login';
    }
    
    public function index() {
        
    }
    
    public function  exec() {
        if(isset($this->request->data)) {
            $username = $this->request->data["user_name"];
            $password = md5($this->request->data["password"]);
            if($this->Auth->login($username, $password)) {
                if($this->Session->check('redirect')) {
                    $this->redirect($this->Session->read('redirect'));
                } else {
                    $this->redirect('/');
                }
     
            } else {
                $this->Session->setFlash(__('User name or password is incorrect'));
                $this->redirect('/login');
            }
        }
    }
    
    public  function logout() {
        $this->Session->delete('User.name');
        $this->Session->delete('User.uid');
        $this->Session->delete('User.role');
        $this->redirect('/login');
    }

}
