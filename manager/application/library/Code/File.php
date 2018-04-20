<?php
/**
 * Enter description here ...
 * @author maofeng
 * https://blog.csdn.net/sinat_35861727/article/details/73862991
 *
 */

require_once APP_PATH . '/application/library/phpqrcode/phpqrcode.php';

class Code_File {

	// // 1. 生成原始的二维码(生成图片文件)
	// function scerweima($url = '') {
	// 	// require_once 'phpqrcode.php';

	// 	$value = $url; //二维码内容

	// 	$errorCorrectionLevel = 'L'; //容错级别
	// 	$matrixPointSize = 5; //生成图片大小

	// 	//生成二维码图片
	// 	// $filename = 'qrcode/' . microtime() . '.png';
	// 	$root_dir = rtrim($_SERVER['DOCUMENT_ROOT'], 'public');
	// 	$filename = $root_dir . "public/upload/123.png";

	// 	QRcode::png($value, $filename, $errorCorrectionLevel, $matrixPointSize, 2);

	// 	echo $filename;

	// 	// $QR = $filename; //已经生成的原始二维码图片文件

	// 	// $QR = imagecreatefromstring(file_get_contents($QR));

	// 	// //输出图片
	// 	// imagepng($QR, 'qrcode.png');
	// 	// imagedestroy($QR);
	// 	// return '<img src="qrcode.png" alt="使用微信扫描支付">';
	// }

	// //调用查看结果
	// // echo scerweima('https://www.baidu.com');

	// //2. 在生成的二维码中加上logo(生成图片文件)
	// public function scerweima1($url = '') {
	// 	// require_once 'phpqrcode.php';
	// 	$value = $url; //二维码内容
	// 	$errorCorrectionLevel = 'H'; //容错级别
	// 	$matrixPointSize = 16; //生成图片大小
	// 	//生成二维码图片
	// 	// $filename = 'qrcode/'.microtime().'.png';
	// 	$root_dir = rtrim($_SERVER['DOCUMENT_ROOT'], 'public');
	// 	$filename = $root_dir . "public/upload/111.png";
	// 	$filename2 = $root_dir . "public/upload/222.png";

	// 	QRcode::png($value, $filename, $errorCorrectionLevel, $matrixPointSize, 2);

	// 	// $logo = 'qrcode/logo.jpg';  //准备好的logo图片
	// 	// $logo = $root_dir . 'public/upload/201801/08/ead23a3b6f5b701c30746a1a0c9c5f23.jpg';
	// 	$logo = $root_dir . 'public/upload/201801/08/80e166f0a46086e9ae2aa21d4f2909eb.jpg';
	// 	// echo $logo;

	// 	$QR = $filename; //已经生成的原始二维码图

	// 	if (file_exists($logo)) {
	// 		// echo 'yyy';
	// 		$QR = imagecreatefromstring(file_get_contents($QR)); //目标图象连接资源。
	// 		$logo = imagecreatefromstring(file_get_contents($logo)); //源图象连接资源。
	// 		$QR_width = imagesx($QR); //二维码图片宽度
	// 		$QR_height = imagesy($QR); //二维码图片高度
	// 		$logo_width = imagesx($logo); //logo图片宽度
	// 		$logo_height = imagesy($logo); //logo图片高度
	// 		$logo_qr_width = $QR_width / 4; //组合之后logo的宽度(占二维码的1/5)
	// 		$scale = $logo_width / $logo_qr_width; //logo的宽度缩放比(本身宽度/组合后的宽度)
	// 		$logo_qr_height = $logo_height / $scale; //组合之后logo的高度
	// 		$from_width = ($QR_width - $logo_qr_width) / 2; //组合之后logo左上角所在坐标点

	// 		//重新组合图片并调整大小
	// 		/*
	// 		*  imagecopyresampled() 将一幅图像(源图象)中的一块正方形区域拷贝到另一个图像中
	// 		*/
	// 		$r = imagecopyresampled($QR, $logo, $from_width, $from_width, 0, 0, $logo_qr_width, $logo_qr_height, $logo_width, $logo_height);
	// 		var_dump($r, $QR_width, $QR_height, $logo_width, $logo_height);

