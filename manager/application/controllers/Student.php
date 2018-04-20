<?php

use Illuminate\Database\Capsule\Manager as DB;

class StudentController extends AbstractController {

	public function listAction() {
		$params = array_map("trim", [
			'name' => $this->request->getQuery('name'),
			'phone' => $this->request->getQuery('phone'),

			'page' => (!is_null($this->request->getQuery('page'))) ? $this->request->getQuery('page') : 1,
			'page_size' => (!is_null($this->request->getQuery('page_size'))) ? $this->request->getQuery('page_size') : 10,
		]);

		$skip = ($params['page'] - 1) * $params['page_size'];

		// $select = 'id, name, phone, email, school_id, course_type, gender, note, is_enabled, created_at, updated_at';
		$select = 't_student.*, b.name as school_name, c.name as class_name';

		$table_user = Table_Logic_Student::selectRaw($select);
		if (trim($params['name']) != '') {
			$name = urldecode($params['name']);
			$table_user->where('t_student.name', 'like', "%{$name}%");
		}

		if ($params['phone'] != '') {
			// $name = urldecode($params['name']);
			$table_user->where('t_student.phone', 'like', "%{$params['phone']}%");
		}

		// 所在机构
		$school_id = $this->get_school_id();
		$this->smarty->assign('school_id', $school_id);
		if ($school_id > 0) {
			$table_user->where('t_student.school_id', '=', $school_id);
		}

		$count = $table_user->count();
		$users = $table_user
			->leftJoin('t_school_organization as b', 'b.id', '=', 't_student.school_id')
			->leftJoin('t_class as c', 'c.id', '=', 't_student.class_id')
			->skip($skip)
			->limit($params['page_size'])
			->orderBy('id', 'desc')
			->get();

		$totalPage = ceil($count / $params['page_size']);

		$data = [
			//'js' => 'file_list',
			'js' => 'student_list',
			'rand' => time(),
			'users' => $users->toArray(), // 当前页记录
			'count' => $count, // 记录条数
			'page' => $params['page'], // 当前页
			'totalPage' => $totalPage, // 总页数
			'params' => $params,
			'has_add_right' => $this->has_right('student', 'add'),
			'has_enable_right' => $this->has_right('student', 'enable'),
			'has_unenable_right' => $this->has_right('student', 'unenable'),
		];

		// Table_Logic_Coursetype::$Type;
		$this->smarty->assign('course_type', Table_Logic_Coursetype::$Type);
		$this->smarty->getSmarty()->registerPlugin("function", "course_type", "course_type");
		$this->smarty->getSmarty()->registerPlugin("function", "gender", "gender");
		$this->smarty->getSmarty()->registerPlugin("function", "qrcode", "qrcode");

		$this->smarty->display('student/list.tpl', $data);
	}

