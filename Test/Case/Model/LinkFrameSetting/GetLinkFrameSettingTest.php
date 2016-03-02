<?php
/**
 * LinkFrameSetting::getLinkFrameSetting()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsGetTest', 'NetCommons.TestSuite');

/**
 * LinkFrameSetting::getLinkFrameSetting()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Links\Test\Case\Model\LinkFrameSetting
 */
class LinkFrameSettingGetLinkFrameSettingTest extends NetCommonsGetTest {

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
	protected $_modelName = 'LinkFrameSetting';

/**
 * Method name
 *
 * @var string
 */
	protected $_methodName = 'getLinkFrameSetting';

/**
 * getLinkFrameSetting()のテスト
 *
 * @return void
 */
	public function testGetLinkFrameSetting() {
		$model = $this->_modelName;
		$methodName = $this->_methodName;

		//データ生成
		Current::$current['Frame']['key'] = 'frame_3';
		$created = false;

		//テスト実施
		$result = $this->$model->$methodName($created);

		//チェック
		$this->assertEquals('6', Hash::get($result, 'LinkFrameSetting.id'));

		$this->__assertLinkFrameSetting($result['LinkFrameSetting'], array(
			'id' => Hash::get($result, 'LinkFrameSetting.id'),
			'frame_key' => Current::$current['Frame']['key'],
			'display_type' => '3',
			'open_new_tab' => true,
			'display_click_count' => true,
			'category_separator_line' => 'line_a2.gif',
			'list_style' => 'mark_a1.gif',
			'created_user' => null,
			'created' => null,
			'modified_user' => null,
			'modified' => null,
			'category_separator_line_css' => '',
			'list_style_css' => ''
		));
	}

/**
 * getLinkFrameSetting()のテスト(Frame.keyがなく、作成フラグがtrueの場合)
 *
 * @return void
 */
	public function testCreatedWOFrame() {
		$model = $this->_modelName;
		$methodName = $this->_methodName;

		//データ生成
		Current::$current['Frame']['key'] = 'aaaaaa';
		$created = true;

		//テスト実施
		$result = $this->$model->$methodName($created);

		//チェック
		$this->__assertLinkFrameSetting($result['LinkFrameSetting'], array(
			'display_type' => '1',
			'open_new_tab' => true,
			'display_click_count' => true,
			'frame_key' => Current::$current['Frame']['key'],
			'category_separator_line' => null,
			'list_style' => null,
			'created_user' => null,
			'created' => null,
			'modified_user' => null,
			'modified' => null,
			'category_separator_line_css' => null,
			'list_style_css' => 'list-style-type: none;'
		));
	}

/**
 * getLinkFrameSetting()のテスト(Frame.keyがなく、作成フラグがfalseの場合)
 *
 * @return void
 */
	public function testNotCreatedWOFrame() {
		$model = $this->_modelName;
		$methodName = $this->_methodName;

		//データ生成
		Current::$current['Frame']['key'] = 'aaaaaa';
		$created = false;

		//テスト実施
		$result = $this->$model->$methodName($created);

		//チェック
		$this->assertEmpty($result);
		$this->assertInternalType('array', $result);
	}

/**
 * 結果のチェック

 * @param array $result 結果
 * @param array $expected 期待値
 * @return void
 */
	private function __assertLinkFrameSetting($result, $expected) {
		$this->assertEquals(array_keys($expected), array_keys($result));

		$pathKey = 'category_separator_line';
		$this->assertEquals(Hash::get($expected, $pathKey), Hash::get($result, $pathKey));
		if (Hash::get($expected, $pathKey)) {
			$pattern = '/' . preg_quote(Hash::get($expected, $pathKey), '/') . '/';
			$this->assertRegExp($pattern, Hash::get($result, $pathKey . '_css'));
		} else {
			$this->assertEquals(null, Hash::get($result, $pathKey . '_css'));
		}

		$pathKey = 'list_style';
		$this->assertEquals(Hash::get($expected, $pathKey), Hash::get($result, $pathKey));
		if (Hash::get($expected, $pathKey)) {
			$pattern = '/' . preg_quote(Hash::get($expected, $pathKey), '/') . '/';
			$this->assertRegExp($pattern, Hash::get($result, $pathKey . '_css'));
		} else {
			$this->assertEquals('list-style-type: none;', Hash::get($result, $pathKey . '_css'));
		}

		$pathKey = 'frame_key';
		$this->assertEquals(Hash::get($expected, $pathKey), Hash::get($result, $pathKey));

		$pathKey = 'display_type';
		$this->assertEquals(Hash::get($expected, $pathKey), Hash::get($result, $pathKey));

		$pathKey = 'open_new_tab';
		$this->assertEquals(Hash::get($expected, $pathKey), Hash::get($result, $pathKey));

		$pathKey = 'display_click_count';
		$this->assertEquals(Hash::get($expected, $pathKey), Hash::get($result, $pathKey));
	}

}
