<?php

function cut_str($str, $len = 4) {
	// $str = $param['str'];
	// $len = isset($param['len']) ? $param['len'] : 30;
	$font_len = strlen('这');
	if (strlen($str) > $len * $font_len) {
		return mb_substr($str, 0, $len, 'utf-8') . "...";
	}
	return $str;
}

/**
 * 验证邮箱是否正确
 */
function isEmail($mail) {
	$checkmail = "/\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/";
	if (preg_match($checkmail, $mail)) {
		//用正则表达式函数进行判断
		// echo "电子邮箱格式正确";
		return true;
	} else {
		// echo "电子邮箱格式不正确";
		return false;
	}
}

// function isEmail($mail) {
// 	if (trim($mail) == '') {
// 		return false;
// 	}
// 	// $checkmail="/\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/";//定义正则表达式
// 	$checkmail = '/^([a-z0-9])(([-a-z0-9._])*([a-z0-9]))*\@([a-z0-9])*(\.([a-z0-9])([-a-z0-9_-])([a-z0-9])+)*$/i';   //正则表达式
//     if(preg_match($checkmail,$mail)){                       //用正则表达式函数进行判断
// 		return true;
// 	}
// 	return false;
// }

/**
 * 验证手机号是否正确
 */
function isMobile($mobile) {
	if (!is_numeric($mobile)) {
		return false;
	}
	return preg_match('#^13[\d]{9}$|^14[5,7]{1}\d{8}$|^15[^4]{1}\d{8}$|^17[0,6,7,8]{1}\d{8}$|^18[\d]{9}$#', $mobile) ? true : false;
}

/**
 * 打印数组
 * @param $data
 */
function p($data) {
	echo '<pre>';
	print_r($data);
	echo '</pre>';
}

/**
 * 获取配置文件信息
 * @param $field
 * @param null $key
 * @return mixed
 */
function getConfig($field, $key = null) {
	$data = Yaf_Registry::get('config')->toArray();
	return $key ? $data[$field][$key] : $data[$field];
}

/**
 * 获取log路径
 * @return mixed
 */
function getLogPath() {
	return getConfig('log', 'path');
}

/**
 * 连接redis
 */
function redisConnect() {
	return Cache_Cache::getInstance('Redis', ['host' => getConfig('redis', 'host'), 'port' => getConfig('redis', 'port')]);
}

/**
 * 取得对象实例 支持调用类的静态方法
 * @param string $name 类名
 * @param string $method 方法名，如果为空则返回实例化对象
 * @param array $args 调用参数
 * @return object
 */
function get_instance_of($name, $method = '', $args = array()) {
	static $_instance = array();
	$identify = empty($args) ? $name . $method : $name . $method . to_guid_string($args);
	if (!isset($_instance[$identify])) {
		if (class_exists($name)) {
			$o = new $name();
			if (method_exists($o, $method)) {
				if (!empty($args)) {
					$_instance[$identify] = call_user_func_array(array(&$o, $method), $args);
				} else {
					$_instance[$identify] = $o->$method();
				}
			} else {
				$_instance[$identify] = $o;
			}

		} else {
			halt('实例化一个不存在的类！' . ':' . $name);
		}

	}
	return $_instance[$identify];
}

/**
 * 根据PHP各种类型变量生成唯一标识号
 * @param mixed $mix 变量
 * @return string
 */
function to_guid_string($mix) {
	if (is_object($mix) && function_exists('spl_object_hash')) {
		return spl_object_hash($mix);
	} elseif (is_resource($mix)) {
		$mix = get_resource_type($mix) . strval($mix);
	} else {
		$mix = serialize($mix);
	}
	return md5($mix);
}

/**
 * 发送邮件
 * @param array $email
 * @param $title
 * @param $content
 * @return bool
 */
function sendmail($email, $title, $content) {

	if (!is_array($email) || !$email) {
		return false;
	}

	set_time_limit(0);
	header("Content-type: text/html; charset=utf-8");

	$title = "=?UTF-8?B?" . base64_encode($title) . "?=";
	$headers = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n"; // Additional headers
	$headers .= 'from:molaifeng@foxmail.com' . "\r\n";

	foreach ($email as $v) {
		if ($v) {
			if (mail($v, $title, $content, $headers)) {
				Log_Log::info('sendmail: success', true, true);
				return true;
			} else {
				Log_Log::info('sendmail: Mailer Error', true, true);
				return false;
			}
		}
	}

}

