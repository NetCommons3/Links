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
	public $blockKey = '055aa626035385fab3d69697be9db872';

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
		//		$results[1] = Hash::insert($results[1], '0.LinkSetting.id', null);
		//		$results[1] = Hash::remove($results[1], '0.LinkSetting.created_user');
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
		// 仮対応中
		//		$model = $this->_modelName;
		//		$method = $this->_methodName;
		//		if (! $this->_keyAlias) {
		//			$this->_keyAlias = $this->$model->alias;
		//		}
		//
		//		//チェック用データ取得
		//		if (isset($data[$this->$model->alias]['id'])) {
		//			$before = $this->$model->find('first', array(
		//				'recursive' => -1,
		//				'conditions' => array('id' => $data[$this->$model->alias]['id']),
		//			));
		//		} else {
		//			$max = $this->$model->find('first', array(
		//				'recursive' => -1,
		//				'fields' => array('id'),
		//				'order' => array('id' => 'desc'),
		//			));
		//		}
		//
		//		//テスト実行
		//		$result = $this->$model->$method($data);
		//		$this->assertNotEmpty($result);
		//
		//		//idのチェック
		//		if (isset($data[$this->$model->alias]['id'])) {
		//			$id = $data[$this->$model->alias]['id'];
		//		} elseif ($max) {
		//			$id = (string)($max[$this->$model->alias]['id'] + 1);
		//		} else {
		//			$id = $this->$model->getLastInsertID();
		//		}
		//
		//		//登録データ取得
		//		$actual = $this->$model->find('first', array(
		//			'recursive' => -1,
		//			'conditions' => array('id' => $id),
		//		));
		//
		//		if (isset($data[$this->$model->alias]['id'])) {
		//			$actual[$this->$model->alias] = Hash::remove($actual[$this->$model->alias], 'modified');
		//			$actual[$this->$model->alias] = Hash::remove($actual[$this->$model->alias], 'modified_user');
		//		} else {
		//			$actual[$this->$model->alias] = Hash::remove($actual[$this->$model->alias], 'created');
		//			$actual[$this->$model->alias] = Hash::remove($actual[$this->$model->alias], 'created_user');
		//			$actual[$this->$model->alias] = Hash::remove($actual[$this->$model->alias], 'modified');
		//			$actual[$this->$model->alias] = Hash::remove($actual[$this->$model->alias], 'modified_user');
		//
		//			if ($this->$model->hasField('key')) {
		//				$data[$this->$model->alias]['key'] = OriginalKeyBehavior::generateKey(
		//					$this->_keyAlias, $this->$model->useDbConfig
		//				);
		//			}
		//			$before[$this->$model->alias] = array();
		//		}
		//		$expected[$this->$model->alias] = Hash::merge(
		//			$before[$this->$model->alias],
		//			$data[$this->$model->alias],
		//			array(
		//				'id' => $id,
		//			)
		//		);
		//		$expected[$this->$model->alias] = Hash::remove($expected[$this->$model->alias], 'modified');
		//		$expected[$this->$model->alias] = Hash::remove($expected[$this->$model->alias], 'modified_user');
		//
		//		$this->assertEquals($expected, $actual);
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
			array($data, 'Links.LinkSetting', 'save'),
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
