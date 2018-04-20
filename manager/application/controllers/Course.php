<?php

use Illuminate\Database\Capsule\Manager as DB;

class CourseController extends AbstractController {

	public function listAction() {
		$params = [
			'school_id' => $this->request->getQuery('school_id'),
		];
		$school_id = $this->get_school_id();
		$this->smarty->assign('school_id', $school_id);
		if ($school_id > 0) {
			$params['school_id'] = $school_id;
		}

		$data = [
			'has_add_right' => $this->has_right('course', 'add'),
			'has_enable_right' => $this->has_right('schooltype', 'enable'),
			'has_unenable_right' => $this->has_right('schooltype', 'unenable'),
		];
		if (!is_null($params['school_id']) && $params['school_id'] > 0) {
			$select = 't_course.id, t_course.school_id, t_course.course_type, t_course.begin_at, t_course.end_at, t_course.teacher_id,
				t_course.week, t_course.is_enabled, t_course.created_at, t_course.updated_at,
				t.name as teacher_name, s.name as school_name';
			$course = Table_Logic_Course::selectRaw($select)
				->leftJoin('t_teacher as t', 't.id', '=', 't_course.teacher_id')
				->leftJoin('t_school_organization as s', 's.id', '=', 't_course.school_id')
				->where('t_course.school_id', '=', $params['school_id'])
				->where('t_course.is_enabled', '=', 1)
				->orderBy('t_course.begin_at', 'asc')
				->get()->toArray();

			$cc = [];
			foreach ($course as $c) {
				if (isset($cc[$c['week']])) {
					$cc[$c['week']] = array_merge($cc[$c['week']], [$c]);
				} else {
					$cc[$c['week']] = [$c];
				}
			}

			$data = [
				'js' => 'course',
				'rand' => time(),
				// 'users' => $users->toArray(), // 当前页记录
				// 'count' => $count, // 记录条数
				// 'page' => $params['page'], // 当前页
				// 'totalPage' => $totalPage, // 总页数
				'params' => $params,
				'data' => $cc,
				'has_add_right' => $this->has_right('course', 'add'),
				'has_enable_right' => $this->has_right('schooltype', 'enable'),
				'has_unenable_right' => $this->has_right('schooltype', 'unenable'),
			];
		}

		$this->smarty->assign('course_type', Table_Logic_Coursetype::$Type);
		$this->smarty->getSmarty()->registerPlugin("function", "course_type", "course_type");

		//所在学校
		// $school = Table_Logic_School::all()->toArray();
		// $this->smarty->assign('school', $school);

		$table_school = new Table_Logic_School();
		$school = $table_school->where('is_enabled', '=', 1)->get()->toArray();
		$this->smarty->assign('school', $school);

		$this->smarty->display('course/list.tpl', $data);
	}

	public function addAction() {
		$school_id = $this->request->getParam('school_id');
		$this->smarty->assign('school_id', $school_id);

		//
		$account_school_id = $this->get_school_id();
		$this->smarty->assign('account_school_id', $account_school_id);

		if ($this->request->isPost()) {

			$data = array_map("trim", [
				'school_id' => $this->request->getPost('school_id'),
				'begin_at' => $this->request->getPost('begin_at'),
				'end_at' => $this->request->getPost('end_at'),
				'course_type' => $this->request->getPost('course_type'),
				'teacher_id' => $this->request->getPost('teacher_id'),
				'is_enabled' => $this->request->getPost('is_enabled'),
				'note' => '',
				'week' => $this->request->getPost('week'),
			]);

			if ($data['begin_at'] == '') {
				return $this->ajax_error('开课时间不能为空');
			} else {
				$arr = explode(":", $data['begin_at']);
				// $data['begin_at'] = strtotime($data['begin_at']);
				// $data['begin_at'] = mktime(时, 分, 秒, 月, 日, 年);
				$data['begin_at'] = mktime(intval($arr[0]), intval($arr[1]), 0, 0, 0, 0);

			}

			if ($data['end_at'] == '') {
				return $this->ajax_error('结束时间不能为空');
			} else {
				// $data['end_at'] = strtotime($data['end_at']);
				$arr = explode(":", $data['end_at']);
				$data['end_at'] = mktime(intval($arr[0]), intval($arr[1]), 0, 0, 0, 0);
			}

			if ($data['begin_at'] > $data['end_at']) {
				return $this->ajax_error('结束不能早于起始时间');
			}

			if ($data['teacher_id'] == '' || !is_numeric($data['teacher_id']) || $data['teacher_id'] == 0) {
				return $this->ajax_error('需要选择老师');
			}

			$id = $this->request->getPost('id');

			if ($id == '') {
				$data['updated_at'] = $data['created_at'] = time();
				// p($data);exit;
				DB::table('t_course')->insert([$data]);
				return $this->ajax_success('添加成功！');
			} else {
				$data['updated_at'] = time();
				Table_Logic_Course::where('id', $id)->update($data);
				return $this->ajax_success('更新成功！');
			}
		}

		//初始化 modal
		if (!is_null($this->request->getParam('id'))) {
			$id = $this->request->getParam('id');
			$role = DB::table('t_course')->where('id', $id)->first();
			// p($role);

			$role['course_type'] = explode(",", $role['course_type']);
			$this->smarty->assign('role', $role);
		}

		//所在学校
		$school = Table_Logic_School::all()->toArray();
		$this->smarty->assign('school', $school);
		// 课程类型
		$this->smarty->assign('course_type', Table_Logic_Coursetype::$Type);

		// 老师
		// $teacher = Table_Logic_Teacher::all()->toArray();
		$table_teacher = new Table_Logic_Teacher();
		$teacher = $table_teacher->getRowBySchoolIdEnabled($school_id);
		$this->smarty->assign('teacher', $teacher);

		$this->smarty->display('course/add.tpl');
	}

	// public function delAction(){
	// 	$id = $this->request->getParam('id');

	// 	$this->ajax_success('目前未提供删除功能'.$id);
	// }

	public function enableAction() {
		$id = $this->request->getParam('id');
		$data = ['is_enabled' => 1];
		Table_Logic_Schooltype::where('id', $id)->update($data);
		$this->ajax_success('启动成功！');
	}

	public function unenableAction() {
		$id = $this->request->getParam('id');
		$data = ['is_enabled' => 0];
		Table_Logic_Schooltype::where('id', $id)->update($data);
		$this->ajax_success('禁用成功！');
	}

	// 获取符合要求的老师
	public function teachersAction() {
		$res = [
			'teachers' => '<option selected value="0">请选老师...</option>',
		];
		$course_type = $this->request->getParam('course_type');
		$school_id = $this->request->getParam('school_id');

		if (!is_null($course_type)) {
			// $table_city = new Table_Logic_City();
			// $city = $table_city->getCityByProvinceid($province_id);
			$table_teacher = new Table_Logic_Teacher();
			$teachers = $table_teacher->getRowBySchoolIdEnabledCourseType($school_id, $course_type);

			if (!empty($teachers)) {
				foreach ($teachers as $t) {
					$res['teachers'] .= '<option value="' . $t['id'] . '">' . $t['name'] . '</option>';
				}
			}
		}
		echo json_encode($res);exit;
	}
}