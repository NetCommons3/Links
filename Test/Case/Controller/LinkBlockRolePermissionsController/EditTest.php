<?php
/**
 * LinkBlockRolePermissionsController::edit()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('BlockRolePermissionsControllerEditTest', 'Blocks.TestSuite');

/**
 * LinkBlockRolePermissionsController::edit()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Links\Test\Case\Controller\LinkBlockRolePermissionsController
 */
class LinkBlockRolePermissionsControllerEditTest extends BlockRolePermissionsControllerEditTest {

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
 * Controller name
 *
 * @var string
 */
	protected $_controller = 'link_block_role_permissions';

/**
 * 権限設定で使用するFieldsの取得
 *
 * @return array
 */
	private function __approvalFields() {
		$data = array(
			'LinkSetting' => array(
				'use_workflow',
				'approval_type',
			)
		);

		return $data;
	}

/**
 * テストDataの取得
 *
 * @return array
 */
	private function __data() {
		$data = array(
			'LinkSetting' => array(
				'id' => 2,
				'block_key' => 'block_2',
				'use_workflow' => true,
				'approval_type' => true,
			)
		);

		return $data;
	}

/**
 * edit()アクションDataProvider
 *
 * ### 戻り値
 *  - approvalFields コンテンツ承認の利用有無のフィールド
 *  - exception Exception
 *  - return testActionの実行後の結果
 *
 * @return array
 */
	public function dataProviderEditGet() {
		return array(
			array('approvalFields' => $this->__approvalFields())
		);
	}

/**
 * editアクションのGETテスト(Exceptionエラー)
 *
 * @param array $approvalFields コンテンツ承認の利用有無のフィールド
 * @param string|null $exception Exception
 * @param string $return testActionの実行後の結果
 * @dataProvider dataProviderEditGet
 * @return void
 */

	public function testEditGetExceptionError($approvalFields, $exception = null, $return = 'view') {
		$this->_mockForReturnFalse('Links.LinkBlock', 'getLinkBlock');

		$exception = 'BadRequestException';
		$this->testEditGet($approvalFields, $exception, $return);
	}

/**
 * edit()アクションDataProvider
 *
 * ### 戻り値
 *  - data POSTデータ
 *  - exception Exception
 *  - return testActionの実行後の結果
 *
 * @return array
 */
	public function dataProviderEditPost() {
		return array(
			array('data' => $this->__data())
		);
	}

/**
 * editアクションのPOSTテスト(Saveエラー)
 *
 * @param array $data POSTデータ
 * @param string|null $exception Exception
 * @param string $return testActionの実行後の結果
 * @dataProvider dataProviderEditPost
 * @return void
 */
	public function testEditPostSaveError($data, $exception = null, $return = 'view') {
		$data['BlockRolePermission']['content_creatable'][Role::ROOM_ROLE_KEY_GENERAL_USER]['roles_room_id'] = 'aaaa';

		//テスト実施
		$result = $this->testEditPost($data, false, $return);

		$approvalFields = $this->__approvalFields();
		$this->_assertEditGetPermission($approvalFields, $result);
	}

}
