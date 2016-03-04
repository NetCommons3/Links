<?php
/**
 * View/Elements/Links/delete_formのテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');

/**
 * View/Elements/Links/delete_formのテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Links\Test\Case\View\Elements\Links\DeleteForm
 */
class LinksViewElementsLinksDeleteFormTest extends NetCommonsControllerTestCase {

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
		$this->generateNc('TestLinks.TestViewElementsLinksDeleteForm');
	}

/**
 * View/Elements/Links/delete_formのテスト
 *
 * @return void
 */
	public function testDeleteForm() {
		//テスト実行
		$this->_testGetAction('/test_links/test_view_elements_links_delete_form/delete_form',
				array('method' => 'assertNotEmpty'), null, 'view');

		//チェック
		$pattern = '/' . preg_quote('View/Elements/Links/delete_form', '/') . '/';
		$this->assertRegExp($pattern, $this->view);

		$this->assertInput('form', null, 'links/links/delete', $this->view);
		$this->assertInput('input', '_method', 'DELETE', $this->view);
		$this->assertInput('input', 'data[Block][id]', '2', $this->view);
		$this->assertInput('input', 'data[Block][key]', 'block_1', $this->view);
		$this->assertInput('input', 'data[Frame][id]', '6', $this->view);
		$this->assertInput('input', 'data[Link][id]', '2', $this->view);
		$this->assertInput('input', 'data[Link][key]', 'content_key_1', $this->view);
		$this->assertInput('input', 'data[LinkOrder][id]', '1', $this->view);
		$this->assertInput('button', 'delete', null, $this->view);
	}

}
