<?php

use Illuminate\Database\Capsule\Manager as DB;

class SchoolController extends AbstractController {

	public function listAction() {
		$params = [
			'name' => $this->request->getQuery('name'),
			'page' => (!is_null($this->request->getQuery('page'))) ? $this->request->getQuery('page') : 1,
			'page_size' => (!is_null($this->request->getQuery('page_size'))) ? $this->request->getQuery('page_size') : 10,
		];

		$skip = ($params['page'] - 1) * $params['page_size'];

		$select = 't_school_organization.id, t_school_organization.name as name, t_school_organization.note, t_school_organization.is_enabled,
		t_school_organization.contact_name, t_school_organization.area, t_school_organization.city, t_school_organization.province,
		t_school_organization.address, t_school_organization.email, t_school_organization.phone,
		t_school_organization.contract_start_time, t_school_organization.contract_end_time, t_school_organization. contract_file, t_school_organization.contract_name,
		t_school_organization.created_at, t_school_organization.updated_at, b.name as type_name,
		c.province as province_name, d.city as city_name, e.area as area_name';
		$table_user = Table_Logic_School::selectRaw($select);
		if (trim($params['name']) != '') {
			$name = urldecode($params['name']);
			$table_user->where('t_school_organization.name', 'like', "%{$name}%");
		}
		$count = $table_user->count();
		$users = $table_user
			->leftJoin('t_school_type as b', 'b.id', '=', 't_school_organization.school_type_id')
			->leftJoin('t_provinces as c', 'c.provinceid', '=', 't_school_organization.province')
			->leftJoin('t_cities as d', 'd.cityid', '=', 't_school_organization.city')
			->leftJoin('t_areas as e', 'e.areaid', '=', 't_school_organization.area')

			->skip($skip)
			->limit($params['page_size'])
			->orderBy('id', 'desc')
			->get();

		$totalPage = ceil($count / $params['page_size']);

		$data = [
			'js' => 'school',
			'rand' => time(),
			'users' => $users->toArray(), // 当前页记录
			'count' => $count, // 记录条数
			'page' => $params['page'], // 当前页
			'totalPage' => $totalPage, // 总页数
			'params' => $params,
			'has_add_right' => $this->has_right('school', 'add'),
			'has_enable_right' => $this->has_right('school', 'enable'),
			'has_unenable_right' => $this->has_right('school', 'unenable'),
			'has_download_right' => $this->has_right('school', 'download'),

		];

		$this->smarty->display('school/list.tpl', $data);
	}

	public function addAction() {
		if ($this->request->isPost()) {
			$data = array_map("trim", [
				'name' => $this->request->getPost('name'),
				'school_type_id' => $this->request->getPost('school_type_id'),

				'contact_name' => $this->request->getPost('contact_name'),
				'area' => $this->request->getPost('area'),
				'city' => $this->request->getPost('city'),
				'province' => $this->request->getPost('province'),
				'address' => $this->request->getPost('address'),
				'email' => $this->request->getPost('email'),
				'phone' => $this->request->getPost('phone'),

				'contract_start_time' => $this->request->getPost('contract_start_time'),
				'contract_end_time' => $this->request->getPost('contract_end_time'),
				'note' => $this->request->getPost('note'),
				'is_enabled' => $this->request->getPost('is_enabled'),
			]);

			if ($data['name'] == '') {
				return $this->ajax_error('名称不能为空');
			}

			if ($data['contact_name'] == '') {
				return $this->ajax_error('联系人名称不能为空');
			}

			if ($data['phone'] == '') {
				return $this->ajax_error('手机号不能为空');
			} else if (!isMobile($data['phone'])) {
				return $this->ajax_error('手机不正确!');
			}

			if ($data['email'] == '') {
				return $this->ajax_error('邮箱不能为空');
			} else if (!isEmail($data['email'])) {
				return $this->ajax_error('Email不正确!');
			}

			if ($data['province'] == 0) {
				return $this->ajax_error('请选择省');
			}

			if ($data['city'] == 0) {
				$table_city = new Table_Logic_City();
				$city = $table_city->getCityByProvinceid($data['province']);
				if (!empty($city)) {
					return $this->ajax_error('请选择市');
				}
			}

			if ($data['area'] == 0) {
				if ($data['city'] > 0) {
					$table_area = new Table_Logic_Area();
					$area = $table_area->getAreaByCityid($data['city']);
					if (!empty($area)) {
						return $this->ajax_error('请选择区');
					}
				}
			}

			if ($data['address'] == '') {
				return $this->ajax_error('详细地址不能为空');
			}

			// if ($data['note'] == '') {
			// 	return $this->ajax_error('备注不能为空');
			// }

			$r = Upload_File::getInstance()->upload("contract_file", "upload");
			if ($r['flg']) {
				$data['contract_name'] = $r['old_name'];
				$data['contract_file'] = $r['dir'];
			}

			if ($data['contract_start_time'] == '') {
				return $this->ajax_error('合同开始时间不能为空');
			} else {
				$data['contract_start_time'] = strtotime($data['contract_start_time']);
			}
			if ($data['contract_end_time'] == '') {
				return $this->ajax_error('合同结束时间不能为空');
			} else {
				$data['contract_end_time'] = strtotime($data['contract_end_time']);
			}

			if ($data['contract_end_time'] < $data['contract_start_time']) {
				return $this->ajax_error('合同结束时间不能早于合同开始时间！');
			}

			$id = $this->request->getPost('id');

			if ($id == '') {
				// if (!$r['flg']) {
				// 	return $this->ajax_error($r['msg']);
				// }
				if ($data['contract_start_time'] < time()) {
					return $this->ajax_error('合同有效期己过期，不能添加已过期合同！');
				}

				$data['updated_at'] = $data['created_at'] = time();
				DB::table('t_school_organization')->insert([$data]);
				return $this->ajax_success('添加成功！');
			} else {
				$data['updated_at'] = time();
				Table_Logic_School::where('id', $id)->update($data);
				return $this->ajax_success('更新成功！');
			}
		}

		//初始化 modal
		$city_table = new Table_Logic_City();
		$area_table = new Table_Logic_Area();

		if (!is_null($this->request->getParam('id'))) {
			$id = $this->request->getParam('id');
			$role = DB::table('t_school_organization')->where('id', $id)->first();

			$this->smarty->assign('role', $role);

			// 市
			$city = $city_table->getCityByProvinceid($role['province']);
			$this->smarty->assign('city', $city);

			// 区
			$area = $area_table->getAreaByCityid($role['city']);
			$this->smarty->assign('area', $area);
		} else {
			// 市
			$city = $city_table->getAll();
			$this->smarty->assign('city', $city);

			// 区
			$area = $area_table->getAll();
			$this->smarty->assign('area', $area);
		}

		//所在学校类型
		$school_type = Table_Logic_Schooltype::all()->toArray();
		$this->smarty->assign('school_type', $school_type);

		// 省
		$province = Table_Logic_Province::all()->toArray();
		$this->smarty->assign('province', $province);

		$this->smarty->display('school/add.tpl');
	}

