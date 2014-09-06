<?php

/**
 * GatewayModel.php
 *
 * Model to manipulate table voice_gateways
 *
 * $Id: GatewayModel.php 2013/01/19 thucnd$
 * 
 */
class Gateway extends AppModel {
    
    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'fields' => 'username',
            'foreignKey' => 'created_by'
        )
    );
    /**
     * Alias for gateway model
     *
     * @var string
     */
    public $name = 'Gateway';

    /**
     * Primary key for this model
     * @var string
     */
    public $primaryKey = 'gateway_id';

    /**
     * Database table name for gateway model
     *
     * @var string
     */
    public $useTable = 'voice_gateways';

    /**
     * Table name for gateway model
     * @var string 
     */
    public $table = 'voice_gateways';

    /**
     * Default order to be displayed on web inteface
     * @var array 
     */
    public $order = array(
        'Gateway.gateway_id ASC',
        'Gateway.name ASC'
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
        'gateways' => array(
            'rule' => array('minLength', 4),
            'message' => 'Please fill gateways'
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
     * Retrieve list of gateway with default <link>$order</link>
     * @return array List of gateway
     */
    public function getGatewayList() {
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
    public function getGatewayListByCondition() {
        return $this->getListByCondition();
    }
    
    /**
     * List of key-value to be displayed in gateway controller
     * @return array
     */
    public function _getGatewayString() {
        return array(
            'tickbox' => array('name' => CHECK_BOX, 'width' => 25, 'align' => CENTER_ALIGNMENT, 'funcBox' => 'TickBox'),
            'editbox' => array('name' => __('Operations'), 'width' => 50, 'align' => CENTER_ALIGNMENT, 'funcBox' => 'EditBox'),
            'name' => array('name' => __('Name'), 'width' => 100, 'align' => LEFT_ALIGNMENT, 'sorting' => TRUE),
            'gateways' => array('name' => __('Gateways'), 'width' => 100, 'align' => CENTER_ALIGNMENT, 'sorting' => TRUE),
            'gateway_codecs' => array('name' => __('Gateway Codecs'), 'width' => 100, 'align' => CENTER_ALIGNMENT, 'sorting' => TRUE),
            'gateway_timeouts' => array('name' => __('Gateway Timeouts'), 'width' => 100, 'align' => LEFT_ALIGNMENT, 'sorting' => TRUE),
            'gateway_retries' => array('name' => __('Gateway Retries'), 'width' => 50, 'align' => LEFT_ALIGNMENT, 'sorting' => TRUE),            
            'created_date' => array('name' => __('Created Date'), 'width' => 100, 'align' => LEFT_ALIGNMENT, 'sorting' => TRUE),
            'created_by' => array('name' => __('Created By'), 'width' => 80, 'align' => LEFT_ALIGNMENT, 'sorting' => TRUE, 'funcData' => 'CreatedBy'),
       );
    }
}

?>
