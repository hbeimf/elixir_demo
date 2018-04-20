<?php

use Illuminate\Database\Capsule\Manager as DB;

class CurriculumController extends AbstractController {

	public function listAction() {
		$params = [
			'name' => $this->request->getQuery('name'),
			'page' => (!is_null($this->request->getQuery('page'))) ? $this->request->getQuery('page') : 1,
			'page_size' => (!is_null($this->request->getQuery('page_size'))) ? $this->request->getQuery('page_size') : 10,
		];

		$skip = ($params['page'] - 1) * $params['page_size'];

		$select = 'id, name, is_enabled, order_by';
		$table_user = Table_Logic_Curriculum::selectRaw($select);
		if (trim($params['name']) != '') {
			$name = urldecode($params['name']);
			$table_user->where('name', 'like', "%{$name}%");
		}

		// 如果是机构人员， 则过滤掉禁用了的课程
		$school_id = $this->get_school_id();
		if ($school_id > 0) {
			$table_user->where('is_enabled', '=', 1);
		}

		$count = $table_user->count();
		$users = $table_user
			->skip($skip)
			->limit($params['page_size'])
			->orderBy('order_by', 'desc')
			->get()
			->toArray();

		$totalPage = ceil($count / $params['page_size']);

		$table_step = new Table_Logic_Curriculumstep();
		for ($i = 0; $i < count($users); $i++) {
			$users[$i]['steps'] = $table_step
				->where('curriculum_id', '=', $users[$i]['id'])
				->where('is_enabled', '=', 1)
				->get()
				->toArray();
		}
		// p($users);
		$data = [
			'js' => 'curriculum',
			'rand' => time(),
			'users' => $users, // 当前页记录
			'count' => $count, // 记录条数
			'page' => $params['page'], // 当前页
			'totalPage' => $totalPage, // 总页数
			'params' => $params,
			'has_add_right' => $this->has_right('curriculum', 'add'),
			'has_addstep_right' => $this->has_right('curriculum', 'addstep'),
			'has_showstep_right' => $this->has_right('curriculum', 'showstep'),
			'has_edit_right' => $this->has_right('curriculum', 'edit'),
			'has_enable_right' => $this->has_right('curriculum', 'enable'),
			'has_unenable_right' => $this->has_right('curriculum', 'unenable'),
			'has_pic_right' => $this->has_right('pic', 'list'),
			'has_font_right' => $this->has_right('font', 'list'),
			'has_music_right' => $this->has_right('music', 'list'),
			'has_ppt_right' => $this->has_right('ppt', 'list'),
		];

		$this->smarty->display('curriculum/list.tpl', $data);

	}

	public function addAction() {
		$orderBy = Table_Logic_Curriculum::max('order_by') + 1;
		$data = [
			'name' => '课程名称',
			'order_by' => $orderBy,
		];

		$table = new Table_Logic_Curriculum();
		$row = $table->orderBy('id', 'desc')->first();
		if (is_null($row)) {
			$data['updated_at'] = $data['created_at'] = time();
			DB::table('t_curriculum')->insert([$data]);
			return $this->ajax_success('添加成功！');
		} else {
			$d = $row->toArray();
			// p($d['id']);exit;
			$table_step = new Table_Logic_Curriculumstep();
			$count = $table_step->where('curriculum_id', '=', $d['id'])->count();
			if ($count > 0) {
				$data['updated_at'] = $data['created_at'] = time();
				DB::table('t_curriculum')->insert([$data]);
				return $this->ajax_success('添加成功！');
			} else {
				return $this->ajax_error('请先完善最后添加的课程后再添加新课程！');
			}
		}
	}

