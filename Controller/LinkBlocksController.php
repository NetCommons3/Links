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
class LinkBlocksController extends LinksAppController {

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
		'Links.LinkBlock',
	);

/**
 * use components
 *
 * @var array
 */
	public $components = array(
		'Categories.CategoryEdit',
		'NetCommons.Permission' => array(
			'allow' => array(
				'index,add,edit,delete' => 'block_editable',
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
		'Blocks.BlockForm',
		'Blocks.BlockIndex',
		'Blocks.BlockTabs' => array(
			'mainTabs' => array('block_index', 'frame_settings'),
			'blockTabs' => array('block_settings', 'mail_settings', 'role_permissions'),
		),
	);

/**
 * beforeFilter
 *
 * @return void
 */
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->deny('index');

		//CategoryEditComponentの削除
		if ($this->params['action'] === 'index') {
			$this->Components->unload('Categories.CategoryEdit');
		}
	}

/**
 * index
 *
 * @return void
 */
	public function index() {
		$this->Paginator->settings = array(
			'LinkBlock' => array(
				'order' => array('Block.id' => 'desc'),
				'conditions' => $this->LinkBlock->getBlockConditions(),
			)
		);

		$linkBlocks = $this->Paginator->paginate('LinkBlock');
		if (! $linkBlocks) {
			$this->view = 'Blocks.Blocks/not_found';
			return;
		}
		$this->set('linkBlocks', $linkBlocks);
		$this->request->data['Frame'] = Current::read('Frame');
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
			if ($this->LinkBlock->saveLinkBlock($this->data)) {
				return $this->redirect(NetCommonsUrl::backToIndexUrl('default_setting_action'));
			}
			$this->NetCommons->handleValidationError($this->LinkBlock->validationErrors);

		} else {
			//表示処理(初期データセット)
			$this->request->data = $this->LinkBlock->createLinkBlock();
			$this->request->data['Frame'] = Current::read('Frame');
		}
	}

/**
 * edit
 *
 * @return void
 */
	public function edit() {
		if ($this->request->is('put')) {
			//登録処理
			if ($this->LinkBlock->saveLinkBlock($this->data)) {
				return $this->redirect(NetCommonsUrl::backToIndexUrl('default_setting_action'));
			}
			$this->NetCommons->handleValidationError($this->LinkBlock->validationErrors);

		} else {
			//表示処理(初期データセット)
			$linkBlock = $this->LinkBlock->getLinkBlock();
			if (! $linkBlock) {
				return $this->throwBadRequest();
			}
			$this->request->data = Hash::merge($this->request->data, $linkBlock);
			$this->request->data['Frame'] = Current::read('Frame');
		}
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
		if (! $this->LinkBlock->deleteLinkBlock($this->data)) {
			return $this->throwBadRequest();
		}

		$this->redirect(NetCommonsUrl::backToIndexUrl('default_setting_action'));
	}
}
