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

App::uses('BlockAppModel', 'Blocks.Model');

/**
 * LinkBlock Model
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Links\Model
 */
class LinkBlock extends BlockAppModel {

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
			)
		),
		'Categories.Category',
		//'M17n.M17n',
		'NetCommons.OriginalKey',
	);

/**
 * Constructor
 *
 * @param bool|int|string|array $id Set this ID for this model on startup,
 * can also be an array of options, see above.
 * @param string $table Name of database table to use.
 * @param string $ds DataSource connection name.
 * @return void
 * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
 */
	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);

		$this->loadModels([
			'Link' => 'Links.Link',
			'LinkSetting' => 'Links.LinkSetting',
			'LinkOrder' => 'Links.LinkOrder',
		]);
	}

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
			'language_id' => array(
				'numeric' => array(
					'rule' => array('numeric'),
					'message' => __d('net_commons', 'Invalid request.'),
					'required' => false,
				),
			),
			'room_id' => array(
				'numeric' => array(
					'rule' => array('numeric'),
					'message' => __d('net_commons', 'Invalid request.'),
					'required' => false,
				),
			),
			'name' => array(
				'notBlank' => array(
					'rule' => array('notBlank'),
					'message' => sprintf(
						__d('net_commons', 'Please input %s.'), __d('links', 'Link list Title')
					),
					'required' => true,
				)
			)
		));

		if (isset($this->data['LinkSetting'])) {
			$this->LinkSetting->set($this->data['LinkSetting']);
			if (! $this->LinkSetting->validates()) {
				$this->validationErrors = Hash::merge(
					$this->validationErrors, $this->LinkSetting->validationErrors
				);
				return false;
			}
		}

		return parent::beforeValidate($options);
	}

/**
 * Called after each successful save operation.
 *
 * @param bool $created True if this save created a new record
 * @param array $options Options passed from Model::save().
 * @return void
 * @link http://book.cakephp.org/2.0/en/models/callback-methods.html#aftersave
 * @see Model::save()
 * @throws InternalErrorException
 */
	public function afterSave($created, $options = array()) {
		//LinkSetting登録
		if (isset($this->data['LinkSetting'])) {
			$this->LinkSetting->set($this->data['LinkSetting']);
			if (! $this->LinkSetting->save(null, false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error 1'));
			}
		}
		parent::afterSave($created, $options);
	}

/**
 * LinkBlockデータ生成
 *
 * @return array LinkBlockデータ配列
 */
	public function createLinkBlock() {
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
		$fields = Hash::merge(
			array(
				$this->alias . '.*',
				$this->Block->alias . '.*',
				$this->LinkSetting->alias . '.*',
			),
			Hash::get($this->belongsTo, 'TrackableCreator.fields', array()),
			Hash::get($this->belongsTo, 'TrackableUpdater.fields', array())
		);

		$linkBlock = $this->find('all', array(
			'recursive' => 0,
			'fields' => $fields,
			'joins' => array(
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
 */
	public function saveLinkBlock($data) {
		//トランザクションBegin
		$this->begin();

		//バリデーション
		$this->set($data);
		if (! $this->validates()) {
			return false;
		}

		try {
			//登録処理
			$this->useTable = false;
			$this->save(null, false);

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
		//トランザクションBegin
		$this->begin();

		$conditions = array(
			$this->alias . '.key' => $data[$this->alias]['key']
		);
		$blocks = $this->find('list', array(
			'recursive' => -1,
			'conditions' => $conditions,
		));
		$blocks = array_keys($blocks);

		try {
			$conditions = array($this->LinkSetting->alias . '.block_key' => $data[$this->alias]['key']);
			if (! $this->LinkSetting->deleteAll($conditions, false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			$this->Link->blockKey = $data[$this->alias]['key'];
			$conditions = array($this->Link->alias . '.block_id' => $blocks);
			if (! $this->Link->deleteAll($conditions, false, true)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			$conditions = array($this->LinkOrder->alias . '.block_key' => $data[$this->alias]['key']);
			if (! $this->LinkOrder->deleteAll($conditions, false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			//Blockデータ削除
			$this->deleteBlock($data[$this->alias]['key']);

			//トランザクションCommit
			$this->commit();

		} catch (Exception $ex) {
			//トランザクションRollback
			$this->rollback($ex);
		}

		return true;
	}

}
