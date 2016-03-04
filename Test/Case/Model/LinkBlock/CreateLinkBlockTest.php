<?php
/**
 * LinkBlock::createLinkBlock()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsModelTestCase', 'NetCommons.TestSuite');

/**
 * LinkBlock::createLinkBlock()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Links\Test\Case\Model\LinkBlock
 */
class LinkBlockCreateLinkBlockTest extends NetCommonsModelTestCase {

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
	protected $_modelName = 'LinkBlock';

/**
 * Method name
 *
 * @var string
 */
	protected $_methodName = 'createLinkBlock';

/**
 * createLinkBlock()のテスト
 *
 * @return void
 */
	public function testCreateLinkBlock() {
		$model = $this->_modelName;
		$methodName = $this->_methodName;

		//テスト実施
		$result = $this->$model->$methodName();

		//チェック
		$expected = array('LinkBlock', 'Block', 'LinkSetting');
		$this->assertEquals($expected, array_keys($result));

		$pattern = '/' . __d('links', 'New Bookmark List %s', '[0-9]{14}') . '/';
		$this->assertRegExp($pattern, Hash::get($result, 'LinkBlock.name'));
	}

}
