<?php
/**
 * LinkSetting Model
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

//App::uses('LinksAppModel', 'Links.Model');
App::uses('BlockSettingBehavior', 'Blocks.Model/Behavior');
App::uses('BlockAppModel', 'Blocks.Model');

/**
 * LinkSetting Model
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Links\Model
 */
//class LinkSetting extends LinksAppModel {
class LinkSetting extends BlockAppModel {

/**
 * Custom database table name
 *
 * @var string
 */
	public $useTable = false;

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array();

/**
 * use behaviors
 *
 * @var array
 */
	public $actsAs = array(
		'Blocks.BlockRolePermission',
		'Blocks.BlockSetting' => array(
			BlockSettingBehavior::FIELD_USE_WORKFLOW,
		),
	);

/**
 * LinkSettingデータ新規作成
 *
 * @return array
 */
	public function createLinkSetting() {
		//		$linkSetting = $this->createAll();
		/** @see BlockSettingBehavior::getBlockSetting() */
		/** @see BlockSettingBehavior::_createBlockSetting() */
		//		return Hash::merge($linkSetting, $this->getBlockSetting());
		return $this->getBlockSetting();
	}

/**
 * LinkSettingデータ取得
 *
 * @return array
 */
	public function getLinkSetting() {
		//		$linkSetting = $this->find('first', array(
		//			'recursive' => -1,
		//			'conditions' => array(
		//				$this->alias . '.key' => Current::read('Block.key'),
		//				$this->alias . '.language_id' => Current::read('Language.id'),
		//			),
		//		));
		//
		//		return $linkSetting;

		/** @see BlockSettingBehavior::getBlockSetting() */
		return $this->getBlockSetting();
	}

/**
 * Save link settings
 *
 * @param array $data received post data
 * @return bool True on success, false on failure
 * @throws InternalErrorException
 */
	public function saveLinkSetting($data) {
		//トランザクションBegin
		$this->begin();

		//バリデーション
		$this->set($data);
		if (! $this->validates()) {
			return false;
		}

		try {
			$this->save(null, false);
			//			if (! $this->save(null, false)) {
			//				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			//			}

			//トランザクションCommit
			$this->commit();

		} catch (Exception $ex) {
			//トランザクションRollback
			$this->rollback($ex);
		}

		return true;
	}

}
