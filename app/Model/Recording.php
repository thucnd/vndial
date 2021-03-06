<?php

/**
 * RecordingModel.php
 *
 * Model to manipulate table broadcast_recording
 *
 * $Id: RecordingModel.php 2013/01/19 khanhle$
 * 
 */
class Recording extends AppModel {
    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'created_by'
        )
    );
    /**
     * Alias for recording model
     *
     * @var string
     */
    public $name = 'Recording';
    
    /**
     * Primary key for this model
     * @var string
     */
    public $primaryKey = 'recording_id';

    /**
     * Database table name for recording model
     *
     * @var string
     */
    public $useTable = 'recordings';

    /**
     * Table name for recording model
     * @var string 
     */
    public $table = 'recordings';

    /**
     * Default order to be displayed on web inteface
     * @var array 
     */
    public $order = array(
        'Recording.recording_id ASC',
        'Recording.name ASC'
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
        )
    );

    /**
     * Retrieve list of recording with default <link>$order</link>
     * @return array List of recording
     */
    public function getRecordingList() {
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
     * Get list of recording by specific condition
     * @return array List of Recording by specific condition
     */
    public function getRecordingListByCondition() {
        return $this->getListByCondition();
    }
    
    /**
     * List of key-value to be displayed in gateway controller
     * @return array
     */
    public function _getRecordingString() {
        return array(
            'tickbox' => array('name' => CHECK_BOX, 'width' => 25, 'align' => CENTER_ALIGNMENT, 'funcBox' => 'TickBox'),
            'editbox' => array('name' => __('Operations'), 'width' => 50, 'align' => CENTER_ALIGNMENT, 'funcBox' => 'EditBox'),
            'name' => array('name' => __('Name'), 'width' => 100, 'align' => LEFT_ALIGNMENT, 'sorting' => TRUE),
            'description' => array('name' => __('Description'), 'width' => 100, 'align' => CENTER_ALIGNMENT, 'sorting' => TRUE),
            'type' => array('name' => __('Type'), 'width' => 100, 'align' => LEFT_ALIGNMENT, 'sorting' => TRUE),
            'path' => array('name' => __('Path'), 'width' => 200, 'align' => LEFT_ALIGNMENT, 'sorting' => TRUE),
            'size' => array('name' => __('Length'), 'width' => 100, 'align' => LEFT_ALIGNMENT, 'sorting' => TRUE),
            'created_date' => array('name' => __('Created Date'), 'width' => 100, 'align' => LEFT_ALIGNMENT, 'sorting' => TRUE)
        );
    }
}

?>
