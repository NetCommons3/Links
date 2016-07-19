<?php
/**
 * LinkBlock::validate()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsValidateTest', 'NetCommons.TestSuite');
App::uses('LinkBlockFixture', 'Links.Test/Fixture');
App::uses('LinkBlockFixture', 'Links.Test/Fixture');

/**
 * LinkBlock::validate()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Links\Test\Case\Model\LinkBlock
 */
class LinkBlockValidateTest extends NetCommonsValidateTest {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.links.block_setting_for_link',
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
	protected $_methodName = 'validates';

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
		$data['LinkBlock'] = (new LinkBlockFixture())->records[0];

		return array(
			array('data' => $data, 'field' => 'language_id', 'value' => '',
				'message' => __d('net_commons', 'Invalid request.')),
			array('data' => $data, 'field' => 'language_id', 'value' => 'a',
				'message' => __d('net_commons', 'Invalid request.')),
			array('data' => $data, 'field' => 'room_id', 'value' => '',
				'message' => __d('net_commons', 'Invalid request.')),
			array('data' => $data, 'field' => 'room_id', 'value' => 'a',
				'message' => __d('net_commons', 'Invalid request.')),
			array('data' => $data, 'field' => 'name', 'value' => '',
				'message' => sprintf(__d('net_commons', 'Please input %s.'), __d('links', 'Link list Title'))),
		);
	}

/**
 * LinkSetting->validates()のエラーテスト
 *
 * @return void
 */
	public function testLinkSettingValidateError() {
		$model = $this->_modelName;

		//データ生成
		$data['LinkBlock'] = (new LinkBlockFixture())->records[0];
		$data['LinkSetting'] = (new LinkSettingFixture())->records[0];
		$data['LinkSetting'] = Hash::insert($data['LinkSetting'], 'use_workflow', 'aaaa');

		//テスト実施
		$this->$model->set($data);
		$result = $this->$model->validates();
		$this->assertFalse($result);

		//チェック
		$this->assertEquals($this->$model->LinkSetting->validationErrors['use_workflow'][0], __d('net_commons', 'Invalid request.'));
	}

}
