<?php

/**
 * TtsModel.php
 *
 * Model to manipulate table broadcast_tts
 *
 * $Id: TtsModel.php 2013/03/12 thucnd$
 * 
 */
class Tts extends AppModel {
    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'created_by'
        ),
        'Country' => array(
            'className' => 'Country',
            'foreignKey' => 'language'
        )
    );
    /**
     * Alias for tts model
     *
     * @var string
     */
    public $name = 'Tts';
    
    /**
     * Primary key for this model
     * @var string
     */
    public $primaryKey = 'tts_id';

    /**
     * Database table name for tts model
     *
     * @var string
     */
    public $useTable = 'broadcast_tts';

    /**
     * Table name for tts model
     * @var string 
     */
    public $table = 'broadcast_tts';

    /**
     * Default order to be displayed on web inteface
     * @var array 
     */
    public $order = array(
        'Tts.tts_id ASC',
        'Tts.name ASC'
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
        'text_data' => array(
            'rule' => 'notEmpty',
            'required' => true,
            'message' => 'Please fill text'
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
}

?>
