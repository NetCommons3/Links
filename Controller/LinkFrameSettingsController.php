<?php
/**
 * LinkFrameSettingsController Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('LinksAppController', 'Links.Controller');

/**
 * LinkFrameSettingsController Controller
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Links\Controller
 */
class LinkFrameSettingsController extends LinksAppController {

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
		'Links.LinkFrameSetting'
	);

/**
 * use components
 *
 * @var array
 */
	public $components = array(
		'NetCommons.Permission' => array(
			'allow' => array(
				'edit' => 'page_editable',
			),
		),
	);

/**
 * use helpers
 *
 * @var array
 */
	public $helpers = array(
		'Blocks.BlockForm',
		'Blocks.BlockTabs' => array(
			'mainTabs' => array('block_index', 'frame_settings'),
			'blockTabs' => array('block_settings', 'role_permissions'),
		),
	);

/**
 * edit
 *
 * @return void
 */
	public function edit() {
		if ($this->request->is('put') || $this->request->is('post')) {
			if (Hash::get($this->request->data, 'LinkFrameSetting.has_description')) {
				$this->request->data = Hash::insert(
					$this->request->data,
					'LinkFrameSetting.display_type',
					LinkFrameSetting::TYPE_LIST_WITH_DESCRIPTION
				);
			}

			if ($this->LinkFrameSetting->saveLinkFrameSetting($this->request->data)) {
				return $this->redirect(NetCommonsUrl::backToPageUrl(true));
			} else {
				return $this->throwBadRequest();
			}

		} else {
			$this->request->data = $this->LinkFrameSetting->getLinkFrameSetting(true);
			$displayType = Hash::get($this->request->data, 'LinkFrameSetting.display_type');
			if ($displayType === LinkFrameSetting::TYPE_LIST_WITH_DESCRIPTION) {
				$this->request->data = Hash::insert(
					$this->request->data, 'LinkFrameSetting.has_description', true
				);
				$this->request->data = Hash::insert(
					$this->request->data,
					'LinkFrameSetting.display_type',
					LinkFrameSetting::TYPE_LIST_ONLY_TITLE
				);
			}

			$this->request->data['Frame'] = Current::read('Frame');
		}
	}
}
