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
 * @package NetCommons\Links\Model
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
			'className' => 'Blocks.Block',
			'foreignKey' => 'id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * use behaviors
 *
 * @var array
 */
	public $actsAs = array(
		'Blocks.Block' => array(
			'name' => 'LinkBlock.name',
			'loadModels' => array(
				'Category' => 'Categories.Category',
				'CategoryOrder' => 'Categories.CategoryOrder',
				'WorkflowComment' => 'Workflow.WorkflowComment',
			)
		),
		'Categories.Category',
		'M17n.M17n',
		'Workflow.WorkflowComment',
	);

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
			//'language_id' => array(
			//	'numeric' => array(
			//		'rule' => array('numeric'),
			//		'message' => __d('net_commons', 'Invalid request.'),
			//		'required' => true,
			//	),
			//),
			//'room_id' => array(
			//	'numeric' => array(
			//		'rule' => array('numeric'),
			//		'message' => __d('net_commons', 'Invalid request.'),
			//		'required' => true,
			//	),
			//),
			'name' => array(
				'notBlank' => array(
					'rule' => array('notBlank'),
					'message' => sprintf(__d('net_commons', 'Please input %s.'), __d('links', 'Link list Title')),
					'required' => true,
				)
			)
		));

		if (isset($this->data['LinkSetting'])) {
			$this->loadModels(['LinkSetting' => 'Links.LinkSetting']);
			$this->LinkSetting->set($this->data['LinkSetting']);
			if (! $this->LinkSetting->validates()) {
				$this->validationErrors = Hash::merge($this->validationErrors, $this->LinkSetting->validationErrors);
				return false;
			}
		}

		return parent::beforeValidate($options);
	}

/**
 * Called before each save operation, after validation. Return a non-true result
 * to halt the save.
 *
 * @param array $options Options passed from Model::save().
 * @return bool True if the operation should continue, false if it should abort
 * @link http://book.cakephp.org/2.0/en/models/callback-methods.html#beforesave
 * @throws InternalErrorException
 * @see Model::save()
 */
	public function beforeSave($options = array()) {
		//LinkSetting登録
		if (isset($this->data['LinkSetting'])) {
			$this->LinkSetting->set($this->data['LinkSetting']);
		}
		if (isset($this->LinkSetting->data['LinkSetting'])) {
			if (! $this->LinkSetting->save(null, false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}
		}

		return true;
	}

/**
 * LinkBlockデータ生成
 *
 * @return array LinkBlockデータ配列
 */
	public function createLinkBlock() {
		$this->LinkSetting = ClassRegistry::init('Links.LinkSetting');

		$linkBlock = $this->createAll(array(
			'LinkBlock' => array(
				'name' => __d('links', 'New Bookmark List %s', date('YmdHis')),
			),
		));

		return Hash::merge($linkBlock, $this->LinkSetting->create());
	}

/**
 * LinkBlockデータ取得
 *
 * @return array LinkBlockデータ配列
 */
	public function getLinkBlock() {
		$this->LinkSetting = ClassRegistry::init('Links.LinkSetting');

		$linkBlock = $this->find('all', array(
			'recursive' => -1,
			'fields' => array(
				$this->alias . '.*',
				$this->Block->alias . '.*',
				$this->LinkSetting->alias . '.*',
			),
			'joins' => array(
				array(
					'table' => $this->Block->table,
					'alias' => $this->Block->alias,
					'type' => 'INNER',
					'conditions' => array(
						$this->alias . '.id' . ' = ' . $this->Block->alias . ' .id',
					),
				),
				array(
					'table' => $this->LinkSetting->table,
					'alias' => $this->LinkSetting->alias,
					'type' => 'INNER',
					'conditions' => array(
						$this->alias . '.key' . ' = ' . $this->LinkSetting->alias . ' .block_key',
					),
				),
			),
			'conditions' => $this->getBlockConditionById(),
		));

		if (! $linkBlock) {
			return false;
		}
		return $linkBlock[0];
	}

/**
 * LinkBlock登録処理
 *
 * @param array $data received post data
 * @return bool True on success, false on validation errors
 * @throws InternalErrorException
 */
	public function saveLinkBlock($data) {
		$this->loadModels([
			'LinkSetting' => 'Links.LinkSetting',
		]);

		//トランザクションBegin
		$this->begin();

		//バリデーション
		$this->set($data);
		if (! $this->validates()) {
			return false;
		}

		try {
			//登録処理
			if (! $this->save(null, false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			//トランザクションCommit
			$this->commit();

		} catch (Exception $ex) {
			//トランザクションRollback
			$this->rollback($ex);
		}

		return true;
	}

/**
 * LinkBlockの削除処理
 *
 * @param array $data received post data
 * @return mixed On success Model::$data if its not empty or true, false on failure
 * @throws InternalErrorException
 */
	public function deleteLinkBlock($data) {
		$this->loadModels([
			'Link' => 'Links.Link',
			'LinkSetting' => 'Links.LinkSetting',
			'LinkOrder' => 'Links.LinkOrder',
		]);

		//トランザクションBegin
		$this->begin();

		$conditions = array(
			$this->alias . '.key' => $data['Block']['key']
		);
		$blocks = $this->find('list', array(
			'recursive' => -1,
			'conditions' => $conditions,
		));
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

			//Blockデータ削除
			$this->deleteBlock($data['Block']['key']);

			//トランザクションCommit
			$this->commit();

		} catch (Exception $ex) {
			//トランザクションRollback
			$this->rollback($ex);
		}

		return true;
	}

}
