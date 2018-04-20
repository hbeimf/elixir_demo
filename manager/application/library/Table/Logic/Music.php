<?php

class Table_Logic_Music extends EloquentModel {
	protected $table = 't_music';

	public $timestamps = false;

	public function info($id) {
		$info = [
			'flg' => false,
			'info' => [],
		];

		$row = $this->where('id', '=', $id)->first();
		if (is_object($row)) {
			$info['flg'] = true;

			$table_res = new Table_Logic_Resource();
			$domain = $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'];

			$info['info']['name'] = $row->name;

			$png = $table_res->where('id', '=', $row->png)->first();
			if (is_object($png)) {
				$info['info']['png'] = [
					'name' => $png->name,
					'url' => $domain . $png->dir,
					'md5' => $png->md5,
				];
			}

			$xml = $table_res->where('id', '=', $row->xml)->first();
			if (is_object($xml)) {
				$info['info']['xml'] = [
					'name' => $xml->name,
					'url' => $domain . $xml->dir,
					'md5' => $xml->md5,
				];
			}

			$mp3 = $table_res->where('id', '=', $row->mp3)->first();
			if (is_object($mp3)) {
				$info['info']['mp3'] = [
					'name' => $mp3->name,
					'url' => $domain . $mp3->dir,
					'md5' => $mp3->md5,
				];
			}

			$mp3_demo = $table_res->where('id', '=', $row->mp3_demo)->first();
			if (is_object($mp3_demo)) {
				$info['info']['mp3_demo'] = [
					'name' => $mp3_demo->name,
					'url' => $domain . $mp3_demo->dir,
					'md5' => $mp3_demo->md5,
				];
			}
		}

		return $info;
	}
}
