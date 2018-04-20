<?php

use Illuminate\Database\Capsule\Manager as DB;

class MusicController extends AbstractController {

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

		$select = 't_music.*, b.name as t_name, c.dir as png_dir, d.name as xml_name, e.name as mp3_name, f.name as mp3_demo_name';
		$table_user = Table_Logic_Music::selectRaw($select);
		if (trim($params['name']) != '') {
			$name = urldecode($params['name']);
			$table_user->where('t_music.name', 'like', "%{$name}%");
		}
		if ($params['curriculum_id'] != '') {
			$table_user->where('t_music.curriculum_id', '=', $params['curriculum_id']);
		} else {
			$params['curriculum_id'] = 0;
		}

		$count = $table_user->count();
		$users = $table_user
			->leftJoin('t_tutorial as b', 'b.id', '=', 't_music.tutorial_id')
			->leftJoin('t_resource as c', 'c.id', '=', 't_music.png')
			->leftJoin('t_resource as d', 'd.id', '=', 't_music.xml')
			->leftJoin('t_resource as e', 'e.id', '=', 't_music.mp3')
			->leftJoin('t_resource as f', 'f.id', '=', 't_music.mp3_demo')

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
			'has_add_right' => $this->has_right('music', 'add'),
			'has_enable_right' => $this->has_right('music', 'enable'),
			'has_unenable_right' => $this->has_right('music', 'unenable'),
		];

		// $list = Table_Gp_List::find(1)->toArray();

		// $this->smarty->getSmarty()->registerPlugin("function", "menu_name", "menu_name");
		$this->smarty->display('music/list.tpl', $data);

	}

	public function addAction() {
		// 课程 id
		$curriculum_id = $this->request->getQuery('curriculum_id');
		$this->smarty->assign('curriculum_id', $curriculum_id);

		if ($this->request->isPost()) {

			$data = array_map("trim", [
				'name' => $this->request->getPost('name'),
				'tutorial_id' => $this->request->getPost('tutorial_id'),
				'is_enabled' => $this->request->getPost('is_enabled'),
				'curriculum_id' => $curriculum_id,
			]);

			if ($data['tutorial_id'] == 0) {
				return $this->ajax_error('请选择教材');
			}
			if ($data['name'] == '') {
				return $this->ajax_error('乐谱名称不能为空');
			}

			// 上传资源
			$table_resource = new Table_Logic_Resource();
			$r_png = $table_resource->upload('png');
			$r_xml = $table_resource->upload('xml');
			$r_mp3 = $table_resource->upload('mp3');
			$r_mp3_demo = $table_resource->upload('mp3_demo');

			if ($r_png['flg']) {
				$data['png'] = $r_png['id'];

				// $tailer = $table_resource->get_tailer('png');
				$tailer = $r_png['tailer'];
				$limit = ['png'];
				if (!in_array(strtolower($tailer), $limit)) {
					$table_resource->clean($r_png);
					return $this->ajax_error('请选择正确格式上传PNG，仅支持:png');
				}
			}
			if ($r_xml['flg']) {
				$data['xml'] = $r_xml['id'];

				// $tailer = $table_resource->get_tailer('xml');
				$tailer = $r_xml['tailer'];
				$limit = ['xml'];
				if (!in_array(strtolower($tailer), $limit)) {
					$table_resource->clean($r_xml);
					return $this->ajax_error('请选择正确格式上传XML，仅支持:xml');
				}
			}
			if ($r_mp3['flg']) {
				$data['mp3'] = $r_mp3['id'];

				// $tailer = $table_resource->get_tailer('mp3');
				$tailer = $r_mp3['tailer'];
				$limit = ['mp3'];
				if (!in_array(strtolower($tailer), $limit)) {
					$table_resource->clean($r_mp3);
					return $this->ajax_error('请选择正确格式伴奏MP3，仅支持:mp3');
				}
			}
			if ($r_mp3_demo['flg']) {
				$data['mp3_demo'] = $r_mp3_demo['id'];

				// $tailer = $table_resource->get_tailer('mp3_demo');
				$tailer = $r_mp3_demo['tailer'];
				$limit = ['mp3'];
				if (!in_array(strtolower($tailer), $limit)) {
					$table_resource->clean($r_mp3_demo);
					return $this->ajax_error('请选择正确格式示范MP3，仅支持:mp3');
				}
			}

			$id = $this->request->getPost('id');

			if ($id == '') {
				if (!$r_png['flg']) {
					return $this->ajax_error('上传png有误');
				}

				if (!$r_xml['flg']) {
					return $this->ajax_error('上传xml有误');
				}
				// if (!$r_mp3_demo['flg']) {
				// 	return $this->ajax_error('示范MP3有误');
				// }

				$data['updated_at'] = $data['created_at'] = time();
				DB::table('t_music')->insert([$data]);
				return $this->ajax_success('添加成功！');
			} else {
				$data['updated_at'] = time();
				Table_Logic_Music::where('id', $id)->update($data);
				return $this->ajax_success('更新成功！');
			}
		}

		//初始化 modal
		if (!is_null($this->request->getParam('id'))) {
			$id = $this->request->getParam('id');
			$role = DB::table('t_music')->where('id', $id)->first();
			// $role['menu_ids'] = explode(',', $role['menu_ids']);

			$this->smarty->assign('role', $role);
		}

		// 选择教材
		$table_tutorial = new Table_Logic_Tutorial();
		$tutorial = $table_tutorial->where('is_enabled', '=', 1)->get()->toArray();
		$this->smarty->assign('tutorial', $tutorial);

		$this->smarty->display('music/add.tpl');
	}

	// public function delFileAction() {
	// 	$id = $this->request->getParam('id');

	// 	$this->ajax_success('目前未提供删除功能' . $id);
	// }

	public function enableAction() {
		$id = $this->request->getParam('id');
		$data = ['is_enabled' => 1];
		Table_Logic_Music::where('id', $id)->update($data);
		$this->ajax_success('启动成功！');
	}

	public function unenableAction() {
		$id = $this->request->getParam('id');
		$data = ['is_enabled' => 0];
		Table_Logic_Music::where('id', $id)->update($data);
		$this->ajax_success('禁用成功！');
	}

}
