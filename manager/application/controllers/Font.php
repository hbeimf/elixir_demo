<?php

use Illuminate\Database\Capsule\Manager as DB;

class FontController extends AbstractController {

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

		$select = 't_font.*, b.name';
		$table_user = Table_Logic_Font::selectRaw($select);
		if (trim($params['name']) != '') {
			$name = urldecode($params['name']);
			$table_user->where('t_font.font', 'like', "%{$name}%");
		}

		if ($params['curriculum_id'] != '') {
			$table_user->where('t_font.curriculum_id', '=', $params['curriculum_id']);
		} else {
			$params['curriculum_id'] = 0;
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
			'params' => $params,
			'has_add_right' => $this->has_right('font', 'add'),
			'has_enable_right' => $this->has_right('font', 'enable'),
			'has_unenable_right' => $this->has_right('font', 'unenable'),
		];

		// $list = Table_Gp_List::find(1)->toArray();

		$this->smarty->getSmarty()->registerPlugin("function", "sub_str", "sub_str");
		$this->smarty->display('font/list.tpl', $data);

	}

	public function addAction() {
		// 课程 id
		$curriculum_id = $this->request->getQuery('curriculum_id');
		$this->smarty->assign('curriculum_id', $curriculum_id);

		if ($this->request->isPost()) {

			$data = [
				'font' => $this->request->getPost('font'),
				'mp3_desc' => $this->request->getPost('mp3_desc'),
				'mp3_type' => $this->request->getPost('mp3_type'),
				'is_enabled' => $this->request->getPost('is_enabled'),
				'curriculum_id' => $curriculum_id,
			];

			if ($data['font'] == '') {
				// return $this->ajax_error('文字不能为空');
			}
			if ($data['mp3_desc'] == '') {
				// return $this->ajax_error('音频说明不能为空');
			}

			// 上传资源
			$table_resource = new Table_Logic_Resource();
			$r = $table_resource->upload('mp3');

			if ($r['flg']) {
				$data['mp3'] = $r['id'];
				// $tailer = $table_resource->get_tailer('mp3');
				$tailer = $r['tailer'];
				$limit = ['mp3'];
				if (!in_array(strtolower($tailer), $limit)) {
					$table_resource->clean($r);
					return $this->ajax_error('请选择正确格式的音频，仅支持:mp3-' . $tailer);
				}
			}

			$id = $this->request->getPost('id');

			if ($id == '') {
				if (!$r['flg']) {
					return $this->ajax_error($r['msg']);
				}

				$data['updated_at'] = $data['created_at'] = time();
				DB::table('t_font')->insert([$data]);
				return $this->ajax_success('添加成功！');
			} else {
				$data['updated_at'] = time();
				Table_Logic_Font::where('id', $id)->update($data);
				return $this->ajax_success('更新成功！');
			}
		}

		//初始化 modal
		if (!is_null($this->request->getParam('id'))) {
			$id = $this->request->getParam('id');
			$role = DB::table('t_font')->where('id', $id)->first();
			// $role['menu_ids'] = explode(',', $role['menu_ids']);

			$this->smarty->assign('role', $role);
		}

		$this->smarty->display('font/add.tpl');
	}

	public function delFileAction() {
		$id = $this->request->getParam('id');

		$this->ajax_success('目前未提供删除功能' . $id);
	}

	public function enableAction() {
		$id = $this->request->getParam('id');
		$data = ['is_enabled' => 1];
		Table_Logic_Font::where('id', $id)->update($data);
		$this->ajax_success('启动成功！');
	}

	public function unenableAction() {
		$id = $this->request->getParam('id');
		$data = ['is_enabled' => 0];
		Table_Logic_Font::where('id', $id)->update($data);
		$this->ajax_success('禁用成功！');
	}

}
