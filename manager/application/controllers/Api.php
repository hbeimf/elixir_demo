<?php

use Illuminate\Database\Capsule\Manager as DB;

class ApiController extends ApiBaseController {
	// public function addcategoryAction() {
	// 	$id = $this->request->getParam('id');
	// 	$table = new Table_Logic_Code();
	// 	$table->update_ten($id);
	// 	// $row = $table->where('id', '=', $id)->first()->toArray();
	// 	// $data = ['category' => $row['category'] + 1];

	// 	// Table_Logic_Code::where('id', $id)->update($data);

	// 	$this->ajax_success('更新成功');
	// }

	// http://manager.demo.com/api/initdata?token=57f20f883e&id=2&type=all
	public function initdataAction() {
		$id = $this->request->getQuery('id');
		$type = $this->request->getQuery('type');

		$table = new Table_Logic_Code();
		if ($type == 'all') {
			$table->update_all($id);
		} else {
			$table->update_ten($id);
		}

		echo "ok";
	}

	// 生成二维码demo
	//http://htgl.innoplay.cn/api/code/?school_name=测试机构&contract_num=10000&mac=00:01:6C:06:A6:29&token=57f20f883e
	public function codeAction() {
		$code = new Code_File();

		$code->scerweima('https://www.baidu.com');
		$code->scerweima1('https://www.baidu.com');
	}

	// http://htgl.innoplay.cn/font/list
	// http://htgl.innoplay.cn/api/mp3/?school_name=测试机构&contract_num=10000&mac=00:01:6C:06:A6:29&token=57f20f883e
	public function mp3Action() {

		$dir = "/web/m.demo.com/public/upload/201803/06/e5c79ea4e8e77ce7463a7a5be652f54c.mp3";
		$mp3 = new Mp3_File($dir);

		// 调用方法：
		// $mp3 = new MP3File($filename);
		$a = $mp3->getDurationEstimate();
		$b = $mp3->getDuration();
		$duration = $mp3::formatTime($b);

		var_dump($duration);exit;
		// 返回的是一个包含时分秒的数组
	}

	/**
	 *  1>激活接口 *
	 * http://m1.demo.com/api/activate/?school_name=测试机构&contract_num=10000&mac=00:01:6C:06:A6:29&token=57f20f883e
	 * school_name: 机构名称
	 * contract_num: 合同编号
	 * mac: 设备mac
	 * 设备首先得激活才能使用
	 */
	public function activateAction() {
		$params = array_map("trim", [
			'school_name' => $this->request->getQuery('school_name'),
			'contract_num' => $this->request->getQuery('contract_num'),
			'mac' => $this->request->getQuery('mac'),
		]);

		$reply = [
			'flg' => false,
			'msg' => '',
		];

		if (is_null($params['school_name']) || $params['school_name'] == '') {
			$reply['msg'] = '机构名称有误';
			echo json_encode($reply);exit;
		}

		if (is_null($params['contract_num']) || $params['contract_num'] == '') {
			$reply['msg'] = '合同编号有误';
			echo json_encode($reply);exit;
		}

		if (is_null($params['mac']) || $params['mac'] == '') {
			$reply['msg'] = '物理地址有误';
			echo json_encode($reply);exit;
		}

		$row = Table_Logic_School::selectRaw('id')->where('id', '=', $params['contract_num'])->where('name', '=', $params['school_name'])->first();
		if (!is_null($row)) {
			// add mac
			$mac = [
				'mac' => $params['mac'],
				'school_id' => $row->id,
			];
			$table_mac = new Table_Logic_Mac();
			$row_mac = $table_mac->where('mac', '=', $params['mac'])->first();
			if (is_null($row_mac)) {
				$mac['updated_at'] = $mac['created_at'] = time();
				DB::table('t_mac')->insert([$mac]);
			} else {
				$mac['updated_at'] = time();
				$table_mac->where('mac', '=', $params['mac'])->update($mac);
			}

			$reply['flg'] = true;
			$reply['msg'] = '激活成功';
			$reply['school_id'] = $row->id;
			echo json_encode($reply);exit;
		}

		$reply['msg'] = '机构名称合同编号有误';
		echo json_encode($reply);exit;
	}

