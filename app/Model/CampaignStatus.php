<?php

/**
 * CampaignStatus.php
 *
 * Model to manipulate table CampaignStatus
 *
 * $Id: CampaignTypeModel.php 2014/09/06 thucnd$
 * 
 */
class CampaignStatus extends AppModel {
    const CAMPAIGN_START = 1;
    const CAMPAIGN_PAUSE = 2;
    const CAMPAIGN_STOP = 3;

    /**
     * Campaign Status
     * @var string 
     */
    static $fields = array(
          self::CAMPAIGN_START => 'START'
        , self::CAMPAIGN_PAUSE=> 'PAUSED'
        , self::CAMPAIGN_STOP => 'STOP'
    );
}

?>
