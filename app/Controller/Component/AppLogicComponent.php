<?php

/**
 * GatewayLogicComponent.php
 *
 * Gateway logic
 *
 * $Id: GatewayLogicComponent.php 2013/01/22 thucnd$ 
 * 
 */
App::uses('Component', 'Controller');

/**
 * Gateway logic
 *
 */
class AppLogicComponent extends Component {

    public $components = array('RequestHandler', 'Session');
    const _ONLY_ONE_ = 1;

    /**
     * Delete multiple records by ids for that <link>$model</link>
     * @param array $ids List ids to be deleted
     * @param Model $model 
     * 
     * @return boolean True on success, false on failure
     */
    public function deleteMultiple($ids, $model) {

        if (count($ids) === AppLogicComponent::_ONLY_ONE_) {
            return $model->delete($ids[0]);
        } else {
            $conditions = array(
                sprintf(
                        '%s.%s in', $model->name, $model->primaryKey
                ) => $ids);
            return $model->deleteAll($conditions);
        }
    }
    
    /**
     * Save data for this model
     * @param array $data
     * @param Model $model
     * @return On success Model::$data if its not empty or true, false on failure
     */
    public function save($data, $model) {
        $data['created_by'] = $this->Session->read('User.uid');
        $data['created_date'] = date ("Y-m-d H:i:s", $_SERVER['REQUEST_TIME']);
        $date['modified_date'] = date ("Y-m-d H:i:s", $_SERVER['REQUEST_TIME']);
        $model->set($data);
        return $model->save();
    }
    
    /**
     * Update data for this model
     * @param type $data
     * @param type $model
     * @return type
     */
    public function update($data, $model) {
        $date['modified_date'] = date ("Y-m-d H:i:s", $_SERVER['REQUEST_TIME']);
        return $model->save($data, false);
    }
    
    /**
     * Get data for this model follow permission
     * @param type $model
     * @return data list 
     */
    public function getAllData($model) {
        $list = $model->findAllByCreatedBy($this->Session->read('User.uid'));
        return $list;
    }

}

?>
