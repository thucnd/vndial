<?php

/**
 * RoleComponent.php
 *
 * 
 *
 * $Id: RoleComponent.php 554 2013-04-23 02:26:06Z thucnd $
 */
App::uses('SessionHelper', 'View/Helper');
App::import('Model', 'User');

class RoleLogicComponent extends Component {

    public $components = array('RequestHandler', 'Session');
    public $_roleModel;
    public $_controller;
    private $_user;

    const _SUPPER_ADMIN_ = 1;

    function __construct() {
        App::import('Model', 'Role');
        $this->_roleModel = new Role;

        $this->_user = new User;
    }

    /**
     * permission_params
     * 
     * Permisions definition
     * 
     * @return array 
     */
    public function getPermissionParams() {
        $params = array(
            __('Admin Page') => array(
                'admin_page' => __('Access Admin page')
            ),
            __('Campaigns') => array(
                'campaign_view' => __('View campaigns'),
                'campaign_edit' => __('Manage campaigns')
            ),
            __('Audio files') => array(
                'recording_view' => __('View audio files'),
                'recording_edit' => __('Manage audio files')
            ),
            __('Survey') => array(
                'survey_view' => __('View survey'),
                'survey_edit' => __('Manage survey')
            ),
            __('Text to speech') => array(
                'tts_view' => __('View text to speech'),
                'tts_edit' => __('Manage text to speech')
            ),
            __('Groups') => array(
                'contact_group_view' => __('View groups'),
                'contact_group_edit' => __('Manage groups')
            ),
            __('Contacts') => array(
                'contact_view' => __('View contacts'),
                'contact_edit' => __('Manage contacts')
            ),
            __('Users') => array(
                'user_view' => __('View users'),
                'user_edit' => __('Manage users')
            ),
            __('Roles') => array(
                'role_view' => __('View roles'),
                'role_edit' => __('Manage roles')
            ),
            __('Gateways') => array(
                'gateway_view' => __('View gateways'),
                'gateway_edit' => __('Manage gateways')
            ),
            __('Voice settings') => array(
                'settings_view' => __('View voice settings'),
                'settings_edit' => __('Manage voice settings')
            )
        );
        return $params;
    }

    /**
     * checkPermission
     * Check Permision of Users
     * @param type $role
     * @return boolean
     */
    function checkPermission($role) {
        //Get User ID information
        $uid = SessionHelper::read('User.uid');
        $user = $this->_user->findByUserId($uid);
        //Get permission list
        $permissions = $this->getPermissionParams();
        $roleExisting = FALSE;
        foreach ($permissions as $permission) {
            if (array_key_exists($role, $permission)) {
                $roleExisting =  TRUE;
            }
        }
        // if we don don't set permission this page, skip check permission
        if(!$roleExisting) return TRUE;
        //Supper Admin has full access
        if (intval($user['User']['role']) !== self::_SUPPER_ADMIN_) {
            $roles = json_decode($user['Role']['role_permissions'], true);
            if (!in_array($role, $roles)) {
                return false;
            }
        }
        return true;
    }

}

?>