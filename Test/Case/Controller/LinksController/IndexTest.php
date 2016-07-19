<?php
/**
 * LinksController::index()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('WorkflowControllerIndexTest', 'Workflow.TestSuite');

/**
 * LinksController::index()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Links\Test\Case\Controller\LinksController
 */
class LinksControllerIndexTest extends WorkflowControllerIndexTest {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.categories.category',
		'plugin.categories.category_order',
		'plugin.links.frame4link',
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
 * Controller name
 *
 * @var string
 */
	protected $_controller = 'links';

/**
 * テストDataの取得
 *
 * @param int $frameId フレームID
 * @return array
 */
	private function __data($frameId) {
		$blockId = '2';

		$data = array(
			'action' => 'index',
			'frame_id' => $frameId,
			'block_id' => $blockId,
		);

		return $data;
	}

/**
 * indexアクションのテスト(ログインなし)用DataProvider
 *
 * ### 戻り値
 *  - urlOptions: URLオプション
 *  - assert: テストの期待値
 *  - exception: Exception
 *  - return: testActionの実行後の結果
 *
 * @return array
 */
	public function dataProviderIndex() {
		//テストデータ
		$results = array();
		$results[0] = array(
			'urlOptions' => $this->__data('6'),
			'assert' => array(
				array('method' => 'assertTextContains', 'assert' => '<ul class="list-group'),
				array('method' => 'assertTextContains', 'assert' => 'Description 1'),
			),
		);
		$results[1] = array(
			'urlOptions' => $this->__data('7'),
			'assert' => array(
				array('method' => 'assertTextContains', 'assert' => '<ul class="list-group'),
				array('method' => 'assertTextNotContains', 'assert' => 'Description 1'),
			),
		);
		$results[2] = array(
			'urlOptions' => $this->__data('8'),
			'assert' => array(
				array('method' => 'assertTextContains', 'assert' => '<ul class="dropdown-menu"'),
				array('method' => 'assertTextContains', 'assert' => 'Title 1'),
			),
		);

		return $results;
	}

/**
 * indexアクションのテスト
 *
 * @param array $urlOptions URLオプション
 * @param string $assert テストの期待値
 * @param string|null $exception Exception
 * @param string $return testActionの実行後の結果
 * @dataProvider dataProviderIndex
 * @return void
 */
	public function testIndex($urlOptions, $assert, $exception = null, $return = 'view') {
		//テスト実行
		parent::testIndex($urlOptions, array('method' => 'assertNotEmpty'), $exception, $return);

		//チェック
		$method = $assert[0]['method'];
		$this->$method($assert[0]['assert'], $this->view);

		$method = $assert[1]['method'];
		$this->$method($assert[1]['assert'], $this->view);
	}

/**
 * indexアクションのテスト(作成権限あり)用DataProvider
 *
 * ### 戻り値
 *  - urlOptions: URLオプション
 *  - assert: テストの期待値
 *  - exception: Exception
 *  - return: testActionの実行後の結果
 *
 * @return array
 */
	public function dataProviderIndexByCreatable() {
		return array($this->dataProviderIndex()[0]);
	}

/**
 * indexアクションのテスト(作成権限のみ)
 *
 * @param array $urlOptions URLオプション
 * @param array $assert テストの期待値
 * @param string|null $exception Exception
 * @param string $return testActionの実行後の結果
 * @dataProvider dataProviderIndexByCreatable
 * @return void
 */
	public function testIndexByCreatable($urlOptions, $assert, $exception = null, $return = 'view') {
		//テスト実行
		parent::testIndexByCreatable($urlOptions, array('method' => 'assertNotEmpty'), $exception, $return);

		//チェック
		$method = $assert[0]['method'];
		$this->$method($assert[0]['assert'], $this->view);

		$this->assertTextContains('/links/links/add/2', $this->view);
		$this->assertTextNotContains('/links/link_orders/edit/2', $this->view);
	}

/**
 * indexアクションのテスト(編集権限あり)用DataProvider
 *
 * ### 戻り値
 *  - urlOptions: URLオプション
 *  - assert: テストの期待値
 *  - exception: Exception
 *  - return: testActionの実行後の結果
 *
 * @return array
 */
	public function dataProviderIndexByEditable() {
		return array($this->dataProviderIndex()[0]);
	}

/**
 * indexアクションのテスト(編集権限あり)
 *
 * @param array $urlOptions URLオプション
 * @param array $assert テストの期待値
 * @param string|null $exception Exception
 * @param string $return testActionの実行後の結果
 * @dataProvider dataProviderIndexByEditable
 * @return void
 */
	public function testIndexByEditable($urlOptions, $assert, $exception = null, $return = 'view') {
		//テスト実行
		parent::testIndexByEditable($urlOptions, array('method' => 'assertNotEmpty'), $exception, $return);

		//チェック
		$method = $assert[0]['method'];
		$this->$method($assert[0]['assert'], $this->view);

		$this->assertTextContains('/links/links/add/2', $this->view);
		$this->assertTextContains('/links/link_orders/edit/2', $this->view);
	}

/**
 * ExceptionErrorテスト
 *
 * @return void
 */
	public function testIndexOnExceptionError() {
		$this->_mockForReturnFalse('Links.LinkFrameSetting', 'getLinkFrameSetting');

		//テスト実行
		$this->_testGetAction($this->__data('6'), null, 'BadRequestException');
	}

}