	public function editAction() {
		if ($this->request->isPost()) {

			$data = array_map("trim", [
				'name' => $this->request->getPost('name'),
				'order_by' => $this->request->getPost('order_by'),

			]);

			if ($data['name'] == '') {
				return $this->ajax_error('课程名称不能为空');
			}

			if ($data['order_by'] == '') {
				return $this->ajax_error('排序不能为空');
			} else {
				if (!is_numeric($data['order_by'])) {
					return $this->ajax_error('排序必须是阿拉伯数字');
				}
			}

			$id = $this->request->getPost('id');

			if ($id == '') {
				$data['updated_at'] = $data['created_at'] = time();
				DB::table('t_curriculum')->insert([$data]);
				return $this->ajax_success('添加成功！');
			} else {
				$data['updated_at'] = time();
				Table_Logic_Curriculum::where('id', $id)->update($data);
				return $this->ajax_success('更新成功！');
			}
		}

		//初始化 modal
		if (!is_null($this->request->getQuery('curriculum_id'))) {
			$id = $this->request->getQuery('curriculum_id');
			$role = DB::table('t_curriculum')->where('id', $id)->first();

			$this->smarty->assign('role', $role);
		}

		$this->smarty->display('curriculum/edit.tpl');
	}

	public function addstepAction() {
		$curriculum_id = $this->request->getQuery('curriculum_id');
		$this->smarty->assign('curriculum_id', $curriculum_id);
		$step_id = $this->request->getQuery('step_id');
		if (is_null($step_id)) {
			$step_id = $this->request->getPost('curriculum_step_id');
			if (is_null($step_id)) {
				$step_id = 0;
			}
		}
		$this->smarty->assign('step_id', $step_id);

		if ($this->request->isPost()) {

			$data = array_map("trim", [
				'curriculum_id' => $curriculum_id,
				'name' => $this->request->getPost('name'),
				'res_type' => $this->request->getPost('res_type'),
				'music_id' => $this->request->getPost('music_id'),
				'ppt_id' => $this->request->getPost('ppt_id'),
			]);

			if ($data['name'] == '') {
				return $this->ajax_error('步骤名称不能为空');
			}

			if ($data['res_type'] == 1) {
				if ($data['ppt_id'] == 0) {
					return $this->ajax_error('请选择PPT');
				}
			} elseif ($data['res_type'] == 2) {
				if ($data['music_id'] == 0) {
					return $this->ajax_error('请选择乐谱');
				}
			}

			if ($step_id == 0) {
				$data['updated_at'] = $data['created_at'] = time();
				$data['is_enabled'] = 1; // 默认添加课程步骤为启动状态
				DB::table('t_curriculum_step')->insert([$data]);
				return $this->ajax_success('添加成功！');
			} else {
				// 更新版本号，
				$row = DB::table('t_curriculum_step')->where('id', $step_id)->first();
				$data['version_num'] = $row['version_num'] + 1;
				$data['updated_at'] = time();
				Table_Logic_Curriculumstep::where('id', $step_id)->update($data);
				return $this->ajax_success('更新成功！');
			}
		}

		//初始化 modal
		if ($step_id > 0) {
			$role = DB::table('t_curriculum_step')->where('id', $step_id)->first();
			$this->smarty->assign('role', $role);
		}

		$d = [
			'has_delete_right' => $this->has_right('curriculum', 'delete'),
		];
		$this->smarty->display('curriculum/add.tpl', $d);
	}

	public function showstepAction() {
		$curriculum_id = $this->request->getQuery('curriculum_id');
		$this->smarty->assign('curriculum_id', $curriculum_id);
		$step_id = $this->request->getQuery('step_id');
		if (is_null($step_id)) {
			$step_id = $this->request->getPost('curriculum_step_id');
			if (is_null($step_id)) {
				$step_id = 0;
			}
		}
		$this->smarty->assign('step_id', $step_id);

		if ($this->request->isPost()) {

			$data = array_map("trim", [
				'curriculum_id' => $curriculum_id,
				'name' => $this->request->getPost('name'),
				'res_type' => $this->request->getPost('res_type'),
				'music_id' => $this->request->getPost('music_id'),
				'ppt_id' => $this->request->getPost('ppt_id'),
			]);

			if ($data['name'] == '') {
				return $this->ajax_error('步骤名称不能为空');
			}

			if ($data['res_type'] == 1) {
				if ($data['ppt_id'] == 0) {
					return $this->ajax_error('请选择PPT');
				}
			} elseif ($data['res_type'] == 2) {
				if ($data['music_id'] == 0) {
					return $this->ajax_error('请选择乐谱');
				}
			}

			if ($step_id == 0) {

				$data['updated_at'] = $data['created_at'] = time();
				DB::table('t_curriculum_step')->insert([$data]);
				return $this->ajax_success('添加成功！');
			} else {
				// 更新版本号，
				$row = DB::table('t_curriculum_step')->where('id', $step_id)->first();
				$data['version_num'] = $row['version_num'] + 1;
				$data['updated_at'] = time();
				Table_Logic_Curriculumstep::where('id', $step_id)->update($data);
				return $this->ajax_success('更新成功！');
			}
		}

		//初始化 modal
		if ($step_id > 0) {
			$role = DB::table('t_curriculum_step')->where('id', $step_id)->first();
			$this->smarty->assign('role', $role);
		}

		// show flg
		$this->smarty->assign('show_flg', 1);
		$this->smarty->display('curriculum/add.tpl');
	}

