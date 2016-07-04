<?php
/**
 * LinksController::view()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('WorkflowControllerViewTest', 'Workflow.TestSuite');

/**
 * LinksController::view()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Links\Test\Case\Controller\LinksController
 */
class LinksControllerViewTest extends WorkflowControllerViewTest {

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
 * @return array
 */
	private function __data() {
		$frameId = '6';
		$blockId = '2';
		$contentKey = 'content_key_1';

		$data = array(
			'action' => 'view',
			'frame_id' => $frameId,
			'block_id' => $blockId,
			'key' => $contentKey,
		);

		return $data;
	}

/**
 * viewアクションのテスト用DataProvider
 *
 * ### 戻り値
 *  - urlOptions: URLオプション
 *  - assert: テストの期待値
 *  - exception: Exception
 *  - return: testActionの実行後の結果
 *
 * @return array
 */
	public function dataProviderView() {
		$data = $this->__data();

		//テストデータ
		$results = array();
		$results[0] = array(
			'urlOptions' => Hash::insert($data, 'key', 'content_key_1'),
			'assert' => array('method' => 'assertNotEmpty'),
		);
		$results[1] = array(
			'urlOptions' => Hash::insert($data, 'key', 'content_key_2'),
			'assert' => null, 'exception' => 'BadRequestException'
		);
		$results[2] = array(
			'urlOptions' => Hash::insert($data, 'key', 'content_key_3'),
			'assert' => array('method' => 'assertNotEmpty'),
		);
		$results[3] = array(
			'urlOptions' => Hash::insert($data, 'key', 'content_key_4'),
			'assert' => array('method' => 'assertNotEmpty'),
		);
		$results[4] = array(
			'urlOptions' => Hash::insert($data, 'key', 'content_key_5'),
			'assert' => null, 'exception' => 'BadRequestException'
		);
		$results[5] = array(
			'urlOptions' => Hash::insert($data, 'key', 'content_key_999'),
			'assert' => null, 'exception' => 'BadRequestException'
		);

		return $results;
	}

/**
 * viewアクションのテスト
 *
 * @param array $urlOptions URLオプション
 * @param array $assert テストの期待値
 * @param string|null $exception Exception
 * @param string $return testActionの実行後の結果
 * @dataProvider dataProviderView
 * @return void
 */
	public function testView($urlOptions, $assert, $exception = null, $return = 'view') {
		//テスト実行
		parent::testView($urlOptions, $assert, $exception, $return);
		if ($exception) {
			return;
		}

		//チェック
		$this->__assertView($urlOptions['key'], false);
	}

/**
 * viewアクションのテスト(作成権限のみ)用DataProvider
 *
 * ### 戻り値
 *  - urlOptions: URLオプション
 *  - assert: テストの期待値
 *  - exception: Exception
 *  - return: testActionの実行後の結果
 *
 * @return array
 */
	public function dataProviderViewByCreatable() {
		$data = $this->__data();

		//テストデータ
		$results = array();
		$results[0] = array(
			'urlOptions' => Hash::insert($data, 'key', 'content_key_1'),
			'assert' => array('method' => 'assertNotEmpty'),
		);
		$results[1] = array(
			'urlOptions' => Hash::insert($data, 'key', 'content_key_2'),
			'assert' => array('method' => 'assertNotEmpty'),
		);
		$results[2] = array(
			'urlOptions' => Hash::insert($data, 'key', 'content_key_3'),
			'assert' => array('method' => 'assertNotEmpty'),
		);
		$results[3] = array(
			'urlOptions' => Hash::insert($data, 'key', 'content_key_4'),
			'assert' => array('method' => 'assertNotEmpty'),
		);
		$results[4] = array(
			'urlOptions' => Hash::insert($data, 'key', 'content_key_5'),
			'assert' => null, 'exception' => 'BadRequestException'
		);
		$results[5] = array(
			'urlOptions' => Hash::insert($data, 'key', 'content_key_999'),
			'assert' => null, 'exception' => 'BadRequestException'
		);

		return $results;
	}

/**
 * viewアクションのテスト(作成権限のみ)
 *
 * @param array $urlOptions URLオプション
 * @param array $assert テストの期待値
 * @param string|null $exception Exception
 * @param string $return testActionの実行後の結果
 * @dataProvider dataProviderViewByCreatable
 * @return void
 */
	public function testViewByCreatable($urlOptions, $assert, $exception = null, $return = 'view') {
		//テスト実行
		parent::testViewByCreatable($urlOptions, $assert, $exception, $return);
		if ($exception) {
			return;
		}

		//チェック
		if ($urlOptions['key'] === 'content_key_1') {
			$this->__assertView($urlOptions['key'], false);

		} elseif ($urlOptions['key'] === 'content_key_3') {
			$this->__assertView($urlOptions['key'], true);

		} elseif ($urlOptions['key'] === 'content_key_4') {
			$this->__assertView($urlOptions['key'], false);

		} else {
			$this->__assertView($urlOptions['key'], false);
		}
	}

/**
 * viewアクションのテスト用DataProvider
 *
 * ### 戻り値
 *  - urlOptions: URLオプション
 *  - assert: テストの期待値
 *  - exception: Exception
 *  - return: testActionの実行後の結果
 *
 * @return array
 */
	public function dataProviderViewByEditable() {
		$data = $this->__data();

		//テストデータ
		$results = array();
		$results[0] = array(
			'urlOptions' => Hash::insert($data, 'key', 'content_key_1'),
			'assert' => array('method' => 'assertNotEmpty'),
		);
		$results[1] = array(
			'urlOptions' => Hash::insert($data, 'key', 'content_key_2'),
			'assert' => array('method' => 'assertNotEmpty'),
		);
		$results[2] = array(
			'urlOptions' => Hash::insert($data, 'key', 'content_key_3'),
			'assert' => array('method' => 'assertNotEmpty'),
		);
		$results[3] = array(
			'urlOptions' => Hash::insert($data, 'key', 'content_key_4'),
			'assert' => array('method' => 'assertNotEmpty'),
		);
		$results[4] = array(
			'urlOptions' => Hash::insert($data, 'key', 'content_key_5'),
			'assert' => array('method' => 'assertNotEmpty'),
		);
		$results[5] = array(
			'urlOptions' => Hash::insert($data, 'key', 'content_key_999'),
			'assert' => null, 'exception' => 'BadRequestException'
		);

		return $results;
	}

/**
 * viewアクションのテスト(編集権限あり)
 *
 * @param array $urlOptions URLオプション
 * @param array $assert テストの期待値
 * @param string|null $exception Exception
 * @param string $return testActionの実行後の結果
 * @dataProvider dataProviderViewByEditable
 * @return void
 */
	public function testViewByEditable($urlOptions, $assert, $exception = null, $return = 'view') {
		//テスト実行
		parent::testViewByEditable($urlOptions, $assert, $exception, $return);
		if ($exception) {
			return;
		}

		//チェック
		$this->__assertView($urlOptions['key'], true);
	}

/**
 * view()のassert
 *
 * @param string $contentKey コンテンツキー
 * @param bool $isLatest 最終コンテンツかどうか
 * @return void
 * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
 */
	private function __assertView($contentKey, $isLatest = false) {
		if ($contentKey === 'content_key_1') {
			if ($isLatest) {
				//コンテンツのデータ(id=2, key=content_key_1)に対する期待値
				$this->assertTextContains('Title 2', $this->view);
				$this->assertTextContains('Description 2', $this->view);
				$badgeId = 'nc-badge-6-2';
			} else {
				//コンテンツのデータ(id=1, key=content_key_1)に対する期待値
				$this->assertTextContains('Title 1', $this->view);
				$this->assertTextContains('Description 1', $this->view);
				$badgeId = 'nc-badge-6-1';
			}

		} elseif ($contentKey === 'content_key_2') {
			//コンテンツのデータ(id=3, key=content_key_2)に対する期待値
			$this->assertTextContains('Title 3', $this->view);
			$this->assertTextContains('Description 3', $this->view);
			$badgeId = 'nc-badge-6-3';

		} elseif ($contentKey === 'content_key_3') {
			if ($isLatest) {
				//コンテンツのデータ(id=5, key=content_key_3)に対する期待値
				$this->assertTextContains('Title 5', $this->view);
				$this->assertTextContains('Description 5', $this->view);
				$badgeId = 'nc-badge-6-5';
			} else {
				//コンテンツのデータ(id=4, key=content_key_3)に対する期待値
				$this->assertTextContains('Title 4', $this->view);
				$this->assertTextContains('Description 4', $this->view);
				$badgeId = 'nc-badge-6-4';
			}

		} elseif ($contentKey === 'content_key_4') {
			if ($isLatest) {
				//コンテンツのデータ(id=7, key=content_key_4)に対する期待値
				$this->assertTextContains('Title 7', $this->view);
				$this->assertTextContains('Description 7', $this->view);
				$badgeId = 'nc-badge-6-7';
			} else {
				//コンテンツのデータ(id=6, key=content_key_4)に対する期待値
				$this->assertTextContains('Title 6', $this->view);
				$this->assertTextContains('Description 6', $this->view);
				$badgeId = 'nc-badge-6-6';
			}

		} elseif ($contentKey === 'content_key_5') {
			//コンテンツのデータ(id=8, key=content_key_5)に対する期待値
			$this->assertTextContains('Title 8', $this->view);
			$this->assertTextContains('Description 8', $this->view);
			$badgeId = 'nc-badge-6-8';
		}

		$pattern = '/' . preg_quote('<span class="badge"', '/') . ' id="' . $badgeId . '">1' . preg_quote('</span>', '/') . '/';
		$result = str_replace("\n", '', $this->view);
		$result = str_replace("\t", '', $result);
		$this->assertRegExp($pattern, $result);
	}

/**
 * viewアクションのテスト
 *
 * @return void
 */
	//public function testViewOnLinkUpdateCountError() {
	//	//テストデータ
	//	$this->_mockForReturnFalse('Links.Link', 'updateCount');
	//	$urlOptions = Hash::insert($this->__data(), 'key', 'content_key_1');
	//
	//	//テスト実行
	//	parent::testView($urlOptions, null, 'BadRequestException');
	//}

}
