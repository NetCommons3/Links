<?php
/**
 * LinkSetting::saveLinkSetting()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsSaveTest', 'NetCommons.TestSuite');

/**
 * LinkSetting::saveLinkSetting()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Links\Test\Case\Model\LinkSetting
 */
class LinkSettingSaveLinkSettingTest extends NetCommonsSaveTest {

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
	protected $_modelName = 'LinkSetting';

/**
 * Method name
 *
 * @var string
 */
	protected $_methodName = 'saveLinkSetting';

/**
 * block key
 *
 * @var string
 */
	public $blockKey = 'block_1';

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		Current::write('Plugin.key', $this->plugin);
		Current::write('Block.key', $this->blockKey);
	}

/**
 * Save用DataProvider
 *
 * ### 戻り値
 *  - data 登録データ
 *
 * @return array テストデータ
 * @see NetCommonsSaveTest::testSave();
 */
	public function dataProviderSave() {
		$data['LinkSetting']['use_workflow'] = '0';

		$results = array();
		// * 編集の登録処理
		$results[0] = array($data);
		// * 新規の登録処理
		$results[1] = array($data);
		$results[1] = Hash::insert($results[1], '0.LinkSetting.use_workflow', '1');

		return $results;
	}

/**
 * Saveのテスト
 *
 * @param array $data 登録データ
 * @dataProvider dataProviderSave
 * @return void
 */
	public function testSave($data) {
		$model = $this->_modelName;
		$method = $this->_methodName;

		//テスト実行
		$result = $this->$model->$method($data);
		$this->assertNotEmpty($result);

		//登録データ取得
		$actual = $this->$model->getLinkSetting();
		$expected = $data;

		$this->assertEquals($expected, $actual);
	}

/**
 * SaveのExceptionError用DataProvider
 *
 * ### 戻り値
 *  - data 登録データ
 *  - mockModel Mockのモデル
 *  - mockMethod Mockのメソッド
 *
 * @return array テストデータ
 */
	public function dataProviderSaveOnExceptionError() {
		$data = $this->dataProviderSave()[0];
		return array(
			array($data[0]['LinkSetting'], 'Blocks.BlockSetting', 'saveMany'),
		);
	}

/**
 * SaveのValidationError用DataProvider
 *
 * ### 戻り値
 *  - data 登録データ
 *  - mockModel Mockのモデル
 *  - mockMethod Mockのメソッド(省略可：デフォルト validates)
 *
 * @return array テストデータ
 */
	public function dataProviderSaveOnValidationError() {
		$data = $this->dataProviderSave()[0];

		return array(
			array($data, 'Links.LinkSetting'),
		);
	}

}
