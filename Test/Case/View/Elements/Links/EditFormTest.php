<?php
/**
 * View/Elements/Links/edit_formのテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');

/**
 * View/Elements/Links/edit_formのテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Links\Test\Case\View\Elements\Links\EditForm
 */
class LinksViewElementsLinksEditFormTest extends NetCommonsControllerTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.categories.category',
		'plugin.categories.category_order',
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
		$this->generateNc('TestLinks.TestViewElementsLinksEditForm');
	}

/**
 * View/Elements/Links/edit_formのテスト
 *
 * @return void
 */
	public function testEditForm() {
		//テスト実行
		$this->_testGetAction('/test_links/test_view_elements_links_edit_form/edit_form/2',
				array('method' => 'assertNotEmpty'), null, 'view');

		//チェック
		$pattern = '/' . preg_quote('View/Elements/Links/edit_form', '/') . '/';
		$this->assertRegExp($pattern, $this->view);

		$this->assertInput('input', 'data[Block][id]', '2', $this->view);
		$this->assertInput('input', 'data[Block][key]', 'block_1', $this->view);
		$this->assertInput('input', 'data[Frame][id]', '6', $this->view);
		$this->assertInput('input', 'data[Link][id]', '2', $this->view);
		$this->assertInput('input', 'data[Link][block_id]', '2', $this->view);
		$this->assertInput('input', 'data[Link][key]', 'content_key_1', $this->view);
		$this->assertInput('input', 'data[Link][language_id]', '2', $this->view);
		$this->assertInput('input', 'data[LinkOrder][id]', '1', $this->view);
		$this->assertInput('input', 'data[LinkOrder][block_key]', 'block_1', $this->view);
		$this->assertInput('input', 'data[LinkOrder][link_key]', 'content_key_1', $this->view);
		$this->assertInput('input', 'data[Link][url]', 'http://www.netcommons.org', $this->view);
		$this->assertInput('input', 'data[Link][title]', 'Title 2" id="LinkTitle', $this->view);
		$this->assertInput('textarea', 'data[Link][description]', 'Description 2', $this->view);
		$this->assertInput('select', 'data[Link][category_id]', '', $this->view);
	}

}
