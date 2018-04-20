<?php

use Illuminate\Database\Capsule\Manager as DB;

class IndexController extends AbstractController {

	public function indexAction() {
		$data = ['js' => 'index_index'];
		$this->smarty->display('index/index.tpl', $data);
	}

	public function loginAction() {
		if ($this->request->isPost()) {
			$redis = Redis_Client::getInstance()->get_redis();

			$data = array_map("trim", [
				'username' => $this->request->getPost('username'),
				'password' => $this->request->getPost('password'),
			]);

			$user_lock_key = "userlock@" . $data['username'];
			if ($redis->exists($user_lock_key) && $redis->get($user_lock_key) >= 5) {
				$redis->expire($user_lock_key, 60);
				return $this->ajax_error('请一分钟后再登录！', 501);
			} else {
				// check here
				$account = DB::table('system_account')
					->where('account_name', $data['username'])
					->where('passwd', md5(trim($data['password'])))
					->first();

				if (!is_null($account)) {
					$_SESSION["username"] = $data['username'];
					$_SESSION['passwd'] = md5($data['password']);
					$_SESSION['nickname'] = $account['nickname'];
					$_SESSION['account_id'] = $account['id'];
					$_SESSION['school_id'] = $account['school_id'];

					$redis->del($user_lock_key);
					return $this->ajax_success('登录成功！');
				} else {
					if ($redis->exists($user_lock_key)) {
						$redis->incr($user_lock_key);
					} else {
						$redis->set($user_lock_key, 1);
						$redis->expire($user_lock_key, 60);
					}
				}

				$t = 5;
				if ($redis->exists($user_lock_key)) {
					$t = $t - $redis->get($user_lock_key);
				}
				if ($t == 0) {
					// return $this->ajax_error('登录失败！请一分钟后再试！');
					return $this->ajax_error('请一分钟后再登录！', 501);
				}
				return $this->ajax_error('登录失败！还可以再试' . $t . '次');
			}

		}

		$this->smarty->display('index/login.tpl');
	}

	public function logoutAction() {
		unset($_SESSION['username']);
		unset($_SESSION['passwd']);
		unset($_SESSION['nickname']);
		unset($_SESSION['account_id']);
		unset($_SESSION['school_id']);

		$this->redirect("/index/login");
	}

}
