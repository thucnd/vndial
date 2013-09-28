<?php

/**
 * CountryModel.php
 *
 * Model to manipulate table country
 *
 * $Id: CountryModel.php 2013/03/16 thucnd$
 * 
 */
class Country extends AppModel {
 
    /**
     * Alias for country model
     *
     * @var string
     */
    public $name = 'Country';
    
    /**
     * Primary key for this model
     * @var string
     */
    public $primaryKey = 'country_iso';

    /**
     * Database table name for country model
     *
     * @var string
     */
    public $useTable = 'country';

    /**
     * Table name for country model
     * @var string 
     */
    public $table = 'country';

    /**
     * Default order to be displayed on web inteface
     * @var array 
     */
    public $order = array(
        'Country.country_iso ASC',
        'Country.country_name ASC'
    );
    

    /**
     * Retrieve list of recording with default <link>$order</link>
     * @return array List of recording
     */
    public function getCountryList() {
        return $this->find('all');
    }

    /**
     * Total number of records
     * @return int Total number of records in this model
     */
    public function countCountry() {
        $total = $this->find('count');
        
        return $total;
    }

    /**
     * Get list of country by specific condition
     * @return array List of Recording by specific condition
     */
    public function getCountryListByCondition() {
        return $this->getListByCondition();
    }
}

?>
