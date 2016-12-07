<?php
/**
 * LinksController::link()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');

/**
 * LinksController::link()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Links\Test\Case\Controller\LinksController
 */
class LinksControllerLinkTest extends NetCommonsControllerTestCase {

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
 * link()アクションのGetリクエストテスト
 *
 * @return void
 */
	public function testLinkGet() {
		//テスト実行
		$this->_testGetAction(array('action' => 'link', 'frame_id' => '6'),
				null, 'BadRequestException', 'json');
	}

/**
 * テストDataの取得
 *
 * @return array
 */
	private function __data() {
		$data = array(
			'Frame' => array(
				'id' => '6',
			),
			'Block' => array(
				'id' => '2',
			),
			'Link' => array(
				'id' => '2',
				'key' => 'content_key_1',
			),
		);
		return $data;
	}

/**
 * link()アクションのテスト
 *
 * @return void
 */
	public function testLinkPost() {
		//テスト実行
		$data = $this->__data();
		$result = $this->_testPostAction('put', $data, array('action' => 'link'), null, 'json');

		//チェック
		$this->assertEquals('OK', $result['name']);
		$this->assertEquals(200, $result['code']);
	}

/**
 * viewアクションのテスト
 *
 * @return void
 */
	public function testViewBadLinkId() {
		//テスト実行
		$data = Hash::insert($this->__data(), 'Link.id', '999');
		$this->_testPostAction('put', $data, array('action' => 'link'), 'BadRequestException', 'json');
	}

/**
 * viewアクションのテスト
 *
 * @return void
 */
	public function testViewOnLinkUpdateCountError() {
		//テストデータ
		$this->_mockForReturnFalse('Links.Link', 'updateCount');
		//テスト実行
		$data = $this->__data();
		$this->_testPostAction('put', $data, array('action' => 'link'), 'BadRequestException', 'json');
	}

}
