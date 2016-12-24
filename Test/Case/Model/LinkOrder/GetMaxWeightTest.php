<?php
/**
 * LinkOrder::getMaxWeight()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsGetTest', 'NetCommons.TestSuite');

/**
 * LinkOrder::getMaxWeight()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Links\Test\Case\Model\LinkOrder
 */
class LinkOrderGetMaxWeightTest extends NetCommonsGetTest {

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
	protected $_methodName = 'getMaxWeight';

/**
 * getMaxWeight()のテスト
 *
 * @return void
 */
	public function testGetMaxWeight() {
		$model = $this->_modelName;
		$methodName = $this->_methodName;

		//データ生成
		Current::$current = Hash::insert(Current::$current, 'Block.key', 'block_1');
		$categoryKey = 'category_1';

		//テスト実施
		$result = $this->$model->$methodName($categoryKey);

		//チェック
		$this->assertEquals(4, $result);
	}

/**
 * getMaxWeight()のテスト(一つも選択していないカテゴリー)
 *
 * @return void
 */
	public function testGetMaxWeightNoDataCategory() {
		$model = $this->_modelName;
		$methodName = $this->_methodName;

		//データ生成
		Current::$current = Hash::insert(Current::$current, 'Block.key', 'block_1');
		$categoryKey = 'category_99';

		//テスト実施
		$result = $this->$model->$methodName($categoryKey);

		//チェック
		$this->assertEquals(0, $result);
	}

}
