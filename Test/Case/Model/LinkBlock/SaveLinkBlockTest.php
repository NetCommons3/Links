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
App::uses('BlockFixture', 'Blocks.Test/Fixture');

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
		$data['LinkBlock']['content_count'] = '0';
		$data['LinkSetting'] = (new BlockFixture())->records[0];
		$data['Frame'] = array('id' => '6');
		$data['Block'] = array(
			'id' => $data['LinkBlock']['id'],
			'key' => $data['LinkBlock']['key'],
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
		$results[1] = Hash::insert($results[1], '0.LinkSetting.id', null);
		$results[1] = Hash::insert($results[1], '0.LinkSetting.key', '');
		$results[1] = Hash::remove($results[1], '0.LinkSetting.created_user');
		$results[1] = Hash::insert($results[1], '0.Block.id', null);
		$results[1] = Hash::insert($results[1], '0.Block.key', null);

		return $results;
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
			array($data, 'Links.LinkBlock', 'saveBlock'),
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
		$data = $this->dataProviderSave()[0][0];

		return array(
			array($data, 'Links.LinkBlock'),
		);
	}

}
