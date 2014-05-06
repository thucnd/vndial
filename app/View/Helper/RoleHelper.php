<?php
/**
 * RoleHelper.php
 *
 * Manage Permission
 *
 * $Id: RoleHelper.php 2014/05/06 ThucNd$
 * 
 */

App::uses('Helper', 'View');
App::uses('SessionHelper', 'View/Helper');
App::import('Model', 'User');

class RoleHelper extends Helper {    
        
    private $_user;
    const _SUPPER_ADMIN_ = 1;
    /**
     * Load Role information
     */
    function __construct() {
        // Load Role Model        
        $this->_user = new User;
    }
            
    /**
     * checkPermission
     * Check Permision of Users
     * @param type $role
     * @return boolean
     */
    function checkPermission($role) {
        $uid = SessionHelper::read('User.uid');
        $user = $this->_user->findByUserId($uid);
        
        //Supper Admin has full access
        if(intval($user['User']['role']) !== self::_SUPPER_ADMIN_) {
            $roles = json_decode($user['Role']['role_permissions'], true);
            if(!in_array($role, $roles)) {
                return false;
            }
        } 
        return true;
    }
}
