<?php

use Illuminate\Database\Capsule\Manager as DB;

class ClassesController extends AbstractController {

	public function listAction() {
		$params = [
			'name' => $this->request->getQuery('name'),
			'page' => (!is_null($this->request->getQuery('page'))) ? $this->request->getQuery('page') : 1,
			'page_size' => (!is_null($this->request->getQuery('page_size'))) ? $this->request->getQuery('page_size') : 10,
		];

		$skip = ($params['page'] - 1) * $params['page_size'];

		$select = 't_class.*, b.name as school_name';
		$table_user = Table_Logic_Classes::selectRaw($select);
		if (trim($params['name']) != '') {
			$name = urldecode($params['name']);
			$table_user->where('t_class.name', 'like', "%{$name}%");
		}

		// 所在机构
		$school_id = $this->get_school_id();
		$this->smarty->assign('school_id', $school_id);
		if ($school_id > 0) {
			$table_user->where('t_class.school_id', '=', $school_id);
		}

		$count = $table_user->count();
		$users = $table_user
			->leftJoin('t_school_organization as b', 'b.id', '=', 't_class.school_id')
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
			'has_add_right' => $this->has_right('classes', 'add'),
			'has_enable_right' => $this->has_right('classes', 'enable'),
			'has_unenable_right' => $this->has_right('classes', 'unenable'),
		];

		$this->smarty->display('classes/list.tpl', $data);
	}

	public function addAction() {
		if ($this->request->isPost()) {

			$data = array_map("trim", [
				'name' => $this->request->getPost('name'),
				'desc' => $this->request->getPost('desc'),
				'school_id' => $this->request->getPost('school_id'),
			]);

			if ($data['name'] == '') {
				return $this->ajax_error('班级名称不能为空');
			} elseif (strlen($data['name']) > 200) {
				return $this->ajax_error('班级名称太长');
			}

			if ($data['school_id'] == 0) {
				return $this->ajax_error('请选择机构');
			}
			$id = $this->request->getPost('id');

			$r = Upload_File::getInstance()->upload("img", "upload");
			if ($r['flg']) {
				if (!in_array($r['tailer'], ['png', 'jpg', 'jpeg'])) {
					return $this->ajax_error("班级logo格式不正确");
				}

				$data['dir'] = isset($r['dir']) ? $r['dir'] : '';
				$data['url'] = isset($r['url']) ? $r['url'] : '';
				$data['md5'] = isset($r['md5']) ? $r['md5'] : '';
				$data['width'] = isset($r['width']) ? $r['width'] : '';
				$data['height'] = isset($r['height']) ? $r['height'] : '';
			}

			if ($id == '') {
				if (!$r['flg']) {
					return $this->ajax_error($r['msg']);
				}

				$data['updated_at'] = $data['created_at'] = time();
				DB::table('t_class')->insert([$data]);
				return $this->ajax_success('添加成功！');
			} else {
				$data['updated_at'] = time();
				Table_Logic_Classes::where('id', $id)->update($data);
				return $this->ajax_success('更新成功！');
			}
		}

		//初始化 modal
		if (!is_null($this->request->getParam('id'))) {
			$id = $this->request->getParam('id');
			$role = DB::table('t_class')->where('id', $id)->first();
			// $role['menu_ids'] = explode(',', $role['menu_ids']);

			$this->smarty->assign('role', $role);
		}

		//所在学校
		// $school = Table_Logic_School::all()->toArray();
		// $this->smarty->assign('school', $school);
		$table_school = new Table_Logic_School();
		$school = $table_school->where('is_enabled', '=', 1)->get()->toArray();
		$this->smarty->assign('school', $school);

		// var_dump($this->get_school_id());
		$this->smarty->assign('school_id', $this->get_school_id());

		$this->smarty->display('classes/add.tpl');
	}

	public function delFileAction() {
		$id = $this->request->getParam('id');

		$this->ajax_success('目前未提供删除功能' . $id);
	}

}
