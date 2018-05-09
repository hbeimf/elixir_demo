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
		$id = $this->request->getQuery('id');
		// get code by id
		$row = DB::table('m_gp_list_163')->where('id', $id)->first();
		// p($row);exit;
		$params = [
			'from' => $this->request->getQuery('from'),
			// 'code' => $this->request->getQuery('code'),
			'code' => $row['code_sina'],
			'id' => $id,
		];

		$pre = DB::table('m_gp_list_163')->where('id', '<', $id)->orderBy('id', 'desc')->first();
		$next = DB::table('m_gp_list_163')->where('id', '>', $id)->orderBy('id', 'asc')->first();

		// p($pre);exit;
		$data = [
			'js' => 'file_timelist',
			'params' => $params,
			'pre' => (isset($next['id']) && $next['id'] > 1) ? $pre['id'] : 1,
			'next' => isset($next['id']) ? $next['id'] : 1,
		];
		$this->smarty->display('file/timelist.tpl', $data);
	}

	// 堆积图demo
	public function heapAction() {
		$params = [
			'from' => $this->request->getQuery('from'),
			'code' => $this->request->getQuery('code'),
		];

		$data = [
			'js' => 'file_heap',
			'params' => $params,
		];
		$this->smarty->display('file/heap.tpl', $data);
	}

	// http://echarts.baidu.com/examples/editor.html?c=bar-y-category
	public function headjsonAction() {
		$code = trim($this->request->getQuery('code'));
		// $code = substr($code, 2, 6);

		$table = new Table_Logic_Today();
		$obj = $table->where('code', '=', $code)->get();
		if (!is_null($obj)) {
			$rows = $obj->toArray();
			// p($row);exit;
			$row = $rows[0];

			$json = json_decode($row['history_relative_price'], true);
			// p($json);exit;

			$yAxis_data = [];
			$series_data = [];
			foreach ($json as $j) {
				# code...
				$yAxis_data[] = $j['start'] . '-' . $j['end'] . '-' . $j['id'];
				$series_data[] = $j['num'];
			}
			$data = [
				'title_text' => $row['code'],
				'title_subtext' => '数据来自网络-[' . $row['timer'] . ']-[' . $row['current_relative_price'] . ']-[' . $row['price'] . ']',
				'legend_data' => [$row['code']],
				'yAxis_data' => $yAxis_data,
				'series' => [
					'name' => $row['code'],
					'data' => $series_data,
				],
			];

		} else {
			$data = [
				'title_text' => '世界人口总量',
				'title_subtext' => '数据来自网络,数据出错',
				'legend_data' => ['2012年'],
				'yAxis_data' => ['巴西1', '印尼1', '美国', '印度', '中国', '世界人口(万)'],
				'series' => [
					'name' => '2012年',
					'data' => [19325, 23438, 31000, 121594, 134141, 681807],
				],
			];
		}

		echo json_encode($data);exit;
	}

	public function jsonAction() {
		$type = trim($this->request->getQuery('type'));
		$code = trim($this->request->getQuery('code'));
		// var_dump(trim($this->request->getQuery('category')));exit;
		$category = (trim($this->request->getQuery('category')) == "") ? 0 : trim($this->request->getQuery('category'));

		// $code = substr($code, 2, 6);

		$select = 'close_price,name, timer_int, format(((close_price - yesterday_close_price) / yesterday_close_price)*100, 1) as per';
		$obj = Table_Logic_Price::selectRaw($select);
		$obj->where('from_code', '=', $code)->where('close_price', '!=', 0)->orderBy('timer_int', 'desc');

		// ->offset($offset)->limit($limit)
		if ($type == 1) {
			//周
			$offset = 0;
			$limit = 10;
			$obj->offset($offset)->limit($limit);
		}

		if ($type == 2) {
			//月
			$offset = 0;
			$limit = 22;
			$obj->offset($offset)->limit($limit);
		}

		if ($type == 3) {
			//半年
			$offset = 0;
			$limit = 130;
			$obj->offset($offset)->limit($limit);
		}

		if ($type == 4) {
			//一年
			$offset = 0;
			$limit = 260;
			$obj->offset($offset)->limit($limit);
		}

		if ($type == 6) {
			//两年
			$offset = 0;
			$limit = 520;
			$obj->offset($offset)->limit($limit);
		}

		$history = $obj->get();

		$data = [];

		$name = '';
		if (count($history) > 0) {
			// foreach ($history as $h) {
			// 	$data[] = [
			// 		'name' => '',
			// 		'value' => [
			// 			date("Y/m/d", $h['timer_int']),
			// 			// $h['close_price'],
			// 			($category == 0) ? $h['close_price'] : $h['per'],
			// 		],
			// 	];
			// 	$name = $h['name'];
			// }

			for ($i = 0; $i < count($history); $i++) {
				$add1 = $history[$i]['close_price'] / $history[count($history) - 1]['close_price'];

				if ($add1 > 50) {

				} else {
					$data[] = [
						'name' => $add1,
						'value' => [
							date("Y/m/d", $history[$i]['timer_int']),
							// $h['close_price'],
							($category == 0) ? $history[$i]['close_price'] : $history[$i]['per'],
						],
					];
					$name = $history[$i]['name'];
				}

			}

		}
		// $table = new Table_Gp_List();
		// $row = $table->findByCode($code);

		$reply = [
			'name' => $name,
			'code' => $code,
			'category' => $category,
			'data' => $data,
		];

		echo json_encode($reply);

		exit;

	}

	public function listAction() {
		$params = array_map("trim", [
			'category' => $this->request->getQuery('category'),
			'name' => $this->request->getQuery('name'),
			'code' => $this->request->getQuery('code'),
			'namesina' => $this->request->getQuery('namesina'),
			'codesina' => $this->request->getQuery('codesina'),
			'page' => (!is_null($this->request->getQuery('page'))) ? $this->request->getQuery('page') : 1,
			'page_size' => (!is_null($this->request->getQuery('page_size'))) ? $this->request->getQuery('page_size') : 10,
			'order_field' => $this->request->getQuery('order_field'),
			'order_by' => $this->request->getQuery('order_by'),
		]);
		// p($params);
		$skip = ($params['page'] - 1) * $params['page_size'];

		// $select = 'id, name, dir, url, created_at, updated_at';
		$select = 'm_gp_list_163.*, b.current_relative_price as hid, b.timer, b.price, c.name as category';
		// Table_Logic_Price
		// $table_user = Table_Logic_Fileresource::selectRaw($select);
		$table_user = Table_Logic_Code::selectRaw($select)
			->leftJoin('m_today as b', 'b.code', '=', 'm_gp_list_163.code_sina')
			->leftJoin('t_school_type as c', 'c.id', '=', 'm_gp_list_163.category');

		if ($params['category'] > 0) {
			$table_user->where('m_gp_list_163.category', '=', $params['category']);
		}

		if (trim($params['name']) != '') {
			$name = urldecode($params['name']);
			$table_user->where('m_gp_list_163.name_163', 'like', "%{$name}%");
		}

		if (trim($params['namesina']) != '') {
			$name = urldecode($params['namesina']);
			$table_user->where('m_gp_list_163.name_sina', 'like', "%{$name}%");
		}

		if (trim($params['code']) != '') {
			$code = urldecode($params['code']);
			$table_user->where('m_gp_list_163.code_163', 'like', "%{$code}%");
		}

		if (trim($params['codesina']) != '') {
			$code = urldecode($params['codesina']);
			$table_user->where('m_gp_list_163.code_sina', 'like', "%{$code}%");
		}

		if ($params['order_field'] == 'category' && $params['order_by'] != '') {
			$table_user->orderBy('m_gp_list_163.category', $params['order_by']);
		}

		if ($params['order_field'] == 'cid' && $params['order_by'] != '') {
			$table_user->orderBy('b.current_relative_price', $params['order_by']);
		}

		if ($params['order_field'] == 'price' && $params['order_by'] != '') {
			$table_user->orderBy('b.price', $params['order_by']);
		}

		$table_user->orderBy('m_gp_list_163.id', 'asc');

		$count = $table_user->count();
		$users = $table_user
			->skip($skip)
			->limit($params['page_size'])
			// ->orderBy('b.current_relative_price', 'desc')
			// ->orderBy('m_gp_list_163.id', 'asc')
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

		//类型
		$school_type = Table_Logic_Schooltype::all()->toArray();
		$this->smarty->assign('school_type', $school_type);

		$this->smarty->display('file/list.tpl', $data);

	}

	public function addFileAction() {
		if ($this->request->isPost()) {
			$data = array_map("trim", [
				'category' => $this->request->getPost('category'),
			]);

			$id = $this->request->getPost('id');

			if ($id == '') {
				return $this->ajax_error('error！');
			} else {
				Table_Logic_Code::where('id', $id)->update($data);
				return $this->ajax_success('更新成功！');
			}
		}

		//初始化 modal
		if (!is_null($this->request->getParam('id'))) {
			$id = $this->request->getParam('id');
			$role = DB::table('m_gp_list_163')->where('id', $id)->first();
			$this->smarty->assign('role', $role);
		}

		//类型
		$school_type = Table_Logic_Schooltype::all()->toArray();
		$this->smarty->assign('school_type', $school_type);

		$this->smarty->display('file/addFile.tpl');
	}

	public function delFileAction() {
		$id = $this->request->getParam('id');

		$this->ajax_success('目前未提供删除功能' . $id);
	}

	public function addcategoryAction() {
		$id = $this->request->getParam('id');
		$table = new Table_Logic_Code();
		$table->update_ten($id);
		// $row = $table->where('id', '=', $id)->first()->toArray();
		// $data = ['category' => $row['category'] + 1];

		// Table_Logic_Code::where('id', $id)->update($data);

		$this->ajax_success('更新成功');
	}

	public function minuscategoryAction() {
		$id = $this->request->getParam('id');

		$table = new Table_Logic_Code();
		$table->update_all($id);
		// $row = $table->where('id', '=', $id)->first()->toArray();
		// $data = ['category' => $row['category'] - 1];
		// if ($data['category'] <= 0) {
		// 	$data['category'] = 0;
		// }

		// Table_Logic_Code::where('id', $id)->update($data);

		$this->ajax_success('初始化成功' . $id);
	}

}
