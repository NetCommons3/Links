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
App::uses('HttpSocket', 'Network/Http');

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
	public $uses = array(
		'Blocks.Block',
		'Links.Link',
		'Links.LinkOrder',
		'Links.LinkFrameSetting',
		'Categories.Category',
		'Comments.Comment',
	);

/**
 * use component
 *
 * @var array
 */
	public $components = array(
		'NetCommons.NetCommonsBlock',
		'NetCommons.NetCommonsWorkflow',
		'NetCommons.NetCommonsRoomRole' => array(
			//コンテンツの権限設定
			'allowedActions' => array(
				'contentCreatable' => array('add', 'edit', 'delete'),
			),
		),
		'Categories.Categories',
	);

/**
 * use helpers
 *
 * @var array
 */
	public $helpers = array(
		'NetCommons.Token'
	);

/**
 * beforeFilter
 *
 * @return void
 */
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('index', 'view', 'link');
	}

/**
 * index
 *
 * @return void
 */
	public function index() {
		if (! $this->viewVars['blockId']) {
			$this->autoRender = false;
			return;
		}
		if (! $this->initLink(['linkFrameSetting'])) {
			return;
		}
		$this->Categories->initCategories(true, '{n}.Category.id');

		//条件
		$conditions = $this->__setConditions();

		//取得
		$links = $this->Link->getLinks($conditions);
		$links = Hash::combine($links, '{n}.Link.id', '{n}', '{n}.Category.id');

		//Viewにセット
		$results = array(
			'links' => $links
		);
		$results = $this->camelizeKeyRecursive($results);
		$this->set($results);

		//Tokenセット
		$this->request->data = array(
			'Frame' => array(
				'id' => $this->viewVars['frameId']
			),
			'Link' => array(
				'id' => null
			),
		);
		$tokenFields = Hash::flatten($this->request->data);
		$hiddenFields = array('Frame.id');
		$this->set('tokenFields', $tokenFields);
		$this->set('hiddenFields', $hiddenFields);
	}

/**
 * view
 *
 * @return void
 */
	public function view() {
		$linkKey = null;
		if (isset($this->params['pass'][1])) {
			$linkKey = $this->params['pass'][1];
		}
		$this->set('linkKey', $linkKey);

		//データ取得
		if (! $this->__initLink(['linkFrameSetting'])) {
			return;
		}
		$this->Categories->initCategories();
	}

/**
 * Get url
 *
 * @return void
 */
	public function get() {
		$url = Hash::get($this->request->query, 'url');
		if (! $url) {
			return false;
		}
		try {
			$socket = new HttpSocket(array('request' => array('redirect' => 10)));
			$response = $socket->get($url);
			if (! $response->isOk()) {
				$this->throwBadRequest(__d('links', 'Failed to obtain the title for this page.'));
				return;
			}
		} catch (SocketException $ex) {
			CakeLog::error($ex);
			$this->throwBadRequest(__d('links', 'Failed to obtain the title for this page.'));
			return;
		}

		$results = array(
			'title' => null,
			'description' => null,
		);

		$body = $response->body;
		$pattern = '/<title>(.*)<\/title>/i';
		$matches = array();
		if (preg_match($pattern, $body, $matches)) {
			$results['title'] = mb_convert_encoding($matches[1], 'utf-8', 'auto');
		}
		$pattern = '/<meta[^"\'<>\]]*name=([\'"]?)description\\1[^"\'<>\]]*content=([\'"]?)([^"\'<>\]]*)\\2[^"\'<>\]]*>/i';
		$matches = array();
		if (preg_match($pattern, $body, $matches)) {
			$results['description'] = mb_convert_encoding($matches[3], 'utf-8', 'auto');
		}

		$this->renderJson($results);
	}

/**
 * add
 *
 * @return void
 */
	public function add() {
		$this->view = 'edit';

		//データ取得
		if (! $this->initLink()) {
			return;
		}
		$this->Categories->initCategories(false, '{n}.Category.id');

		$link = $this->Link->create(
			array(
				'id' => null,
				'key' => null,
				'block_id' => $this->viewVars['blockId'],
				'category_id' => null,
			)
		);
		$linkOrder = $this->LinkOrder->create(
			array(
				'id' => null,
				'block_key' => $this->viewVars['blockKey'],
				'link_key' => null,
			)
		);

		//POSTの場合、登録処理
		$data = array();
		if ($this->request->isPost()) {
			if (! $status = $this->NetCommonsWorkflow->parseStatus()) {
				return;
			}
			if (isset($this->viewVars['categories'][$this->data['Link']['category_id']])) {
				$category['Category'] = $this->viewVars['categories'][$this->data['Link']['category_id']]['category'];
			} else {
				$category = $this->Category->create(array('key' => null));
			}
			$data = Hash::merge(
				$this->data, array(
					'Link' => array('status' => $status),
				),
				$category
			);
			unset($data['LinkOrder']['weight']);

			$this->Link->saveLink($data);
			if ($this->handleValidationError($this->Link->validationErrors)) {
				$this->redirectByFrameId();
				return;
			}
		}

		//Viewにセット
		$data = Hash::merge(
			$link, $linkOrder, $data,
			['contentStatus' => null, 'comments' => []]
		);
		$results = $this->camelizeKeyRecursive($data);
		$this->set($results);
	}

