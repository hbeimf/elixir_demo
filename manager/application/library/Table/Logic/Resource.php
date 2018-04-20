<?php

class Table_Logic_Resource extends EloquentModel {
	protected $table = 't_resource';

	public $timestamps = false;

	// <pre>Array
	// (
	//     [flg] => 1
	//     [dir] => /upload/201801/12/80e166f0a46086e9ae2aa21d4f2909eb.jpg
	//     [url] => http://m1.demo.com/upload/201801/12/80e166f0a46086e9ae2aa21d4f2909eb.jpg
	//     [md5] => 80e166f0a46086e9ae2aa21d4f2909eb
	//     [width] => 75
	//     [height] => 100
	//     [old_name] => 333.jpg
	//     [size] => 4210
	//     [msg] => 上传成功
	// )

	// 清理那些错误上传的文件
	public function clean($r) {

	}

	public function get_tailer($name) {
		return Upload_File::getInstance()->get_tailer($name);
	}

	public function upload($name) {
		$md5 = Upload_File::getInstance()->get_md5($name);

		$reply = [
			'flg' => false,
			'id' => '',
			'msg' => '',
			'from' => '',
			'tailer' => '',
		];

		if (trim($md5) != '') {
			$row = $this->where('md5', '=', $md5)->first();
			if (is_null($row)) {
				$r = Upload_File::getInstance()->upload($name, "upload");
				if ($r['flg']) {
					$time = time();

					$data = [
						'name' => $r['old_name'],
						'dir' => $r['dir'],
						'url' => $r['url'],
						'md5' => $r['md5'],
						'file_size' => $r['size'],
						'width' => $r['width'],
						'height' => $r['height'],
						'created_at' => $time,
						'updated_at' => $time,
						'tailer' => $r['tailer'],
					];
					$id = $this->insertGetId($data);

					$reply = [
						'flg' => true,
						'id' => $id,
						'from' => 'new',
						'tailer' => $r['tailer'],
					];
				} else {
					$reply['msg'] = $r['msg'];
				}
			} else {
				$time = time();

				$name = isset($_FILES[$name]['name']) ? $_FILES[$name]['name'] : $row->name;
				$data = [
					'name' => $name,
					'dir' => $row->dir,
					'url' => $row->url,
					'md5' => $row->md5,
					'file_size' => $row->file_size,
					'width' => $row->width,
					'height' => $row->height,
					'created_at' => $time,
					'updated_at' => $time,
					'tailer' => $row->tailer,
				];
				$id = $this->insertGetId($data);

				$reply = [
					'flg' => true,
					'id' => $id,
					'from' => 'old',
					'tailer' => $row->tailer,
				];

			}
		} else {
			$reply['msg'] = '请选择文件';
		}

		return $reply;
	}
}
