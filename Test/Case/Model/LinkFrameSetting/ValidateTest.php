<?php
/**
 * LinkFrameSetting::validate()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsValidateTest', 'NetCommons.TestSuite');
App::uses('LinkFrameSettingFixture', 'Links.Test/Fixture');

/**
 * LinkFrameSetting::validate()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Links\Test\Case\Model\LinkFrameSetting
 */
class LinkFrameSettingValidateTest extends NetCommonsValidateTest {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.links.link_frame_setting',
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
	protected $_methodName = 'validate';

/**
 * ValidationErrorのDataProvider
 *
 * ### 戻り値
 *  - data 登録データ
 *  - field フィールド名
 *  - value セットする値
 *  - message エラーメッセージ
 *  - overwrite 上書きするデータ(省略可)
 *
 * @return array テストデータ
 */
	public function dataProviderValidationError() {
		$data['LinkFrameSetting'] = (new LinkFrameSettingFixture())->records[0];

		return array(
			array('data' => $data, 'field' => 'frame_key', 'value' => '',
				'message' => __d('net_commons', 'Invalid request.')),
			array('data' => $data, 'field' => 'display_type', 'value' => 'a',
				'message' => __d('net_commons', 'Invalid request.')),
			array('data' => $data, 'field' => 'display_type', 'value' => '99',
				'message' => __d('net_commons', 'Invalid request.')),
			array('data' => $data, 'field' => 'open_new_tab', 'value' => '2',
				'message' => __d('net_commons', 'Invalid request.')),
			array('data' => $data, 'field' => 'display_click_count', 'value' => '2',
				'message' => __d('net_commons', 'Invalid request.')),
			array('data' => $data, 'field' => 'category_separator_line', 'value' => 'aa',
				'message' => __d('net_commons', 'Invalid request.')),
			array('data' => $data, 'field' => 'list_style', 'value' => 'aa',
				'message' => __d('net_commons', 'Invalid request.')),
		);
	}

}
