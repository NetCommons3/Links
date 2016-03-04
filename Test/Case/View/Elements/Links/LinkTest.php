<?php
/**
 * View/Elements/Links/linkのテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');

/**
 * View/Elements/Links/linkのテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Links\Test\Case\View\Elements\Links\Link
 */
class LinksViewElementsLinksLinkTest extends NetCommonsControllerTestCase {

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
		$this->generateNc('TestLinks.TestViewElementsLinksLink');
	}

/**
 * View/Elements/Links/linkのテスト
 * [ステータス表示なし、新しいタブで表示、クリック数表示]
 *
 * @return void
 */
	public function testLinkWOStatusWNewTabWClickCount() {
		//テスト実行
		$contentKey = 'content_key_1';
		$this->_testGetAction('/test_links/test_view_elements_links_link/link/2/' . $contentKey . '?frame_id=6',
				array('method' => 'assertNotEmpty'), null, 'view');

		//チェック
		$this->__assertView($contentKey, false, true, true);
	}

/**
 * View/Elements/Links/linkのテスト
 * [ステータス表示なし、新しいタブで表示、クリック数表示]
 *
 * @return void
 */
	public function testLinkWStatusWNewTabWClickCount() {
		//テスト実行
		$contentKey = 'content_key_2';
		$this->_testGetAction('/test_links/test_view_elements_links_link/link/2/' . $contentKey . '?frame_id=6',
				array('method' => 'assertNotEmpty'), null, 'view');

		//チェック
		$this->__assertView($contentKey, true, true, true);
	}

/**
 * View/Elements/Links/linkのテスト
 * [ステータス表示なし、新しいタブで表示なし、クリック数表示あり]
 *
 * @return void
 */
	public function testLinkWOStatusWONewTabWClickCount() {
		//テスト実行
		$contentKey = 'content_key_1';
		$this->_testGetAction('/test_links/test_view_elements_links_link/link_without_new_tab/2/' . $contentKey . '?frame_id=6',
				array('method' => 'assertNotEmpty'), null, 'view');

		//チェック
		$this->__assertView($contentKey, false, false, true);
	}

/**
 * View/Elements/Links/linkのテスト
 * [ステータス表示なし、新しいタブで表示、クリック数表示なし]
 *
 * @return void
 */
	public function testLinkWOStatusWNewTabWOClickCount() {
		//テスト実行
		$contentKey = 'content_key_1';
		$this->_testGetAction('/test_links/test_view_elements_links_link/link_without_click_count/2/' . $contentKey . '?frame_id=6',
				array('method' => 'assertNotEmpty'), null, 'view');

		//チェック
		$this->__assertView($contentKey, false, true, false);
	}

/**
 * view()のassert
 *
 * @param string $contentKey コンテンツキー
 * @param bool $status ステータスを表示するか
 * @param bool $openNewTab 新しいタブで開くかどうか
 * @param bool $displayClickCount クリック数を表示するかどうか
 * @return void
 */
	private function __assertView($contentKey, $status, $openNewTab, $displayClickCount) {
		$pattern = '/' . preg_quote('View/Elements/Links/link', '/') . '/';
		$this->assertRegExp($pattern, $this->view);

		$this->view = str_replace("\n", '', $this->view);
		$this->view = str_replace("\t", '', $this->view);

		if ($contentKey === 'content_key_2') {
			$this->assertTextContains('Title 3', $this->view);
			$linkId = '3';
		} else {
			$this->assertTextContains('Title 1', $this->view);
			$linkId = '1';
		}

		$pattern = 'onclick="return false;" ng-click="clickLink($event, \'' . $linkId . '\', \'' . $contentKey . '\')"';
		if ($status) {
			$this->assertTextNotContains($pattern, $this->view);
			$this->assertTextContains(__d('net_commons', 'Approving'), $this->view);
		} else {
			$this->assertTextContains($pattern, $this->view);
			$this->assertTextNotContains(__d('net_commons', 'Approving'), $this->view);
		}

		$pattern = '<span class="badge" id="nc-badge-6-' . $linkId . '">1</span>';
		if ($displayClickCount) {
			$this->assertTextContains($pattern, $this->view);
		} else {
			$this->assertTextNotContains($pattern, $this->view);
		}

		$pattern = 'target="_blank"';
		if ($openNewTab) {
			$this->assertTextContains($pattern, $this->view);
		} else {
			$this->assertTextNotContains($pattern, $this->view);
		}
	}

}