/**
 * edit
 *
 * @return void
 */
	public function edit() {
		$linkKey = null;
		if (isset($this->params['pass'][1])) {
			$linkKey = $this->params['pass'][1];
		}
		$this->set('linkKey', $linkKey);

		//データ取得
		if (! $this->__initLink(['comments'])) {
			return;
		}
		$this->Categories->initCategories(false, '{n}.Category.id');

		//POSTの場合、登録処理
		$data = array();
		if ($this->request->isPost()) {
			if (! $status = $this->NetCommonsWorkflow->parseStatus()) {
				return;
			}

			$data = $this->data;

			$categoryId = $data['Link']['category_id'];
			$category = array();
			if (isset($this->viewVars['categories'][$categoryId])) {
				$category['Category'] = $this->viewVars['categories'][$categoryId]['category'];
			} else {
				$category = $this->Category->create(array('key' => null));
			}

			$data = Hash::merge(
				$data, $category,
				array('Link' => array(
					'status' => $status,
					'click_count' => $this->viewVars['link']['clickCount'],
					'created_user' => $this->viewVars['link']['createdUser']
				))
			);
			unset($data['Link']['id'], $data['LinkOrder']['weight']);

			$this->Link->saveLink($data);

			if ($this->handleValidationError($this->Link->validationErrors)) {
				$this->redirectByFrameId();
				return;
			}

			$data['contentStatus'] = null;
			$data['comments'] = null;
		}

		$data = Hash::merge(
			$this->viewVars, $data,
			['contentStatus' => $this->viewVars['link']['status']]
		);
		$results = $this->camelizeKeyRecursive($data);
		$this->set($results);
	}

/**
 * delete
 *
 * @return void
 */
	public function delete() {
		$linkKey = null;
		if (isset($this->params['pass'][1])) {
			$linkKey = $this->params['pass'][1];
		}
		$this->set('linkKey', $linkKey);

		//データ取得
		if (! $this->__initLink()) {
			return;
		}

		if (! $this->request->isDelete()) {
			$this->throwBadRequest();
			return;
		}

		if (! $this->Link->deleteLink($this->data)) {
			$this->throwBadRequest();
			return;
		}

		$this->redirectByFrameId();
	}

/**
 * link
 *
 * @return void
 */
	public function link() {
		$linkKey = null;
		if (isset($this->params['pass'][1])) {
			$linkKey = $this->params['pass'][1];
		}
		$this->set('linkKey', $linkKey);

		//データ取得
		if (! $this->__initLink()) {
			return;
		}

		if (! $this->request->isPost()) {
			$this->throwBadRequest();
			return;
		}

		if (! $this->Link->updateCount($this->data['Link']['id'], $this->viewVars['blockId'])) {
			$this->throwBadRequest();
			return;
		}

		$this->redirectByFrameId();
	}

/**
 * Get conditions function for getting the Link data.
 *
 * @return array Conditions data
 */
	private function __setConditions() {
		//言語の指定
		$activeConditions = array(
			'Link.is_active' => true,
		);
		$latestConditons = array();

		if ($this->viewVars['contentEditable']) {
			$activeConditions = array();
			$latestConditons = array(
				'Link.is_latest' => true,
			);
		} elseif ($this->viewVars['contentCreatable']) {
			$activeConditions = array(
				'Link.is_active' => true,
				'Link.created_user !=' => (int)$this->viewVars['userId'],
			);
			$latestConditons = array(
				'Link.is_latest' => true,
				'Link.created_user' => (int)$this->viewVars['userId'],
			);
		}

		$conditions = array(
			'Link.block_id' => $this->viewVars['blockId'],
			'OR' => array($activeConditions, $latestConditons)
		);

		return $conditions;
	}

/**
 * Function do set into view with getting the Link data.
 *
 * @param array $contains Optional result sets
 * @return bool True on success, False on failure
 */
	private function __initLink($contains = []) {
		if (! $this->initLink($contains)) {
			return false;
		}

		$conditions = $this->__setConditions();
		if (! $link = $this->Link->getLink(
			$this->viewVars['blockId'],
			$this->viewVars['linkKey'],
			$conditions
		)) {
			$this->throwBadRequest();
			return false;
		}
		$link = $this->camelizeKeyRecursive($link);
		$this->set($link);

		if (in_array('comments', $contains, true)) {
			$comments = $this->Comment->getComments(
				array(
					'plugin_key' => $this->params['plugin'],
					'content_key' => $this->viewVars['linkKey'],
				)
			);
			$comments = $this->camelizeKeyRecursive($comments);
			$this->set(['comments' => $comments]);
		}

		return true;
	}

}
