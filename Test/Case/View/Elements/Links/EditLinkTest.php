<?php
/**
 * View/Elements/Links/edit_linkのテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');

/**
 * View/Elements/Links/edit_linkのテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Links\Test\Case\View\Elements\Links\EditLink
 */
class LinksViewElementsLinksEditLinkTest extends NetCommonsControllerTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.links.link',
	);

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
		$this->generateNc('TestLinks.TestViewElementsLinksEditLink');
	}

/**
 * View/Elements/Links/edit_linkのテスト
 *
 * @return void
 */
	public function testEditLink() {
		//ログイン
		TestAuthGeneral::login($this);

		//テスト実行
		$this->_testGetAction('/test_links/test_view_elements_links_edit_link/edit_link/2?frame_id=6',
				array('method' => 'assertNotEmpty'), null, 'view');

		//ログアウト
		TestAuthGeneral::logout($this);

		//チェック
		$pattern = '/' . preg_quote('View/Elements/Links/edit_link', '/') . '/';
		$this->assertRegExp($pattern, $this->view);
		$this->assertTextContains('glyphicon-edit', $this->view);
	}

/**
 * View/Elements/Links/edit_linkのテスト
 *
 * @return void
 */
	public function testEditLinkNotCanEdit() {
		//テスト実行
		$this->_testGetAction('/test_links/test_view_elements_links_edit_link/edit_link/2?frame_id=6',
				array('method' => 'assertNotEmpty'), null, 'view');

		//チェック
		$pattern = '/' . preg_quote('View/Elements/Links/edit_link', '/') . '/';
		$this->assertRegExp($pattern, $this->view);
		$this->assertTextNotContains('glyphicon-edit', $this->view);
	}

}