	// public function delFileAction() {
	// 	$id = $this->request->getParam('id');

	// 	$this->ajax_success('目前未提供删除功能' . $id);
	// }

	public function pptAction() {
		$params = array_map("trim", [
			'name' => $this->request->getQuery('name'),
			'curriculum_id' => $this->request->getQuery('curriculum_id'),
			'page' => (!is_null($this->request->getQuery('page'))) ? $this->request->getQuery('page') : 1,
			'page_size' => (!is_null($this->request->getQuery('page_size'))) ? $this->request->getQuery('page_size') : 10,
		]);

		$skip = ($params['page'] - 1) * $params['page_size'];

		$select = '*';
		$table_user = Table_Logic_Ppt::selectRaw($select);
		if (trim($params['name']) != '') {
			$name = urldecode($params['name']);
			$table_user->where('name', 'like', "%{$name}%");
		}

		if ($params['curriculum_id'] != '') {
			$table_user->where('curriculum_id', '=', $params['curriculum_id']);
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
			'pageType' => 'modal', // 模态框
			'params' => $params,
			'has_add_right' => $this->has_right('ppt', 'add'),
			'has_enable_right' => $this->has_right('ppt', 'enable'),
			'has_unenable_right' => $this->has_right('ppt', 'unenable'),
		];

		// $list = Table_Gp_List::find(1)->toArray();

		// $this->smarty->getSmarty()->registerPlugin("function", "menu_name", "menu_name");
		$this->smarty->display('curriculum/ppt.tpl', $data);

	}

	public function musicAction() {
		$params = [
			'name' => $this->request->getQuery('name'),
			'curriculum_id' => $this->request->getQuery('curriculum_id'),
			'page' => (!is_null($this->request->getQuery('page'))) ? $this->request->getQuery('page') : 1,
			'page_size' => (!is_null($this->request->getQuery('page_size'))) ? $this->request->getQuery('page_size') : 10,
		];

		$skip = ($params['page'] - 1) * $params['page_size'];

		$select = 't_music.*, b.name as t_name, c.dir as png_dir, d.name as xml_name, e.name as mp3_name, f.name as mp3_demo_name';
		$table_user = Table_Logic_Music::selectRaw($select);
		// if (trim($params['name']) != '') {
		// 	$name = urldecode($params['name']);
		// 	// $table_user->where('t_music.name', 'like', "%{$name}%");
		// }
		// $count = $table_user->count();
		$users_obj = $table_user
			->leftJoin('t_tutorial as b', 'b.id', '=', 't_music.tutorial_id')
			->leftJoin('t_resource as c', 'c.id', '=', 't_music.png')
			->leftJoin('t_resource as d', 'd.id', '=', 't_music.xml')
			->leftJoin('t_resource as e', 'e.id', '=', 't_music.mp3')
			->leftJoin('t_resource as f', 'f.id', '=', 't_music.mp3_demo')
			->skip($skip)
			->limit($params['page_size'])
			->orderBy('t_music.id', 'desc');

		if (trim($params['name']) != '') {
			$name = urldecode($params['name']);
			$table_user->where('d.name', 'like', "%{$name}%");
		}

		if ($params['curriculum_id'] != '') {
			$table_user->where('t_music.curriculum_id', '=', $params['curriculum_id']);
		}

		$count = $table_user->count();
		$users = $users_obj->get();
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
			'has_add_right' => $this->has_right('teacher', 'add'),
			'has_enable_right' => $this->has_right('teacher', 'enable'),
			'has_unenable_right' => $this->has_right('teacher', 'unenable'),
		];

