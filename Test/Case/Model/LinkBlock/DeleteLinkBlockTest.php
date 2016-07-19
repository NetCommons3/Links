<?php
/**
 * LinkBlock::deleteLinkBlock()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('WorkflowDeleteTest', 'Workflow.TestSuite');
App::uses('LinkBlockFixture', 'Links.Test/Fixture');

/**
 * LinkBlock::deleteLinkBlock()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Links\Test\Case\Model\LinkBlock
 */
class LinkBlockDeleteLinkBlockTest extends WorkflowDeleteTest {

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
	protected $_methodName = 'deleteLinkBlock';

/**
 * Delete用DataProvider
 *
 * ### 戻り値
 *  - data: 削除データ
 *  - associationModels: 削除確認の関連モデル array(model => conditions)
 *
 * @return array テストデータ
 * @see NetCommonsDeleteTest::testDelete()
 */
	public function dataProviderDelete() {
		$data = array(
			'LinkBlock' => array(
				'id' => '2',
				'key' => 'block_1'
			)
		);
		$association = array(
			'LinkSetting' => array('key' => $data['LinkBlock']['key']),
			'Link' => array('block_id' => $data['LinkBlock']['id']),
			'LinkOrder' => array('block_key' => $data['LinkBlock']['key']),
		);

		$results = array();
		$results[0] = array($data, $association);

		return $results;
	}

/**
 * ExceptionError用DataProvider
 *
 * ### 戻り値
 *  - data 登録データ
 *  - mockModel Mockのモデル
 *  - mockMethod Mockのメソッド
 *
 * @return array テストデータ
 */
	public function dataProviderDeleteOnExceptionError() {
		$data = $this->dataProviderDelete()[0][0];

		return array(
			array($data, 'Links.Link', 'deleteAll'),
			array($data, 'Links.LinkOrder', 'deleteAll'),
		);
	}

}
