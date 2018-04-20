<?php

use Illuminate\Database\Capsule\Manager as DB;

class PptController extends AbstractController {

	public function listAction() {
		$params = array_map("trim", [
			'name' => $this->request->getQuery('name'),
			'curriculum_id' => $this->request->getQuery('curriculum_id'),
			'page' => (!is_null($this->request->getQuery('page'))) ? $this->request->getQuery('page') : 1,
			'page_size' => (!is_null($this->request->getQuery('page_size'))) ? $this->request->getQuery('page_size') : 10,
		]);

		if (!is_null($this->request->getPost('curriculum_id')) && $this->request->getPost('curriculum_id') != '') {
			$params['curriculum_id'] = $this->request->getPost('curriculum_id');
		}

		$skip = ($params['page'] - 1) * $params['page_size'];

		$select = '*';
		$table_user = Table_Logic_Ppt::selectRaw($select);
		if (trim($params['name']) != '') {
			$name = urldecode($params['name']);
			$table_user->where('name', 'like', "%{$name}%");
		}

		if ($params['curriculum_id'] != '') {
			$table_user->where('curriculum_id', '=', $params['curriculum_id']);
		} else {
			$params['curriculum_id'] = 0;
		}

		$count = $table_user->count();
		$users = $table_user
			->skip($skip)
			->limit($params['page_size'])
			->orderBy('id', 'desc')
			->get();

		$totalPage = ceil($count / $params['page_size']);

		$data = [
			'js' => 'ppt',
			'rand' => time(),
			'users' => $users->toArray(), // 当前页记录
			'count' => $count, // 记录条数
			'page' => $params['page'], // 当前页
			'totalPage' => $totalPage, // 总页数
			'params' => $params,
			'has_add_right' => $this->has_right('ppt', 'add'),
			'has_enable_right' => $this->has_right('ppt', 'enable'),
			'has_unenable_right' => $this->has_right('ppt', 'unenable'),
		];

		// $list = Table_Gp_List::find(1)->toArray();

		// $this->smarty->getSmarty()->registerPlugin("function", "menu_name", "menu_name");
		$this->smarty->display('ppt/list.tpl', $data);

	}

	public function addAction() {
		// 课程 id
		$curriculum_id = $this->request->getQuery('curriculum_id');
		$this->smarty->assign('curriculum_id', $curriculum_id);

		if ($this->request->isPost()) {

			$data = array_map("trim", [
				'name' => $this->request->getPost('name'),
				'class_type' => $this->request->getPost('class_type'),
				'is_enabled' => $this->request->getPost('is_enabled'),
				'curriculum_id' => $curriculum_id,
			]);

			if ($data['name'] == '') {
				return $this->ajax_error('PPT名称不能为空');
			}

			if ($data['class_type'] == 1) {
				$data['area1'] = $this->request->getPost('area_11_id');
				$data['area2'] = $this->request->getPost('area_12_id');
				$data['area3'] = 0;
				$data['area4'] = 0;

				if ($data['area1'] == 0) {
					return $this->ajax_error('区域1未完成');
				}
				if ($data['area2'] == 0) {
					return $this->ajax_error('区域2未完成');
				}

			} else {
				$data['area1'] = $this->request->getPost('area_21_id');
				$data['area2'] = $this->request->getPost('area_22_id');
				$data['area3'] = $this->request->getPost('area_23_id');
				$data['area4'] = $this->request->getPost('area_24_id');
				if ($data['area1'] == 0) {
					return $this->ajax_error('区域1未完成');
				}
				if ($data['area2'] == 0) {
					return $this->ajax_error('区域2未完成');
				}
				if ($data['area3'] == 0) {
					return $this->ajax_error('区域3未完成');
				}
				if ($data['area4'] == 0) {
					return $this->ajax_error('区域4未完成');
				}
			}

			$id = $this->request->getPost('id');

			if ($id == '') {
				$data['updated_at'] = $data['created_at'] = time();
				DB::table('t_ppt')->insert([$data]);
				return $this->ajax_success('添加成功！');
			} else {
				$data['updated_at'] = time();
				Table_Logic_Ppt::where('id', $id)->update($data);
				return $this->ajax_success('更新成功！');
			}
		}

		//初始化 modal
		if (!is_null($this->request->getParam('id'))) {
			$id = $this->request->getParam('id');
			$row = DB::table('t_ppt')->where('id', $id)->first();
			$this->smarty->assign('role', $row);

			$table_pic = new Table_Logic_Pic();
			$table_font = new Table_Logic_Font();
			$table_resource = new Table_Logic_Resource();
			if ($row['class_type'] == 1) {
				// 初始图片
				$row11 = $table_pic->where('id', '=', $row['area1'])->first();
				$res11 = $table_resource->where('id', '=', $row11['pic'])->first();
				$area11 = [
					'dir' => $res11['dir'],
					'id' => $row['area1'],
				];
				// 初始音频文字
				$row12 = $table_font->where('id', '=', $row['area2'])->first();
				$res12 = $table_resource->where('id', '=', $row12['mp3'])->first();
				$area12 = [
					'font' => $row12['font'],
					'id' => $row['area2'],
					'mp3' => $res12['name'],
				];

				$this->smarty->assign('area11', $area11);
				$this->smarty->assign('area12', $area12);
			} else {
				// 初始音频文字
				$row21 = $table_font->where('id', '=', $row['area1'])->first();
				$res21 = $table_resource->where('id', '=', $row21['mp3'])->first();
				$area21 = [
					'font' => $row21['font'],
					'id' => $row['area1'],
					'mp3' => $res21['name'],
				];

				// 初始图片
				$row22 = $table_pic->where('id', '=', $row['area2'])->first();
				$res22 = $table_resource->where('id', '=', $row22['pic'])->first();
				$area22 = [
					'dir' => $res22['dir'],
					'id' => $row['area2'],
				];

				// 初始音频文字
				$row23 = $table_font->where('id', '=', $row['area3'])->first();
				$res23 = $table_resource->where('id', '=', $row23['mp3'])->first();
				$area23 = [
					'font' => $row23['font'],
					'id' => $row['area3'],
					'mp3' => $res23['name'],
				];

				// 初始音频文字
				$row24 = $table_font->where('id', '=', $row['area4'])->first();
				$res24 = $table_resource->where('id', '=', $row24['mp3'])->first();
				$area24 = [
					'font' => $row24['font'],
					'id' => $row['area4'],
					'mp3' => $res24['name'],
				];

				$this->smarty->assign('area21', $area21);
				$this->smarty->assign('area22', $area22);
				$this->smarty->assign('area23', $area23);
				$this->smarty->assign('area24', $area24);

			}
		}

		$this->smarty->display('ppt/add.tpl');
	}

