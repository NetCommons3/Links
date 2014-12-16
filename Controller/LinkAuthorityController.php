<?php
/**
 * LinkAuthority Controller
 *
 * @author Ryuji AMANO <ryuji@ryus.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('LinksAppController', 'Links.Controller');

/**
 * LinkAuthority Controller
 *
 * @author Ryuji AMANO <ryuji@ryus.co.jp>
 * @package NetCommons\Links\Controller
 */
class LinkAuthorityController extends LinksAppController {

/**
 * use model
 *
 * @var array
 */
	public $uses = array(
		'Blocks.BlockRolePermission',
		'Rooms.RolesRoom',
		'Rooms.RoomRolePermission',
		'Roles.Role',
		'Frames.Frame'
	);

/**
 * use component
 *
 * @var array
 */
	public $components = array(
		'NetCommons.NetCommonsFrame',
		'NetCommons.NetCommonsRoomRole',
	);

/**
 * beforeFilter
 *
 * @return void
 */
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow();
	}

/**
 * view method
 *
 * @param int $frameId frames.id
 * @param string $lang ex)"en" or "ja" etc.
 * @return CakeResponse A response object containing the rendered view.
 */
	public function view($frameId = 0, $type = 'list') {
		if ($this->response->statusCode() !== 200) {
			return $this->render(false);
		}

		return $this->render('LinkAuthority/view', false);
	}

	public function form($frameId = 0) {
		// frameIdからroom取得
		$frame = $this->Frame->findById($frameId);
		$roles = $this->RolesRoom->findAllByRoomId($frame['Frame']['room_id']);
		foreach($roles as $role){
			$roleKey = $role['RolesRoom']['role_key'];
			$rolePermission[$roleKey] = false;
		}
		unset($rolePermission['room_administrator']); //ルーム管理者は制限しないので取り除く
		$this->set('rolePermission', $rolePermission);
		$this->set('frameId', $frameId);
	}
	public function edit($frameId = 0) {
		if (! $this->request->isPost()) {
			throw new MethodNotAllowedException();
		}
		//保存
		if ($this->saveBlockRolePermission($frameId, $this->data)) {

			$result = array(
				'name' => __d('net_commons', 'Successfully finished.'),
			);

			$this->set(compact('result'));
			$this->set('_serialize', 'result');
			return $this->render(false);
		} else {

			$error = __d('net_commons', 'Failed to register data.');
//			$error .= $this->formatValidationErrors($this->LinkFrameSetting->validationErrors);
			throw new ForbiddenException($error);
		}

	}
	public function get($frameId = 0) {
		// frameIdからroom取得
		$frame = $this->Frame->findById($frameId);
		$roomId = $frame['Frame']['room_id'];

		$roles = $this->getContentCreatableRoomRoles($roomId);
debug($roles);
		// リンク集の権限をblock_role_permissionsから取り出す（不要？）
		$blockRolePermission = $this->getBlockRolePermissionByFrame($frame);
		$ret = array();
		foreach($roles as $role){
			$roleKey = $role['Role']['key'];
			$var = array(
				'name' => $role['Role']['name'],
				'permission' => false, // MyTodo BlockRolePermissionからセット
			);
			$ret['add_link'][$roleKey] = $var;
		}
		unset($ret['add_link']['room_administrator']); //ルーム管理者は制限しないので取り除く
		$this->set('roles', $ret);
		$this->set('_serialize', 'roles');
		return $this->render(false);

	}

	/**
	 * ルーム管理者以外でリンク作成可能（contetn_creatable）なルームロールを返す
	 *
	 */
	protected function getContentCreatableRoomRoles($roomId) {
		// ルームから　roles_rooms からルームのロールを読み出し
		// role_keyに対応した言語をrolesテーブルから読み出したいのでbindModel モデルで定義しときたいなぁ
		$this->RolesRoom->bindModel(
			array(
				'hasMany' => array(
					'RoomRolePermission' => array(
						'className' => 'Rooms.RoomRolePermission'
					)
				),
				'belongsTo' => array(
					'Role' => array(
						'className' => 'Roles.Role',
						'foreignKey' => false,
						'conditions' => array('RolesRoom.role_key = Role.key'),
					),
				),
			)
		);
		$conditions = array(
			'room_id' => $roomId,
			'RoomRolePermission.permission' => 'content_creatable', //ε(　　　　 v ﾟωﾟ)　＜ conttent_creatableはマジックナンバー？
			'RoomRolePermission.value' => 1, //ε(　　　　 v ﾟωﾟ)　＜マジックナンバー？
			'role_key !=' => 'room_administrator' // ルーム管理者は除外する
		);

		$roles = $this->RolesRoom->find('all', array(
				'conditions' => $conditions
			));
		return $roles;

	}

	protected function saveBlockRolePermission($frameId, $data) {
		// MyTodo 現在のBlockRolePermissionを削除

		$frame = $this->Frame->findById($frameId);
		$roomId = $frame['Frame']['room_id'];
		// block_key
		$blockKey = $frame['Block']['key'];
		foreach($data['BlockRolePermission'] as $permission => $roles){
			foreach($roles as $roleKey => $value){
				$saveData = array(
					'roles_room_id' => '', // MyTodo
					'block_key' => $blockKey,
					'permission' => $permission,
					'value' => $value,
				);
				$this->BlockRolePermission->create(); // MyTodo 既にある場合は？
				$this->BlockRolePermission->save($saveData);
			}
		}
		// roles_room_id <- roke_key AND room_id から
		// permisssion
		// value

	}

	protected function getBlockRolePermissionByFrame($frame) {
		$blockKey = $frame['Block']['key'];
		$blockRolePermission = $this->BlockRolePermission->findByBlockKey($blockKey);
		return $blockRolePermission;
	}
}
