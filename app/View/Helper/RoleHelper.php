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
class RoleHelper extends Helper {   
    private $RoleLogic; 
    function __construct() {
        // Load setting
        App::uses('RoleLogicComponent', 'Controller/Component');
        $collection = new ComponentCollection();
        $this->RoleLogic = new RoleLogicComponent($collection);
    }
    /**
     * checkPermission
     * Check Permision of Users
     * @param type $role
     * @return boolean
     */
    function checkPermission($role) {
        return $this->RoleLogic->checkPermission($role);

    }
}
