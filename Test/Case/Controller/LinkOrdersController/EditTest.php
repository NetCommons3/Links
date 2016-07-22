<?php
/**
 * LinkOrdersController::edit()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');
App::uses('LinkOrderFixture', 'Links.Test/Fixture');

/**
 * LinkOrdersController::edit()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Links\Test\Case\Controller\LinkOrdersController
 */
class LinkOrdersControllerEditTest extends NetCommonsControllerTestCase {

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
	protected $_controller = 'link_orders';

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
 * edit()アクションのGetリクエストテスト
 *
 * @return void
 */
	public function testEditGet() {
		//テストデータ
		$frameId = '6';
		$blockId = '2';
		$blockKey = 'block_1';

		//テスト実行
		$this->_testGetAction(array('action' => 'edit', 'block_id' => $blockId, 'frame_id' => $frameId),
				array('method' => 'assertNotEmpty'), null, 'view');

		//チェック
		$this->__assertEditGet($frameId, $blockId, $blockKey);
	}

/**
 * edit()のチェック
 *
 * @param int $frameId フレームID
 * @param int $blockId ブロックID
 * @param string $blockKey ブロックKey
 * @return void
 */
	private function __assertEditGet($frameId, $blockId, $blockKey) {
		$this->assertInput('form', null, 'links/link_orders/edit/' . $blockId, $this->view);
		$this->assertInput('input', '_method', 'PUT', $this->view);
		$this->assertInput('input', 'data[Frame][id]', $frameId, $this->view);
		$this->assertInput('input', 'data[Block][id]', $blockId, $this->view);
		$this->assertInput('input', 'data[Block][key]', $blockKey, $this->view);

		$this->assertEquals($frameId, Hash::get($this->controller->request->data, 'Frame.id'));
		$this->assertEquals($blockId, Hash::get($this->controller->request->data, 'Block.id'));
		$this->assertEquals($blockKey, Hash::get($this->controller->request->data, 'Block.key'));
		$this->assertCount(5, Hash::get($this->controller->request->data, 'LinkOrders'));

		$this->__assertRequestData($blockId, $blockKey, array(
			'Link' => array('id' => '5', 'key' => 'content_key_3'),
			'LinkOrder' => array('id' => '3', 'weight' => '1'),
			'Category' => array('id' => null, 'key' => null),
			'CategoryOrder' => array('id' => null, 'weight' => null),
		));
		$this->__assertRequestData($blockId, $blockKey, array(
			'Link' => array('id' => '2', 'key' => 'content_key_1'),
			'LinkOrder' => array('id' => '1', 'weight' => '1'),
			'Category' => array('id' => '1', 'key' => 'category_1'),
			'CategoryOrder' => array('id' => '1', 'weight' => '1'),
		));
		$this->__assertRequestData($blockId, $blockKey, array(
			'Link' => array('id' => '3', 'key' => 'content_key_2'),
			'LinkOrder' => array('id' => '2', 'weight' => '2'),
			'Category' => array('id' => '1', 'key' => 'category_1'),
			'CategoryOrder' => array('id' => '1', 'weight' => '1'),
		));
		$this->__assertRequestData($blockId, $blockKey, array(
			'Link' => array('id' => '7', 'key' => 'content_key_4'),
			'LinkOrder' => array('id' => '4', 'weight' => '3'),
			'Category' => array('id' => '1', 'key' => 'category_1'),
			'CategoryOrder' => array('id' => '1', 'weight' => '1'),
		));
		$this->__assertRequestData($blockId, $blockKey, array(
			'Link' => array('id' => '8', 'key' => 'content_key_5'),
			'LinkOrder' => array('id' => '5', 'weight' => '4'),
			'Category' => array('id' => '1', 'key' => 'category_1'),
			'CategoryOrder' => array('id' => '1', 'weight' => '1'),
		));
	}

/**
 * edit()アクションの評価
 *
 * @param int $blockId ブロックID
 * @param string $blockKey ブロックKey
 * @param array $expected 期待値
 * @return void
 */
	private function __assertRequestData($blockId, $blockKey, $expected) {
		$actual = $this->controller->request->data;
		$linkOrderId = Hash::get($expected, 'LinkOrder.id');

		$pathKey = 'LinkOrders.' . $linkOrderId . '.Link.id';
		$this->assertEquals(Hash::get($expected, 'Link.id'), Hash::get($actual, $pathKey));

		$pathKey = 'LinkOrders.' . $linkOrderId . '.Link.key';
		$this->assertEquals(Hash::get($expected, 'Link.key'), Hash::get($actual, $pathKey));

		$pathKey = 'LinkOrders.' . $linkOrderId . '.Link.category_id';
		$this->assertEquals(Hash::get($expected, 'Category.id'), Hash::get($actual, $pathKey));

		$pathKey = 'LinkOrders.' . $linkOrderId . '.Link.block_id';
		$this->assertEquals($blockId, Hash::get($actual, $pathKey));

		$pathKey = 'LinkOrders.' . $linkOrderId . '.LinkOrder.id';
		$this->assertEquals($linkOrderId, Hash::get($actual, $pathKey));

		$pathKey = 'LinkOrders.' . $linkOrderId . '.LinkOrder.block_key';
		$this->assertEquals($blockKey, Hash::get($actual, $pathKey));

		$pathKey = 'LinkOrders.' . $linkOrderId . '.LinkOrder.category_key';
		$this->assertEquals(Hash::get($expected, 'Category.key'), Hash::get($actual, $pathKey));

		$pathKey = 'LinkOrders.' . $linkOrderId . '.LinkOrder.link_key';
		$this->assertEquals(Hash::get($expected, 'Link.key'), Hash::get($actual, $pathKey));

		$pathKey = 'LinkOrders.' . $linkOrderId . '.LinkOrder.weight';
		$this->assertEquals(Hash::get($expected, 'LinkOrder.weight'), Hash::get($actual, $pathKey));

		$pathKey = 'LinkOrders.' . $linkOrderId . '.Category.id';
		$this->assertEquals(Hash::get($expected, 'Category.id'), Hash::get($actual, $pathKey));

		$pathKey = 'LinkOrders.' . $linkOrderId . '.Category.key';
		$this->assertEquals(Hash::get($expected, 'Category.key'), Hash::get($actual, $pathKey));

		$pathKey = 'LinkOrders.' . $linkOrderId . '.CategoryOrder.id';
		$this->assertEquals(Hash::get($expected, 'CategoryOrder.id'), Hash::get($actual, $pathKey));

		$pathKey = 'LinkOrders.' . $linkOrderId . '.CategoryOrder.category_key';
		$this->assertEquals(Hash::get($expected, 'Category.key'), Hash::get($actual, $pathKey));

		$pathKey = 'LinkOrders.' . $linkOrderId . '.CategoryOrder.weight';
		$this->assertEquals(Hash::get($expected, 'CategoryOrder.weight'), Hash::get($actual, $pathKey));
	}

/**
 * POSTリクエストデータ生成
 *
 * @return array リクエストデータ
 */
	private function __data() {
		$data = array(
			'Frame' => array(
				'id' => '6'
			),
			'Block' => array(
				'id' => '2', 'key' => 'block_1'
			),
		);
		$data['LinkOrders'] = array();
		$data['LinkOrders'][] = array('LinkOrder' => Hash::insert((new LinkOrderFixture())->records[2], 'weight', '1'));
		$data['LinkOrders'][] = array('LinkOrder' => Hash::insert((new LinkOrderFixture())->records[4], 'weight', '1'));
		$data['LinkOrders'][] = array('LinkOrder' => Hash::insert((new LinkOrderFixture())->records[3], 'weight', '2'));
		$data['LinkOrders'][] = array('LinkOrder' => Hash::insert((new LinkOrderFixture())->records[1], 'weight', '3'));
		$data['LinkOrders'][] = array('LinkOrder' => Hash::insert((new LinkOrderFixture())->records[0], 'weight', '4'));
		$data['LinkOrders'] = Hash::combine($data['LinkOrders'], '{n}.LinkOrder.id', '{n}');

		return $data;
	}

/**
 * edit()アクションのPOSTリクエストテスト
 *
 * @return void
 */
	public function testEditPost() {
		//テストデータ
		$frameId = '6';
		$blockId = '2';

		//テスト実行
		$this->_testPostAction('put', $this->__data(),
				array('action' => 'edit', 'block_id' => $blockId, 'frame_id' => $frameId), null, 'view');

		//チェック
		$header = $this->controller->response->header();
		$pattern = '/' . preg_quote('/', '/') . '/';
		$this->assertRegExp($pattern, $header['Location']);
	}

/**
 * ValidationErrorテスト
 *
 * @return void
 */
	public function testEditPostValidationError() {
		$this->generateNc(Inflector::camelize($this->_controller), array('components' => array(
			'Session' => array('setFlash')
		)));

		//テストデータ
		$frameId = '6';
		$blockId = '2';

		//テスト実行
		$this->controller->Session->expects($this->once())
			->method('setFlash')
			->will($this->returnValue(null));

		$this->_testPostAction('put', Hash::insert($this->__data(), 'LinkOrders.{n}.LinkOrder.weight', 'aaaa'),
				array('action' => 'edit', 'block_id' => $blockId, 'frame_id' => $frameId), null, 'view');
	}

/**
 * ExceptionErrorテスト
 *
 * @return void
 */
	public function testEditPostOnExceptionError() {
		$this->_mockForReturnFalse('Links.LinkBlock', 'getLinkBlock');

		//テストデータ
		$frameId = '6';
		$blockId = '2';

		//テスト実行
		$this->_testPostAction('put', $this->__data(),
				array('action' => 'edit', 'block_id' => $blockId, 'frame_id' => $frameId), 'BadRequestException', 'view');
	}

}
