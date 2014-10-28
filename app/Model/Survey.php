<?php
/**
 * QuestionModel.php
 *
 * Model to manipulate table broadcast_survey_question
 *
 * $Id: QuestionModel.php 2013/05/15 thucnd$
 * 
 */
class Survey extends AppModel {
   public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'fields' => 'username',
            'foreignKey' => 'created_by'
        )
       ,
        'Recording' => array(
            'className' => 'Recording',
            'fields' => array('recording_id', 'name'),
            'foreignKey' => 'recording_id'
        )
    );
   
   public $hasMany = array(
        'Response' => array(
            'className' => 'Response',
            'foreignKey' => 'survey_id'
        )
    );

    /**
     * Alias for question model
     *
     * @var string
     */
    public $name = 'Survey';

    /**
     * Primary key for this model
     * @var string
     */
    public $primaryKey = 'survey_id';

    /**
     * Database table name for question model
     *
     * @var string
     */
    public $useTable = 'broadcast_survey_question';

    /**
     * Table name for question model
     * @var string 
     */
    public $table = 'broadcast_survey_question';

    /**
     * Default order to be displayed on web inteface
     * @var array 
     */
    public $order = array(
        'Survey.survey_id ASC',
    );

    /**
     *
     * Validate fields  
     */
    public $validate = array(
        'question' => array(
            'rule' => 'notEmpty',
            'required' => true,
            'message' => 'Please enter your question'
        ),
        'recording_id' => array(
            'rule' => 'notEmpty',
            'required' => true,
            'message' => 'Please select audio files'
        )
    );

    /**
     * Retrieve list of question with default <link>$order</link>
     * @return array List of question
     */
    public function getSurveyList() {
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
     * Get list of question by specific condition
     * @return array List of Question by specific condition
     */
    public function getSurveyListByCondition() {
        return $this->getListByCondition();
    }
    
    /**
     * List of key-value to be displayed in gateway controller
     * @return array
     */
    public function _getSurveyString() {
        return array(
            'tickbox' => array('name' => CHECK_BOX, 'width' => 25, 'align' => CENTER_ALIGNMENT, 'funcBox' => 'TickBox'),
            'editbox' => array('name' => __('Operations'), 'width' => 50, 'align' => CENTER_ALIGNMENT, 'funcBox' => 'EditBox'),
            'question' => array('name' => __('Question'), 'width' => 100, 'align' => LEFT_ALIGNMENT, 'sorting' => TRUE),
            'description' => array('name' => __('Description'), 'width' => 100, 'align' => CENTER_ALIGNMENT, 'sorting' => TRUE),
            'recording_id' => array('name' => __('Recording'), 'width' => 100, 'align' => CENTER_ALIGNMENT, 'sorting' => TRUE, 'funcData' => 'RecordingName'),
            'created_date' => array('name' => __('Created Date'), 'width' => 100, 'align' => LEFT_ALIGNMENT, 'sorting' => TRUE),
            'created_by' => array('name' => __('Created By'), 'width' => 100, 'align' => LEFT_ALIGNMENT, 'sorting' => TRUE, 'funcData' => 'CreatedBy')
        );
    }
}

?>