	// 		// QRcode::png($QR, $filename, $errorCorrectionLevel, $matrixPointSize, 2);
	// 		// $rr = file_put_contents($filename, $QR);
	// 		var_dump($QR);

	// 		imagepng($QR, $filename2);
	// 	} else {
	// 		// echo 'xxx';
	// 	}
	// }

	/**
	 * $student_link 要生成二维码链接
	 * $filename 生成二维码保存路径
	 * $logo 中间放的logo图片路径
	 */
	public function create_qrcode($student_link, $filename, $logo, $water = [], $matrixPointSize = 8) {
		$value = $student_link; //二维码内容
		$errorCorrectionLevel = 'H'; //容错级别
		// $matrixPointSize = 8; //生成图片大小
		//生成二维码图片
		QRcode::png($value, $filename, $errorCorrectionLevel, $matrixPointSize, 10);

		$QR = $filename; //已经生成的原始二维码图

		if (file_exists($logo)) {
			// echo 'yyy';
			$QR = imagecreatefromstring(file_get_contents($QR)); //目标图象连接资源。
			$logo = imagecreatefromstring(file_get_contents($logo)); //源图象连接资源。
			$QR_width = imagesx($QR); //二维码图片宽度
			$QR_height = imagesy($QR); //二维码图片高度
			$logo_width = imagesx($logo); //logo图片宽度
			$logo_height = imagesy($logo); //logo图片高度
			$logo_qr_width = $QR_width / 4; //组合之后logo的宽度(占二维码的1/5)
			$scale = $logo_width / $logo_qr_width; //logo的宽度缩放比(本身宽度/组合后的宽度)
			$logo_qr_height = $logo_height / $scale; //组合之后logo的高度
			$from_width = ($QR_width - $logo_qr_width) / 2; //组合之后logo左上角所在坐标点

			//重新组合图片并调整大小
			/*
			*  imagecopyresampled() 将一幅图像(源图象)中的一块正方形区域拷贝到另一个图像中
			*/
			$r = imagecopyresampled($QR, $logo, $from_width, $from_width, 0, 0, $logo_qr_width, $logo_qr_height, $logo_width, $logo_height);
			imagepng($QR, $filename);
			imagedestroy($QR);
			imagedestroy($logo);

			if (isset($water['top'])) {
				$this->water($filename, $water['top'], 2);
			}

			if (isset($water['bottom'])) {
				$this->water($filename, $water['bottom'], 8);
			}
		}
	}

	public function water($imgFileName, $text = ' ', $pos = 2) {

		$obj = new Code_Water($imgFileName); //实例化对象
		$obj->waterTypeStr = true; //开启文字水印
		$obj->waterTypeImage = false; //开启图片水印
		// $obj->pos = 2; //定义水印图片位置
		// $obj->pos = 8; //定义水印图片位置
		$obj->pos = $pos;

		// $obj->waterImg = './water.png'; //水印图片
		$obj->transparent = 100; //水印透明度
		// $obj->waterStr = '南山小学：小明 电话：02052552'; //水印文字
		$obj->waterStr = $text; //水印文字
		$obj->fontSize = 15; //文字字体大小
		$obj->fontColor = array(0, 0, 0); //水印文字颜色（RGB）
		// $obj->fontFile = './font/msyh.ttc'; //字体文件，这里是微软雅黑
		$obj->fontFile = rtrim($_SERVER['DOCUMENT_ROOT'], '/') . '/image/simsun.ttc';
		// $obj->fontFile = '/mnt/web/m.demo.com/public/image/simsun.ttc'; //字体文件，这里是微软雅黑
		$obj->is_draw_rectangle = false; //开启绘制矩形区域
		// $obj->output_img = './' . $file . '_n' . $file_ext; //输出的图片路径
		$obj->output_img = $imgFileName; //输出的图片路径

		$obj->output();

	}
}

?>