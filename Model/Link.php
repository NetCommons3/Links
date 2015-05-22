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
		'NetCommons.Publishable',
		'NetCommons.OriginalKey',
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
		'Block' => array(
			'className' => 'Block',
			'foreignKey' => 'block_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
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
				'notEmpty' => array(
					'rule' => array('notEmpty'),
					'message' => __d('net_commons', 'Invalid request.'),
					'allowEmpty' => false,
					'required' => true,
					'on' => 'update', // Limit validation to 'create' or 'update' operations
				),
			),

			//status to set in PublishableBehavior.

			'click_count' => array(
				'numeric' => array(
					'rule' => array('numeric'),
					'message' => __d('net_commons', 'Invalid request.'),
					'allowEmpty' => true,
				),
			),

			//status to set in PublishableBehavior.

			'url' => array(
				'notEmpty' => array(
					'rule' => array('notEmpty'),
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
				'notEmpty' => array(
					'rule' => array('notEmpty'),
					'message' => sprintf(__d('net_commons', 'Please input %s.'), __d('links', 'Title')),
					'allowEmpty' => false,
					'required' => true,
				),
			),
		));

		return parent::beforeValidate($options);
	}

/**
 * Get Links
 *
 * @param array $conditions findAll conditions
 * @return array Links
 */
	public function getLinks($conditions) {
		$links = $this->find('all', array(
			'recursive' => 0,
			'conditions' => $conditions,
			'order' => array(
				'CategoryOrder.weight' => 'asc',
				'LinkOrder.weight' => 'asc',
			),
		));
		return $links;
	}

/**
 * Get Link
 *
 * @param int $blockId blocks.id
 * @param string $linkKey links.key
 * @param array $conditions find conditions
 * @return array Link
 */
	public function getLink($blockId, $linkKey, $conditions = []) {
		$conditions[$this->alias . '.block_id'] = $blockId;
		$conditions[$this->alias . '.key'] = $linkKey;

		$link = $this->find('first', array(
				'recursive' => 0,
				'conditions' => $conditions,
			)
		);

		return $link;
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
			'Link' => 'Links.Link',
			'LinkOrder' => 'Links.LinkOrder',
			'Comment' => 'Comments.Comment',
		]);

		//トランザクションBegin
		$this->setDataSource('master');
		$dataSource = $this->getDataSource();
		$dataSource->begin();

		try {
			//バリデーション
			if (! $this->validateLink($data, ['linkOrder', 'comment'])) {
				return false;
			}

			//Link登録
			if (! $link = $this->save(null, false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			//LinkOrder登録
			$this->LinkOrder->data['LinkOrder']['category_key'] = $data['Category']['key'];
			if (! $data['LinkOrder']['link_key']) {
				$this->LinkOrder->data['LinkOrder']['link_key'] = $link[$this->alias]['key'];
			}
			if (! $this->LinkOrder->save(null, false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}
			//Comment登録
			if (isset($data['Comment']) && $this->Comment->data) {
				$this->Comment->data[$this->Comment->name]['block_key'] = $link['Block']['key'];
				$this->Comment->data[$this->Comment->name]['content_key'] = $link[$this->name]['key'];
				if (! $this->Comment->save(null, false)) {
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

		return $link;
	}

/**
 * validate of Link
 *
 * @param array $data received post data
 * @param array $contains Optional validate sets
 * @return bool True on success, false on validation errors
 */
	public function validateLink($data, $contains = []) {
		$this->set($data);
		$this->validates();
		if ($this->validationErrors) {
			return false;
		}
		if (in_array('linkOrder', $contains, true)) {
			if (! $this->LinkOrder->validateLinkOrder($data)) {
				$this->validationErrors = Hash::merge($this->validationErrors, $this->LinkOrder->validationErrors);
				return false;
			}
		}
		if (in_array('comment', $contains, true) && isset($data['Comment'])) {
			if (! $this->Comment->validateByStatus($data, array('plugin' => $this->plugin, 'caller' => $this->name))) {
				$this->validationErrors = Hash::merge($this->validationErrors, $this->Comment->validationErrors);
				return false;
			}
		}
		return true;
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
			'Link' => 'Links.Link',
			'LinkOrder' => 'Links.LinkOrder',
			'Comment' => 'Comments.Comment',
		]);

		//トランザクションBegin
		$this->setDataSource('master');
		$dataSource = $this->getDataSource();
		$dataSource->begin();

		try {
			if (! $this->deleteAll(array($this->alias . '.key' => $data['Link']['key']), false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			$this->LinkOrder->data = array(
				$this->LinkOrder->name => array(
					'link_key' => $data['Link']['key'],
				)
			);
			if (! $this->LinkOrder->deleteAll(
				$this->LinkOrder->data[$this->LinkOrder->name], false
			)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			//コメントの削除
			$this->Comment->deleteByContentKey($data['Link']['key']);

			//トランザクションCommit
			$dataSource->commit();

		} catch (Exception $ex) {
			//トランザクションRollback
			$dataSource->rollback();
			//エラー出力
			CakeLog::error($ex);
			throw $ex;
		}

		return true;
	}

/**
 * Update count
 *
 * @param int $id links.id
 * @param int $blockId blocks.id
 * @return bool True on success, false on validation errors
 * @throws InternalErrorException
 */
	public function updateCount($id, $blockId) {
		$this->loadModels([
			'Link' => 'Links.Link',
		]);

		//トランザクションBegin
		$this->setDataSource('master');
		$dataSource = $this->getDataSource();
		$dataSource->begin();

		try {
			$this->updateAll(
				array($this->name . '.click_count' => $this->name . '.click_count + 1'),
				array(
					$this->name . '.id' => $id,
					$this->name . '.block_id' => $blockId,
				)
			);

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
