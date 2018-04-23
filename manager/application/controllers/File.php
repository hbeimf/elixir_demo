<?php

use Illuminate\Database\Capsule\Manager as DB;

class FileController extends AbstractController {

	// 柱状统计图
	public function indexAction() {
		$params = [
			'from' => $this->request->getQuery('from'),
		];

		$data = [
			'js' => 'file_index',
			'params' => $params,
		];
		$this->smarty->display('file/index.tpl', $data);
	}

	// 线状统计图demo
	public function timelistAction() {
		$params = [
			'from' => $this->request->getQuery('from'),
			'code' => $this->request->getQuery('code'),
		];

		$data = [
			'js' => 'file_timelist',
			'params' => $params,
		];
		$this->smarty->display('file/timelist.tpl', $data);
	}

	public function jsonAction() {
		$code = trim($this->request->getQuery('code'));
		$code = substr($code, 2, 6);
		// $code = '600000';
		// $code = '000001';

		// echo $code;exit;

		$select = 'price, timer_int';
		$obj = Table_Logic_Price::selectRaw($select);
		$obj->where('code', '=', $code)->where('price', '!=', 0)->orderBy('timer_int', 'desc');

		// $count = $account_obj->count();
		$history = $obj->orderBy('timer_int', 'desc')->get();

		$data = [];

		if (count($history) > 0) {
			foreach ($history as $h) {
				$data[] = [
					'name' => '',
					'value' => [
						date("Y/m/d", $h['timer_int']),
						$h['price'],
					],
				];
			}
		}
		// $table = new Table_Gp_List();
		// $row = $table->findByCode($code);

		$reply = [
			'name' => 'test',
			'code' => $code,
			'data' => $data,
		];

		echo json_encode($reply);

		exit;

	}

	public function listAction() {
		$params = [
			'name' => $this->request->getQuery('name'),
			'page' => (!is_null($this->request->getQuery('page'))) ? $this->request->getQuery('page') : 1,
			'page_size' => (!is_null($this->request->getQuery('page_size'))) ? $this->request->getQuery('page_size') : 10,
		];

		$skip = ($params['page'] - 1) * $params['page_size'];

		// $select = 'id, name, dir, url, created_at, updated_at';
		$select = '*';
		// Table_Logic_Price
		// $table_user = Table_Logic_Fileresource::selectRaw($select);
		$table_user = Table_Logic_Code::selectRaw($select);

		// if (trim($params['name']) != '') {
		// 	$name = urldecode($params['name']);
		// 	$table_user->where('name', 'like', "%{$name}%");
		// }
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

		// $list = Table_Gp_List::find(1)->toArray();
		// p($data);exit;
		// $this->smarty->getSmarty()->registerPlugin("function", "has_file", "has_file");
		$this->smarty->display('file/list.tpl', $data);

	}

	public function addFileAction() {
		if ($this->request->isPost()) {
			$table_resource = new Table_Logic_Resource();
			$r = $table_resource->upload('img');

			if ($r['flg']) {
				// var_dump($r);exit;
				if ($r['from'] == 'old') {
					return $this->ajax_error('文件己存在，不要重复上传！');
				}
				return $this->ajax_success('添加成功！');
			}

			return $this->ajax_error('添加失败！');
		}

		//初始化 modal
		if (!is_null($this->request->getParam('id'))) {
			$id = $this->request->getParam('id');
			$role = DB::table('t_resource')->where('id', $id)->first();
			// $role['menu_ids'] = explode(',', $role['menu_ids']);

			$this->smarty->assign('role', $role);
		}

		$this->smarty->display('file/addFile.tpl');
	}

	public function delFileAction() {
		$id = $this->request->getParam('id');

		$this->ajax_success('目前未提供删除功能' . $id);
	}

}
