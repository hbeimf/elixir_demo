<?php

use Illuminate\Database\Capsule\Manager as DB;

// sql 查询记录
function queryLog($params) {
	$queryLog = DB::getQueryLog();
	print_query($queryLog);

	// $r = DB::connection('demo')->getQueryLog();
	// print_query($r);

}

function print_query($queryLog) {
	if (!empty($queryLog)) {
		foreach ($queryLog as $log) {
			if ($log['time'] > 1000) {
				echo "<font style=\"color:red;\">" . $log['query'] . " -- bindings: " . json_encode($log['bindings'], JSON_UNESCAPED_UNICODE) . " -- " . $log['time'] . " ms</font><br />";
			} else {
				echo $log['query'] . " -- bindings: " . json_encode($log['bindings'], JSON_UNESCAPED_UNICODE) . " -- " . $log['time'] . " ms<br />";
			}
		}
	}
}

// 分页函数
function page($params) {
	// p($params);
	$current_page = isset($params['current_page']) ? $params['current_page'] : 1;
	$total_page = isset($params['total_page']) ? $params['total_page'] : 1;
	$page_type = isset($params['page_type']) ? $params['page_type'] : "";

	$current_url = $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

	$pure_urls = explode('?', $current_url);
	$pure_url = $pure_urls[0];

	$urls = parse_url($current_url);

	$querys = [];
	if (isset($urls['query'])) {
		$p = explode('&', $urls['query']);
		foreach ($p as $val) {
			$kv = explode('=', $val);
			$querys[$kv[0]] = isset($kv[1]) ? urldecode($kv[1]) : '';
		}
	}

	$html = '<ul>';

	if ($current_page <= 1) {
		$html .= '	<li class="prev disabled"><a href="javascript:;">← <span class="hidden-480">第一页</span></a></li>';
		$html .= '	<li class="prev disabled"><a href="javascript:;"><span class="hidden-480">上一页</span></a></li>';
	} else {
		$querys['page'] = 1;
		$first_page_url = $pure_url . '?' . http_build_query($querys);

		$querys['page'] = $current_page - 1;
		$url = $pure_url . '?' . http_build_query($querys);

		if ($page_type == 'modal') {
			$html .= '	<li class="prev"><a class="page_modal" href="javascript:;" data-href="' . $first_page_url . '">← <span class="hidden-480">第一页</span></a></li>';
			$html .= '	<li class="prev"><a class="page_modal" href="javascript:;" data-href="' . $url . '"><span class="hidden-480">上一页</span></a></li>';

		} else {
			$html .= '	<li class="prev"><a href="' . $first_page_url . '">← <span class="hidden-480">第一页</span></a></li>';
			$html .= '	<li class="prev"><a href="' . $url . '"><span class="hidden-480">上一页</span></a></li>';

		}

	}

	$show_size = 10;

	$for_num = ($total_page <= $show_size) ? $total_page : 10;
	// $start_add = 0;

	$start = 1;
	if ($current_page <= ($show_size / 2)) {
		$start = 1;
	} elseif ($current_page >= ($total_page - ($show_size / 2))) {
		$start = $total_page - $show_size + 1;
	} else {
		$start = $current_page - ($show_size / 2);
	}

	if ($start <= 0) {
		$start = 1;
	}

	for ($i = 0; $i < $for_num; $i++) {
		$the_page = $i + $start;
		$querys['page'] = $the_page;
		$url = $pure_url . '?' . http_build_query($querys);

		if ($the_page == $current_page) {
			// $html .= '	<li class="active"><a href="' . $url . '">' . $the_page . '</a></li>';
			$html .= '	<li class="active"><a href="javascript:;">' . $the_page . '</a></li>';
		} else {
			if ($page_type == 'modal') {
				$html .= '	<li><a class="page_modal" href="javascript:;" data-href="' . $url . '">' . $the_page . '</a></li>';
			} else {
				$html .= '	<li><a href="' . $url . '">' . $the_page . '</a></li>';
			}

		}
	}

	if ($current_page >= $total_page) {
		$html .= '	<li class="next disabled"><a href="javascript:;"><span class="hidden-480">下一页</span></a></li>';
		$html .= '	<li class="next disabled"><a href="javascript:;"><span class="hidden-480">最后一页</span> → </a></li>';

	} else {
		$querys['page'] = $current_page + 1;
		$url = $pure_url . '?' . http_build_query($querys);
		// $html .= '	<li class="next"><a href="' . $url . '"><span class="hidden-480">下一页</span> → </a></li>';

		$querys['page'] = $total_page;
		$last_page_url = $pure_url . '?' . http_build_query($querys);

		if ($page_type == 'modal') {
			// $html .= '	<li><a href="javascript:;" data-href="' . $url . '">' . $the_page . '</a></li>';
			$html .= '	<li class="next"><a class="page_modal" href="javascript:;" data-href="' . $url . '"><span class="hidden-480">下一页</span></a></li>';
			$html .= '	<li class="next"><a class="page_modal" href="javascript:;" data-href="' . $last_page_url . '"><span class="hidden-480">最后一页</span> → </a></li>';

		} else {
			$html .= '	<li class="next"><a href="' . $url . '"><span class="hidden-480">下一页</span></a></li>';
			$html .= '	<li class="next"><a href="' . $last_page_url . '"><span class="hidden-480">最后一页</span> → </a></li>';

		}
	}

	$html .= '</ul>';

	return $html;
}
?>
