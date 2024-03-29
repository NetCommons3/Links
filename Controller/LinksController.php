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
		'Categories.CategoriesLanguage',
	);

/**
 * use component
 *
 * @var array
 */
	public $components = array(
		'NetCommons.Permission' => array(
			'allow' => array(
				'get,add,edit,delete' => 'content_creatable',
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
		$this->Auth->allow('link');

		if (! Current::read('Block.id')) {
			return $this->setAction('emptyRender');
		}
		$this->LinkBlock->unbindModel(['belongsTo' => ['TrackableCreator', 'TrackableUpdater']], true);
		$linkBlock = $this->LinkBlock->getLinkBlock([
			'LinkBlock.id',
			'LinkBlock.room_id',
			'LinkBlock.plugin_key',
			'LinkBlock.key',
			'LinkBlock.public_type',
			'LinkBlock.publish_start',
			'LinkBlock.publish_end',
			'LinkBlock.content_count',
			'name'
		]);
		if (! $linkBlock) {
			return $this->setAction('throwBadRequest');
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
			return $this->throwBadRequest();
		}
		$this->set('linkFrameSetting', $linkFrameSetting['LinkFrameSetting']);

		//カテゴリ
		array_unshift($this->viewVars['categories'], (
			$this->Category->create(['id' => 0])
			+ $this->CategoriesLanguage->create(['name' => ''])
		));

		//取得
		$this->Link->unbindModel(['belongsTo' => ['TrackableCreator', 'TrackableUpdater']], true);
		$results = $this->Link->getWorkflowContents('all', array(
			'recursive' => 0,
			'fields' => [
				'Link.id',
				'Link.block_id',
				'Link.category_id',
				'Link.language_id',
				'Link.key',
				'Link.status',
				'Link.url',
				'Link.title',
				'Link.description',
				'Link.click_count',
			],
			'conditions' => array(
				'Link.block_id' => Current::read('Block.id'),
			),
			'order' => array(
				'CategoryOrder.weight' => 'asc',
				'LinkOrder.weight' => 'asc',
			),
		));
		$links = [];
		foreach ($results as $link) {
			$categoryId = (int)$link['Link']['category_id'];
			$linkId = $link['Link']['id'];
			$links[$categoryId][$linkId] = $link;
		}
		$this->set('links', $links);
	}

/**
 * view
 *
 * @return void
 */
	public function view() {
		$linkFrameSetting = $this->LinkFrameSetting->getLinkFrameSetting(true);
		$this->set('linkFrameSetting', $linkFrameSetting['LinkFrameSetting']);

		$link = $this->Link->getWorkflowContents('first', array(
			'recursive' => 0,
			'conditions' => array(
				$this->Link->alias . '.block_id' => Current::read('Block.id'),
				$this->Link->alias . '.key' => $this->params['key']
			)
		));
		if (! $link) {
			return $this->throwBadRequest();
		}
		$this->set('link', $link);

		$categoryId = isset($link['Link']['category_id'])
			? $link['Link']['category_id']
			: null;
		$category = Hash::extract(
			$this->viewVars['categories'],
			'{n}.Category[id=' . $categoryId . ']'
		);
		$category = isset($category[0])
			? $category[0]
			: [];
		$this->set('category', $category);

		//if (! $this->Link->updateCount($link['Link']['id'])) {
		//	return $this->throwBadRequest();
		//}

		//新着データを既読にする
		$this->Link->saveTopicUserStatus($link);
	}

/**
 * Get url
 *
 * @return void
 * @throws SocketException
 */
	public function get() {
		$url = isset($this->request->query['url'])
			? $this->request->query['url']
			: null;
		if (! $url || $url === 'http://') {
			return $this->throwBadRequest(
				sprintf(__d('net_commons', 'Please input %s.'), __d('links', 'URL'))
			);
		}
		try {
			$socket = new HttpSocket(array('request' => array('redirect' => 10)));
			$response = $socket->get($url);
			if (! $response->isOk()) {
				throw new SocketException(__d('links', 'Failed to obtain the title for this page.'));
			}
		} catch (SocketException $ex) {
			CakeLog::error($ex);
			return $this->throwBadRequest(__d('links', 'Failed to obtain the title for this page.'));
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
		$pattern = '<meta[^"\'<>\]]*' .
						'name=([\'"]?)' .
						'description\\1[^"\'<>\]]*' .
						'content=([\'"]?)([^"\'<>\]]*)\\2[^"\'<>\]]*>';
		$matches = array();
		if (preg_match('/' . $pattern . '/i', $body, $matches)) {
			$results['description'] = mb_convert_encoding($matches[3], 'utf-8', 'auto');
		} else {
			$results['description'] = '';
		}

		if ($results['title']) {
			$this->NetCommons->renderJson($results);
		} else {
			return $this->throwBadRequest(__d('links', 'Failed to obtain the title for this page.'));
		}
	}

/**
 * add
 *
 * @return void
 */
	public function add() {
		$this->view = 'edit';

		if ($this->request->is('post')) {
			//登録処理
			$data = $this->data;
			$data['Link']['status'] = $this->Workflow->parseStatus();
			$categoryId = isset($data['Link']['category_id'])
				? $data['Link']['category_id']
				: null;
			$category = Hash::extract(
				$this->viewVars['categories'],
				'{n}.Category[id=' . $categoryId . ']'
			);
			$data['LinkOrder']['category_key'] = isset($category[0]['key'])
				? $category[0]['key']
				: '';
			unset($data['Link']['id'], $data['LinkOrder']['weight']);

			if ($this->Link->saveLink($data)) {
				return $this->redirect(NetCommonsUrl::backToPageUrl());
			}
			$this->NetCommons->handleValidationError($this->Link->validationErrors);

		} else {
			$this->request->data += $this->Link->create(array(
					'url' => 'http://'
				));
			$this->request->data += $this->LinkOrder->create();
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
		$linkKey = $this->params['key'];
		if ($this->request->is('put')) {
			$linkKey = $this->data['Link']['key'];
		}
		$link = $this->Link->getWorkflowContents('first', array(
			'recursive' => 0,
			'conditions' => array(
				$this->Link->alias . '.block_id' => Current::read('Block.id'),
				$this->Link->alias . '.key' => $linkKey
			)
		));
		if (empty($link)) {
			return $this->throwBadRequest();
		}

		//編集権限チェック
		if (! $this->Link->canEditWorkflowContent($link)) {
			return $this->throwBadRequest();
		}

		if ($this->request->is('put')) {
			//登録処理
			$data = $this->data;
			$data['Link']['status'] = $this->Workflow->parseStatus();
			$categoryId = isset($data['Link']['category_id'])
				? $data['Link']['category_id']
				: null;
			$category = Hash::extract(
				$this->viewVars['categories'],
				'{n}.Category[id=' . $categoryId . ']'
			);
			$data['LinkOrder']['category_key'] = isset($category[0]['key'])
				? $category[0]['key']
				: '';
			unset($data['Link']['id']);

			if ($this->Link->saveLink($data)) {
				return $this->redirect(NetCommonsUrl::backToPageUrl());
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
		if (! $this->request->is('delete')) {
			return $this->throwBadRequest();
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
			return $this->throwBadRequest();
		}

		if (! $this->Link->deleteLink($this->data)) {
			return $this->throwBadRequest();
		}

		$this->redirect(NetCommonsUrl::backToPageUrl());
	}

/**
 * link
 *
 * @return void
 */
	public function link() {
		if (! $this->request->is('put')) {
			return $this->throwBadRequest();
		}

		$link = $this->Link->getWorkflowContents('first', array(
			'recursive' => -1,
			'conditions' => array(
				$this->Link->alias . '.block_id' => Current::read('Block.id'),
				$this->Link->alias . '.id' => Hash::get($this->data, 'Link.id')
			)
		));
		if (! $link) {
			return $this->throwBadRequest();
		}

		if (! $this->Link->updateCount($this->data['Link']['id'])) {
			return $this->throwBadRequest();
		}

		$this->NetCommons->renderJson();
	}
}
