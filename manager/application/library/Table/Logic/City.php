<?php

class Table_Logic_City extends EloquentModel {
    protected $table = 't_cities';

    public $timestamps = false;

    public function getCityByProvinceid($province_id) {
    	// return $this->orderBy('id', 'desc')->get()->toArray();  
    	return $this->where('provinceid', '=', $province_id)->get()->toArray();  
    }

    public function getAll() {
    	return $this->orderBy('id', 'desc')->get()->toArray();  
    }

    
}
