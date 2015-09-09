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

App::uses('LinksAppModel', 'Links.Model');

/**
 * LinkSetting Model
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Links\Model
 */
class LinkSetting extends LinksAppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array();

/**
 * Called during validation operations, before validation. Please note that custom
 * validation rules can be defined in $validate.
 *
 * @param array $options Options passed from Model::save().
 * @return bool True if validate operation should continue, false to abort
 * @link http://book.cakephp.org/2.0/en/models/callback-methods.html#beforevalidate
 * @see Model::save()
 */
	public function beforeValidate($options = array()) {
		$this->validate = Hash::merge($this->validate, array(
			'block_key' => array(
				'notBlank' => array(
					'rule' => array('notBlank'),
					'message' => __d('net_commons', 'Invalid request.'),
					'allowEmpty' => false,
					'required' => true,
					'on' => 'update', // Limit validation to 'create' or 'update' operations
				),
			),
			'use_workflow' => array(
				'boolean' => array(
					'rule' => array('boolean'),
					'message' => __d('net_commons', 'Invalid request.'),
				),
			),
		));

		return parent::beforeValidate($options);
	}

/**
 * Get link setting data
 *
 * @param string $blockKey blocks.key
 * @return array
 */
	public function getLinkSetting($blockKey) {
		$conditions = array(
			'block_key' => $blockKey
		);

		$linkSetting = $this->find('first', array(
				'recursive' => -1,
				'conditions' => $conditions,
			)
		);

		return $linkSetting;
	}

/**
 * Save link settings
 *
 * @param array $data received post data
 * @return bool True on success, false on failure
 * @throws InternalErrorException
 */
	public function saveLinkSetting($data) {
		$this->loadModels([
			'LinkSetting' => 'Links.LinkSetting',
			'BlockRolePermission' => 'Blocks.BlockRolePermission',
		]);

		//トランザクションBegin
		$this->setDataSource('master');
		$dataSource = $this->getDataSource();
		$dataSource->begin();

		try {
			if (! $this->validateLinkSetting($data)) {
				return false;
			}
			foreach ($data[$this->BlockRolePermission->alias] as $value) {
				if (! $this->BlockRolePermission->validateBlockRolePermissions($value)) {
					$this->validationErrors = Hash::merge($this->validationErrors, $this->BlockRolePermission->validationErrors);
					return false;
				}
			}

			if (! $this->save(null, false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}
			foreach ($data[$this->BlockRolePermission->alias] as $value) {
				if (! $this->BlockRolePermission->saveMany($value, ['validate' => false])) {
					throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
				}
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
 * validate linkSettings
 *
 * @param array $data received post data
 * @return bool True on success, false on validation errors
 */
	public function validateLinkSetting($data) {
		$this->set($data);
		$this->validates();
		if ($this->validationErrors) {
			return false;
		}
		return true;
	}

}
