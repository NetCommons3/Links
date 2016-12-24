<?php
/**
 * LinkBlock::saveLinkBlock()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsSaveTest', 'NetCommons.TestSuite');
App::uses('LinkBlockFixture', 'Links.Test/Fixture');
App::uses('BlocksLanguageFixture', 'Blocks.Test/Fixture');

/**
 * LinkBlock::saveLinkBlock()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Links\Test\Case\Model\LinkBlock
 */
class LinkBlockSaveLinkBlockTest extends NetCommonsSaveTest {

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
	protected $_modelName = 'LinkBlock';

/**
 * Method name
 *
 * @var string
 */
	protected $_methodName = 'saveLinkBlock';

/**
 * Key Alias
 *
 * @var array
 */
	protected $_keyAlias = 'Block';

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		Current::write('Plugin.key', $this->plugin);
	}

/**
 * Save用DataProvider
 *
 * ### 戻り値
 *  - data 登録データ
 *
 * @return array テストデータ
 */
	public function dataProviderSave() {
		$data['LinkBlock'] = (new LinkBlockFixture())->records[0];
		$data['LinkBlock']['language_id'] = (new BlocksLanguageFixture())->records[0]['language_id'];
		$data['LinkBlock']['name'] = (new BlocksLanguageFixture())->records[0]['name'];
		$data['LinkBlock']['content_count'] = '0';
		$data['LinkSetting']['use_workflow'] = '0';
		$data['Frame'] = array('id' => '6');
		$data['Block'] = array(
			'id' => $data['LinkBlock']['id'],
			'key' => $data['LinkBlock']['key'],
		);
		$data['BlocksLanguage'] = array(
			'language_id' => $data['LinkBlock']['language_id'],
		);

		$results = array();
		// * 編集の登録処理
		$results[0] = array($data);
		// * 新規の登録処理
		$results[1] = array($data);
		$results[1] = Hash::insert($results[1], '0.LinkBlock.id', null);
		$results[1] = Hash::insert($results[1], '0.LinkBlock.key', null);
		$results[1] = Hash::remove($results[1], '0.LinkBlock.created_user');
		$results[1] = Hash::insert($results[1], '0.Block.id', null);
		$results[1] = Hash::insert($results[1], '0.Block.key', null);

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
		if (! $this->_keyAlias) {
			$this->_keyAlias = $this->$model->alias;
		}

		$created = !isset($data[$this->$model->alias]['id']);

		//チェック用データ取得
		if (! $created) {
			$before = $this->$model->find('first', array(
				'recursive' => 0,
				'conditions' => array('LinkBlock.id' => $data[$this->$model->alias]['id']),
			));
		} else {
			$max = $this->$model->find('first', array(
				'recursive' => 0,
				'fields' => array('LinkBlock.id'),
				'order' => array('LinkBlock.id' => 'desc'),
			));
			$before[$this->$model->alias] = array();
		}

		//テスト実行
		$result = $this->$model->$method($data);
		$this->assertNotEmpty($result);

		//idのチェック
		if (isset($data[$this->$model->alias]['id'])) {
			$id = $data[$this->$model->alias]['id'];
		} elseif ($max) {
			$id = (string)($max[$this->$model->alias]['id'] + 1);
		} else {
			$id = $this->$model->getLastInsertID();
		}

		//チェック
		$actual = $this->_getActual($id, $created);
		$expected = $this->_getExpected($id, $data, $before, $created);
		$this->assertEquals($expected, $actual);
	}

/**
 * 結果データ取得
 *
 * @param int $id ID
 * @param bool $created 作成かどうか
 * @return array
 */
	protected function _getActual($id, $created) {
		$model = $this->_modelName;

		//登録データ取得
		$actual = $this->$model->find('first', array(
			'recursive' => 0,
			'conditions' => array('LinkBlock.id' => $id),
		));

		if ($created) {
			$actual[$this->$model->alias] = Hash::remove($actual[$this->$model->alias], 'created');
			$actual[$this->$model->alias] = Hash::remove($actual[$this->$model->alias], 'created_user');
			$actual[$this->$model->alias] = Hash::remove($actual[$this->$model->alias], 'modified');
			$actual[$this->$model->alias] = Hash::remove($actual[$this->$model->alias], 'modified_user');
		} else {
			$actual[$this->$model->alias] = Hash::remove($actual[$this->$model->alias], 'modified');
			$actual[$this->$model->alias] = Hash::remove($actual[$this->$model->alias], 'modified_user');
		}

		return $actual[$this->$model->alias];
	}

/**
 * 期待値の取得
 *
 * @param int $id ID
 * @param array $data 登録データ
 * @param array $before 登録前データ
 * @param bool $created 作成かどうか
 * @return array
 */
	protected function _getExpected($id, $data, $before, $created) {
		$model = $this->_modelName;

		if ($created && $this->$model->hasField('key')) {
			$data[$this->$model->alias]['key'] = OriginalKeyBehavior::generateKey(
				$this->_keyAlias, $this->$model->useDbConfig
			);
		}

		$expected[$this->$model->alias] = Hash::merge(
			$before[$this->$model->alias],
			$data[$this->$model->alias]
		);
		$expected[$this->$model->alias]['id'] = $id;
		$expected[$this->$model->alias] = Hash::remove($expected[$this->$model->alias], 'modified');
		$expected[$this->$model->alias] = Hash::remove($expected[$this->$model->alias], 'modified_user');
		$expected[$this->$model->alias]['block_id'] = $id;
		$expected[$this->$model->alias]['is_origin'] = true;
		$expected[$this->$model->alias]['is_translation'] = false;

		return $expected[$this->$model->alias];
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
		$data = $this->dataProviderSave()[0][0];

		return array(
			array($data, 'Links.LinkBlock', 'save'),
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
		$data = $this->dataProviderSave()[0][0];

		return array(
			array($data, 'Links.LinkBlock'),
		);
	}

}