	public function delFileAction() {
		$id = $this->request->getParam('id');

		$this->ajax_success('目前未提供删除功能' . $id);
	}

	public function enableAction() {
		$id = $this->request->getParam('id');
		$data = ['is_enabled' => 1];
		Table_Logic_Ppt::where('id', $id)->update($data);
		$this->ajax_success('启动成功！');
	}

	public function unenableAction() {
		$id = $this->request->getParam('id');
		$data = ['is_enabled' => 0];
		Table_Logic_Ppt::where('id', $id)->update($data);
		$this->ajax_success('禁用成功！');
	}

	public function picAction() {
		// 课程 id
		$curriculum_id = $this->request->getQuery('curriculum_id');
		$this->smarty->assign('curriculum_id', $curriculum_id);

		$area = $this->request->getQuery('area');
		$this->smarty->assign('area', $area);

		$params = [
			'name' => $this->request->getQuery('name'),
			'curriculum_id' => $curriculum_id,
			'page' => (!is_null($this->request->getQuery('page'))) ? $this->request->getQuery('page') : 1,
			'page_size' => (!is_null($this->request->getQuery('page_size'))) ? $this->request->getQuery('page_size') : 10,
		];

		$skip = ($params['page'] - 1) * $params['page_size'];

		$select = 't_picture.*, b.dir';
		$table_user = Table_Logic_Pic::selectRaw($select);
		$table_user->where('t_picture.is_enabled', '=', 1);
		if (trim($params['name']) != '') {
			$name = urldecode($params['name']);
			$table_user->where('t_picture.name', 'like', "%{$name}%");
		}
		if ($params['curriculum_id'] != '') {
			$table_user->where('t_picture.curriculum_id', '=', $curriculum_id);
		}

		$count = $table_user->count();
		$users = $table_user
			->leftJoin('t_resource as b', 'b.id', '=', 't_picture.pic')
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
			'pageType' => 'modal', // 模态框
			'params' => $params,
			'has_add_right' => $this->has_right('pic', 'add'),
			'has_enable_right' => $this->has_right('pic', 'enable'),
			'has_unenable_right' => $this->has_right('pic', 'unenable'),
		];
		$this->smarty->display('ppt/pic.tpl', $data);
	}

	public function fontAction() {
		// 课程 id
		$curriculum_id = $this->request->getQuery('curriculum_id');
		$this->smarty->assign('curriculum_id', $curriculum_id);

		$area = $this->request->getQuery('area');
		$this->smarty->assign('area', $area);

		$params = array_map("trim", [
			'name' => $this->request->getQuery('name'),
			'curriculum_id' => $curriculum_id,
			'page' => (!is_null($this->request->getQuery('page'))) ? $this->request->getQuery('page') : 1,
			'page_size' => (!is_null($this->request->getQuery('page_size'))) ? $this->request->getQuery('page_size') : 10,
		]);

		$skip = ($params['page'] - 1) * $params['page_size'];

		$select = 't_font.*, b.name';
		$table_user = Table_Logic_Font::selectRaw($select);
		$table_user->where('t_font.is_enabled', '=', 1);
		if (trim($params['name']) != '') {
			$name = urldecode($params['name']);
			$table_user->where('t_font.font', 'like', "%{$name}%");
		}
		if ($params['curriculum_id'] != '') {
			$table_user->where('t_font.curriculum_id', '=', $curriculum_id);
		}
		$count = $table_user->count();
		$users = $table_user
			->leftJoin('t_resource as b', 'b.id', '=', 't_font.mp3')
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
			'pageType' => 'modal', // 模态框
			'params' => $params,
			'has_add_right' => $this->has_right('font', 'add'),
			'has_enable_right' => $this->has_right('font', 'enable'),
			'has_unenable_right' => $this->has_right('font', 'unenable'),
		];

		// $list = Table_Gp_List::find(1)->toArray();

		// $this->smarty->getSmarty()->registerPlugin("function", "menu_name", "menu_name");
		// $this->smarty->display('font/list.tpl', $data);
		$this->smarty->display('ppt/font.tpl', $data);

	}

}
