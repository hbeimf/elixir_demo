<?php
$loader = require './vendor/autoload.php';

// use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Capsule\Manager as DB;

class get_data {
	public function run() {
		$data = DB::table('m_gp_list')->first();
		print_r($data);
	}
	public function __construct() {
		$this->_initDatabaseEloquent();
	}

	private function _initDatabaseEloquent() {
		$db = new DB;
		$db->addConnection($this->database_config);
		$db->setAsGlobal();
		$db->bootEloquent();
		$db::connection()->enableQueryLog();
	}

	private $database_config = [
		'driver' => 'mysql',
		'host' => '127.0.0.1',
		'database' => 'ants',
		'username' => 'root',
		'password' => '123456',
		'port' => 3306,
		'charset' => 'utf8',
		'collation' => 'utf8_unicode_ci',
		'prefix' => "",
	];
}

$obj = new get_data();
$obj->run();

?>