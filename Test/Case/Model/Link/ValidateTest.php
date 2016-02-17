<?php
/**
 * Link::validate()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsValidateTest', 'NetCommons.TestSuite');
App::uses('LinkFixture', 'Links.Test/Fixture');
App::uses('LinkOrderFixture', 'Links.Test/Fixture');

/**
 * Link::validate()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Links\Test\Case\Model\Link
 */
class LinkValidateTest extends NetCommonsValidateTest {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.links.link',
		'plugin.links.link_order',
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
		$data['Link'] = (new LinkFixture())->records[0];
		$data['LinkOrder'] = (new LinkOrderFixture())->records[0];

		return array(
			array('data' => $data, 'field' => 'block_id', 'value' => null,
				'message' => __d('net_commons', 'Invalid request.')),
			array('data' => $data, 'field' => 'block_id', 'value' => 'a',
				'message' => __d('net_commons', 'Invalid request.')),
			array('data' => $data, 'field' => 'key', 'value' => '',
				'message' => __d('net_commons', 'Invalid request.')),
			array('data' => $data, 'field' => 'language_id', 'value' => null,
				'message' => __d('net_commons', 'Invalid request.')),
			array('data' => $data, 'field' => 'language_id', 'value' => 'a',
				'message' => __d('net_commons', 'Invalid request.')),
			array('data' => $data, 'field' => 'click_count', 'value' => 'a',
				'message' => __d('net_commons', 'Invalid request.')),
			array('data' => $data, 'field' => 'url', 'value' => '',
				'message' => sprintf(__d('net_commons', 'Please input %s.'), __d('links', 'URL'))),
			array('data' => $data, 'field' => 'url', 'value' => 'a',
				'message' => sprintf(__d('net_commons', 'Unauthorized pattern for %s. Please input the data in %s format.'), __d('links', 'URL'), __d('links', 'URL'))),
			array('data' => $data, 'field' => 'title', 'value' => '',
				'message' => sprintf(__d('net_commons', 'Please input %s.'), __d('links', 'Title'))),
		);
	}

/**
 * LinkOrder->validates()のエラーテスト
 *
 * @return void
 */
	public function testLinkOrderValidateError() {
		$model = $this->_modelName;

		//データ生成
		$data['Link'] = (new LinkFixture())->records[0];
		$data['LinkOrder'] = (new LinkOrderFixture())->records[0];
		$data['LinkOrder'] = Hash::insert($data['LinkOrder'], 'weight', 'aaaa');

		//テスト実施
		$this->$model->set($data);
		$result = $this->$model->validates();
		$this->assertFalse($result);

		//チェック
		$this->assertEquals($this->$model->LinkOrder->validationErrors['weight'][0], __d('net_commons', 'Invalid request.'));
	}

}
