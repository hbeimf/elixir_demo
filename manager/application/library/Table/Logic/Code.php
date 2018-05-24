<?php
use Illuminate\Database\Capsule\Manager as DB;

class Table_Logic_Code extends EloquentModel {
	// protected $table = 'm_gp_list';
	protected $table = 'm_gp_list_163';
	public $timestamps = false;

	private $row = null;

	public function update_ten($id) {
		$start = date("Ymd", time() - 24 * 60 * 60 * 10);

		$sina_code = $this->get_code($id);
		// $code = '0' . substr($sina_code, 2, 6);
		// $code1 = '1' . substr($sina_code, 2, 6);

		$this->download($sina_code, $start);
		// $demo = new Thriftc_Example();
		// $demo->demo();

		$thrift = new Thriftc_Call();
		$thrift->call(10000, $id);
	}

	public function update_all($id) {
		$start = '20000101';

		$sina_code = $this->get_code($id);
		// $code = '0' . substr($sina_code, 2, 6);
		// $code1 = '1' . substr($sina_code, 2, 6);

		$this->download($sina_code, $start);

		$thrift = new Thriftc_Call();
		$thrift->call(10000, $id);
	}

	private function get_code($id) {
		$this->row = $this->where('id', '=', $id)->first();
		return $this->row->code_sina;
		// return $this->code_download_163;
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

					$rise_and_fall_num = is_numeric($list[8]) ? $list[8] : 0;
					$rise_and_fall_percent = is_numeric($list[9]) ? $list[9] : 0;
					$turnover_rate = is_numeric($list[10]) ? $list[10] : 0;
					$volume = is_numeric($list[11]) ? $list[11] : 0;
					$transaction_amount = is_numeric($list[12]) ? $list[12] : 0;

					if ($close_price == 0) {

					} else {
						$vals[] = "('{$from_code}', '{$code}', '{$name}', '{$timer}', {$timer_int}, {$open_price}, {$yesterday_close_price}, {$close_price}, {$today_top_price}, {$today_bottom_price}, {$rise_and_fall_num}, {$rise_and_fall_percent}, {$turnover_rate}, {$volume}, {$transaction_amount})";
					}
				}
			}

			try {
				$sql = "INSERT IGNORE INTO m_all (from_code, code, name, timer, timer_int, open_price, yesterday_close_price, close_price, today_top_price, today_bottom_price, rise_and_fall_num, rise_and_fall_percent, turnover_rate, volume, transaction_amount) values " . implode(', ', $vals);

				// echo $sql;exit;
				$r = DB::insert($sql);
				// var_dump($r);exit;
			} catch (\Exception $e) {
				// echo $dst . "\n";
				// echo $e->getMessage();exit;

			}
		}

	}

	private function download($from_code, $start) {
		// $con = $this->http_get($code, $start);
		// $con1 = $this->http_get($code1, $start);

		// $data = (strlen($con) > strlen($con1)) ? $con : $con1;

		$data = $this->http_get($this->row->code_download_163, $start);

		// if ($this->row->code_download_163 == '') {
		// 	$download_code = (strlen($con) > strlen($con1)) ? $code : $code1;
		// 	// 更新下载code
		// 	$update_row = ['code_download_163' => $download_code];
		// 	$this->where('id', $this->row->id)->update($update_row);
		// }

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
