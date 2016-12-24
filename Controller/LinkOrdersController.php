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
		'Links.LinkBlock',
		'Links.LinkOrder',
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
				'edit' => 'content_editable',
			),
		),
		'Categories.Categories',
	);

/**
 * edit
 *
 * @return void
 */
	public function edit() {
		$linkBlock = $this->LinkBlock->getLinkBlock();
		if (! $linkBlock) {
			return $this->throwBadRequest();
		}
		$this->set('linkBlock', $linkBlock['LinkBlock']);

		//カテゴリ
		array_unshift(
			$this->viewVars['categories'],
			Hash::merge(
				$this->Category->create(['id' => 0]),
				$this->CategoriesLanguage->create(['name' => __d('links', 'No Category')])
			)
		);

		//リンクデータ取得
		$links = $this->Link->find('all', array(
			'recursive' => 0,
			'conditions' => array(
				'Link.block_id' => Current::read('Block.id'),
				'Link.is_latest' => true,
			),
			'order' => array(
				'CategoryOrder.weight' => 'asc',
				'LinkOrder.weight' => 'asc',
			),
		));
		$this->set('links', Hash::combine($links, '{n}.LinkOrder.weight', '{n}', '{n}.Link.category_id'));

		if ($this->request->is('put')) {
			if ($this->LinkOrder->saveLinkOrders($this->data)) {
				return $this->redirect(NetCommonsUrl::backToPageUrl());
			}
			$this->NetCommons->handleValidationError($this->LinkOrder->validationErrors);

		} else {
			$this->request->data['LinkOrders'] = Hash::combine($links, '{n}.LinkOrder.id', '{n}');
			$this->request->data['Frame'] = Current::read('Frame');
			$this->request->data['Block'] = Current::read('Block');
		}
	}

}
