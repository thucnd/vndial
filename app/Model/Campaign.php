<?php

/**
 * CampaignModel.php
 *
 * Model to manipulate table campaigns
 *
 * $Id: CampaignModel.php 2013/04/29 thucnd$
 * 
 */
class Campaign extends AppModel {

    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'fields' => 'username',
            'foreignKey' => 'created_by'
        )
    );

    /**
     * Alias for campaign model
     *
     * @var string
     */
    public $name = 'Campaign';

    /**
     * Primary key for this model
     * @var string
     */
    public $primaryKey = 'campaign_id';

    /**
     * Database table name for campaign model
     *
     * @var string
     */
    public $useTable = 'campaigns';

    /**
     * Table name for campaign model
     * @var string 
     */
    public $table = 'campaigns';

    /**
     * Default order to be displayed on web inteface
     * @var array 
     */
    public $order = array(
        'Campaign.campaign_id ASC',
        'Campaign.name ASC'
    );

    /**
     *
     * Validate fields  
     */
    public $validate = array(
        'name' => array(
            'rule' => 'notEmpty',
            'required' => true,
            'message' => 'Please fill name'
        ),
        'caller' => array(
            'rule' => 'notEmpty',
            'required' => true,
            'message' => 'Please fill caller name'
        ),
        'a_leg' => array(
            'rule' => 'notEmpty',
            'required' => true,
            'message' => 'Please select outbound gateway '
        ),
        'app_type_id' => array(
            'rule' => 'notEmpty',
            'required' => true,
            'message' => 'Please select data'
        ),
        'group_id' => array(
            'rule' => 'notEmpty',
            'required' => true,
            'message' => 'Please select phone book'
        )
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

    /**
     * Retrieve list of campaign with default <link>$order</link>
     * @return array List of campaign
     */
    public function getCampaignList() {
        return $this->find('all');
    }

    /**
     * Total number of records
     * @return int Total number of records in this model
     */
    public function countRecords() {
        $total = $this->find('count');

        return $total;
    }

    /**
     * Get list of campaign by specific condition
     * @return array List of Campaign by specific condition
     */
    public function getCampaignListByCondition() {
        return $this->getListByCondition();
    }
    
    /**
     * List of key-value to be displayed in Tts controller
     * @return array
     */
    public function _getCampaignString() {
        return array(
            'tickbox' => array('name' => CHECK_BOX, 'width' => 25, 'align' => CENTER_ALIGNMENT, 'funcBox' => 'TickBox'),
            'campbox' => array('name' => __('Operations'), 'width' => 130, 'align' => CENTER_ALIGNMENT, 'funcBox' => 'CampBox'),
            'status' => array('name' => __('Status'), 'width' => 80, 'align' => CENTER_ALIGNMENT, 'sorting' => TRUE, 'funcData' => 'Status'),
            'name' => array('name' => __('Name'), 'width' => 100, 'align' => CENTER_ALIGNMENT, 'sorting' => TRUE),
            'caller' => array('name' => __('Caller name'), 'width' => 100, 'align' => CENTER_ALIGNMENT, 'sorting' => TRUE),
            'camp_type_id' => array('name' => __('Type'), 'width' => 100, 'align' => CENTER_ALIGNMENT, 'sorting' => TRUE, 'funcData' => 'CampaignType'),
            'start_at' => array('name' => __('Start time'), 'width' => 100, 'align' => CENTER_ALIGNMENT, 'sorting' => TRUE),
            'stop_at' => array('name' => __('Stop time'), 'width' => 100, 'align' => CENTER_ALIGNMENT, 'sorting' => TRUE)
        );
    }
}

?>
