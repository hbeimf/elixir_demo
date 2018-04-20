<?php

class AchievementsController extends AbstractController {

	public function indexAction() {
		// $data = ['js' => 'index_index'];
		$data = [];
		$this->smarty->display('achievements/index.tpl', $data);
	}

}