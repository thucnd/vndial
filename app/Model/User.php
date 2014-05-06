<?php

/**
 * UserModel.php
 *
 * Model to manipulate table users
 *
 * $Id: UserModel.php 2013/03/03 ThucNd$
 * 
 */
class User extends AppModel {
    public $belongsTo = array(
        'Role' => array(
            'className' => 'Role',
            'fields' => array('role_name', 'role_permissions'),
            'foreignKey' => 'role'
        ),
        'Gateway' => array(
            'className' => 'Gateway',
            'fields' => array('gateway_id', 'name'),
            'foreignKey' => 'gateway_id'
        )
    );
    
    /**
     * Alias for user model
     *
     * @var string
     */
    public $name = 'User';

    /**
     * Primary key for this model
     * @var string
     */
    public $primaryKey = 'user_id';

    /**
     * Database table name for user model
     *
     * @var string
     */
    public $useTable = 'users';

    /**
     * Table name for user model
     * @var string 
     */
    public $table = 'users';

    /**
     * Default order to be displayed on web inteface
     * @var array 
     */
    public $order = array(
        'User.username ASC'
    );

    /**
     *
     * Validate fields  
     */
    public $validate = array(
        'username' => array(
            'alphaNumeric' => array(
                'rule' => 'alphaNumeric',
                'required' => true,
                'message' => 'Username must be alphabets and numbers only'
            ),
            'between' => array(
                'rule' => array('between', 5, 30),
                'message' => 'Username between 5 to 30 characters'
            )
        ),
        'password' => array(
            'rule'    => array('minLength', '8'),
            'message' => 'Password must be minimum 8 characters long'
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
     * Retrieve list of user with default <link>$order</link>
     * @return array List of gateway
     */
    public function getUserList() {
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
     * Get list of gateway by specific condition
     * @return array List of Gateway by specific condition
     */
    public function getUserListByCondition() {
        return $this->getListByCondition();
    }

}

?>
