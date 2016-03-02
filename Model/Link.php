<?php
/**
 * Link Model
 *
 * @property Block $Block
 * @property Category $Category
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('LinksAppModel', 'Links.Model');

/**
 * Link Model
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Links\Model
 */
class Link extends LinksAppModel {

/**
 * use behaviors
 *
 * @var array
 */
	public $actsAs = array(
		'NetCommons.OriginalKey',
		'Workflow.WorkflowComment',
		'Workflow.Workflow',
	);

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
	public $belongsTo = array(
		'LinkOrder' => array(
			'className' => 'Links.LinkOrder',
			'foreignKey' => false,
			'conditions' => 'LinkOrder.link_key=Link.key',
			'fields' => '',
			'order' => array('LinkOrder.weight' => 'asc')
		),
		'Category' => array(
			'className' => 'Categories.Category',
			'foreignKey' => 'category_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'CategoryOrder' => array(
			'className' => 'Categories.CategoryOrder',
			'foreignKey' => false,
			'conditions' => 'CategoryOrder.category_key=Category.key',
			'fields' => '',
			'order' => array('CategoryOrder.weight' => 'asc')
		)
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
			'block_id' => array(
				'numeric' => array(
					'rule' => array('numeric'),
					'message' => __d('net_commons', 'Invalid request.'),
					'allowEmpty' => false,
					'required' => true,
					'on' => 'update', // Limit validation to 'create' or 'update' operations
				),
			),
			'key' => array(
				'notBlank' => array(
					'rule' => array('notBlank'),
					'message' => __d('net_commons', 'Invalid request.'),
					'allowEmpty' => false,
					'required' => true,
					'on' => 'update', // Limit validation to 'create' or 'update' operations
				),
			),
			'language_id' => array(
				'numeric' => array(
					'rule' => array('numeric'),
					'message' => __d('net_commons', 'Invalid request.'),
					'required' => true,
				),
			),
			'click_count' => array(
				'numeric' => array(
					'rule' => array('numeric'),
					'message' => __d('net_commons', 'Invalid request.'),
					'allowEmpty' => true,
				),
			),

			//status to set in PublishableBehavior.

			'url' => array(
				'notBlank' => array(
					'rule' => array('notBlank'),
					'message' => sprintf(__d('net_commons', 'Please input %s.'), __d('links', 'URL')),
					'allowEmpty' => false,
					'required' => true,
				),
				'url' => array(
					'rule' => array('url'),
					'message' => sprintf(__d('net_commons', 'Unauthorized pattern for %s. Please input the data in %s format.'), __d('links', 'URL'), __d('links', 'URL')),
					'allowEmpty' => false,
					'required' => true,
				),
			),
			'title' => array(
				'notBlank' => array(
					'rule' => array('notBlank'),
					'message' => sprintf(__d('net_commons', 'Please input %s.'), __d('links', 'Title')),
					'allowEmpty' => false,
					'required' => true,
				),
			),
		));

		if (isset($this->data['LinkOrder'])) {
			$this->LinkOrder->set($this->data['LinkOrder']);
			if (! $this->LinkOrder->validates()) {
				debug($this->LinkOrder->validationErrors);
				$this->validationErrors = Hash::merge($this->validationErrors, $this->LinkOrder->validationErrors);
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
		//LinkOrder登録
		if (isset($this->LinkOrder->data['LinkOrder'])) {
			$this->data['LinkOrder']['link_key'] = $this->data[$this->alias]['key'];
			$result = $this->LinkOrder->save($this->data['LinkOrder'], false);
			if (! $result) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}
			$this->data['LinkOrder'] = $result['LinkOrder'];
		}
	}

/**
 * Save Link
 *
 * @param array $data received post data
 * @return bool True on success, false on validation errors
 * @throws InternalErrorException
 */
	public function saveLink($data) {
		$this->loadModels([
			'Category' => 'Categories.Category',
			'LinkOrder' => 'Links.LinkOrder',
		]);

		//トランザクションBegin
		$this->begin();

		//バリデーション
		$this->set($data);
		if (! $this->validates()) {
			return false;
		}

		try {
			//Link登録
			if (! $link = $this->save(null, false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			//トランザクションCommit
			$this->commit();

		} catch (Exception $ex) {
			//トランザクションRollback
			$this->rollback($ex);
		}

		return $link;
	}

/**
 * Delete Link
 *
 * @param array $data received post data
 * @return mixed On success Model::$data if its not empty or true, false on failure
 * @throws InternalErrorException
 */
	public function deleteLink($data) {
		$this->loadModels([
			'LinkOrder' => 'Links.LinkOrder',
		]);

		//トランザクションBegin
		$this->begin();

		try {
			if (! $this->deleteAll(array($this->alias . '.key' => $data['Link']['key']), false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			if (! $this->LinkOrder->delete($data['LinkOrder']['id'])) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			//コメントの削除
			$this->deleteCommentsByContentKey($data['Link']['key']);

			//トランザクションCommit
			$this->commit();

		} catch (Exception $ex) {
			//トランザクションRollback
			$this->rollback($ex);
		}

		return true;
	}

/**
 * クリック数の更新
 *
 * @param int $id links.id
 * @return bool True on success, false on validation errors
 * @throws InternalErrorException
 */
	public function updateCount($id) {
		//トランザクションBegin
		$this->begin();

		try {
			$result = $this->updateAll(
				array(
					$this->alias . '.click_count' => $this->alias . '.click_count + 1'
				),
				array(
					$this->alias . '.id' => $id,
					$this->alias . '.block_id' => Current::read('Block.id'),
				)
			);
			if (! $result) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			//トランザクションCommit
			$this->commit();

		} catch (Exception $ex) {
			//トランザクションRollback
			$this->rollback($ex);
		}

		$this->setSlaveDataSource();

		return true;
	}

}
