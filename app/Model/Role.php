<?php

/**
 * RoleModel.php
 *
 * Model to manipulate table role
 *
 * $Id: RoleModel.php 2013/04/03 thucnd$
 * 
 */
class Role extends AppModel {

    /**
     * Alias for role model
     *
     * @var string
     */
    public $name = 'Role';

    /**
     * Primary key for this model
     * @var string
     */
    public $primaryKey = 'role_id';

    /**
     * Database table name for user model
     *
     * @var string
     */
    public $useTable = 'role';

    /**
     * Table name for role model
     * @var string 
     */
    public $table = 'role';

    /**
     * Default order to be displayed on web inteface
     * @var array 
     */
    public $order = array(
        'Role.role_id ASC',
        'Role.role_name ASC'
    );

    /**
     *
     * Validate fields  
     */
    public $validate = array(
        'role_name' => array(
            'alphaNumeric' => array(
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'Role nane is required'
            )
        ),
        'role_permissions' => array(
            'rule' => 'notEmpty',
            'required' => true,
            'message' => 'please select at least a permission'
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
    public function getRoleList() {
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
     * Get list of role by specific condition
     * @return array List of Role by specific condition
     */
    public function getRoleListByCondition() {
        return $this->getListByCondition();
    }
    
     /**
     * List of key-value to be displayed in User controller
     * @return array
     */
     public function _getRoleString() {
        return array(
            'tickbox' => array('name' => CHECK_BOX, 'width' => 25, 'align' => CENTER_ALIGNMENT, 'funcBox' => 'TickBox'),
            'editbox' => array('name' => __('Operations'), 'width' => 50, 'align' => CENTER_ALIGNMENT, 'funcBox' => 'EditBox'),
            'role_name' => array('name' => __('Role name'), 'width' => 200, 'align' => CENTER_ALIGNMENT, 'sorting' => TRUE)
        );
    }
}
?>
