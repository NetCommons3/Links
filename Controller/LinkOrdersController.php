<?php
/**
 * LinkOrders Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('LinksAppController', 'Links.Controller');

/**
 * LinkOrders Controller
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Links\Controller
 */
class LinkOrdersController extends LinksAppController {

/**
 * use models
 *
 * @var array
 */
	public $uses = array(
		'Links.Link',
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
		'NetCommons.NetCommonsBlock',
		'NetCommons.NetCommonsRoomRole' => array(
			//コンテンツの権限設定
			'allowedActions' => array(
				'contentEditable' => array('edit'),
			),
		),
		'Categories.Categories',
		'Paginator',
	);

/**
 * edit
 *
 * @return void
 */
	public function edit() {
		if (! $this->initLink()) {
			return;
		}
		$this->Categories->initCategories(true);

		$this->Paginator->settings = array(
			'Link' => array(
				'order' => array('LinkOrder.weight' => 'asc'),
				'conditions' => array(
					'Link.block_id' => $this->viewVars['blockId'],
					'Link.is_latest' => true,
				),
				'limit' => -1
			)
		);
		$links = $this->Paginator->paginate('Link');
		$links = Hash::combine($links, '{n}.LinkOrder.weight', '{n}', '{n}.Category.id');

		//POST処理
		$data = array();
		if ($this->request->isPost()) {
			//登録処理
			$data = $this->data;

			$this->LinkOrder->saveLinkOrders($data);
			//validationError
			if ($this->NetCommons->handleValidationError($this->LinkOrder->validationErrors)) {
				//リダイレクト
				$this->redirect(Current::backToPageUrl());
				return;
			}
		}

		$data = Hash::merge(array('links' => $links), $data);
		$results = $this->camelizeKeyRecursive($data);
		$this->set($results);
	}

}
