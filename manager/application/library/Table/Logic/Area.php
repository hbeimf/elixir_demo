<?php

class Table_Logic_Area extends EloquentModel {
    protected $table = 't_areas';

    public $timestamps = false;

    public function getAreaByCityid($city_id) {
    	return $this->where('cityid', '=', $city_id)->get()->toArray();  
    }

     public function getAll() {
    	return $this->orderBy('id', 'desc')->get()->toArray();  
    }
}
