<?php
/**
 * LinksController::delete()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('WorkflowControllerDeleteTest', 'Workflow.TestSuite');

/**
 * LinksController::delete()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Links\Test\Case\Controller\LinksController
 */
class LinksControllerDeleteTest extends WorkflowControllerDeleteTest {

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
	protected $_controller = 'links';

/**
 * テストDataの取得
 *
 * @param string $contentKey キー
 * @return array
 */
	private function __data($contentKey = null) {
		$frameId = '6';
		$blockId = '2';
		$blockKey = 'block_1';
		if ($contentKey === 'link_content_key_2') {
			$contentId = '3';
			$contentOrderId = '2';
		} elseif ($contentKey === 'link_content_key_4') {
			$contentId = '5';
			$contentOrderId = '4';
		} else {
			$contentId = '2';
			$contentOrderId = '1';
		}

		$data = array(
			'delete' => null,
			'Frame' => array(
				'id' => $frameId,
			),
			'Block' => array(
				'id' => $blockId,
				'key' => $blockKey,
			),
			'Link' => array(
				'id' => $contentId,
				'key' => $contentKey,
			),
			'LinkOrder' => array(
				'id' => $contentOrderId,
			),
		);

		return $data;
	}

/**
 * deleteアクションのGETテスト用DataProvider
 *
 * ### 戻り値
 *  - role: ロール
 *  - urlOptions: URLオプション
 *  - assert: テストの期待値
 *  - exception: Exception
 *  - return: testActionの実行後の結果
 *
 * @return array
 */
	public function dataProviderDeleteGet() {
		$data = $this->__data();

		//テストデータ
		$results = array();
		// * ログインなし
		$results[0] = array('role' => null,
			'urlOptions' => array(
				'frame_id' => $data['Frame']['id'],
				'block_id' => $data['Block']['id'],
				'key' => 'link_content_key_1',
			),
			'assert' => null, 'exception' => 'ForbiddenException'
		);
		// * 作成権限のみ(自分自身)
		array_push($results, Hash::merge($results[0], array(
			'role' => Role::ROOM_ROLE_KEY_GENERAL_USER,
			'urlOptions' => array(
				'frame_id' => $data['Frame']['id'],
				'block_id' => $data['Block']['id'],
				'key' => 'link_content_key_2',
			),
			'assert' => null, 'exception' => 'BadRequestException'
		)));
		// * 編集権限、公開権限なし
		array_push($results, Hash::merge($results[0], array(
			'role' => Role::ROOM_ROLE_KEY_EDITOR,
			'assert' => null, 'exception' => 'BadRequestException'
		)));
		// * 公開権限あり
		array_push($results, Hash::merge($results[0], array(
			'role' => Role::ROOM_ROLE_KEY_ROOM_ADMINISTRATOR,
			'assert' => null, 'exception' => 'BadRequestException'
		)));
		array_push($results, Hash::merge($results[0], array(
			'role' => Role::ROOM_ROLE_KEY_ROOM_ADMINISTRATOR,
			'assert' => null, 'exception' => 'BadRequestException', 'return' => 'json'
		)));

		return $results;
	}

/**
 * deleteアクションのPOSTテスト用DataProvider
 *
 * ### 戻り値
 *  - data: 登録データ
 *  - role: ロール
 *  - urlOptions: URLオプション
 *  - exception: Exception
 *  - return: testActionの実行後の結果
 *
 * @return array
 */
	public function dataProviderDeletePost() {
		$data = $this->__data();

		//テストデータ
		$results = array();
		// * ログインなし
		$contentKey = 'link_content_key_1';
		array_push($results, array(
			'data' => $this->__data($contentKey),
			'role' => null,
			'urlOptions' => array(
				'frame_id' => $data['Frame']['id'],
				'block_id' => $data['Block']['id'],
				'key' => $contentKey
			),
			'exception' => 'ForbiddenException'
		));
		// * 作成権限のみ
		// ** 他人の記事
		$contentKey = 'link_content_key_1';
		array_push($results, array(
			'data' => $this->__data($contentKey),
			'role' => Role::ROOM_ROLE_KEY_GENERAL_USER,
			'urlOptions' => array(
				'frame_id' => $data['Frame']['id'],
				'block_id' => $data['Block']['id'],
				'key' => $contentKey
			),
			'exception' => 'BadRequestException'
		));
		$contentKey = 'link_content_key_1';
		array_push($results, array(
			'data' => $this->__data($contentKey),
			'role' => Role::ROOM_ROLE_KEY_GENERAL_USER,
			'urlOptions' => array(
				'frame_id' => $data['Frame']['id'],
				'block_id' => $data['Block']['id'],
				'key' => $contentKey
			),
			'exception' => 'BadRequestException', 'return' => 'json'
		));
		// ** 自分の記事＆一度も公開されていない
		$contentKey = 'link_content_key_2';
		array_push($results, array(
			'data' => $this->__data($contentKey),
			'role' => Role::ROOM_ROLE_KEY_GENERAL_USER,
			'urlOptions' => array(
				'frame_id' => $data['Frame']['id'],
				'block_id' => $data['Block']['id'],
				'key' => $contentKey
			),
		));
		// ** 自分の記事＆一度公開している
		$contentKey = 'link_content_key_4';
		array_push($results, array(
			'data' => $this->__data($contentKey),
			'role' => Role::ROOM_ROLE_KEY_GENERAL_USER,
			'urlOptions' => array(
				'frame_id' => $data['Frame']['id'],
				'block_id' => $data['Block']['id'],
				'key' => $contentKey
			),
			'exception' => 'BadRequestException'
		));
		// * 編集権限あり
		// ** 公開していない
		$contentKey = 'link_content_key_2';
		array_push($results, array(
			'data' => $this->__data($contentKey),
			'role' => Role::ROOM_ROLE_KEY_EDITOR,
			'urlOptions' => array(
				'frame_id' => $data['Frame']['id'],
				'block_id' => $data['Block']['id'],
				'key' => $contentKey
			),
		));
		// ** 公開している
		$contentKey = 'link_content_key_4';
		array_push($results, array(
			'data' => $this->__data($contentKey),
			'role' => Role::ROOM_ROLE_KEY_EDITOR,
			'urlOptions' => array(
				'frame_id' => $data['Frame']['id'],
				'block_id' => $data['Block']['id'],
				'key' => $contentKey
			),
			'exception' => 'BadRequestException'
		));
		// * 公開権限あり
		// ** フレームID指定なしテスト
		$contentKey = 'link_content_key_1';
		array_push($results, array(
			'data' => $this->__data($contentKey),
			'role' => Role::ROOM_ROLE_KEY_ROOM_ADMINISTRATOR,
			'urlOptions' => array(
				'frame_id' => null,
				'block_id' => $data['Block']['id'],
				'key' => $contentKey
			),
		));

		return $results;
	}

/**
 * deleteアクションのExceptionErrorテスト用DataProvider
 *
 * ### 戻り値
 *  - mockModel: Mockのモデル
 *  - mockMethod: Mockのメソッド
 *  - data: 登録データ
 *  - urlOptions: URLオプション
 *  - exception: Exception
 *  - return: testActionの実行後の結果
 *
 * @return array
 */
	public function dataProviderDeleteExceptionError() {
		$data = $this->__data();

		//テストデータ
		$results = array();
		$results[0] = array(
			'mockModel' => 'Links.Link',
			'mockMethod' => 'deleteLink',
			'data' => $data,
			'urlOptions' => array(
				'frame_id' => $data['Frame']['id'],
				'block_id' => $data['Block']['id'],
				'key' => 'link_content_key_1',
			),
			'exception' => 'BadRequestException',
			'return' => 'view'
		);
		$results[1] = Hash::merge($results[0], array(
			'return' => 'json'
		));

		//TODO:必要なデータをここに書く

		return $results;
	}

}
