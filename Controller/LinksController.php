<?php
/**
 * Links Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('LinksAppController', 'Links.Controller');

/**
 * Links Controller
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Links\Controller
 */
class LinksController extends LinksAppController {

/**
 * use model
 *
 * @var array
 */
	//public $uses = array();

/**
 * use component
 *
 * @var array
 */
	public $components = array(
		'NetCommons.NetCommonsFrame',
		'NetCommons.NetCommonsRoomRole',
	);

/**
 * beforeFilter
 *
 * @return void
 */
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow();

		$frameId = (isset($this->params['pass'][0]) ? (int)$this->params['pass'][0] : 0);
		//Frameのデータをviewにセット
		if (! $this->NetCommonsFrame->setView($this, $frameId)) {
			$this->response->statusCode(400);
			return;
		}
		//Roleのデータをviewにセット
		if (! $this->NetCommonsRoomRole->setView($this)) {
			$this->response->statusCode(400);
			return;
		}
	}

/**
 * index method
 *
 * @param int $frameId frames.id
 * @param string $lang ex)"en" or "ja" etc.
 * @return CakeResponse A response object containing the rendered view.
 */
	public function index($frameId = 0, $type = 'list') {
		$this->set('type', $type);
		return $this->render('Links/index');
	}

/**
 * show linkAdd method
 *
 * @param int $frameId frames.id
 * @return CakeResponse A response object containing the rendered view.
 */
	public function linkAdd($frameId = 0) {
		if ($this->response->statusCode() !== 200) {
			return $this->render(false);
		}

		//編集権限チェック
		if (! $this->viewVars['contentEditable']) {
			$this->response->statusCode(403);
			return $this->render(false);
		}

		return $this->render('Links/link_add', false);
	}

/**
 * show manage method
 *
 * @param int $frameId frames.id
 * @return CakeResponse A response object containing the rendered view.
 */
	public function manage($frameId = 0) {
		if ($this->response->statusCode() !== 200) {
			return $this->render(false);
		}

		//編集権限チェック
		if (! $this->viewVars['contentEditable']) {
			$this->response->statusCode(403);
			return $this->render(false);
		}

		return $this->render('Links/manage', false);
	}
}
