<?php
/**
 * LinkCategory Controller
 *
 * @author Ryuji AMANO <ryuji@ryus.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('LinksAppController', 'Links.Controller');

/**
 * LinkCategory Controller
 *
 * @author Ryuji AMANO <ryuji@ryus.co.jp>
 * @package NetCommons\Links\Controller
 */
class LinkCategoryController extends LinksAppController {

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

		//Roleのデータをviewにセット
		if (! $this->NetCommonsRoomRole->setView($this)) {
			throw new ForbiddenException();
		}

		//編集権限チェック
		if (! $this->viewVars['contentEditable']) {
			throw new ForbiddenException();
		}

		//Frameのデータをviewにセット
		if (! $this->NetCommonsFrame->setView($this, $frameId)) {
			throw new ForbiddenException();
		}

	}

/**
 * view method
 *
 * @param int $frameId frames.id
 * @param string $lang ex)"en" or "ja" etc.
 * @return CakeResponse A response object containing the rendered view.
 */
	public function view($frameId = 0, $type = 'list') {
		if ($this->response->statusCode() !== 200) {
			return $this->render(false);
		}

		return $this->render('LinkCategory/view', false);
	}
/**
* form method
*
* @param int $frameId frames.id
* @return CakeResponse A response object containing the rendered view.
*/
	public function form($frameId = 0) {
		return $this->render('LinkCategory/form', false);
	}

	public function add($frameId = 0) {
		if (! $this->request->isPost()) {
			throw new MethodNotAllowedException();
		}

		$postData = $this->data;
//		unset($postData['Announcement']['id']);

		//保存
		if ($this->LinkCategory->saveLinkCategory($postData)) {
//			$announcement = $this->Announcement->getAnnouncement(
//				$this->viewVars['blockId'],
//				$this->viewVars['contentEditable']
//			);

			$result = array(
				'name' => __d('net_commons', 'Successfully finished.'),
				'link_category' => $postData,
			);

			$this->set(compact('result'));
			$this->set('_serialize', 'result');
			return $this->render(false);
		} else {
			throw new ForbiddenException(__d('net_commons', 'Failed to register data.'));
		}
	}
}
