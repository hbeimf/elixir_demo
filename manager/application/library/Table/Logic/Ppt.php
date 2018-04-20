<?php

class Table_Logic_Ppt extends EloquentModel {
	protected $table = 't_ppt';

	public $timestamps = false;

	public function info($id) {
		$info = [
			'flg' => false,
			'info' => [],
		];
		$row = $this->where('id', '=', $id)->first();

		if (is_object($row)) {
			$table_pic = new Table_Logic_Pic();
			$table_font = new Table_Logic_Font();
			$table_res = new Table_Logic_Resource();

			$domain = $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'];

			$info['info']['tpl_type'] = $row->class_type; // 模板类型
			if ($row->class_type == 1) {
				$info['flg'] = true;
				// 模板 1, area1, area2
				$pic = $table_pic->where('id', '=', $row->area1)->first();
				$res = $table_res->where('id', '=', $pic->pic)->first();
				$info['info']['area1'] = [
					'name' => $pic->name,
					'url' => $domain . $res->dir,
					'md5' => $res->md5,
				];

				$font = $table_font->where('id', '=', $row->area2)->first();
				$res_mp3 = $table_res->where('id', '=', $font->mp3)->first();
				$info['info']['area2'] = [
					'font' => $font->font,
					'mp3_desc' => $font->mp3_desc,
					'mp3_type' => $font->mp3_type,
					'url' => $domain . $res_mp3->dir,
					'md5' => $res_mp3->md5,
				];

			} elseif ($row->class_type == 2) {
				$info['flg'] = true;
				// 模板 2, area1, area2, area3, area4
				$font = $table_font->where('id', '=', $row->area1)->first();
				$res_mp3 = $table_res->where('id', '=', $font->mp3)->first();
				$info['info']['area1'] = [
					'font' => $font->font,
					'mp3_desc' => $font->mp3_desc,
					'mp3_type' => $font->mp3_type,
					'url' => $domain . $res_mp3->dir,
					'md5' => $res_mp3->md5,
				];

				$pic = $table_pic->where('id', '=', $row->area2)->first();
				$res = $table_res->where('id', '=', $pic->pic)->first();
				$info['info']['area2'] = [
					'name' => $pic->name,
					'url' => $domain . $res->dir,
					'md5' => $res->md5,
				];

				$font3 = $table_font->where('id', '=', $row->area3)->first();
				$res_mp3 = $table_res->where('id', '=', $font3->mp3)->first();
				$info['info']['area3'] = [
					'font' => $font3->font,
					'mp3_desc' => $font3->mp3_desc,
					'mp3_type' => $font->mp3_type,
					'url' => $domain . $res_mp3->dir,
					'md5' => $res_mp3->md5,
				];

				$font4 = $table_font->where('id', '=', $row->area4)->first();
				$res_mp3 = $table_res->where('id', '=', $font4->mp3)->first();
				$info['info']['area4'] = [
					'font' => $font4->font,
					'mp3_desc' => $font4->mp3_desc,
					'mp3_type' => $font->mp3_type,
					'url' => $domain . $res_mp3->dir,
					'md5' => $res_mp3->md5,
				];

			}
		}
		return $info;
	}

}
