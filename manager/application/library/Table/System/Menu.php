<?php

class Table_System_Menu extends EloquentModel {
    protected $table = 'system_menu';

    // public $primaryKey = 'id';

    public $timestamps = false;

    // protected $dateFormat = 'U';

    public function allMenu() {
        // return $this->where('status', '=', '1')->orderBy('id', 'desc')->get()->toArray();  
        return $this->orderBy('id', 'desc')->get()->toArray();  
        
    }
}
