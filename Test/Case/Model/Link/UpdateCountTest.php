<?php
/**
 * Link::updateCount()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsModelTestCase', 'NetCommons.TestSuite');

/**
 * Link::updateCount()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Links\Test\Case\Model\Link
 */
class LinkUpdateCountTest extends NetCommonsModelTestCase {

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
	protected $_modelName = 'Link';

/**
 * Method name
 *
 * @var string
 */
	protected $_methodName = 'updateCount';

/**
 * updateCount()のテスト
 *
 * @return void
 */
	public function testUpdateCount() {
		$model = $this->_modelName;
		$methodName = $this->_methodName;

		//データ生成
		$id = '2';
		Current::$current = Hash::insert(Current::$current, 'Block.id', '2');

		//事前チェック
		$result = $this->$model->find('first', array(
			'recursive' => -1,
			'fields' => array('id', 'key', 'click_count'),
			'conditions' => array('id' => $id),
		));
		$expected = array('id' => '2', 'key' => 'content_key_1', 'click_count' => '1');
		$this->assertEquals($expected, $result[$this->$model->alias]);

		//テスト実施
		$result = $this->$model->$methodName($id);
		$this->assertTrue($result);

		//チェック
		$result = $this->$model->find('first', array(
			'recursive' => -1,
			'fields' => array('id', 'key', 'click_count'),
			'conditions' => array('id' => $id),
		));
		$expected['click_count'] = '2';
		$this->assertEquals($expected, $result[$this->$model->alias]);
	}

/**
 * updateCount()のExceptionErrorテスト
 *
 * @return void
 */
	public function testUpdateCountOnExceptionError() {
		$model = $this->_modelName;
		$methodName = $this->_methodName;

		//データ生成
		$id = '2';
		Current::$current = Hash::insert(Current::$current, 'Block.id', '2');
		$this->_mockForReturnFalse($model, 'Links.Link', 'updateAll');

		//テスト実施
		$this->setExpectedException('InternalErrorException');
		$this->$model->$methodName($id);
	}

}