	/**
	 * 2>登录接口 *
	 * http://m1.demo.com/api/login/?school_id=10000&mac=00:01:6C:06:A6:29&token=57f20f883e&username=15923565897&password=123456
	 * school_id: 机构id
	 * mac: 设备mac
	 * username: 用户名
	 * password: 口令
	 * token:
	 * 设备登录后连接代理服，代理服进程身份验证
	 */
	public function loginAction() {
		$params = array_map("trim", [
			'school_id' => $this->request->getQuery('school_id'),
			'mac' => $this->request->getQuery('mac'),
			'username' => $this->request->getQuery('username'),
			'password' => $this->request->getQuery('password'),
		]);

		$reply = [
			'flg' => false,
			'msg' => '',
		];

		if (is_null($params['school_id']) || $params['school_id'] == '') {
			$reply['msg'] = '机构编号有误';
			echo json_encode($reply);exit;
		}

		if (is_null($params['mac']) || $params['mac'] == '') {
			$reply['msg'] = '物理地址有误';
			echo json_encode($reply);exit;
		}

		if (!$this->has_activate($params['school_id'], $params['mac'])) {
			$reply['msg'] = '设备未激活';
			echo json_encode($reply);exit;
		}

		if (is_null($params['username']) || $params['username'] == '') {
			$reply['msg'] = '账号有误';
			echo json_encode($reply);exit;
		}

		if (is_null($params['password']) || $params['password'] == '') {
			$reply['msg'] = '口令有误';
			echo json_encode($reply);exit;
		}

		$account = Table_System_Account::selectRaw('id')
			->where('account_name', '=', $params['username'])
			->where('passwd', '=', md5($params['password']))
			->first();

		if (is_null($account)) {
			$reply['msg'] = '账号口令有误';
			echo json_encode($reply);exit;
		} else {
			$teacher = Table_Logic_Teacher::selectRaw('name, dir')->where('account_id', '=', $account->id)->first();
			if (!is_null($teacher)) {
				$proxy = $this->get_proxy($params['school_id']);

				$reply['flg'] = true;
				$reply['uid'] = $account->id;
				$reply['name'] = $teacher->name;
				$reply['pic_url'] = $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['SERVER_NAME'] . $teacher->dir;
				$reply['token'] = substr(md5(microtime()), 2, 10);
				$reply['ip'] = $proxy['ip'];
				$reply['port'] = $proxy['port'];

				$redis = Redis_Client::getInstance()->get_redis();
				$redis->hset('userinfo@' . $reply['uid'], 'token', $reply['token']);
				echo json_encode($reply);exit;
			} else {
				$student = Table_Logic_Student::selectRaw('name, dir')->where('account_id', '=', $account->id)->first();
				if (!is_null($student)) {
					$proxy = $this->get_proxy($params['school_id']);

					$reply['flg'] = true;
					$reply['uid'] = $account->id;
					$reply['name'] = $student->name;
					$reply['pic_url'] = $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['SERVER_NAME'] . $student->dir;
					$reply['token'] = substr(md5(microtime()), 2, 10);
					$reply['ip'] = $proxy['ip'];
					$reply['port'] = $proxy['port'];

					$redis = Redis_Client::getInstance()->get_redis();
					$redis->hset('userinfo@' . $reply['uid'], 'token', $reply['token']);
					echo json_encode($reply);exit;

				} else {
					$reply['msg'] = '账号口令有误!';
					echo json_encode($reply);exit;
				}
			}
		}
	}

