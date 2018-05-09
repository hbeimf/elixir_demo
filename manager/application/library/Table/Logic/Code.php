<?php
use Illuminate\Database\Capsule\Manager as DB;

class Table_Logic_Code extends EloquentModel {
	// protected $table = 'm_gp_list';
	protected $table = 'm_gp_list_163';
	public $timestamps = false;

	public function update_ten($id) {
		$start = date("Ymd", time() - 24 * 60 * 60 * 10);

		$sina_code = $this->get_code($id);
		$code = '0' . substr($sina_code, 2, 6);
		$code1 = '1' . substr($sina_code, 2, 6);

		$this->download($sina_code, $code, $code1, $start);
		// $demo = new Thriftc_Example();
		// $demo->demo();

		$thrift = new Thriftc_Call();
		$thrift->call(10000, $id);
	}

	public function update_all($id) {
		$start = '20000101';

		$sina_code = $this->get_code($id);
		$code = '0' . substr($sina_code, 2, 6);
		$code1 = '1' . substr($sina_code, 2, 6);

		$this->download($sina_code, $code, $code1, $start);

		$thrift = new Thriftc_Call();
		$thrift->call(10000, $id);
	}

	private function get_code($id) {
		$row = $this->where('id', '=', $id)->first();
		return $row->code_sina;
	}

	private function parser($from_code, $data) {
		$arr = explode("\n", $data);
		// p($arr);exit;
		if (count($arr) > 3) {
			$vals = [];
			for ($i = 1; $i < count($arr); $i++) {
				if (trim($arr[$i]) != '') {
					$list = explode(",", $arr[$i]);
					$list = array_map("trim", $list);

					$code = trim($list[1], "'");
					$timer = $list[0];
					$close_price = is_numeric($list[3]) ? $list[3] : 0;
					$name = $list[2];
					$timer_int = strtotime($timer);
					$open_price = is_numeric($list[6]) ? $list[6] : 0;
					$yesterday_close_price = is_numeric($list[7]) ? $list[7] : 0;
					$today_top_price = is_numeric($list[4]) ? $list[4] : 0;
					$today_bottom_price = is_numeric($list[5]) ? $list[5] : 0;

					if ($close_price == 0) {

					} else {
						$vals[] = "('{$from_code}', '{$code}', '{$name}', '{$timer}', {$timer_int}, {$open_price}, {$yesterday_close_price}, {$close_price}, {$today_top_price}, {$today_bottom_price})";
					}
				}
			}

			try {
				$sql = "INSERT IGNORE INTO m_all (from_code, code, name, timer, timer_int, open_price, yesterday_close_price, close_price, today_top_price, today_bottom_price) values " . implode(', ', $vals);

				// echo $sql;exit;
				$r = DB::insert($sql);
				// var_dump($r);exit;
			} catch (\Exception $e) {
				// echo $dst . "\n";
				// echo $e->getMessage();exit;

			}
		}

	}

	private function download($from_code, $code, $code1, $start) {
		$con = $this->http_get($code, $start);
		$con1 = $this->http_get($code1, $start);

		$data = (strlen($con) > strlen($con1)) ? $con : $con1;

		$this->parser($from_code, $data);
	}

	private function http_get($code, $start) {
		$today = date("Ymd", time());
		// $start = date("Ymd", time() - 24 * 60 * 60 * 10);
		// $link = $this->_url . "?code={$code}&start=20000101&end={$today}";
		$link = $this->_url . "?code={$code}&start={$start}&end={$today}";

		// echo $link . "\n";
		$data = file_get_contents($link);
		$data = iconv('GBK', 'utf-8', $data); //exit;
		return $data;
	}

	private $_url = "http://quotes.money.163.com/service/chddata.html";

}