		// $list = Table_Gp_List::find(1)->toArray();

		// $this->smarty->getSmarty()->registerPlugin("function", "menu_name", "menu_name");
		$this->smarty->display('curriculum/music.tpl', $data);
	}

	public function musicInfoAction() {
		$reply = [
			'flg' => false,
			'msg' => '',
		];
		$music_id = $this->request->getQuery('music_id');
		$table = new Table_Logic_Music();
		$obj = $table->where('id', '=', $music_id)->first();
		if (!is_null($obj)) {
			$table_res = new Table_Logic_Resource();
			$row = $table_res->where('id', '=', $obj->png)->first()->toArray();
			$reply = [
				'flg' => true,
				'msg' => '',
				'step_name' => $obj->name,
				'name' => $row['name'],
				'dir' => $row['dir'],
			];
			echo json_encode($reply);exit;
		}
		echo json_encode($reply);exit;

	}

	public function pptInfoAction() {
		$reply = [
			'flg' => false,
			'msg' => '',
		];

		$ppt_id = $this->request->getQuery('ppt_id');
		$table = new Table_Logic_Ppt();
		$obj = $table->where('id', '=', $ppt_id)->first();
		if (!is_null($obj)) {
			$reply = [
				'flg' => true,
				'msg' => '',
				'step_name' => $obj->name,
				'class_type' => $obj->class_type,
			];

			$table_pic = new Table_Logic_Pic();
			$table_font = new Table_Logic_Font();
			$table_res = new Table_Logic_Resource();
			if ($obj->class_type == 1) {
				// 模板 1, area1, area2
				$pic = $table_pic->where('id', '=', $obj->area1)->first();
				$res = $table_res->where('id', '=', $pic->pic)->first();
				$reply['area1'] = [
					'name' => $pic->name,
					'img_dir' => $res->dir,
				];

				$font = $table_font->where('id', '=', $obj->area2)->first();
				$reply['area2'] = [
					'font' => $font->font,
					'mp3' => $font->mp3_desc,
				];

				echo json_encode($reply);exit;

			} elseif ($obj->class_type == 2) {
				// 模板 2, area1, area2, area3, area4
				$font = $table_font->where('id', '=', $obj->area1)->first();
				$reply['area1'] = [
					'font' => $font->font,
					'mp3' => $font->mp3_desc,
				];

				$pic = $table_pic->where('id', '=', $obj->area2)->first();
				$res = $table_res->where('id', '=', $pic->pic)->first();
				$reply['area2'] = [
					'name' => $pic->name,
					'img_dir' => $res->dir,
				];

				$font3 = $table_font->where('id', '=', $obj->area3)->first();
				$reply['area3'] = [
					'font' => $font3->font,
					'mp3' => $font3->mp3_desc,
				];

				$font4 = $table_font->where('id', '=', $obj->area4)->first();
				$reply['area4'] = [
					'font' => $font4->font,
					'mp3' => $font4->mp3_desc,
				];

				echo json_encode($reply);exit;
			}
		}

		echo json_encode($reply);exit;
	}

	public function enableAction() {
		$id = $this->request->getParam('id');
		$data = ['is_enabled' => 1];
		Table_Logic_Curriculum::where('id', $id)->update($data);
		$this->ajax_success('启动成功！');
	}

	public function unenableAction() {
		$id = $this->request->getParam('id');
		$data = ['is_enabled' => 0];
		Table_Logic_Curriculum::where('id', $id)->update($data);
		$this->ajax_success('禁用成功！');
	}

	public function deleteAction() {
		$id = $this->request->getQuery('step_id');
		$data = ['is_enabled' => 0];
		Table_Logic_Curriculumstep::where('id', $id)->update($data);
		$this->ajax_success('删除成功！');
	}
}