	/**
	 * 2.1>修改密码
	 * http://m1.demo.com/api/modifyPasswd/?school_id=10000&mac=00:01:6C:06:A6:29&token=57f20f883e&username=15923565897&oldpassword=123456&newpassword=123456
	 * school_id: 机构id
	 * mac: 设备mac
	 * username: 用户名
	 * oldpassword: 旧口令
	 * newpassword : 新口令
	 * token:
	 * 设备登录后连接代理服，代理服进程身份验证
	 */
	public function modifyPasswdAction() {
		$params = array_map("trim", [
			'school_id' => $this->request->getQuery('school_id'),
			'mac' => $this->request->getQuery('mac'),
			'username' => $this->request->getQuery('username'),
			'oldpassword' => $this->request->getQuery('oldpassword'),
			'newpassword' => $this->request->getQuery('newpassword'),

		]);

		$reply = [
			'flg' => false,
			'msg' => '',
		];

		if (is_null($params['school_id']) || $params['school_id'] == '') {
			$reply['msg'] = '机构编号有误';
			echo json_encode($reply);exit;
		}

		if (is_null($params['mac']) || $params['mac'] == '') {
			$reply['msg'] = '物理地址有误';
			echo json_encode($reply);exit;
		}

		if (!$this->has_activate($params['school_id'], $params['mac'])) {
			$reply['msg'] = '设备未激活';
			echo json_encode($reply);exit;
		}

		if (is_null($params['username']) || $params['username'] == '') {
			$reply['msg'] = '账号有误';
			echo json_encode($reply);exit;
		}

		if (is_null($params['oldpassword']) || $params['oldpassword'] == '') {
			$reply['msg'] = '旧口令有误';
			echo json_encode($reply);exit;
		}

		if (is_null($params['newpassword']) || $params['newpassword'] == '') {
			$reply['msg'] = '新口令有误';
			echo json_encode($reply);exit;
		}

		$account = Table_System_Account::selectRaw('id')
			->where('account_name', '=', $params['username'])
			->where('passwd', '=', md5($params['oldpassword']))
			->first();

		if (is_null($account)) {
			$reply['msg'] = '账号口令有误';
			echo json_encode($reply);exit;
		} else {
			$data = [
				'passwd' => md5($params['newpassword']),
				'updated_at' => time(),
			];
			Table_System_Account::where('id', $account->id)->update($data);

			$reply['flg'] = true;
			$reply['msg'] = '修改成功';
			echo json_encode($reply);exit;
		}
	}

	/**
	 * 3> 课程列表
	 * http://m1.demo.com/api/curriculumList/?school_id=10000&mac=00:01:6C:06:A6:29&token=57f20f883e
	 * school_id: 机构id
	 * mac: 设备mac
	 * token:
	 */
	public function curriculumListAction() {
		$params = array_map("trim", [
			'school_id' => $this->request->getQuery('school_id'),
			'mac' => $this->request->getQuery('mac'),
		]);

		$reply = [
			'flg' => false,
			'msg' => '',
		];

		if (is_null($params['school_id']) || $params['school_id'] == '') {
			$reply['msg'] = '机构编号有误';
			echo json_encode($reply);exit;
		}

		if (is_null($params['mac']) || $params['mac'] == '') {
			$reply['msg'] = '物理地址有误';
			echo json_encode($reply);exit;
		}

		if (!$this->has_activate($params['school_id'], $params['mac'])) {
			$reply['msg'] = '设备未激活';
			echo json_encode($reply);exit;
		}

		$row = Table_Logic_Curriculum::selectRaw('id, name')->orderBy('id', 'desc')->get();
		if (is_object($row)) {
			$reply['flg'] = true;
			$reply['data'] = $row->toArray();
		} else {
			$reply['msg'] = '暂时未设置任何课程，请耐心等待';
		}
		echo json_encode($reply);exit;

	}

	/**
	 * 4> 课程详情
	 * http://m1.demo.com/api/curriculumInfo/?school_id=10000&mac=00:01:6C:06:A6:29&token=57f20f883e&curriculum_id=1
	 * school_id: 机构id
	 * mac: 设备mac
	 * token:
	 * curriculum_id: 课程 id
	 */
	public function curriculumInfoAction() {
		$params = array_map("trim", [
			'school_id' => $this->request->getQuery('school_id'),
			'mac' => $this->request->getQuery('mac'),
			'curriculum_id' => $this->request->getQuery('curriculum_id'),
		]);

		$reply = [
			'flg' => false,
			'msg' => '',
		];

		if (is_null($params['school_id']) || $params['school_id'] == '') {
			$reply['msg'] = '机构编号有误';
			echo json_encode($reply);exit;
		}

		if (is_null($params['mac']) || $params['mac'] == '') {
			$reply['msg'] = '物理地址有误';
			echo json_encode($reply);exit;
		}

		if (!$this->has_activate($params['school_id'], $params['mac'])) {
			$reply['msg'] = '设备未激活';
			echo json_encode($reply);exit;
		}

		$row = Table_Logic_Curriculumstep::selectRaw('id, name, res_type, ppt_id, music_id')
			->where('curriculum_id', '=', $params['curriculum_id'])->orderBy('id', 'asc')->get()->toArray();

		$step = [];
		if (count($row) > 0) {
			$table_ppt = new Table_Logic_Ppt();
			$table_music = new Table_Logic_Music();

			for ($i = 0; $i < count($row); $i++) {
				$step[$i] = [
					// 'step_id' => $i + 1,
					'id' => $row[$i]['id'],
					'name' => $row[$i]['name'],
					'type' => $row[$i]['res_type'],
				];

				if ($row[$i]['res_type'] == 1) {
					$info = $table_ppt->info($row[$i]['ppt_id']);
					if ($info['flg']) {
						$step[$i]['info'] = $info['info'];
					} else {
						$step[$i]['info'] = [];
					}
				} elseif ($row[$i]['res_type'] == 2) {
					$info = $table_music->info($row[$i]['music_id']);
					if ($info['flg']) {
						$step[$i]['info'] = $info['info'];
					} else {
						$step[$i]['info'] = [];
					}

				}
			}
		}

		$reply = [
			'flg' => true,
			'msg' => '',
			'data' => $step,
		];

		echo json_encode($reply);

	}

