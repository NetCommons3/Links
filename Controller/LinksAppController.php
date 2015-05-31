<?php
/**
 * LinksApp Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AppController', 'Controller');

/**
 * LinksApp Controller
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Links\Controller
 */
class LinksAppController extends AppController {

/**
 * use component
 *
 * @var array
 */
	public $components = array(
		'NetCommons.NetCommonsFrame',
		'Pages.PageLayout',
		'Security',
	);

/**
 * use models
 *
 * @var array
 */
	public $uses = array(
		'Links.LinkBlock',
	);

/**
 * initLink
 *
 * @param array $contains Optional result sets
 * @return bool True on success, False on failure
 */
	public function initLink($contains = []) {
		if (! $linkBlock = $this->LinkBlock->getLinkBlock($this->viewVars['blockId'], $this->viewVars['roomId'])) {
			$this->throwBadRequest();
			return false;
		}
		$linkBlock = $this->camelizeKeyRecursive($linkBlock);
		$this->set($linkBlock);

		if (in_array('linkSetting', $contains, true)) {
			if (! $linkSetting = $this->LinkSetting->getLinkSetting($linkBlock['linkBlock']['key'])) {
				$linkSetting = $this->LinkSetting->create(
					array('id' => null)
				);
			}
			$linkSetting = $this->camelizeKeyRecursive($linkSetting);
			$this->set($linkSetting);
		}

		if (in_array('linkFrameSetting', $contains, true)) {
			if (! $linkFrameSetting = $this->LinkFrameSetting->getLinkFrameSetting($this->viewVars['frameKey'])) {
				$linkFrameSetting = $this->LinkFrameSetting->create(array(
					'id' => null,
					'display_type' => LinkFrameSetting::TYPE_DROPDOWN,
					'category_separator_line' => LinkFrameSetting::CATEGORY_SEPARATOR_DEFAULT,
					'list_style' => LinkFrameSetting::LINE_STYLE_DISC,
				));
			}

			//カテゴリ間の区切り線
			$separatorLine = $linkFrameSetting['LinkFrameSetting']['category_separator_line'];
			$linkFrameSetting['LinkFrameSetting']['category_separator_line_css'] =
					$this->LinkFrameSetting->getCategorySeparatorLineCss($separatorLine);

			//リストマーク
			$listStyle = $linkFrameSetting['LinkFrameSetting']['list_style'];
			$linkFrameSetting['LinkFrameSetting']['list_style_css'] = $this->LinkFrameSetting->getLineStyleCss($listStyle);

			$linkFrameSetting = $this->camelizeKeyRecursive($linkFrameSetting);
			$this->set($linkFrameSetting);
		}

		$this->set('userId', (int)$this->Auth->user('id'));

		return true;
	}

/**
 * initTabs
 *
 * @param string $mainActiveTab Main active tab
 * @param string $blockActiveTab Block active tab
 * @return void
 */
	public function initTabs($mainActiveTab, $blockActiveTab) {
		if (isset($this->params['pass'][1])) {
			$blockId = (int)$this->params['pass'][1];
		} else {
			$blockId = null;
		}

		//タブの設定
		$settingTabs = array(
			'tabs' => array(
				'block_index' => array(
					'url' => array(
						'plugin' => $this->params['plugin'],
						'controller' => 'link_blocks',
						'action' => 'index',
						$this->viewVars['frameId'],
					)
				),
				'frame_settings' => array(
					'url' => array(
						'plugin' => $this->params['plugin'],
						'controller' => 'link_frame_settings',
						'action' => 'edit',
						$this->viewVars['frameId'],
					)
				),
			),
			'active' => $mainActiveTab
		);
		$this->set('settingTabs', $settingTabs);

		$blockSettingTabs = array(
			'tabs' => array(
				'block_settings' => array(
					'url' => array(
						'plugin' => $this->params['plugin'],
						'controller' => 'link_blocks',
						'action' => $this->params['action'],
						$this->viewVars['frameId'],
						$blockId
					)
				),
				'role_permissions' => array(
					'url' => array(
						'plugin' => $this->params['plugin'],
						'controller' => 'link_block_role_permissions',
						'action' => 'edit',
						$this->viewVars['frameId'],
						$blockId
					)
				),
			),
			'active' => $blockActiveTab
		);
		$this->set('blockSettingTabs', $blockSettingTabs);
	}

}
