<?php
$loader = require './vendor/autoload.php';

// http://quotes.money.163.com/0600000.html#9b01
// use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Capsule\Manager as DB;

class get_data {
	public function run() {
		$data = DB::table('m_gp_list')->get();
		$i = 0;
		foreach ($data as $v) {
			$code = '0' . substr($v['code'], 2, 6);
			$code1 = '1' . substr($v['code'], 2, 6);

			$this->download($code);
			$this->download($code1);
		}

		$this->run_parse();
	}

	public function download($code) {
		$today = date("Ymd", time());
		$start = date("Ymd", time() - 24 * 60 * 60 * 10);
		// $link = $this->_url . "?code={$code}&start=20000101&end={$today}";
		$link = $this->_url . "?code={$code}&start={$start}&end={$today}";
		// echo $link . "\n";
		$data = file_get_contents($link);
		$data = iconv('GBK', 'utf-8', $data); //exit;

		$dst = "./csv/{$code}.csv";
		$size = file_put_contents($dst, $data);
		echo $size;
		if ($size < 200) {
			unlink($dst);
		}
		echo "\n";
	}

	public function run_parse() {
		$data = DB::table('m_gp_list')->get();
		$i = 1;
		$all = count($data);
		foreach ($data as $v) {
			$code = '0' . substr($v['code'], 2, 6);
			$code1 = '1' . substr($v['code'], 2, 6);

			$this->parse($code);
			$this->parse($code1);
			echo "all: {$all}, current: {$i}, code:" . substr($v['code'], 2, 6) . "\n";
			$i++;
		}

	}

	public function parse($code) {

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
				$timer_int = strtotime($timer);
				$vals[] = "('{$code}', '{$timer}', {$timer_int}, {$price})";
			}

			$sql = "INSERT IGNORE INTO m_all (code, timer, timer_int, price) values " . implode(', ', $vals);
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