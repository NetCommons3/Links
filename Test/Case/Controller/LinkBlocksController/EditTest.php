<?php
/**
 * LinkBlocksController::edit()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('BlocksControllerEditTest', 'Blocks.TestSuite');

/**
 * LinkBlocksController::edit()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Links\Test\Case\Controller\LinkBlocksController
 */
class LinkBlocksControllerEditTest extends BlocksControllerEditTest {

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
 * Controller name
 *
 * @var string
 */
	protected $_controller = 'link_blocks';

/**
 * Edit controller name
 *
 * @var string
 */
	protected $_editController = 'link_blocks';

/**
 * テストDataの取得
 *
 * @param bool $isEdit 編集かどうか
 * @return array
 */
	private function __data($isEdit) {
		$frameId = '6';
		if ($isEdit) {
			$blockId = '4';
			$blockKey = 'block_2';
			$linkId = '3';
			$linkKey = $blockKey;
		} else {
			$blockId = null;
			$blockKey = null;
			$linkId = null;
			$linkKey = $blockKey;
		}

		$data = array(
			'Frame' => array(
				'id' => $frameId
			),
			'Block' => array(
				'id' => $blockId,
				'key' => $blockKey,
				'language_id' => '2',
				'room_id' => '1',
				'plugin_key' => $this->plugin,
				'public_type' => '1',
				'from' => null,
				'to' => null,
			),
			'LinkSetting' => array(
				'id' => $linkId,
				'block_key' => $linkKey,
			),
			'LinkBlock' => array(
				'id' => $blockId,
				'key' => $blockKey,
				'name' => 'Link name',
			),
		);

		return $data;
	}

/**
 * add()アクションDataProvider
 *
 * ### 戻り値
 *  - method: リクエストメソッド（get or post or put）
 *  - data: 登録データ
 *  - validationError: バリデーションエラー
 *
 * @return array
 */
	public function dataProviderAdd() {
		$data = $this->__data(false);

		//テストデータ
		$results = array();
		$results[0] = array('method' => 'get');
		$results[1] = array('method' => 'put');
		$results[2] = array('method' => 'post', 'data' => $data, 'validationError' => false);
		$results[3] = array('method' => 'post', 'data' => $data,
			'validationError' => array(
				'field' => 'LinkBlock.name',
				'value' => '',
				'message' => sprintf(__d('net_commons', 'Please input %s.'), __d('links', 'Link list Title')),
			)
		);

		return $results;
	}

/**
 * edit()アクションDataProvider
 *
 * ### 戻り値
 *  - method: リクエストメソッド（get or post or put）
 *  - data: 登録データ
 *  - validationError: バリデーションエラー
 *
 * @return array
 */
	public function dataProviderEdit() {
		$data = $this->__data(true);

		//テストデータ
		$results = array();
		$results[0] = array('method' => 'get');
		$results[1] = array('method' => 'post');
		$results[2] = array('method' => 'put', 'data' => $data, 'validationError' => false);
		$results[3] = array('method' => 'put', 'data' => $data,
			'validationError' => array(
				'field' => 'LinkBlock.name',
				'value' => '',
				'message' => sprintf(__d('net_commons', 'Please input %s.'), __d('links', 'Link list Title')),
			)
		);

		return $results;
	}

/**
 * edit()アクションのExceptionErrorテスト
 *
 * @return void
 */
	public function testEditGetOnExceptionError() {
		//ログイン
		TestAuthGeneral::login($this);

		//テストデータ
		$this->_mockForReturnFalse('Links.LinkBlock', 'getLinkBlock');

		//テスト実行
		$this->_testGetAction(array('action' => 'edit', 'block_id' => '2', 'frame_id' => '6'), null, 'BadRequestException');

		//ログアウト
		TestAuthGeneral::logout($this);
	}

/**
 * delete()アクションDataProvider
 *
 * ### 戻り値
 *  - data 削除データ
 *
 * @return array
 */
	public function dataProviderDelete() {
		$data = array(
			'Block' => array(
				'id' => '4',
				'key' => 'block_2',
			),
			'LinkBlock' => array(
				'key' => 'block_2',
			),
		);

		//テストデータ
		$results = array();
		$results[0] = array('data' => $data);

		return $results;
	}

/**
 * delete()アクションのExceptionErrorテスト
 *
 * @return void
 */
	public function testDeleteOnExceptionError() {
		//ログイン
		TestAuthGeneral::login($this);

		//テストデータ
		$this->_mockForReturnFalse('Links.LinkBlock', 'deleteLinkBlock');

		//テスト実行
		$data = $this->dataProviderDelete()[0]['data'];
		$this->_testPostAction('delete', $data, array('action' => 'delete', 'block_id' => '2', 'frame_id' => '6'), 'BadRequestException');

		//ログアウト
		TestAuthGeneral::logout($this);
	}

}