	public function delAction() {
		$id = $this->request->getParam('id');

		$this->ajax_success('目前未提供删除功能' . $id);
	}

	public function enableAction() {
		$id = $this->request->getParam('id');
		$data = ['is_enabled' => 1];
		Table_Logic_School::where('id', $id)->update($data);
		$this->ajax_success('启动成功！');
	}

	public function unenableAction() {
		$id = $this->request->getParam('id');
		$data = ['is_enabled' => 0];
		Table_Logic_School::where('id', $id)->update($data);
		$this->ajax_success('禁用成功！');
	}

	public function downloadAction() {
		$id = $this->request->getParam('id');
		if (is_numeric($id)) {
			$data = DB::table('t_school_organization')->where('id', $id)->first();
			if (is_array($data)) {
				//打开文件
				$file_name = $data['contract_name'];
				$dir = $p = rtrim($_SERVER['DOCUMENT_ROOT'], '/') . $data['contract_file'];
				// echo $dir;

				$file = fopen($dir, "r");
				//输入文件标签
				Header("Content-type: application/octet-stream");
				Header("Accept-Ranges: bytes");
				Header("Accept-Length: " . filesize($dir));
				Header("Content-Disposition: attachment; filename=" . $file_name);
				//输出文件内容
				//读取文件内容并直接输出到浏览器
				echo fread($file, filesize($dir));
				fclose($file);
				exit();
			}
		}
	}

	// 通用接口请求
	public function cityAction() {
		$res = [
			'city' => '<option selected value="0">请选择市...</option>',
			'area' => '<option selected value="0">请选择区...</option>',
		];
		$province_id = $this->request->getParam('provinceid');
		if (!is_null($province_id)) {
			$table_city = new Table_Logic_City();
			$city = $table_city->getCityByProvinceid($province_id);
			if (!empty($city)) {
				foreach ($city as $c) {
					$res['city'] .= '<option value="' . $c['cityid'] . '">' . $c['city'] . '</option>';
				}
			}
		}
		echo json_encode($res);exit;
	}

	public function areaAction() {
		$reply = '<option selected value="0">请选择区...</option>';
		$city_id = $this->request->getParam('cityid');
		if (!is_null($city_id)) {
			$table_area = new Table_Logic_Area();
			$area = $table_area->getAreaByCityid($city_id);
			if (!empty($area)) {
				foreach ($area as $a) {
					$reply .= '<option value="' . $a['areaid'] . '">' . $a['area'] . '</option>';
				}
			}
		}
		echo $reply;exit;
	}
}