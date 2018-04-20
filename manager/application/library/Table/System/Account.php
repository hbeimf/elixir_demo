<?php

class Table_System_Account extends EloquentModel {
	protected $table = 'system_account';

	public $timestamps = false;

	// 判断 account 是否重复添加
	public function isAccountDouble($account) {
		$res = $this->where('account_name', $account)->first();
		if (is_null($res)) {
			return false;
		}
		return true;
	}

	public function is_superadmin($uid = '') {
		if (!is_numeric($uid)) {
			return false;
		}

		$res = $this->where('id', $uid)->first();
		if (is_null($res)) {
			return false;
		}
		$account = $res->toArray();
		if (isset($account['account_name']) && $account['account_name'] == 'superadmin') {
			return true;
		}
		return false;
	}

}