	/**
	 * 5> 学生列表 *
	 * http://m1.demo.com/api/studentList/?school_id=10000&mac=00:01:6C:06:A6:29&token=57f20f883e&course_type=1&gender=male&classid=6
	 * school_id: 机构id
	 * mac: 设备mac
	 * token: 57f20f883e
	 * course_type: 课程类型: [{1: 基础课}, {2: 特色课}, {3: 兴趣班}, {4: 考级班}]
	 * gender: 性别 : [{male: 男}, {female: 女}]
	 * classid: 班级id
	 */
	public function studentListAction() {
		$params = array_map("trim", [
			'school_id' => $this->request->getQuery('school_id'),
			'mac' => $this->request->getQuery('mac'),
			'course_type' => $this->request->getQuery('course_type'),
			'gender' => $this->request->getQuery('gender'),
			'classid' => $this->request->getQuery('classid'),
		]);

		$reply = [
			'flg' => false,
			'msg' => '',
		];

		if (is_null($params['school_id']) || $params['school_id'] == '') {
			$reply['msg'] = '机构编号有误';
			echo json_encode($reply);exit;
		}

		if (is_null($params['mac']) || $params['mac'] == '') {
			$reply['msg'] = '物理地址有误';
			echo json_encode($reply);exit;
		}

		if (!$this->has_activate($params['school_id'], $params['mac'])) {
			$reply['msg'] = '设备未激活';
			echo json_encode($reply);exit;
		}

		// 获取学生列表
		$select = 't_student.id, t_student.name, t_student.url, t_student.phone, t_student.email,
		t_student.class_id,
		c.name as class_name,
		c.id as class_id,
		t_student.school_id,
		b.name as school_name,
		t_student.course_type, t_student.gender';
		$obj_instance = Table_Logic_Student::selectRaw($select)
			->leftJoin('t_school_organization as b', 'b.id', '=', 't_student.school_id')
			->leftJoin('t_class as c', 'c.id', '=', 't_student.class_id')
			->where('t_student.school_id', '=', $params['school_id'])
			->orderBy('t_student.id', 'desc');
		// ->get();

		if (!is_null($params['course_type']) && is_numeric($params['course_type'])) {
			$types = [
				1 => 'base',
				2 => 'characteristic',
				3 => 'interest',
				4 => 'level_examination',
			];
			if (isset($types[$params['course_type']])) {
				$t = $types[$params['course_type']];
				$obj_instance->whereRaw("FIND_IN_SET('{$t}', t_student.course_type)");
			}
		}

		if (!is_null($params['gender']) && $params['gender'] != '') {
			$obj_instance->where('t_student.gender', '=', $params['gender']);
		}

		if (!is_null($params['classid']) && is_numeric($params['classid'])) {
			$obj_instance->where('c.id', '=', $params['classid']);
		}

		$obj = $obj_instance->get();
		if (is_object($obj) && count($obj) > 0) {
			$reply['flg'] = true;
			$reply['data'] = $obj->toArray();
		} else {
			$reply['msg'] = "条例条件学生为空";
		}
		echo json_encode($reply);exit;
	}

