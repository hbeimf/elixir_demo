<?php
/**
 * Enter description here ...
 * @author maofeng
 *
 */
class Upload_File {

	/**
	 *
	 * Enter description here ...
	 * @param unknown_type $array
	 * @param unknown_type $path_info
	 */
	function save_array($array, $path_info) {
		$str = '<?php' . "\n";
		$str .= 'return ' . var_export($array, true) . ';' . "\n";
		$str .= '?>';
		$dir = rtrim($_SERVER['DOCUMENT_ROOT'], '/') . '/Cache/' . ltrim($path_info, '/');
		$r = file_put_contents($dir, $str);

		if (is_numeric($r)) {
			$res = array('flg' => true, 'msg' => '保存数据成功');
		} else {
			$res = array('flg' => false, 'msg' => '保存数据失败');
		}

		return $res;
	}

	function read_array($path_info) {
		$dir = rtrim($_SERVER['DOCUMENT_ROOT'], '/') . '/Cache/' . ltrim($path_info, '/');
		if (file_exists($dir)) {
			if (is_readable($dir)) {
				$array = include_once $dir;
				$res = array('flg' => true, 'data' => $array, 'msg' => '');
			} else {
				$res = array('flg' => false, 'msg' => '没有读权限');
			}
		} else {
			$res = array('flg' => false, 'msg' => '文件不存在');
		}
		return $res;
	}

	/**
	 *
	 * Enter description here ...
	 * @param unknown_type $content
	 * @param unknown_type $path_info
	 */
	function save_file($content, $path_info) {
		$dir = rtrim($_SERVER['DOCUMENT_ROOT'], '/') . '/Cache/' . ltrim($path_info, '/');
		$r = file_put_contents($dir, $content);
		if (is_numeric($r)) {
			$res = array('flg' => true, 'msg' => '保存数据成功');
		} else {
			$res = array('flg' => false, 'msg' => '保存数据失败');
		}
		return $res;
	}

	function read_file($path_info) {
		$dir = rtrim($_SERVER['DOCUMENT_ROOT'], '/') . '/Cache/' . ltrim($path_info, '/');
		if (file_exists($dir)) {
			if (is_readable($dir)) {
				$con = file_get_contents($dir);
				$res = array('flg' => true, 'data' => $con, 'msg' => '');
			} else {
				$res = array('flg' => false, 'msg' => '没有读权限');
			}
		} else {
			$res = array('flg' => false, 'msg' => '文件不存在');
		}
		return $res;
	}

	public function get_md5($fileName) {
		if (!isset($_FILES[$fileName])) {
			return '';
		}

		if (is_uploaded_file($_FILES[$fileName]['tmp_name'])) {
			return md5_file($_FILES[$fileName]['tmp_name']);
		}
		return '';
	}

	// 获取文件后缀
	public function get_tailer($fileName) {
		if (!isset($_FILES[$fileName])) {
			return '';
		}

		if (is_uploaded_file($_FILES[$fileName]['tmp_name'])) {
			$oldName = $_FILES[$fileName]['name'];
			$cacheArray = explode('.', $oldName);
			return $cacheArray[count($cacheArray) - 1];
		}
		return '';
	}

