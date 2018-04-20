<?php
// http://www.cnblogs.com/52fhy/p/5277657.html
class Table_System_Role extends EloquentModel {
	protected $table = 'system_role';

	// public $primaryKey = 'id';

	public $timestamps = false;

	// protected $dateFormat = 'U';

	public function getRoleIdByRoleName($role_name) {
		$res = $this->where('role_name', $role_name)->first();
		if (!is_null($res)) {
			$role = $res->toArray();
			return $role['id'];
		}
		return '';
	}

	public function allRole() {
		return $this->where('role_name', '!=', '超级管理员')->orderBy('id', 'desc')->get()->toArray();
	}

	public function allRoles() {
		return $this->orderBy('id', 'desc')->get()->toArray();
	}

}
