<?php
/**
 * Links Controller
 *
 * @author Ryuji AMANO <ryuji@ryus.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('LinksAppController', 'Links.Controller');

/**
 * Links Controller
 *
 * @author Ryuji AMANO <ryuji@ryus.co.jp>
 * @package NetCommons\Links\Controller
 *
 * @property Link $Links
 */
class LinksController extends LinksAppController {

public $helpers = array('Links.LinksStatus');
/**
 * use model
 *
 * @var array
 */
	public $uses = array(
		'Links.Link',
		'Links.LinkCategory',
	);

/**
 * use component
 *
 * @var array
 */

	public $components = array(
		'NetCommons.NetCommonsBlock', //use Announcement model
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
		// カテゴリ一覧を取得
		$categories = $this->LinkCategory->getCategories(
			$this->viewVars['blockId'] // MyTodo まだブロックレコードがないときは0なので、どうする？s
		);
		foreach($categories as &$category){
			//Linkデータを取得
			$links = $this->Link->getLinksByCategoryId(
				$category['LinkCategory']['id'],
				$this->viewVars['blockId'],
				$this->viewVars['contentEditable']
			);
			$category['links'] = $links;
		}
		$this->set('categories', $categories);
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
