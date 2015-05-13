<?php
/**
 * BlocksController
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('LinksAppController', 'Links.Controller');

/**
 * BlocksController
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Links\Controller
 */
class BlocksController extends LinksAppController {

/**
 * layout
 *
 * @var array
 */
	public $layout = 'NetCommons.setting';

/**
 * use models
 *
 * @var array
 */
	public $uses = array(
		'Blocks.Block',
		'Frames.Frame',
		'Links.LinkSetting',
		'Categories.Category',
	);

/**
 * use components
 *
 * @var array
 */
	public $components = array(
		'NetCommons.NetCommonsFrame',
		'NetCommons.NetCommonsBlock',
		'NetCommons.NetCommonsRoomRole' => array(
			//コンテンツの権限設定
			'allowedActions' => array(
				'blockEditable' => array('index', 'add', 'edit', 'delete')
			),
		),
		'Paginator',
		'Categories.Categories',
	);

/**
 * use helpers
 *
 * @var array
 */
	public $helpers = array(
		'NetCommons.Date',
	);

/**
 * beforeFilter
 *
 * @return void
 */
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->deny('index');

		$results = $this->camelizeKeyRecursive($this->NetCommonsFrame->data);
		$this->set($results);

		//タブの設定
		$this->initTabs('block_index', 'block_settings');
	}

/**
 * index
 *
 * @return void
 * @throws Exception
 */
	public function index() {
		$this->Paginator->settings = array(
			'LinkBlock' => array(
				'order' => array('Block.id' => 'desc'),
				'conditions' => array(
					'Block.language_id' => $this->viewVars['languageId'],
					'Block.room_id' => $this->viewVars['roomId'],
					'Block.plugin_key ' => $this->params['plugin'],
				),
				//'limit' => 1
			)
		);
		try {
			$linkBlocks = $this->Paginator->paginate('LinkBlock');
		} catch (Exception $ex) {
			if (isset($this->request['paging']) && $this->params['named']) {
				$this->redirect('/links/blocks/index/' . $this->viewVars['frameId']);
				return;
			}
			CakeLog::error($ex);
			throw $ex;
		}
		if (! $linkBlocks) {
			$this->view = 'Blocks/not_found';
			return;
		}

		$results = array(
			'linkBlocks' => $linkBlocks
		);
		$results = $this->camelizeKeyRecursive($results);
		$this->set($results);
	}

/**
 * add
 *
 * @return void
 */
	public function add() {
		$this->view = 'Blocks/edit';

		$this->set('blockId', null);
		$block = $this->Block->create(
			array(
				'id' => null,
				'key' => null,
				'name' => __d('links', 'New Bookmark List %s', date('YmdHis')),
			)
		);

		$data = array();
		if ($this->request->isPost()) {
			$data = $this->__parseRequestData();

			$this->LinkBlock->saveLinkBlock($data);
			if ($this->handleValidationError($this->LinkBlock->validationErrors)) {
				if (! $this->request->is('ajax')) {
					$this->redirect('/links/blocks/index/' . $this->viewVars['frameId']);
				}
				return;
			}
			$data['Block']['id'] = null;
			$data['Block']['key'] = null;
			unset($data['Frame']);
		}

		$results = $this->camelizeKeyRecursive(Hash::merge($block, $data));
		$this->set($results);
	}

/**
 * edit
 *
 * @return void
 */
	public function edit() {
		if (! $this->NetCommonsBlock->validateBlockId()) {
			$this->throwBadRequest();
			return false;
		}
		$this->set('blockId', (int)$this->params['pass'][1]);

		if (! $this->initLink(['linkSetting'])) {
			return;
		}
		$this->Categories->initCategories();

		if ($this->request->isPost()) {
			$data = $this->__parseRequestData();
			$data['LinkSetting']['block_key'] = $data['Block']['key'];

			$this->LinkBlock->saveLinkBlock($data);
			if ($this->handleValidationError($this->LinkBlock->validationErrors)) {
				if (! $this->request->is('ajax')) {
					$this->redirect('/links/blocks/index/' . $this->viewVars['frameId']);
				}
				return;
			}
			unset($data['Frame']);

			$results = $this->camelizeKeyRecursive($data);
			$this->set($results);
		}
	}

/**
 * delete
 *
 * @return void
 */
	public function delete() {
		if (! $this->NetCommonsBlock->validateBlockId()) {
			$this->throwBadRequest();
			return false;
		}
		$this->set('blockId', (int)$this->params['pass'][1]);

		if (! $this->initLink()) {
			return;
		}

		if ($this->request->isDelete()) {
			if ($this->LinkBlock->deleteLinkBlock($this->data)) {
				if (! $this->request->is('ajax')) {
					$this->redirect('/links/blocks/index/' . $this->viewVars['frameId']);
				}
				return;
			}
		}

		$this->throwBadRequest();
	}

/**
 * Parse data from request
 *
 * @return array
 */
	private function __parseRequestData() {
		$data = $this->data;
		if ($data['Block']['public_type'] === Block::TYPE_LIMITED) {
			//$data['Block']['from'] = implode('-', $data['Block']['from']);
			//$data['Block']['to'] = implode('-', $data['Block']['to']);
		} else {
			unset($data['Block']['from'], $data['Block']['to']);
		}

		return $data;
	}

}