// 视图函数开始 ==========================================================
function has_file($param) {
	$dir = $param['dir'];
	$root_dir = rtrim($_SERVER['DOCUMENT_ROOT'], 'public');
	$file_dir = $root_dir . 'public' . $dir;
	// return $file_dir;
	if (file_exists($file_dir)) {
		return '存在';
	}
	return '<font color="red">丢失</font>';
}

function qrcode($param) {
	$id = $param['id'];
	$role = $param['role'];

	$root_dir = rtrim($_SERVER['DOCUMENT_ROOT'], 'public');
	$qrcode_dir = $root_dir . "public/qrcode/{$role}_{$id}.png";
	if (file_exists($qrcode_dir)) {
		return "/qrcode/{$role}_{$id}.png";
	}

	if ($role == 'teacher') {
		return "/teacher/qrcode/id/{$id}";
	}
	return "/student/qrcode/id/{$id}";
}

/**
 * 截取字符串
 */
function sub_str($param) {
	$str = $param['str'];
	$len = isset($param['len']) ? $param['len'] : 30;
	$font_len = strlen('这');
	if (strlen($str) > 30 * $font_len) {
		return mb_substr($str, 0, $len, 'utf-8') . "...";
	}
	return $str;
}

function acount_menu($param) {
	if (trim($param['the_role']) != '') {
		$group = [];

		$the_role = explode(",", $param['the_role']);
		$all_role = $param['all_role'];
		foreach ($all_role as $key => $value) {
			if (in_array($value['id'], $the_role)) {
				$tmp = explode(',', $value['menu_ids']);
				foreach ($tmp as $t) {
					$group[$t] = $t;
				}
			}
		}

		$the_menu = implode(",", $group);

		$p = [
			'the_menu' => $the_menu,
			'all_menu' => $param['all_menu'],
		];
		menu_name($p);
	}
}

// 视图函数开始 =====================================================
function category_name($param) {
	$categorys = explode(',', $param['category']);

	$reply = '';

	$c = [
		'normal' => '默认类型',
		'c300' => '沪深300',
		'c50' => '上证50',
	];
	foreach ($categorys as $category) {
		$reply .= $c[$category] . '<br />';
	}

	return $reply;
}

// 返回角色名称
function role_name($param) {
	if (trim($param['the_role']) != '') {
		$the_role = explode(",", $param['the_role']);
		$all_role = $param['all_role'];
		foreach ($all_role as $key => $value) {
			if (in_array($value['id'], $the_role)) {
				echo $value['role_name'] . '<br />';
			}
		}
	}
}

function menu_name($p) {
	if (trim($p['the_menu']) != '') {
		$the_menu = explode(',', $p['the_menu']);
		$all_menu = $p['all_menu'];

		$tmp_menu = [];
		foreach ($all_menu as $key => $value) {
			if (!empty($value['child'])) {
				foreach ($value['child'] as $child) {
					if (in_array($child['id'], $the_menu)) {
						$tmp_menu[$key] = $value;
					}
				}
			}
		}

		foreach ($tmp_menu as $key => $value) {

			echo $value['menu_name'] . '<br />';
			foreach ($value['child'] as $child) {
				if (in_array($child['id'], $the_menu)) {
					$type = ($child['type'] == 1) ? '[导航]' : '[<font color="red">功能</font>]';
					echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $child['menu_name'] . $type . '<br />';
				}
			}
		}

	}
}

//课程类型
function course_type($p) {
	$the_type = explode(',', $p['type']);
	$res = '';
	foreach ($p['types'] as $t) {
		if (in_array($t['id'], $the_type)) {
			$res .= ' ,' . $t['name'];
		}
	}
	echo trim($res, ' ,');
}

// 性别
function gender($p) {
	if ($p['g'] == 'male') {
		echo '男';
	} else if ($p['g'] == 'female') {
		echo '女';
	} else {
		echo '保密';
	}
}

// 视图函数结束　 ==========================================================
