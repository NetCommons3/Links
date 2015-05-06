<?php
/**
 * LinkBlock Model
 *
 * @property Language $Language
 * @property Room $Room
 * @property Frame $Frame
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('BlocksAppModel', 'Blocks.Model');

/**
 * LinkBlock Model
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Blocks\Model
 */
class LinkBlock extends BlocksAppModel {

/**
 * Custom database table name
 *
 * @var string
 */
	public $useTable = 'blocks';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array();

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $hasOne = array(
		'Block' => array(
			'className' => 'Block',
			'foreignKey' => 'id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * Get link block data
 *
 * @param int $blockId blocks.id
 * @param int $roomId rooms.id
 * @return array
 */
	public function getLinkBlock($blockId, $roomId) {
		$conditions = array(
			'Block.id' => $blockId,
			'Block.room_id' => $roomId,
		);

		$linkBlock = $this->find('first', array(
				'recursive' => 0,
				'conditions' => $conditions,
			)
		);

		return $linkBlock;
	}

/**
 * Save block
 *
 * @param array $data received post data
 * @return bool True on success, false on validation errors
 * @throws InternalErrorException
 */
	public function saveLinkBlock($data) {
		$this->loadModels([
			'LinkSetting' => 'Links.LinkSetting',
			'Block' => 'Blocks.Block',
			'Frame' => 'Frames.Frame',
		]);

		//トランザクションBegin
		$this->setDataSource('master');
		$dataSource = $this->getDataSource();
		$dataSource->begin();

		try {
			//バリデーション
			if (! $this->validateLinkBlock($data, ['linkSetting'])) {
				return false;
			}

			//ブロックの登録
			$block = $this->Block->saveByFrameId($data['Frame']['id']);

			//登録処理
			$this->LinkSetting->data['LinkSetting']['block_key'] = $block['Block']['key'];
			if (! $this->LinkSetting->save(null, false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			//トランザクションCommit
			$dataSource->commit();

		} catch (Exception $ex) {
			//トランザクションRollback
			$dataSource->rollback();
			CakeLog::error($ex);
			throw $ex;
		}

		return true;
	}

/**
 * Validate block
 *
 * @param array $data received post data
 * @param array $contains Optional validate sets
 * @return bool True on success, false on validation errors
 */
	public function validateLinkBlock($data, $contains = []) {
		if (! $this->Block->validateBlock($data)) {
			$this->validationErrors = Hash::merge($this->validationErrors, $this->Block->validationErrors);
			return false;
		}

		if (in_array('linkSetting', $contains, true)) {
			if (! $this->LinkSetting->validateLinkSetting($data)) {
				$this->validationErrors = Hash::merge($this->validationErrors, $this->LinkSetting->validationErrors);
				return false;
			}
		}
		return true;
	}

/**
 * Delete block
 *
 * @param array $data received post data
 * @return mixed On success Model::$data if its not empty or true, false on failure
 * @throws InternalErrorException
 */
	public function deleteLinkBlock($data) {
		$this->setDataSource('master');

		$this->loadModels([
			'Link' => 'Links.Link',
			'LinkSetting' => 'Links.LinkSetting',
			'LinkOrder' => 'Links.LinkOrder',
			'Block' => 'Blocks.Block',
			'Category' => 'Categories.Category',
		]);

		//トランザクションBegin
		$dataSource = $this->getDataSource();
		$dataSource->begin();

		$conditions = array(
			$this->alias . '.key' => $data['Block']['key']
		);
		$blocks = $this->find('list', array(
				'recursive' => -1,
				'conditions' => $conditions,
			)
		);
		$blocks = array_keys($blocks);

		try {
			if (! $this->LinkSetting->deleteAll(array($this->LinkSetting->alias . '.block_key' => $data['Block']['key']), false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			if (! $this->Link->deleteAll(array($this->Link->alias . '.block_id' => $blocks), false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			if (! $this->LinkOrder->deleteAll(array($this->LinkOrder->alias . '.block_key' => $data['Block']['key']), false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			//Categoryデータ削除
			$this->Category->deleteByBlockKey($data['Block']['key']);

			//Blockデータ削除
			$this->Block->deleteBlock($data['Block']['key']);

			//トランザクションCommit
			$dataSource->commit();

		} catch (Exception $ex) {
			//トランザクションRollback
			$dataSource->rollback();
			CakeLog::error($ex);
			throw $ex;
		}

		return true;
	}

}
