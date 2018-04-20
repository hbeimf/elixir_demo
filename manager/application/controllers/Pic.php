<?php

use Illuminate\Database\Capsule\Manager as DB;

class PicController extends AbstractController {

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

		$select = 't_picture.*, b.dir';
		$table_user = Table_Logic_Pic::selectRaw($select);
		if (trim($params['name']) != '') {
			$name = urldecode($params['name']);
			$table_user->where('t_picture.name', 'like', "%{$name}%");
		}

		if ($params['curriculum_id'] != '') {
			$table_user->where('t_picture.curriculum_id', '=', $params['curriculum_id']);
		} else {
			$params['curriculum_id'] = 0;
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
			'js' => 'pic',
			'rand' => time(),
			'users' => $users->toArray(), // 当前页记录
			'count' => $count, // 记录条数
			'page' => $params['page'], // 当前页
			'totalPage' => $totalPage, // 总页数
			'params' => $params,
			'has_add_right' => $this->has_right('pic', 'add'),
			'has_enable_right' => $this->has_right('pic', 'enable'),
			'has_unenable_right' => $this->has_right('pic', 'unenable'),
		];

		// $list = Table_Gp_List::find(1)->toArray();

		// $this->smarty->getSmarty()->registerPlugin("function", "menu_name", "menu_name");
		$this->smarty->display('pic/list.tpl', $data);

	}

	public function addAction() {
		// 课程 id
		$curriculum_id = $this->request->getQuery('curriculum_id');
		$this->smarty->assign('curriculum_id', $curriculum_id);

		if ($this->request->isPost()) {

			$data = [
				'name' => $this->request->getPost('name'),
				'note' => $this->request->getPost('note'),
				'is_enabled' => $this->request->getPost('is_enabled'),
				'curriculum_id' => $curriculum_id,
			];

			if ($data['name'] == '') {
				return $this->ajax_error('名称不能为空');
			}

			// 上传资源
			$table_resource = new Table_Logic_Resource();
			$r = $table_resource->upload('img');

			if ($r['flg']) {
				$data['pic'] = $r['id'];

				// $tailer = $table_resource->get_tailer('img');
				$tailer = $r['tailer'];
				$limit = ['png'];
				if (!in_array(strtolower($tailer), $limit)) {
					$table_resource->clean($r);
					return $this->ajax_error('请选择正确格式的图片，仅支持:png');
				}
			}

			$id = $this->request->getPost('id');
			if ($id == '') {
				if (!$r['flg']) {
					return $this->ajax_error($r['msg']);
				}

				$data['updated_at'] = $data['created_at'] = time();
				DB::table('t_picture')->insert([$data]);
				return $this->ajax_success('添加成功！');
			} else {
				$data['updated_at'] = time();
				Table_Logic_Pic::where('id', $id)->update($data);
				return $this->ajax_success('更新成功！');
			}
		}

		//初始化 modal
		if (!is_null($this->request->getParam('id'))) {
			$id = $this->request->getParam('id');
			$role = DB::table('t_picture')->where('id', $id)->first();
			// $role['menu_ids'] = explode(',', $role['menu_ids']);

			$this->smarty->assign('role', $role);

			$pic = DB::table('t_resource')->where('id', $role['pic'])->first();
			$this->smarty->assign('pic', $pic);
		}

		$this->smarty->display('pic/add.tpl');
	}

	// public function delFileAction(){
	// 	$id = $this->request->getParam('id');

	// 	$this->ajax_success('目前未提供删除功能'.$id);
	// }

	public function enableAction() {
		$id = $this->request->getParam('id');
		$data = ['is_enabled' => 1];
		Table_Logic_Pic::where('id', $id)->update($data);
		$this->ajax_success('启动成功！');
	}

	public function unenableAction() {
		$id = $this->request->getParam('id');
		$data = ['is_enabled' => 0];
		Table_Logic_Pic::where('id', $id)->update($data);
		$this->ajax_success('禁用成功！');
	}

}
