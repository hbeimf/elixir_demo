<?php

/**
 * Class AbstractController
 */
abstract class ApiBaseController extends Yaf_Controller_Abstract {

	/**
	 * 登录、权限判断、初始化
	 */
	public function init() {
		$this->request = Yaf_Dispatcher::getInstance()->getRequest();

		$token = $this->request->getQuery('token');
		if (is_null($token) ||  $token != $this->_token) {
			$reply = [
				'flg' => false,
				'msg' => 'token 出错 ',
			];
			echo json_encode($reply);exit;
		}
	}

	private $_token = '57f20f883e';
}
