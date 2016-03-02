<?php
/**
 * beforeSave()とafterSave()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsModelTestCase', 'NetCommons.TestSuite');
App::uses('LinkOrderFixture', 'Links.Test/Fixture');

/**
 * beforeSave()とafterSave()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Links\Test\Case\Model\LinkOrder
 */
class LinkOrderSaveTest extends NetCommonsModelTestCase {

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
	protected $_methodName = 'save';

/**
 * テストDataの取得
 *
 * @return array
 */
	private function __data() {
		Current::$current = Hash::insert(Current::$current, 'Block.key', 'block_1');

		$data['LinkOrder'] = (new LinkOrderFixture())->records[0];
		$data['LinkOrder'] = Hash::remove($data['LinkOrder'], 'created');
		$data['LinkOrder'] = Hash::remove($data['LinkOrder'], 'created_user');
		$data['LinkOrder'] = Hash::remove($data['LinkOrder'], 'modified');
		$data['LinkOrder'] = Hash::remove($data['LinkOrder'], 'modified_user');

		return $data;
	}

/**
 * save()のテスト(Weightデータあり)
 *
 * @return void
 */
	public function testSaveWithWeight() {
		$model = $this->_modelName;
		$methodName = $this->_methodName;

		//データ生成
		$data = $this->__data();

		//テスト実施
		$result = $this->$model->$methodName($data);

		//チェック
		$this->assertDatetime($result[$this->$model->alias]['modified']);
		$result = Hash::remove($result, 'LinkOrder.modified');

		$expected = $data;
		$this->assertEquals($expected, $result);
	}

/**
 * save()のテスト(Weightデータなし)
 *
 * @return void
 */
	public function testSaveWOWeight() {
		$model = $this->_modelName;
		$methodName = $this->_methodName;

		//データ生成
		$data = $this->__data();
		$data = Hash::remove($data, 'LinkOrder.weight');

		//テスト実施
		$result = $this->$model->$methodName($data);

		//チェック
		$this->assertDatetime($result[$this->$model->alias]['modified']);
		$result = Hash::remove($result, 'LinkOrder.modified');

		$expected = $data;
		$this->assertEquals($expected, $result);
	}

/**
 * save()のテスト(カテゴリーの変更)
 *
 * @return void
 */
	public function testSaveByCategoryNull() {
		$model = $this->_modelName;
		$methodName = $this->_methodName;

		//データ生成
		$data = $this->__data();
		$data = Hash::remove($data, 'LinkOrder.weight');
		$data = Hash::insert($data, 'LinkOrder.category_key', null);

		//テスト実施
		$result = $this->$model->$methodName($data);

		//チェック
		$this->assertDatetime($result[$this->$model->alias]['modified']);
		$result = Hash::remove($result, 'LinkOrder.modified');

		$expected = $data;
		$expected = Hash::insert($expected, 'LinkOrder.weight', 2);
		$this->assertEquals($expected, $result);
	}

/**
 * save()のテスト(新規データ)
 *
 * @return void
 */
	public function testSaveByInsertData() {
		$model = $this->_modelName;
		$methodName = $this->_methodName;

		//データ生成
		$data = $this->__data();
		$data = Hash::remove($data, 'LinkOrder.id');
		$data = Hash::remove($data, 'LinkOrder.weight');
		$data = Hash::insert($data, 'LinkOrder.link_key', 'new_link_order');

		//テスト実施
		$result = $this->$model->$methodName($data);

		//チェック
		$this->assertDatetime($result[$this->$model->alias]['created']);
		$result = Hash::remove($result, 'LinkOrder.created');
		$this->assertDatetime($result[$this->$model->alias]['modified']);
		$result = Hash::remove($result, 'LinkOrder.modified');

		$expected = $data;
		$expected = Hash::insert($expected, 'LinkOrder.id', '6');
		$expected = Hash::insert($expected, 'LinkOrder.weight', 5);
		$this->assertEquals($expected, $result);
	}

}
