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

}

?>
