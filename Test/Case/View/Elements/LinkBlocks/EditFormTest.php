<?php
/**
 * View/Elements/LinkBlocks/edit_formのテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');

/**
 * View/Elements/LinkBlocks/edit_formのテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Links\Test\Case\View\Elements\LinkBlocks\EditForm
 */
class LinksViewElementsLinkBlocksEditFormTest extends NetCommonsControllerTestCase {

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
		$this->generateNc('TestLinks.TestViewElementsLinkBlocksEditForm');
	}

/**
 * View/Elements/LinkBlocks/edit_formのテスト
 *
 * @return void
 */
	public function testEditForm() {
		//テスト実行
		$this->_testGetAction('/test_links/test_view_elements_link_blocks_edit_form/edit_form',
				array('method' => 'assertNotEmpty'), null, 'view');

		//チェック
		$pattern = '/' . preg_quote('View/Elements/LinkBlocks/edit_form', '/') . '/';
		$this->assertRegExp($pattern, $this->view);

		$this->assertInput('input', 'data[LinkSetting][id]', '1', $this->view);
		$this->assertInput('input', 'data[LinkSetting][block_key]', 'block_1', $this->view);
		$this->assertInput('input', 'data[LinkBlock][name]', 'Block name 1', $this->view);

		//$this->element('Blocks.form_hidden')のチェック
		//⇒ここでは、呼ばれているかどうかのチェックのみ
		$this->assertInput('input', 'data[Frame][id]', '6', $this->view);
		$this->assertInput('input', 'data[Block][id]', '2', $this->view);
		$this->assertInput('input', 'data[Block][key]', 'block_1', $this->view);

		//$this->element('Blocks.public_type')のチェック
		//⇒ここでは、呼ばれているかどうかのチェックのみ
		$this->assertInput('input', 'data[Block][public_type]', '0', $this->view);

		//$this->element('Categories.edit_form')のチェック
		//⇒ここでは、呼ばれているかどうかのチェックのみ
		$this->assertTextContains('ng-controller="Categories"', $this->view);
	}

}
