<?php

/**
 * ContactModel.php
 *
 * Model to manipulate table contacts
 *
 * $Id: ContactModel.php 2013/01/23 khanhle$
 * 
 */
class Contact extends AppModel {

    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'fields' => 'username',
            'foreignKey' => 'created_by'
        ),
        'ContactGroup' => array(
            'className' => 'ContactGroup',
            'fields' => 'name',
            'foreignKey' => 'group_id'
        )
    );
    /**
     * Alias for contact model
     *
     * @var string
     */
    public $name = 'Contact';
    
    /**
     * Primary key for this model
     * @var string
     */
    public $primaryKey = 'contact_id';

    /**
     * Database table name for contact model
     *
     * @var string
     */
    public $useTable = 'contacts';

    /**
     * Table name for contact model
     * @var string 
     */
    public $table = 'contacts';

    /**
     * Default order to be displayed on web inteface
     * @var array 
     */
    public $order = array(
        'Contact.contact_id ASC',
        'Contact.first_name ASC'
    );
    

    /**
     * Retrieve list of contact with default <link>$order</link>
     * @return array List of contact
     */
    public function getContactList() {
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
     * Get list of contact by specific condition
     * @return array List of Contact by specific condition
     */
    public function getContactListByCondition() {
        return $this->getListByCondition();
    }
}

?>
