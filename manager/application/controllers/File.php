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

		$history = $obj->get();

		$data = [];

		$name = '';
		if (count($history) > 0) {
			foreach ($history as $h) {
				$data[] = [
					'name' => '',
					'value' => [
						date("Y/m/d", $h['timer_int']),
						// $h['close_price'],
						($category == 0) ? $h['close_price'] : $h['per'],
					],
				];
				$name = $h['name'];
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
			'name' => $this->request->getQuery('name'),
			'code' => $this->request->getQuery('code'),
			'page' => (!is_null($this->request->getQuery('page'))) ? $this->request->getQuery('page') : 1,
			'page_size' => (!is_null($this->request->getQuery('page_size'))) ? $this->request->getQuery('page_size') : 10,
		]);

		$skip = ($params['page'] - 1) * $params['page_size'];

		// $select = 'id, name, dir, url, created_at, updated_at';
		$select = 'm_gp_list.*, b.current_relative_price as hid, b.timer';
		// Table_Logic_Price
		// $table_user = Table_Logic_Fileresource::selectRaw($select);
		$table_user = Table_Logic_Code::selectRaw($select)
			->leftJoin('m_today as b', 'b.code', '=', 'm_gp_list.code');

		if (trim($params['name']) != '') {
			$name = urldecode($params['name']);
			$table_user->where('m_gp_list.name', 'like', "%{$name}%");
		}

		if (trim($params['code']) != '') {
			$code = urldecode($params['code']);
			$table_user->where('m_gp_list.code', 'like', "%{$code}%");
		}

		$count = $table_user->count();
		$users = $table_user
			->skip($skip)
			->limit($params['page_size'])
			->orderBy('b.current_relative_price', 'desc')
			->orderBy('m_gp_list.id', 'asc')
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
