<?php
$loader = require './vendor/autoload.php';

// http://quotes.money.163.com/0600000.html#9b01
// use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Capsule\Manager as DB;

class get_data {
	public function run() {
		// $this->run_download();
		$this->run_parse();
		// $this->parse('0601229');
	}

	public function run_download() {
		$data = DB::table('m_gp_list')->get();
		$i = 1;
		$total = count($data);
		foreach ($data as $v) {
			$code = '0' . substr($v['code'], 2, 6);
			$code1 = '1' . substr($v['code'], 2, 6);

			$this->download($code);
			$this->download($code1);

			echo "当前第 [{$i}] 条, 共:{$total} \n";
			$i++;
		}
	}

	private function get_start() {

	}

	public function download($code) {
		$today = date("Ymd", time());
		// $start = date("Ymd", time() - 24 * 60 * 60 * 10);
		// $link = $this->_url . "?code={$code}&start=20000101&end={$today}";
		$link = $this->_url . "?code={$code}&start={$this->_start}&end={$today}";

		// echo $link . "\n";
		$data = file_get_contents($link);
		$data = iconv('GBK', 'utf-8', $data); //exit;

		$dst = "./csv/{$code}.csv";
		$size = file_put_contents($dst, $data);
		// echo $size;
		if ($size < 200) {
			unlink($dst);
		}
		// echo "\n";
	}

	public function run_parse() {
		$data = DB::table('m_gp_list')->get();
		$i = 1;
		$all = count($data);
		foreach ($data as $v) {
			$code = '0' . substr($v['code'], 2, 6);
			$code1 = '1' . substr($v['code'], 2, 6);

			echo "all: {$all}, current: {$i}, code:" . substr($v['code'], 2, 6) . "\n";
			$this->parse($code);
			$this->parse($code1);

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
				// for ($i = 0; $i < 2; $i++) {

				# code...
				// echo $arr[$i];
				// echo "\n";
				$list = explode(",", $arr[$i]);
				$list = array_map("trim", $list);
				// [0] => 日期
				// [1] => 股票代码
				// [2] => 名称
				// [3] => 收盘价
				// [4] => 最高价
				// [5] => 最低价
				// [6] => 开盘价
				// [7] => 前收盘
				// [8] => 涨跌额
				// [9] => 涨跌幅
				// [10] => 换手率
				// [11] => 成交量
				// [12] => 成交金额
				// [13] => 总市值
				// [14] => 流通市值
				// [15] => 成交笔数

				$code = trim($list[1], "'");
				$timer = $list[0];
				$close_price = is_numeric($list[3]) ? $list[3] : 0;
				$name = $list[2];
				$timer_int = strtotime($timer);
				$open_price = is_numeric($list[6]) ? $list[6] : 0;
				$yesterday_close_price = is_numeric($list[7]) ? $list[7] : 0;
				$today_top_price = is_numeric($list[4]) ? $list[4] : 0;
				$today_bottom_price = is_numeric($list[5]) ? $list[5] : 0;

				// print_r($list);
				$vals[] = "('{$code}', '{$name}', '{$timer}', {$timer_int}, {$open_price}, {$yesterday_close_price}, {$close_price}, {$today_top_price}, {$today_bottom_price})";
				// print_r($vals);
				// exit;
			}

			try {
				$sql = "INSERT IGNORE INTO m_all (code, name, timer, timer_int, open_price, yesterday_close_price, close_price, today_top_price, today_bottom_price) values " . implode(', ', $vals);
				// echo $sql . "\n";
				DB::insert($sql);
			} catch (Except $e) {
				echo $dst . "\n";
			}
		}
	}

	public function __construct() {
		$this->_initDatabaseEloquent();
		$this->_set_start();
	}

	private function _initDatabaseEloquent() {
		$db = new DB;
		$db->addConnection($this->database_config);
		$db->setAsGlobal();
		$db->bootEloquent();
		$db::connection()->enableQueryLog();
	}

	// https://blog.csdn.net/qq_28018283/article/details/53113642
	private function _set_start() {
		// $sql = "select count(*) as a from m_all";
		$sql = "select * from m_all limit 1";
		$res = DB::select($sql, []);
		// var_dump($res);exit;
		if (count($res) > 0) {
			$today = date("Ymd", time());
			$this->_start = date("Ymd", time() - 24 * 60 * 60 * 10);
		} else {
			$this->_start = '20000101';
		}
		echo "start: " . $this->_start . "\n";
	}

	private $_start = '20000101';

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