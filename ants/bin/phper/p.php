<?php
$loader = require './vendor/autoload.php';

// http://quotes.money.163.com/0600000.html#9b01
// use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Capsule\Manager as DB;

// CREATE TABLE `m_all` (
//   `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
//   `code` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'code',
//   `timer` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '字符串时间',
//   `price` float(10,3) NOT NULL DEFAULT '0.000' COMMENT '收盘价',
//   PRIMARY KEY (`id`),
//   UNIQUE KEY `code_time` (`code`,`timer`)
// ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='m_all';

class get_data {
	public function run() {
		$data = DB::table('m_gp_list')->get();
		$i = 1;
		$all = count($data);
		foreach ($data as $v) {
			$code = '0' . substr($v['code'], 2, 6);
			$code1 = '1' . substr($v['code'], 2, 6);

			$this->download($code);
			$this->download($code1);
			echo "all: {$all}, current: {$i}, code:" . substr($v['code'], 2, 6) . "\n";
			$i++;
		}

	}

	public function download($code) {

		$dst = "./csv/{$code}.csv";

		if (file_exists($dst)) {
			$arr = file($dst);
			// print_r($arr);exit;

			$vals = [];

			for ($i = 1; $i < count($arr); $i++) {
				# code...
				// echo $arr[$i];
				// echo "\n";
				$list = explode(",", $arr[$i]);
				$list = array_map("trim", $list);

				$code = trim($list[1], "'");
				$timer = $list[0];
				$price = $list[3];
				$vals[] = "('{$code}', '{$timer}', {$price})";
			}

			$sql = "INSERT IGNORE INTO m_all (code, timer, price) values " . implode(', ', $vals);
			DB::insert($sql);
		}
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

	private $_url = "http://quotes.money.163.com/service/chddata.html";
}

$obj = new get_data();
$obj->run();

?>