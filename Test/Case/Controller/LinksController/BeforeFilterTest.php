<?php
/**
 * LinksController::beforeFilter()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');

/**
 * LinksController::beforeFilter()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Links\Test\Case\Controller\LinksController
 */
class LinksControllerBeforeFilterTest extends NetCommonsControllerTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.categories.category',
		'plugin.categories.category_order',
		'plugin.categories.categories_language',
		'plugin.links.link',
		'plugin.links.link_frame_setting',
		'plugin.links.link_order',
		'plugin.links.block_setting_for_link',
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
	protected $_controller = 'links';

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
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
 * index()アクションのテスト
 *
 * @return void
 */
	public function testBeforeFilter() {
		//テスト実行
		$this->_testGetAction(array('action' => 'index', 'frame_id' => '6'),
				array('method' => 'assertNotEmpty'), null, 'view');
	}

/**
 * index()アクションのテスト(ブロックIDなし)
 *
 * @return void
 */
	public function testBeforeFilterWOBlockId() {
		//テスト実行
		$this->_testGetAction(array('action' => 'index', 'frame_id' => '13'),
				array('method' => 'assertEmpty'), null, 'view');
	}

/**
 * index()アクションのテスト(ブロックデータなし)
 *
 * @return void
 */
	public function testBeforeFilterWOBlockData() {
		$this->_mockForReturnFalse('Links.LinkBlock', 'getLinkBlock');

		//テスト実行
		$this->_testGetAction(array('action' => 'index', 'frame_id' => '6'),
				null, 'BadRequestException', 'view');
	}

}
