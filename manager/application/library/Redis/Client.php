<?php


class Redis_Client {
	private $_redis = null;
	private function __construct() {
                    $this->_redis = new redis();  

                    $config = Yaf_Application::app()->getConfig()->redis->toArray();
                    // p($config);
                    $this->_redis->connect($config['host'], $config['port']);

	}


	private static $_instance = null;

	private function __clone() {
	}

	public static function getInstance() {
		if (self::$_instance === null) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

            public function get_redis() {
                return $this->_redis;
            }

            public function test() {
                // echo 'test';
                $this->_redis->set("testkey", "333");
                $v = $this->_redis->get("testkey");
                echo $v;

            }
}


