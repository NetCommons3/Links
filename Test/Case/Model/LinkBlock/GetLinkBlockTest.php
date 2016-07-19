<?php
/**
 * LinkBlock::getLinkBlock()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('WorkflowGetTest', 'Workflow.TestSuite');

/**
 * LinkBlock::getLinkBlock()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Links\Test\Case\Model\LinkBlock
 */
class LinkBlockGetLinkBlockTest extends WorkflowGetTest {

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
	protected $_methodName = 'getLinkBlock';

/**
 * getLinkBlock()のテスト
 *
 * @return void
 */
	public function testGetLinkBlock() {
		$model = $this->_modelName;
		$methodName = $this->_methodName;

		//テストデータ
		$roomId = '1';
		$blockId = '2';
		$blockKey = 'block_1';
		Current::write('Room.id', $roomId);
		Current::write('Block.id', $blockId);
		Current::write('Block.key', $blockKey);

		//テスト実施
		$result = $this->$model->$methodName();

		//チェック
		$expected = array('LinkBlock', 'Block', 'LinkSetting');
		$this->assertEquals($expected, array_keys($result));

		$this->assertEquals($blockId, Hash::get($result, 'LinkBlock.id'));
		$this->assertEquals('2', Hash::get($result, 'LinkBlock.language_id'));
		$this->assertEquals($roomId, Hash::get($result, 'LinkBlock.room_id'));
		$this->assertEquals($blockKey, Hash::get($result, 'LinkBlock.key'));

		$this->assertEquals($blockId, Hash::get($result, 'Block.id'));
		$this->assertEquals('2', Hash::get($result, 'Block.language_id'));
		$this->assertEquals($roomId, Hash::get($result, 'Block.room_id'));
		$this->assertEquals($this->plugin, Hash::get($result, 'Block.plugin_key'));
		$this->assertEquals($blockKey, Hash::get($result, 'Block.key'));

		//$this->assertEquals('1', Hash::get($result, 'LinkSetting.id'));
		//$this->assertEquals($blockKey, Hash::get($result, 'LinkSetting.block_key'));
		//$this->assertEquals(true, Hash::get($result, 'LinkSetting.use_workflow'));
		$this->assertEquals('2', Hash::get($result, 'LinkSetting.id'));
		$this->assertEquals($blockKey, Hash::get($result, 'LinkSetting.key'));
		$this->assertEquals(0, Hash::get($result, 'LinkSetting.use_workflow'));
	}

/**
 * getLinkBlock()のテスト
 *
 * @return void
 */
	public function testGetLinkBlockWOBlockId() {
		$model = $this->_modelName;
		$methodName = $this->_methodName;

		//テストデータ
		Current::$current['Block']['id'] = '99';

		//テスト実施
		$result = $this->$model->$methodName();
		$this->assertFalse($result);
	}

}