	/**
	 * 5.1> 班级列表 *
	 * http://m1.demo.com/api/calssList/?school_id=10000&mac=00:01:6C:06:A6:29&token=57f20f883e
	 * school_id: 机构id
	 * mac: 设备mac
	 * token: 57f20f883e
	 */
	public function calsslistAction() {
		$params = array_map("trim", [
			'school_id' => $this->request->getQuery('school_id'),
			'mac' => $this->request->getQuery('mac'),
		]);

		$reply = [
			'flg' => false,
			'msg' => '',
		];

		if (is_null($params['school_id']) || $params['school_id'] == '') {
			$reply['msg'] = '机构编号有误';
			echo json_encode($reply);exit;
		}

		if (is_null($params['mac']) || $params['mac'] == '') {
			$reply['msg'] = '物理地址有误';
			echo json_encode($reply);exit;
		}

		if (!$this->has_activate($params['school_id'], $params['mac'])) {
			$reply['msg'] = '设备未激活';
			echo json_encode($reply);exit;
		}

		$row = Table_Logic_Classes::selectRaw('id, name, school_id, url')
			->where('school_id', '=', $params['school_id'])->orderBy('id', 'asc')->get();

		if (is_object($row)) {
			$reply['flg'] = true;
			$reply['data'] = $row->toArray();

		}
		echo json_encode($reply);

	}

	/**
	 * 6> 基本信息 *
	 * http://m1.demo.com/api/accountInfo/?school_id=10000&mac=00:01:6C:06:A6:29&token=57f20f883e&uid=23
	 * school_id: 机构id
	 * mac: 设备mac
	 * token: 57f20f883e
	 */
	public function accountInfoAction() {
		$params = array_map("trim", [
			'school_id' => $this->request->getQuery('school_id'),
			'mac' => $this->request->getQuery('mac'),
			'uid' => $this->request->getQuery('uid'),
		]);

		$reply = [
			'flg' => false,
			'msg' => '',
		];

		if (is_null($params['school_id']) || $params['school_id'] == '') {
			$reply['msg'] = '机构编号有误';
			echo json_encode($reply);exit;
		}

		if (is_null($params['mac']) || $params['mac'] == '') {
			$reply['msg'] = '物理地址有误';
			echo json_encode($reply);exit;
		}

		if (is_null($params['uid']) || $params['uid'] == '') {
			$reply['msg'] = 'UID有误';
			echo json_encode($reply);exit;
		}

		if (!$this->has_activate($params['school_id'], $params['mac'])) {
			$reply['msg'] = '设备未激活';
			echo json_encode($reply);exit;
		}

		$teacher = Table_Logic_Teacher::selectRaw('t_teacher.name, t_teacher.dir, t_teacher.school_id, t_teacher.course_type, b.name as school_name')
			->leftJoin('t_school_organization as b', 'b.id', '=', 't_teacher.school_id')
			->where('t_teacher.account_id', '=', $params['uid'])->first();

		if (!is_null($teacher)) {
			$reply['flg'] = true;
			$reply['name'] = $teacher->name;
			$reply['url'] = $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['SERVER_NAME'] . $teacher->dir;
			$reply['school_id'] = $teacher->school_id;
			$reply['school_name'] = $teacher->school_name;

			$reply['course_type'] = $this->course_type($teacher->course_type);
			echo json_encode($reply);exit;
		} else {
			$student = Table_Logic_Student::selectRaw('t_student.name, t_student.dir, t_student.school_id, t_student.course_type, b.name as school_name')
				->leftJoin('t_school_organization as b', 'b.id', '=', 't_student.school_id')
				->where('t_student.account_id', '=', $params['uid'])->first();

			if (!is_null($student)) {
				$reply['flg'] = true;
				$reply['name'] = $student->name;
				$reply['url'] = $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['SERVER_NAME'] . $student->dir;
				$reply['school_id'] = $student->school_id;
				$reply['school_name'] = $student->school_name;
				$reply['course_type'] = $this->course_type($student->course_type);
				echo json_encode($reply);exit;
			} else {
				$reply['msg'] = '账号不存在!';
				echo json_encode($reply);exit;
			}
		}
	}

	// 课程类型
	private function course_type($type) {
		$r = [];
		$types = explode(',', $type);
		foreach (Table_Logic_Coursetype::$Type as $t) {
			if (in_array($t['id'], $types)) {
				$r[$t['id']] = $t['name'];
			}
		}
		return $r;
	}

	// 设备是否激活
	private function has_activate($school_id, $mac) {
		$row_mac = Table_Logic_Mac::selectRaw('id')->where('school_id', '=', $school_id)
			->where('mac', '=', $mac)->first();

		if (!is_null($row_mac)) {
			return true;
		}

		return false;
	}

	// 代理服配置
	private function get_proxy($school_id = '') {
		return [
			'ip' => '192.168.1.49',
			'port' => 8001,
		];
	}

}
