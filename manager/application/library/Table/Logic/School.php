<?php

class Table_Logic_School extends EloquentModel {
	protected $table = 't_school_organization';

	public $timestamps = false;

	public function getRowById($id) {
		return $this->where('id', $id)->first()->toArray();
	}
}
