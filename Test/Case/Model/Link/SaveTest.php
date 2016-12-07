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
App::uses('LinkFixture', 'Links.Test/Fixture');
App::uses('LinkOrderFixture', 'Links.Test/Fixture');

/**
 * beforeSave()とafterSave()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Links\Test\Case\Model\Link
 */
class LinkSaveTest extends NetCommonsModelTestCase {

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
	protected $_modelName = 'Link';

/**
 * Method name
 *
 * @var string
 */
	protected $_methodName = 'save';

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$model = $this->_modelName;
		$this->$model->Behaviors->unload('Topics');
	}

/**
 * テストDataの取得
 *
 * @return array
 */
	private function __data() {
		Current::$current = Hash::insert(Current::$current, 'Permission.content_publishable.value', true);
		Current::$current = Hash::insert(Current::$current, 'Block.key', 'block_1');
		$data['Link'] = array(
			'block_id' => '2',
			'key' => '',
			'language_id' => '2',
			'category_id' => '1',
			'status' => '1',
			'url' => 'http://www.netcommons.org',
			'title' => 'Title new',
			'description' => '',
		);
		$data['LinkOrder'] = array(
			'block_key' => 'block_1',
			'category_key' => 'category_1',
			'link_key' => '',
		);
		return $data;
	}

/**
 * テスト評価
 *
 * @param array $result 結果
 * @param array $expected 期待値
 * @return void
 */
	private function __assert($result, $expected) {
		$model = $this->_modelName;

		$key = OriginalKeyBehavior::generateKey($this->$model->alias, $this->$model->useDbConfig);
		$expected['Link'] = Hash::merge($expected['Link'], array(
			'key' => $key,
			'is_active' => true,
			'is_latest' => true,
			'id' => '9',
			'is_origin' => true,
			'is_translation' => false,
		));
		$expected['LinkOrder'] = Hash::merge($expected['LinkOrder'], array(
			'link_key' => $key,
			'weight' => 5,
			'id' => '6',
		));

		$this->assertDatetime($result['Link']['created']);
		$this->assertDatetime($result['Link']['modified']);
		$this->assertDatetime($result['LinkOrder']['created']);
		$this->assertDatetime($result['LinkOrder']['modified']);

		$result = Hash::remove($result, '{s}.created');
		$result = Hash::remove($result, '{s}.modified');

		$this->assertEquals($expected, $result);
	}

/**
 * save()のテスト
 *
 * @return void
 */
	public function testSave() {
		$model = $this->_modelName;
		$methodName = $this->_methodName;

		//テスト実施
		$data = $this->__data();
		$result = $this->$model->$methodName($data);

		//チェック
		$this->__assert($result, $data);
	}

/**
 * save()のExceptionErrorテスト
 *
 * @return void
 */
	public function testSaveOnExceptionError() {
		$model = $this->_modelName;
		$methodName = $this->_methodName;
		$this->_mockForReturnFalse($model, 'Links.LinkOrder', 'save');

		//テスト実施
		$this->setExpectedException('InternalErrorException');
		$data = $this->__data();
		$this->$model->$methodName($data);
	}

}
