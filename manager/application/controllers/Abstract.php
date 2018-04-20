<?php

/**
 * Class AbstractController
 */
abstract class AbstractController extends Yaf_Controller_Abstract {

	protected function allow_user_agent() {
		$uarowser = $_SERVER['HTTP_USER_AGENT'];
		if (strstr($uarowser, 'MSIE 6') || strstr($uarowser, 'MSIE 7') || strstr($uarowser, 'MSIE 8') || strstr($uarowser, 'MSIE 9')) {
			return false;
		}

		return true;

		//echo $_SERVER["HTTP_USER_AGENT"];
		// return true;
		// Mozilla/5.0 (Macintosh; Intel Mac OS X 10.13; rv:58.0) Gecko/20100101 Firefox/58.0
		//if (strpos($_SERVER["HTTP_USER_AGENT"], "Firefox")) {
		//	return true;
		//} else if (strpos($_SERVER["HTTP_USER_AGENT"], "Chrome")) {
		//	return true;
		//} else if (strpos($_SERVER["HTTP_USER_AGENT"], "Safari")) {
		//	return true;
		//}
		//return false;
	}

	/**
	 * 登录、权限判断、初始化
	 */
	public function init() {
		if (!$this->allow_user_agent()) {
			// echo $_SERVER["HTTP_USER_AGENT"];
			echo '暂不支持ie9及以下版本ie浏览器，请使用火狐浏览器打开<a href="http://www.firefox.com.cn/">点击去下载</a>';exit();
		} else {
			// var_dump("expression");exit;
			$this->request = Yaf_Dispatcher::getInstance()->getRequest();
			$this->smarty = View::getInstance();
			$this->_controller = strtolower($this->request->getControllerName());
			$this->_action = strtolower($this->request->getActionName());

			if (!$this->is_login()) {

				if (!(trim($this->_controller) == 'index' && trim($this->_action) == 'login')) {
					$this->redirect("/index/login");

				}

			} else {
				// $menu = Table_System_Menu::all()->toArray();
				$table_menu = new Table_System_Menu();
				$this->_menu = $table_menu->allMenu();

				// if (isset($_SESSION['account_id'])) {
				// $account_id = $_SESSION['account_id'];
				$table_account = new Table_System_Account();
				$this->_row_account = $table_account->where('id', $_SESSION['account_id'])->first()->toArray();
				// }

				$this->_all_role = Table_System_Role::all()->toArray();

				// $reply = $this->has_right($this->_controller, $this->_action, $this->_menu, $this->_all_role, $this->_row_account);
				$reply = $this->has_right($this->_controller, $this->_action);

				if ($reply['flg']) {
					$this->smarty->assign('system_menu', $this->parse_menu($this->_menu));
					$this->smarty->assign('current_menu', $this->current_menu($this->_menu));

					// 定义开发环境
					$debug = ($this->request->getQuery('debug') == 'yes') ? 'yes' : '';
					if (!is_null($this->request->getPost('debug')) && $this->request->getPost('debug') != '') {
						$debug = $this->request->getPost('debug');
					}
					$this->smarty->assign('debug', $debug);
					$app_env = (isset($_SERVER['APP_ENV'])) ? $_SERVER['APP_ENV'] : '';
					$this->smarty->assign('APP_ENV', $app_env);

					$nickname = isset($_SESSION['nickname']) ? $_SESSION['nickname'] : 'no name';
					$this->smarty->assign('nickname', $nickname);
					$right = isset($_SESSION['right']) ? $_SESSION['right'] : [];

					$this->smarty->assign('menu_right', $this->access_right($this->_menu));
				} else {
					// return $this->ajax_error('没有权限访问');
					// if ($this->request->isXmlHttpRequest()) {
					// 	return $this->ajax_error('没有权限访问');
					// } else {
					// 	echo "没有访问权限";
					// }

					if (in_array($this->_action, ['enable', 'unenable'])) {
						return $this->ajax_error($reply["msg"]);
					} else {
						echo $reply["msg"];
					}

					exit;
				}
			}
		}

	}

