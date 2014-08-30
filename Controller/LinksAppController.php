<?php

App::uses('AppController', 'Controller');
App::uses('NetCommonsFrameAppController', 'NetCommons.Controller');

class LinksAppController extends NetCommonsFrameAppController {

/**
 * フレーム初期化
 *
 * @param int $frameId frames.id
 * @param string $lang language
 * @return CakeResponse
 */
	protected function _init($frameId, $lang) {
		//フレーム初期化処理
		if (! $this->_initializeFrame($frameId, $lang)) {
			$this->response->statusCode(400);
			return $this->render(false);
		}
	}
}
