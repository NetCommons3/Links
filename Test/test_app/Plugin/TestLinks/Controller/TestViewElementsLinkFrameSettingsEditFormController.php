<?php
/**
 * View/Elements/LinkFrameSettings/edit_formテスト用Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AppController', 'Controller');

/**
 * View/Elements/LinkFrameSettings/edit_formテスト用Controller
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Links\Test\test_app\Plugin\TestLinks\Controller
 */
class TestViewElementsLinkFrameSettingsEditFormController extends AppController {

/**
 * edit_form
 *
 * @return void
 */
	public function edit_form() {
		$this->autoRender = true;

		$this->request->data = array(
			'LinkFrameSetting' => array(
				'id' => '6',
				'frame_key' => 'frame_3',
				'display_type' => '3',
				'open_new_tab' => true,
				'display_click_count' => true,
				'category_separator_line' => 'line_a2.gif',
				'list_style' => 'mark_a1.gif',
				'category_separator_line_css' => 'background-image: url(/links/img/line/line_a2.gif); border-image: url(/links/img/line/line_a2.gif); height: 5px;',
				'list_style_css' => 'list-style-type: none; list-style-image: url(/links/img/mark/mark_a1.gif); '
			),
			'Frame' => array(
				'id' => '6',
				'language_id' => '2',
				'room_id' => '2',
				'box_id' => '3',
				'plugin_key' => 'links',
				'block_id' => '2',
				'key' => 'frame_3',
				'name' => 'Test frame main',
				'weight' => '1',
				'is_deleted' => '0',
			)
		);
	}

}