	/**
	 *
	 * Enter description here ...
	 * @param string $fileName 要上传的文件源信息 <input type="file" name="fileName" id="fileName" />
	 * @param string $fileInfo 上传目标文件的信息/public/attachment/  代表/public/attachment/目录下
	 * @param string $newFileName 新上传文件的名字，为空会以文件md5值为新名
	 * @param array $limit 允许上传的文件的后辍限制 array(),
	 * @param int $size int
	 *  */
	public function upload($fileName = '', $pathInfo = '', $newFileName = '', $size = 102400000, $limit = array('xml', 'mp3', 'zip', 'docx', 'doc', 'xlsx', 'pdf', 'txt', 'jpg', 'gif', 'png', 'jpeg', 'apk', 'ipa', 'csv')) {
		$p = rtrim($_SERVER['DOCUMENT_ROOT'], '/') . '/' . trim($pathInfo, '/');
		if (!is_dir($p)) {
			$res = array('flg' => false, 'msg' => $p . '路径不存在');
			return $res;
		}

		if (!isset($_FILES[$fileName])) {
			$res = array('flg' => false, 'msg' => '数据键值不存在,文件没有正确提交');
			return $res;
		}

		if (is_uploaded_file($_FILES[$fileName]['tmp_name'])) {
			if ($_FILES[$fileName]["size"] > $size) {
				$res = array('flg' => false, 'msg' => '文件大小超过了限制');
				return $res;
			}

			$real_path = rtrim($_SERVER['DOCUMENT_ROOT'], '/');
			$dir = $real_path . '/' . trim($pathInfo, '/');
			$back_name = '';

			//增加年月路径
			try {
				$month = date("Ym", time());

				$dir .= "/" . $month;
				$back_name .= $month;

				if (!is_dir($dir)) {
					mkdir($dir);
				}
				$day = date("d", time());
				$dir .= "/" . $day;
				$back_name .= "/" . $day;
				if (!is_dir($dir)) {
					mkdir($dir);
				}
			} catch (Exception $e) {
				$res = array('flg' => false, 'msg' => '创建目录失败');
				return $res;
			}

			if (is_dir($dir) && is_writable($dir)) {

				$oldName = $_FILES[$fileName]['name'];
				$cacheArray = explode('.', $oldName);
				$tailer = $cacheArray[count($cacheArray) - 1];

				if (in_array(strtolower($tailer), $limit)) {
					if (trim($newFileName) == '') {
						$md5 = $newFileName = md5_file($_FILES[$fileName]['tmp_name']);
					} else {
						$md5 = md5_file($_FILES[$fileName]['tmp_name']);
					}
					$newName = $newFileName . '.' . $tailer;
					$destination = $dir . '/' . $newName;
					move_uploaded_file($_FILES[$fileName]['tmp_name'], $destination);
					$dir = str_replace(rtrim($_SERVER['DOCUMENT_ROOT'], '/'), '', $destination);
					$url = $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] . $dir;

					$res = array(
						'flg' => true,
						'dir' => $dir,
						'url' => $url,
						'md5' => $md5,
						'width' => 0,
						'height' => 0,
						'old_name' => $oldName,
						'size' => $_FILES[$fileName]["size"],
						'tailer' => $tailer,
						'msg' => '上传成功',
					);

					//如果是图片 ， 返回 图片宽高属性
					if (in_array(strtolower($tailer), array('jpg', 'gif', 'png', 'jpeg', 'bmp'))) {
						$img_info = @getimagesize($destination);
						if (is_array($img_info)) {
							$res['width'] = $img_info[0];
							$res['height'] = $img_info[1];
						}
					}
					//如果是图片

					return $res;

				} else {
					$res = array('flg' => false, 'msg' => '上传文件后辍不支持');
					return $res;
				}
			} else {
				$res = array('flg' => false, 'msg' => '上传目录没有写权限');
				return $res;
			}
		} else {
			$res = array('flg' => false, 'msg' => '没有提交文件');
			return $res;
		}
	}

	public function download($fileInfo = '', $newName = 'newFile.txt') {
		$result = '';
		$attachmentPath = $fileInfo;

		if (file_exists($attachmentPath)) {

			header("Content-Type:application/octet-stream");
			header("Content-Disposition: attachment; filename=$newName");

			header("Pragma: no-cache");
			header("Expires: 0");
			echo file_get_contents($attachmentPath);
			exit();
		}
	}

	/**
	 *
	 * Enter description here ...
	 * //file_put_contents(__DIR__ . '/gearman.log', $log . "\n", FILE_APPEND | LOCK_EX);
	 * @param unknown_type $log
	 * @param unknown_type $path_info
	 */
	function save_log($log, $path_info) {
		$abs_path = rtrim($_SERVER['DOCUMENT_ROOT'], '/') . "/Cache/" . trim($path_info, "/");
		if (file_exists($abs_path)) {

			if (is_writable($abs_path)) {
				$fp = fopen($abs_path, 'a');
				$r = fwrite($fp, $log . "\n");
				fclose($fp);
				if ($r === false) {
					$res = array('flg' => false, 'msg' => '保存失败');
				} else {
					$res = array('flg' => true, 'msg' => '保存成功');
				}
			} else {
				$res = array('flg' => false, 'msg' => '文件没有写权限');
			}

		} else {
			$r = file_put_contents($abs_path, $log . "\n");
			if (is_numeric($r)) {
				$res = array('flg' => true, 'msg' => '保存数据成功');
			} else {
				$res = array('flg' => false, 'msg' => '保存数据失败');
			}
		}

		return $res;
	}

	/**
	 *
	 *
	 * 从指定的url下载文件 到指定目录，
	 * Enter description here ...
	 * @param unknown_type $url
	 * @param unknown_type $dir 这个目录必顺手动建立
	 */
	public function move_file($url = '', $dir = '/upload/images/') {
		//解析url
		$arr = parse_url($url);
		$arr_path = explode('/', trim($arr['path'], '/'));
		$file_name = $arr_path[count($arr_path) - 1];
		$tailer = explode('.', $file_name);
		$t = $tailer[count($tailer) - 1];

		$new_name = strtolower(md5(microtime() . mt_rand())) . "." . $t;

		$abs_path = rtrim($_SERVER['DOCUMENT_ROOT'], '/') . "/" . trim($dir, "/");

		//增加年月路径
		$month = date("Ym", time());
		$abs_path .= "/" . $month;

		if (!is_dir($abs_path)) {
			mkdir($abs_path);
		}

		$day = date("d", time());
		$abs_path .= "/" . $day;
		if (!is_dir($abs_path)) {
			mkdir($abs_path);
		}

		$abs_path_md5 = $abs_path;
		$abs_path .= "/" . $new_name;

		$file = file_get_contents($url);
		file_put_contents($abs_path, $file);

		$md5_name = strtoupper(md5_file($abs_path)) . "." . $t;
		$abs_path_md5 .= "/" . $md5_name;

		if ($abs_path != $abs_path_md5) {
			file_put_contents($abs_path_md5, $file);
			@unlink($abs_path);
		}

		return str_replace(rtrim($_SERVER['DOCUMENT_ROOT'], '/'), '', $abs_path_md5);
	}

	/**
	 * 获取对向
	 *
	 */
	public static function getInstance() {
		if (self::$_instance === null) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	private function __construct() {}

	private function __clone() {}

	private static $_instance = null;

}
?>