<?php

/**
 * AuthComponent.php
 *
 * 
 *
 * $Id: auth.php 554 2013-03-03 02:26:06Z thucnd $
 */
class AuthComponent extends Component {

    public $components = array('RequestHandler', 'Session');
    public $_usersModel;

    function startup(& $controller) {
        App::import('Model', 'User');
        $this->_usersModel = new User;
    }

    /**
     * login
     * 
     * Check user and password
     * 
     * @param type $username
     * @param type $password 
     * $return bool
     */
    function login($username, $password) {
        
        $users = $this->_usersModel->find('first',array(
                                                    'conditions' => array(
                                                        'User.username' => $username,
                                                        'User.password' => $password
                                                      )
                                            ));
        if(count($users) > 0) {
            $this->Session->write('User.name', $users['User']['username']);
            $this->Session->write('User.uid', $users['User']['user_id']);
            $this->Session->write('User.role', $users['User']['role']);
            return true;
        } else {
            return false;
        }
        return true;
    }
    
    /**
     * isLogin
     * 
     * check login or not 
     * 
     * @return boolean 
     */
    function isLogin() {
        if(!$this->Session->check('User.name')) {
            return false;
        }
        return true;
    }
    
    /**
     * getLoginInfo
     * 
     * Get login information
     * 
     * @return $user 
     */
    function getLoginInfo() {
        $user = $this->_usersModel->find('first',array(
                                                    'conditions' => array(
                                                        'User.username' => $this->Session->read('User.name')
                                                      )
                                            ));
        return $user;
    }

}

?>