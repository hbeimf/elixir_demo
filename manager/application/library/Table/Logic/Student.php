<?php

class Table_Logic_Student extends EloquentModel {
    protected $table = 't_student';

    public $timestamps = false;

    public function getRowById($id) {
        return $this->where('id', $id)->first()->toArray();
    }
}
