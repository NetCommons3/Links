<?php
/**
 * LinkOrder::saveLinkOrders()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsSaveTest', 'NetCommons.TestSuite');
App::uses('LinkOrderFixture', 'Links.Test/Fixture');

/**
 * LinkOrder::saveLinkOrders()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Links\Test\Case\Model\LinkOrder
 */
class LinkOrderSaveLinkOrdersTest extends NetCommonsSaveTest {

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
 * Model name
 *
 * @var string
 */
	protected $_modelName = 'LinkOrder';

/**
 * Method name
 *
 * @var string
 */
	protected $_methodName = 'saveLinkOrders';

/**
 * Save用DataProvider
 *
 * ### 戻り値
 *  - data 登録データ
 *
 * @return array テストデータ
 */
	public function dataProviderSave() {
		$results = array();
		$results[0][0]['LinkOrders'] = array();
		$results[0][0]['LinkOrders'][] = array('LinkOrder' => Hash::insert((new LinkOrderFixture())->records[2], 'weight', '1'));
		$results[0][0]['LinkOrders'][] = array('LinkOrder' => Hash::insert((new LinkOrderFixture())->records[4], 'weight', '1'));
		$results[0][0]['LinkOrders'][] = array('LinkOrder' => Hash::insert((new LinkOrderFixture())->records[3], 'weight', '2'));
		$results[0][0]['LinkOrders'][] = array('LinkOrder' => Hash::insert((new LinkOrderFixture())->records[1], 'weight', '3'));
		$results[0][0]['LinkOrders'][] = array('LinkOrder' => Hash::insert((new LinkOrderFixture())->records[0], 'weight', '4'));
		$results[0][0]['LinkOrders'] = Hash::combine($results[0][0]['LinkOrders'], '{n}.LinkOrder.id', '{n}');

		return $results;
	}

/**
 * Saveのテスト
 *
 * @param array $data 登録データ
 * @dataProvider dataProviderSave
 * @return void
 */
	public function testSave($data) {
		$model = $this->_modelName;
		$method = $this->_methodName;

		$fields = array_keys(Hash::get($data, 'LinkOrders.1.LinkOrder'));
		$expected = $this->$model->find('all', array(
			'recursive' => -1,
			'fields' => $fields,
			'order' => array('id' => 'asc')
		));
		$expected = Hash::combine($expected, '{n}.LinkOrder.id', '{n}');
		$expected = Hash::merge($expected, $data['LinkOrders']);

		//テスト実行
		$result = $this->$model->$method($data);
		$this->assertNotEmpty($result);

		//チェック
		$actual = $this->$model->find('all', array(
			'recursive' => -1,
			'fields' => $fields,
			'order' => array('id' => 'asc')
		));
		$actual = Hash::combine($actual, '{n}.LinkOrder.id', '{n}');

		$this->assertEquals($expected, $actual);
	}

/**
 * SaveのExceptionError用DataProvider
 *
 * ### 戻り値
 *  - data 登録データ
 *  - mockModel Mockのモデル
 *  - mockMethod Mockのメソッド
 *
 * @return array テストデータ
 */
	public function dataProviderSaveOnExceptionError() {
		$data = $this->dataProviderSave()[0][0];

		return array(
			array($data, 'Links.LinkOrder', 'saveMany'),
		);
	}

/**
 * SaveのValidationError用DataProvider
 *
 * ### 戻り値
 *  - data 登録データ
 *  - mockModel Mockのモデル
 *  - mockMethod Mockのメソッド(省略可：デフォルト validates)
 *
 * @return array テストデータ
 */
	public function dataProviderSaveOnValidationError() {
		$data = $this->dataProviderSave()[0][0];

		return array(
			array($data, 'Links.LinkOrder', 'validateMany'),
		);
	}

}
