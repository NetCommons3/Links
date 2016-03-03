<?php
/**
 * beforeDelete()とafterDelete()のテスト
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
 * beforeDelete()とafterDelete()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Links\Test\Case\Model\LinkOrder
 */
class LinkOrderDeleteTest extends NetCommonsModelTestCase {

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
	protected $_methodName = 'delete';

/**
 * delete()のテスト
 *
 * @return void
 */
	public function testDelete() {
		$model = $this->_modelName;
		$methodName = $this->_methodName;

		//事前チェック
		$result = $this->$model->find('first', array(
			'recursive' => -1,
			'fields' => array('weight'),
			'conditions' => array('id' => '2')
		));
		$this->assertEquals('2', $result[$this->$model->alias]['weight']);

		//テスト実施
		$id = (new LinkOrderFixture())->records[0]['id'];
		$result = $this->$model->$methodName($id);
		$this->assertTrue($result);

		//チェック
		$result = $this->$model->find('first', array(
			'recursive' => -1,
			'fields' => array('weight'),
			'conditions' => array('id' => '2')
		));
		$this->assertEquals('1', $result[$this->$model->alias]['weight']);
	}

}
