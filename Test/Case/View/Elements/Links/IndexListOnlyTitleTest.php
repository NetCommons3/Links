<?php
/**
 * View/Elements/Links/index_list_only_titleのテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');

/**
 * View/Elements/Links/index_list_only_titleのテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Links\Test\Case\View\Elements\Links\IndexListOnlyTitle
 */
class LinksViewElementsLinksIndexListOnlyTitleTest extends NetCommonsControllerTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.categories.category',
		'plugin.categories.category_order',
		'plugin.links.link',
		'plugin.links.link_frame_setting',
		'plugin.links.link_order',
		'plugin.links.link_setting',
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
		$this->generateNc('TestLinks.TestViewElementsLinksIndexListOnlyTitle');
		//ログイン
		TestAuthGeneral::login($this);
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		//ログアウト
		TestAuthGeneral::logout($this);
		parent::tearDown();
	}

/**
 * View/Elements/Links/index_list_only_titleのテスト
 *
 * @return void
 */
	public function testIndexListOnlyTitle() {
		//テスト実行
		$this->_testGetAction('/test_links/test_view_elements_links_index_list_only_title/index_list_only_title/2?frame_id=6',
				array('method' => 'assertNotEmpty'), null, 'view');

		//チェック
		$pattern = '/' . preg_quote('View/Elements/Links/index_list_only_title', '/') . '/';
		$this->assertRegExp($pattern, $this->view);

		$this->assertTextContains('<ul class="list-group"', $this->view);
		$this->assertTextContains('/links/img/line/line_a2.gif', $this->view);
		$this->assertTextContains('/links/img/mark/mark_a1.gif', $this->view);

		$this->assertTextContains('Category 1', $this->view);
		$this->assertTextContains('Title 2', $this->view);
		$this->assertTextContains('Title 3', $this->view);
		$this->assertTextContains('Title 5', $this->view);
		$this->assertTextContains('Title 7', $this->view);
		$this->assertTextContains('Title 8', $this->view);

		$this->assertTextNotContains('Description 2', $this->view);
		$this->assertTextNotContains('Description 3', $this->view);
		$this->assertTextNotContains('Description 5', $this->view);
		$this->assertTextNotContains('Description 7', $this->view);
		$this->assertTextNotContains('Description 8', $this->view);

		$this->assertTextContains('nc-badge-6-2', $this->view);
		$this->assertTextContains('nc-badge-6-3', $this->view);
		$this->assertTextContains('nc-badge-6-5', $this->view);
		$this->assertTextContains('nc-badge-6-7', $this->view);
		$this->assertTextContains('nc-badge-6-8', $this->view);
	}

}
