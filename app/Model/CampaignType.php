<?php

/**
 * CampaignTypeModel.php
 *
 * Model to manipulate table broadcast_campaign_type
 *
 * $Id: CampaignTypeModel.php 2013/03/16 thucnd$
 * 
 */
class CampaignType extends AppModel {
    const PLAY_AUDIO = 1;
    const SURVEY = 2;
    const TEXT_TO_SPEECH = 3;

    /**
     * Alias for Campaign Type model
     *
     * @var string
     */
    public $name = 'CampaignType';

    /**
     * Primary key for this model
     * @var string
     */
    public $primaryKey = 'campaign_type_id';

    /**
     * Database table name for campaign type model
     *
     * @var string
     */
    public $useTable = 'campaign_type';

    /**
     * Table name for campaign type model
     * @var string 
     */
    public $table = 'campaign_type';

    /**
     * Default order to be displayed on web inteface
     * @var array 
     */
    public $order = array(
        'CampaignType.campaign_type_id ASC',
        'CampaignType.name ASC'
    );
    
    /**
     * Campaign Type
     * @var string 
     */
    static $fields = array(
         self::PLAY_AUDIO => 'Play audio'
        ,self::SURVEY => 'Survey'
        ,self::TEXT_TO_SPEECH => 'Text to speech'
    );

    /**
     * validates
     * 
     * @param type $data
     * @return boolean 
     */
    function validates($data = array()) {
        if (empty($data)) {
            $data = $this->data;
        }
        parent::validates($data);
        if (count($this->validationErrors) > 0) {
            return false;
        } else {
            return true;
        }
    }

}

?>
