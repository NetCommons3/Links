<?php
/**
 * LinkBlocksController::beforeFilter()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');

/**
 * LinkBlocksController::beforeFilter()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Links\Test\Case\Controller\LinkBlocksController
 */
class LinkBlocksControllerBeforeFilterTest extends NetCommonsControllerTestCase {

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
		'plugin.workflow.workflow_comment',
	);

/**
 * Plugin name
 *
 * @var string
 */
	public $plugin = 'links';

/**
 * Controller name
 *
 * @var string
 */
	protected $_controller = 'link_blocks';

/**
 * index()アクションのテスト
 *
 * @return void
 */
	public function testBeforeFilterIndex() {
		//ログイン
		TestAuthGeneral::login($this);

		//テスト実行
		$this->_testGetAction(array('action' => 'index', 'block_id' => '2', 'frame_id' => '6'),
				array('method' => 'assertNotEmpty'), null, 'view');

		//チェック
		$this->assertFalse($this->controller->Components->loaded('Categories.CategoryEdit'));
		$this->assertNotEmpty($this->view);

		//ログアウト
		TestAuthGeneral::logout($this);
	}

/**
 * index()アクションのテスト
 *
 * @return void
 */
	public function testBeforeFilterEdit() {
		//ログイン
		TestAuthGeneral::login($this);

		//テスト実行
		$this->_testGetAction(array('action' => 'edit', 'block_id' => '2', 'frame_id' => '6'),
				array('method' => 'assertNotEmpty'), null, 'view');

		//チェック
		$this->assertTrue($this->controller->Components->loaded('Categories.CategoryEdit'));
		$this->assertNotEmpty($this->view);

		//ログアウト
		TestAuthGeneral::logout($this);
	}

}
