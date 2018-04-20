<?php

class Table_Logic_Classes extends EloquentModel {
	protected $table = 't_class';

	public $timestamps = false;

	public function getRowBySchoolId($school_id) {
		return $this->where('school_id', '=', $school_id)->get()->toArray();
	}

	public function getRowById($id) {
		return $this->where('id', $id)->first()->toArray();
	}
}
