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
		'Links.Link',
		'Links.LinkBlock',
		'Links.LinkOrder',
		'Links.LinkFrameSetting',
		'Categories.Category',
	);

/**
 * use component
 *
 * @var array
 */
	public $components = array(
		'NetCommons.Permission' => array(
			'allow' => array(
				'link,add,edit,delete' => 'content_creatable',
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
		'NetCommons.Token',
		'Workflow.Workflow',
	);

/**
 * beforeFilter
 *
 * @return void
 */
	public function beforeFilter() {
		parent::beforeFilter();

		if (! Current::read('Block.id')) {
			$this->setAction('emptyRender');
			return false;
		}

		$linkBlock = $this->LinkBlock->getLinkBlock();
		if (! $linkBlock) {
			$this->setAction('throwBadRequest');
			return false;
		}
		$this->set('linkBlock', $linkBlock['LinkBlock']);
	}

/**
 * index
 *
 * @return void
 */
	public function index() {
		$linkFrameSetting = $this->LinkFrameSetting->getLinkFrameSetting(true);
		if (! $linkFrameSetting) {
			$this->throwBadRequest();
			return;
		}
		$this->set('linkFrameSetting', $linkFrameSetting['LinkFrameSetting']);

		//カテゴリ
		array_unshift($this->viewVars['categories'], $this->Category->create(array('id' => 0)));

		//取得
		$links = $this->Link->getWorkflowContents('all', array(
			'recursive' => 0,
			'conditions' => array(
				'Link.block_id' => Current::read('Block.id'),
			),
			'order' => array(
				'CategoryOrder.weight' => 'asc',
				'LinkOrder.weight' => 'asc',
			),
		));
		$this->set('links', Hash::combine($links, '{n}.Link.id', '{n}', '{n}.Category.id'));
	}

/**
 * view
 *
 * @return void
 */
	public function view() {
		$link = $this->Link->getWorkflowContents('first', array(
			'recursive' => -1,
			'conditions' => array(
				$this->Link->alias . '.block_id' => Current::read('Block.id'),
				$this->Link->alias . '.key' => Hash::get($this->params['pass'], '1')
			)
		));
		if (! $link) {
			$this->throwBadRequest();
			return;
		}
		$this->set('link', $link);

		$category = Hash::extract(
			$this->viewVars['categories'],
			'{n}.Category[id=' . $link['Link']['category_id'] . ']'
		);
		$this->set('category', Hash::get($category, '0', array()));

		if (! $this->Link->updateCount($link['Link']['id'])) {
			$this->throwBadRequest();
			return;
		}
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

		$this->NetCommons->renderJson($results);
	}

/**
 * add
 *
 * @return void
 */
	public function add() {
		$this->view = 'edit';

		if ($this->request->isPost()) {
			//登録処理
			$data = $this->data;
			$data['Link']['status'] = $this->Workflow->parseStatus();
			$category = Hash::extract(
				$this->viewVars['categories'],
				'{n}.Category[id=' . Hash::get($data, 'Link.category_id', '') . ']'
			);
			$data['LinkOrder']['category_key'] = Hash::get($category, '0.key', '');
			unset($data['Link']['id'], $data['LinkOrder']['weight']);

			if ($this->Link->saveLink($data)) {
				$this->redirect(NetCommonsUrl::backToPageUrl());
				return;
			}
			$this->NetCommons->handleValidationError($this->Link->validationErrors);

		} else {
			$this->request->data = Hash::merge($this->request->data,
				$this->Link->create(),
				$this->LinkOrder->create()
			);
			$this->request->data['Frame'] = Current::read('Frame');
			$this->request->data['Block'] = Current::read('Block');
		}
	}

/**
 * edit
 *
 * @return void
 */
	public function edit() {
		//データ取得
		$linkKey = $this->params['pass'][1];
		if ($this->request->isPut()) {
			$linkKey = $this->data['Link']['key'];
		}
		$link = $this->Link->getWorkflowContents('first', array(
			'recursive' => 0,
			'conditions' => array(
				$this->Link->alias . '.block_id' => Current::read('Block.id'),
				$this->Link->alias . '.key' => $linkKey
			)
		));

		//編集権限チェック
		if (! $this->Link->canEditWorkflowContent($link)) {
			$this->throwBadRequest();
			return false;
		}

		if ($this->request->isPut()) {
			//登録処理
			$data = $this->data;
			$data['Link']['status'] = $this->Workflow->parseStatus();
			$category = Hash::extract(
				$this->viewVars['categories'],
				'{n}.Category[id=' . Hash::get($data, 'Link.category_id', '') . ']'
			);
			$data['LinkOrder']['category_key'] = Hash::get($category, '0.key', '');
			unset($data['Link']['id']);

			if ($this->Link->saveLink($data)) {
				$this->redirect(NetCommonsUrl::backToPageUrl());
				return;
			}
			$this->NetCommons->handleValidationError($this->Link->validationErrors);

		} else {
			$this->request->data = $link;
			$this->request->data['Frame'] = Current::read('Frame');
			$this->request->data['Block'] = Current::read('Block');
		}

		//コメント取得
		$comments = $this->Link->getCommentsByContentKey($linkKey);
		$this->set('comments', $comments);
	}

/**
 * delete
 *
 * @return void
 */
	public function delete() {
		if (! $this->request->isDelete()) {
			$this->throwBadRequest();
			return;
		}

		//データ取得
		$link = $this->Link->getWorkflowContents('first', array(
			'recursive' => -1,
			'conditions' => array(
				$this->Link->alias . '.block_id' => Current::read('Block.id'),
				$this->Link->alias . '.key' => $this->data['Link']['key']
			)
		));

		//削除権限チェック
		if (! $this->Link->canDeleteWorkflowContent($link)) {
			$this->throwBadRequest();
			return false;
		}

		if (! $this->Link->deleteLink($this->data)) {
			$this->throwBadRequest();
			return;
		}

		$this->redirect(NetCommonsUrl::backToPageUrl());
	}

/**
 * link
 *
 * @return void
 */
	public function link() {
		if (! $this->request->isPost()) {
			$this->throwBadRequest();
			return;
		}

		$link = $this->Link->getWorkflowContents('first', array(
			'recursive' => -1,
			'conditions' => array(
				$this->Link->alias . '.block_id' => Current::read('Block.id'),
				$this->Link->alias . '.id' => Hash::get($this->data, 'Link.id')
			)
		));
		if (! $link) {
			$this->throwBadRequest();
			return;
		}

		if (! $this->Link->updateCount($this->data['Link']['id'])) {
			$this->throwBadRequest();
			return;
		}

		$this->redirect(NetCommonsUrl::backToPageUrl());
	}
}
