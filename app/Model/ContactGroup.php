<?php

/**
 * ContactGroupModel.php
 *
 * Model to manipulate table contact_groups
 *
 * $Id: ContactGroupModel.php 2013/01/23 khanhle$
 * 
 */
class ContactGroup extends AppModel {

    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'created_by'
        )
    );
    /**
     * Alias for contact model
     *
     * @var string
     */
    public $name = 'ContactGroup';
    
    /**
     * Primary key for this model
     * @var string
     */
    public $primaryKey = 'group_id';

    /**
     * Database table name for contact_group model
     *
     * @var string
     */
    public $useTable = 'contact_groups';

    /**
     * Table name for contact_group model
     * @var string 
     */
    public $table = 'contact_groups';

    /**
     * Default order to be displayed on web inteface
     * @var array 
     */
    public $order = array(
        'ContactGroup.group_id ASC',
        'ContactGroup.name ASC'
    );
    

    /**
     * Retrieve list of contact_group with default <link>$order</link>
     * @return array List of contact_group
     */
    public function getContactGroupList() {
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
     * Get list of contact_group by specific condition
     * @return array List of ContactGroup by specific condition
     */
    public function getContactGroupListByCondition() {
        return $this->getListByCondition();
    }
    
    /**
     * List of key-value to be displayed in gateway controller
     * @return array
     */
    public function _getContactGroupString() {
        return array(
            'tickbox' => array('name' => CHECK_BOX, 'width' => 25, 'align' => CENTER_ALIGNMENT, 'funcBox' => 'TickBox'),
            'editbox' => array('name' => __('Operations'), 'width' => 50, 'align' => CENTER_ALIGNMENT, 'funcBox' => 'EditBox'),
            'name' => array('name' => __('Name'), 'width' => 100, 'align' => CENTER_ALIGNMENT, 'sorting' => TRUE),
            'description' => array('name' => __('Description'), 'width' => 100, 'align' => CENTER_ALIGNMENT, 'sorting' => TRUE),
            'created_date' => array('name' => __('Created Date'), 'width' => 100, 'align' => CENTER_ALIGNMENT, 'sorting' => TRUE)
        );
    }
}

?>
