<?php

use Illuminate\Database\Capsule\Manager as DB;

class FilexmlController extends AbstractController {

	public function listAction() {
		$params = [
			'name' => $this->request->getQuery('name'),
			'page' => (!is_null($this->request->getQuery('page'))) ? $this->request->getQuery('page') : 1,
			'page_size' => (!is_null($this->request->getQuery('page_size'))) ? $this->request->getQuery('page_size') : 10,
		];

		$skip = ($params['page'] - 1) * $params['page_size'];

		$select = 'id, name, dir, url, `desc`, created_at, updated_at';
		$table_user = Table_Logic_Fileresource::selectRaw($select);
		if (trim($params['name']) != '') {
			$name = urldecode($params['name']);
			$table_user->where('name', 'like', "%{$name}%");
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

		// $list = Table_Gp_List::find(1)->toArray();

		// $this->smarty->getSmarty()->registerPlugin("function", "menu_name", "menu_name");
		$this->smarty->display('file/list.tpl', $data);

	}

	public function addFileAction() {
		if ($this->request->isPost()) {

			$data = [
				'name' => $this->request->getPost('name'),
				'desc' => $this->request->getPost('desc'),
			];

			if ($data['name'] == '') {
				return $this->ajax_error('名称不能为空');
			}

			$id = $this->request->getPost('id');
		
			$r = Upload_File::getInstance()->upload("img", "upload");
			if ($r['flg']) {
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
				DB::table('t_file_resource')->insert([$data]);
				return $this->ajax_success('添加成功！');
			} else {
				$data['updated_at'] = time();
				Table_Logic_Fileresource::where('id', $id)->update($data);
				return $this->ajax_success('更新成功！');
			}
		}

		//初始化 modal
		if (! is_null($this->request->getParam('id'))) {
			$id = $this->request->getParam('id');
			$role = DB::table('t_file_resource')->where('id', $id)->first();
			// $role['menu_ids'] = explode(',', $role['menu_ids']);

			$this->smarty->assign('role', $role);
		}

		$this->smarty->display('file/addFile.tpl');
	}

	public function delFileAction(){
		$id = $this->request->getParam('id');

		$this->ajax_success('目前未提供删除功能'.$id);
	}



	
}
