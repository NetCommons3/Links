<?php
/**
 * View/Elements/LinkFrameSettings/edit_formのテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');

/**
 * View/Elements/LinkFrameSettings/edit_formのテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Links\Test\Case\View\Elements\LinkFrameSettings\EditForm
 */
class LinksViewElementsLinkFrameSettingsEditFormTest extends NetCommonsControllerTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array();

/**
 * Plugin name
 *
 * @var string
 */
	public $plugin = 'links';

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		//テストプラグインのロード
		NetCommonsCakeTestCase::loadTestPlugin($this, 'Links', 'TestLinks');
		//テストコントローラ生成
		$this->generateNc('TestLinks.TestViewElementsLinkFrameSettingsEditForm');
	}

/**
 * View/Elements/LinkFrameSettings/edit_formのテスト
 *
 * @return void
 */
	public function testEditForm() {
		//テスト実行
		$this->_testGetAction('/test_links/test_view_elements_link_frame_settings_edit_form/edit_form',
				array('method' => 'assertNotEmpty'), null, 'view');

		//チェック
		$pattern = '/' . preg_quote('View/Elements/LinkFrameSettings/edit_form', '/') . '/';
		$this->assertRegExp($pattern, $this->view);

		$this->assertInput('input', 'data[LinkFrameSetting][id]', '6', $this->view);
		$this->assertInput('input', 'data[LinkFrameSetting][frame_key]', 'frame_3', $this->view);
		$this->assertInput('input', 'data[Frame][id]', '6', $this->view);
		$this->assertInput('input', 'data[Frame][key]', 'frame_3', $this->view);
		$this->assertInput('radio', 'data[LinkFrameSetting][display_type]', '2', $this->view);
		$this->assertInput('checkbox', 'data[LinkFrameSetting][has_description]', '1', $this->view);
		$this->assertInput('input', 'data[LinkFrameSetting][open_new_tab]', '0', $this->view);
		$this->assertInput('input', 'data[LinkFrameSetting][open_new_tab]', '1', $this->view);
		$this->assertInput('input', 'data[LinkFrameSetting][display_click_count]', '0', $this->view);
		$this->assertInput('input', 'data[LinkFrameSetting][display_click_count]', '1', $this->view);
		$this->assertInput('input', 'data[LinkFrameSetting][category_separator_line]', 'line_a2.gif', $this->view);
		$this->assertInput('input', 'data[LinkFrameSetting][list_style]', 'mark_a1.gif', $this->view);
	}

}
