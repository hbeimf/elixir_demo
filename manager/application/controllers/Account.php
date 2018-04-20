<?php

use Illuminate\Database\Capsule\Manager as DB;

class AccountController extends AbstractController {

	public function listAction() {
		$params = [
			'name' => $this->request->getQuery('name'),
			'page' => (!is_null($this->request->getQuery('page'))) ? $this->request->getQuery('page') : 1,
			'page_size' => (!is_null($this->request->getQuery('page_size'))) ? $this->request->getQuery('page_size') : 10,
		];

		$skip = ($params['page'] - 1) * $params['page_size'];

		$select = 'id, user_name as name, is_enabled, created_at, updated_at';
		$table_user = Table_Logic_Customeraccount::selectRaw($select);
		if (trim($params['name']) != '') {
			$name = urldecode($params['name']);
			$table_user->where('user_name', 'like', "%{$name}%");
		}
		$count = $table_user->count();
		$users = $table_user
			->skip($skip)
			->limit($params['page_size'])
			->orderBy('id', 'desc')
			->get();

		$totalPage = ceil($count / $params['page_size']);

		$data = [
			'js' => 'file_list',
			'rand' => time(),
			'users' => $users->toArray(), // 当前页记录
			'count' => $count, // 记录条数
			'page' => $params['page'], // 当前页
			'totalPage' => $totalPage, // 总页数
			'params' => $params,
		];

		$this->smarty->display('account/list.tpl', $data);
	}

	// public function addAction() {
	// 	if ($this->request->isPost()) {

	// 		$data = [
	// 			'name' => $this->request->getPost('name'),
	// 			'note' => $this->request->getPost('note'),
	// 			'is_enabled' => $this->request->getPost('is_enabled'),
	// 		];

	// 		if ($data['name'] == '') {
	// 			return $this->ajax_error('名称不能为空');
	// 		}

	// 		if ($data['note'] == '') {
	// 			return $this->ajax_error('备注不能为空');
	// 		}

	// 		$id = $this->request->getPost('id');
		
	// 		if ($id == '') {
	// 			$data['updated_at'] = $data['created_at'] = time();
	// 			DB::table('t_school_organization')->insert([$data]);
	// 			return $this->ajax_success('添加成功！');
	// 		} else {
	// 			$data['updated_at'] = time();
	// 			Table_Logic_School::where('id', $id)->update($data);
	// 			return $this->ajax_success('更新成功！');
	// 		}
	// 	}

	// 	//初始化 modal
	// 	if (! is_null($this->request->getParam('id'))) {
	// 		$id = $this->request->getParam('id');
	// 		$role = DB::table('t_school_organization')->where('id', $id)->first();

	// 		$this->smarty->assign('role', $role);
	// 	}

	// 	$this->smarty->display('school/add.tpl');
	// }

	// public function delAction(){
	// 	$id = $this->request->getParam('id');

	// 	$this->ajax_success('目前未提供删除功能'.$id);
	// }

	public function enableAction(){
		$id = $this->request->getParam('id');
		$data = ['is_enabled' => 1];
		Table_Logic_Customeraccount::where('id', $id)->update($data);
		$this->ajax_success('启动成功！');
	}
	
	public function unenableAction(){
		$id = $this->request->getParam('id');
		$data = ['is_enabled' => 0];
		Table_Logic_Customeraccount::where('id', $id)->update($data);
		$this->ajax_success('禁用成功！');
	}
	
}