	public function addAction() {
		if ($this->request->isPost()) {

			$data = [
				'name' => $this->request->getPost('name'),
				'phone' => $this->request->getPost('phone'),
				'email' => $this->request->getPost('email'),
				'school_id' => $this->request->getPost('school_id'),
				'course_type' => $this->request->getPost('course_type'),
				'gender' => $this->request->getPost('gender'),
				'is_enabled' => $this->request->getPost('is_enabled'),
				'note' => $this->request->getPost('note'),
				'class_id' => $this->request->getPost('class_id'),
				// 'account_id' => 0,
			];

			if ($data['name'] == '') {
				return $this->ajax_error('名称不能为空');
			}
			if ($data['school_id'] == 0) {
				return $this->ajax_error('机构不能为空');
			}
			if ($data['class_id'] == 0) {
				return $this->ajax_error('所在班级不能为空');
			}

			if ($data['phone'] == '') {
				return $this->ajax_error('手机不能为空');
			} else if (!isMobile($data['phone'])) {
				return $this->ajax_error('手机不正确!');
			}

			if ($data['email'] == '') {
				return $this->ajax_error('Email不能为空');
			} else if (!isEmail($data['email'])) {
				return $this->ajax_error('Email不正确!');
			}

			if (is_array($data['course_type']) && !empty($data['course_type'])) {
				$data['course_type'] = implode(',', $data['course_type']);
			} else {
				return $this->ajax_error('课程类型不能为空！');
			}

			if ($data['note'] == '') {
				// return $this->ajax_error('备注不能为空');
			}

			//获取角色 id
			$table_role = new Table_System_Role();
			$role_id = $table_role->getRoleIdByRoleName('学生');
			if ($role_id == '') {
				return $this->ajax_error('请通知管理员设置学生角色!');
			}

			$time = time();
			$status = ($this->request->getPost('is_enabled') == 1) ? 1 : 2;
			$data_account = [
				// 'account_name' => $this->request->getPost('account_name'),
				'account_name' => $data['phone'],
				'passwd' => $this->request->getPost('passwd'),
				'role_id' => $role_id,
				'email' => $data['email'],
				'phone' => $data['phone'],
				'status' => $status,
				'note' => $data['note'],
				// 'created_at' => $time,
				// 'updated_at' => $time,
				'nickname' => $data['name'],
				'school_id' => $data['school_id'],
			];

			// if ($data_account['account_name'] == '') {
			// 	return $this->ajax_error('登录账号不能为空');
			// }

			$id = $this->request->getPost('id');

			$r = Upload_File::getInstance()->upload("img", "upload");
			if ($r['flg']) {
				$tailer = $r['tailer'];
				$limit = ['png', 'jpeg', 'jpg'];
				if (!in_array(strtolower($tailer), $limit)) {
					return $this->ajax_error('请选择正确格式上传，仅支持:png, jpg');
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

				if (trim($data_account['passwd']) == '') {
					return $this->ajax_error('登录密码不能为空');
				} else {
					$data_account['passwd'] = md5(trim($data_account['passwd']));
				}

				// 检查 account_name 是否重复添加
				$table_account = new Table_System_Account();
				if ($table_account->isAccountDouble($data['phone'])) {
					return $this->ajax_error('手机号不能重复添加！');
				}

				$data['updated_at'] = $data['created_at'] = $time;
				$data_account['updated_at'] = $data_account['created_at'] = $time;

				// $lastId = User::create($loginuserdata)->id;
				$data['account_id'] = DB::table('system_account')->insertGetId($data_account);

				// DB::table('t_student')->insert([$data]);
				$id = DB::table('t_student')->insertGetId($data);
				$this->create_qrcode($id);
				return $this->ajax_success('添加成功！');
			} else {
				if (trim($data_account['passwd']) != '') {
					$data_account['passwd'] = md5(trim($data_account['passwd']));
				} else {
					unset($data_account['passwd']);
				}

				$data['updated_at'] = $time;
				$data_account['updated_at'] = $time;

				Table_Logic_Student::where('id', $id)->update($data);

				$account = DB::table('t_student')->where('id', $id)->first();
				Table_System_Account::where('id', $account['account_id'])->update($data_account);

				$this->create_qrcode($id);

				return $this->ajax_success('更新成功！');
			}
		}

		//初始化 modal
		if (!is_null($this->request->getParam('id'))) {
			$id = $this->request->getParam('id');
			$role = DB::table('t_student')->where('id', $id)->first();
			$role['course_type'] = explode(',', $role['course_type']);

			// $account_student = DB::table('system_account')->where('id', $role['account_id'])->first();
			// $this->smarty->assign('account_student', $account_student);

			$this->smarty->assign('role', $role);
		}

		//所在学校
		// $school = Table_Logic_School::all()->toArray();
		// $this->smarty->assign('school', $school);
		$table_school = new Table_Logic_School();
		$school = $table_school->where('is_enabled', '=', 1)->get()->toArray();
		$this->smarty->assign('school', $school);

		// 所在学校
		$school_id = $this->get_school_id();
		$this->smarty->assign('school_id', $school_id);

		//所在班级
		if ($school_id > 0) {
			$table_class = new Table_Logic_Classes();
			$classes = $table_class->where('school_id', '=', $school_id)->get()->toArray();
			$this->smarty->assign('classes', $classes);
		} else {
			$classes = Table_Logic_Classes::all()->toArray();
			$this->smarty->assign('classes', $classes);
		}

		// 课程类型
		$this->smarty->assign('course_type', Table_Logic_Coursetype::$Type);

		$this->smarty->display('student/add.tpl');
	}

	// public function delAction(){
	// 	$id = $this->request->getParam('id');

	// 	$this->ajax_success('目前未提供删除功能'.$id);
	// }

	public function enableAction() {
		$id = $this->request->getParam('id');

		$table_student = new Table_Logic_Student();
		$student = $table_student->getRowById($id);

		$data_account = [
			'status' => 1,
		];
		Table_System_Account::where('id', $student['account_id'])->update($data_account);

		$data = ['is_enabled' => 1];
		Table_Logic_Student::where('id', $id)->update($data);
		$this->ajax_success('启动成功！');
	}

	public function unenableAction() {
		$id = $this->request->getParam('id');

		$table_student = new Table_Logic_Student();
		$student = $table_student->getRowById($id);

		$data_account = [
			'status' => 2,
		];
		Table_System_Account::where('id', $student['account_id'])->update($data_account);

		$data = ['is_enabled' => 0];
		Table_Logic_Student::where('id', $id)->update($data);
		$this->ajax_success('禁用成功！');
	}

	public function classesAction() {
		$reply = '<option selected value="0">请选择班级...</option>';
		$school_id = $this->request->getParam('school_id');
		if (!is_null($school_id)) {
			$table = new Table_Logic_Classes();
			$rows = $table->getRowBySchoolId($school_id);
			if (!empty($rows)) {
				foreach ($rows as $row) {
					$reply .= '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
				}
			}
		}
		echo $reply;exit;
	}

	// 生成二维码
	public function qrcodeAction() {
		$id = $this->request->getParam('id');
		$root_dir = rtrim($_SERVER['DOCUMENT_ROOT'], 'public');
		$qrcode_dir = $root_dir . "public/qrcode/student_{$id}.png";

		if (!file_exists($qrcode_dir)) {
			$this->create_qrcode($id);
		}

		$newName = "student_{$id}.png";

		// header("Content-Type:application/octet-stream");
		header('Content-Type:image/png');
		header("Content-Disposition: attachment; filename=$newName");

		header("Pragma: no-cache");
		header("Expires: 0");
		echo file_get_contents($qrcode_dir);
		exit();
	}

	/**
	 * 创建学生二维码
	 */
	private function create_qrcode($id) {
		$root_dir = rtrim($_SERVER['DOCUMENT_ROOT'], 'public');
		$qrcode_dir = $root_dir . "public/qrcode/student_{$id}.png";

		$t = new Table_Logic_Student();
		$student = $t->getRowById($id);

		$s = new Table_Logic_School();
		$school = $s->getRowById($student['school_id']);

		$c = new Table_Logic_Classes();
		$class = $c->getRowById($student['class_id']);

		// 二维码字符串
		// $student_link = 'http://www.baidu.com';

		$student_link = base64_encode(json_encode([
			"activeid" => $student['school_id'],
			"activename" => $school['name'],
			"username" => $student['phone'],
			"userpwd" => "",
		]));

		// logo图片地址
		// $logo = $root_dir . 'public/upload/201801/08/80e166f0a46086e9ae2aa21d4f2909eb.jpg';
		$logo = $root_dir . 'public' . $student['dir'];

		$water = [
			'top' => "机构: " . cut_str($school['name'], 6) . ", 班级: " . cut_str($class['name']),
			'bottom' => '姓名: ' . cut_str($student['name']),
		];
		$qrcode = new Code_File();
		$qrcode->create_qrcode($student_link, $qrcode_dir, $logo, $water);
	}

}