	protected function has_right($controller, $action) {
		//白名单配置列表, ajax
		$wite_name_list = [
			'school' => ['city', 'area'],
			'student' => ['classes', 'qrcode'],
			'teacher' => ['qrcode'],
			'curriculum' => ['musicinfo', 'pptinfo'],
			'course' => ['teachers'],
		];

		if (isset($wite_name_list[$controller])) {
			if (in_array($action, $wite_name_list[$controller])) {
				$reply = [
					'flg' => true,
					'msg' => '',
					'menu_id' => '',
				];
				return $reply;
			}
		}

		$menu = $this->_menu;
		$role = $this->_all_role;
		$account = $this->_row_account;

		$reply = [
			'flg' => false,
			'msg' => '',
			'menu_id' => 0,
		];

		foreach ($menu as $m) {
			# code...
			if ($m['controller'] == $controller && $m['action'] == $action) {
				$reply = [
					'flg' => true,
					'msg' => '',
					'menu_id' => $m['id'],
				];
				break;
			}
		}

		if (!$reply['flg']) {
			if ($controller == 'index') {
				$reply = [
					'flg' => true,
					'msg' => '',
					'menu_id' => '',
				];
			} else {
				$reply['msg'] = "{$controller}/{$action}未添加";
			}
		} else {
			// p($account['role_id']);
			$the_roles = explode(',', $account['role_id']);
			$the_right_menu = [];
			foreach ($role as $r) {
				if (in_array($r['id'], $the_roles)) {
					// p($r);
					if (trim($r['menu_ids']) != '') {
						$menu_ids = explode(',', $r['menu_ids']);
						foreach ($menu_ids as $mid) {
							$the_right_menu[$mid] = $mid;
						}
					}
				}
			}
			// p($reply['menu_id']);
			// p($the_right_menu);
			if (!in_array($reply['menu_id'], $the_right_menu)) {
				$reply = [
					'flg' => false,
					'msg' => '没有权限',
					'menu_id' => $reply['menu_id'],
				];
			}
		}
		return $reply;
	}

	protected function access_right($all_menu) {
		// if (isset($_SESSION['account_id'])) {
		// 	$account_id = $_SESSION['account_id'];

		// 	$table = new Table_System_Account();
		// 	$row = $table->where('id', $account_id)->first()->toArray();

		// 	return $this->right($row, $all_menu);
		// }

		if (isset($this->_row_account)) {
			return $this->right($this->_row_account, $all_menu);
		}

		return [];
	}

	protected function right($account, $all_menu) {
		$roles = explode(',', trim($account['role_id']));
		// $all_role = Table_System_Role::all()->toArray();

		$menu = [];
		foreach ($this->_all_role as $key => $value) {
			if (in_array($value['id'], $roles)) {
				if (trim($value['menu_ids']) != '') {
					$ids = explode(',', $value['menu_ids']);
					foreach ($ids as $id) {
						$menu[$id] = $id;
					}
				}
			}
		}

		// $all_menu = Table_System_Menu::all()->toArray();
		foreach ($all_menu as $key => $value) {
			if (in_array($value['id'], $menu)) {
				$menu[$value['parent_id']] = $value['parent_id'];
			}
		}

		return $menu;
	}

	// 检查是否登录
	protected function is_login() {
		// 获取当前会话id
		$sid = session_id();

		if (isset($_SESSION["username"]) && isset($_SESSION['passwd'])) {
			return true;
		}
		return false;
	}

	protected function current_menu($menu) {
		$reply = [
			'id' => 0,
			'parent_id' => 0,
			'menu_name' => '控制台',
			'parent_menu_name' => '',
		];

		foreach ($menu as $m) {
			$ctrl = strtolower($m['controller']);
			$action = strtolower($m['action']);

			if ($ctrl == strtolower($this->_controller) && strtolower($action == $this->_action)) {
				$reply = [
					'id' => $m['id'],
					'parent_id' => $m['parent_id'],
					'menu_name' => $m['menu_name'],
					'parent_menu_name' => '',
				];
			}
		}

		if ($reply['parent_id'] > 0) {
			foreach ($menu as $v) {
				if ($v['id'] == $reply['parent_id']) {
					$reply['parent_menu_name'] = $v['menu_name'];
				}
			}
		}

		return $reply;
	}

	protected function parse_menu($menu) {
		$list = [];
		foreach ($menu as $m) {
			$m['child'] = [];
			if ($m['parent_id'] == 0) {
				foreach ($menu as $mm) {
					if ($m['id'] == $mm['parent_id']) {
						$m['child'][] = $mm;
					}
				}
				$list[] = $m;
			}
		}
		return $list;
	}

	protected function ajax_error($msg = '', $code = 500) {
		$reply = [
			'code' => $code,
			'msg' => $msg,
		];

		die(json_encode($reply));
	}

	protected function ajax_success($msg = '') {
		$reply = [
			'code' => '200',
			'msg' => $msg,
		];

		die(json_encode($reply));
	}

	// 返回所在机构 id
	protected function get_school_id() {
		return isset($_SESSION['school_id']) ? $_SESSION['school_id'] : 0;
	}

}
