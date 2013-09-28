<?php

/**
 * RoleComponent.php
 *
 * 
 *
 * $Id: RoleComponent.php 554 2013-04-23 02:26:06Z thucnd $
 */
class RoleLogicComponent extends Component {

    public $components = array('RequestHandler', 'Session');
    public $_roleModel;
    public $_controller;

    function startup(& $controller) {
        App::import('Model', 'Role');
        $this->_roleModel = new Role;
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
            __('Campaigns') => array(
                'campaign_view' => __('View campaigns'),
                'campaign_edit' => __('Edit campaigns')
            ),
            __('Audio files') => array(
                'audio_view' => __('View audio files'),
                'audio_edit' => __('Edit audio files')
            ),
            __('Survey') => array(
                'survey_view' => __('View survey'),
                'survey_edit' => __('Edit survey')
            ),
            __('Text to speech') => array(
                'tts_view' => __('View text to speech'),
                'tts_edit' => __('Edit text to speech')
            ),
            __('Groups') => array(
                'group_view' => __('View groups'),
                'group_edit' => __('Edit groups')
            ),
            __('Contacts') => array(
                'contact_view' => __('View contacts'),
                'contact_edit' => __('Edit contacts')
            )
        );
        return $params;
    }
        
}

?>