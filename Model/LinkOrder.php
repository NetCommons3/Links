<?php
/**
 * LinkOrder Model
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('LinksAppModel', 'Links.Model');

/**
 * LinkOrder Model
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Links\Model
 */
class LinkOrder extends LinksAppModel {

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
			'link_key' => array(
				'notBlank' => array(
					'rule' => array('notBlank'),
					'message' => __d('net_commons', 'Invalid request.'),
					'allowEmpty' => false,
					'required' => true,
					'on' => 'update', // Limit validation to 'create' or 'update' operations
				),
			),
			'weight' => array(
				'numeric' => array(
					'rule' => array('numeric'),
					'message' => __d('net_commons', 'Invalid request.'),
					'allowEmpty' => false,
					//'required' => true,
				),
			),
		));

		return parent::beforeValidate($options);
	}

/**
 * Called before each save operation, after validation. Return a non-true result
 * to halt the save.
 *
 * @param array $options Options passed from Model::save().
 * @return bool True if the operation should continue, false if it should abort
 * @link http://book.cakephp.org/2.0/en/models/callback-methods.html#beforesave
 * @see Model::save()
 */
	public function beforeSave($options = array()) {
		if (isset($this->data[$this->name]['block_key']) &&
			isset($this->data[$this->name]['link_key']) &&
			! $this->data[$this->name]['weight'] &&
			array_key_exists('category_key', $this->data[$this->name])
		) {
			$before = $this->find('first', array(
					'recursive' => -1,
					'fields' => array('block_key', 'category_key', 'weight'),
					'conditions' => array('link_key' => $this->data[$this->name]['link_key']),
				));

			if ($before) {
				if ($before[$this->name]['category_key'] !== $this->data[$this->name]['category_key']) {
					$this->updateAll(
						array($this->name . '.weight' => $this->name . '.weight - 1'),
						array(
							$this->name . '.weight > ' => $before[$this->name]['weight'],
							$this->name . '.block_key' => $before[$this->name]['block_key'],
							$this->name . '.category_key' => $before[$this->name]['category_key'],
						)
					);
					$this->data[$this->name]['weight'] = $this->getMaxWeight(
							$this->data[$this->name]['block_key'],
							$this->data[$this->name]['category_key']
						) + 1;
				}
			} elseif (! $this->id) {
				$this->data[$this->name]['weight'] = $this->getMaxWeight(
						$this->data[$this->name]['block_key'],
						$this->data[$this->name]['category_key']
					) + 1;
			}
		}

		return true;
	}

/**
 * Called before every deletion operation.
 *
 * @param bool $cascade If true records that depend on this record will also be deleted
 * @return bool True if the operation should continue, false if it should abort
 * @link http://book.cakephp.org/2.0/en/models/callback-methods.html#beforedelete
 * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
 */
	public function beforeDelete($cascade = true) {
		if (isset($this->data[$this->name]['link_key']) && isset($this->data[$this->name]['category_key'])) {
			$before = $this->find('first', array(
					'recursive' => -1,
					'fields' => array('block_key', 'category_key', 'weight'),
					'conditions' => array('link_key' => $this->data[$this->name]['link_key']),
				));

			$this->updateAll(
				array($this->name . '.weight' => $this->name . '.weight - 1'),
				array(
					$this->name . '.weight > ' => $before[$this->name]['weight'],
					$this->name . '.block_key' => $before[$this->name]['block_key'],
					$this->name . '.category_key' => $before[$this->name]['category_key'],
				)
			);
		}
		return true;
	}

/**
 * validate of link order
 *
 * @param array $data received post data
 * @return bool True on success, false on validation errors
 */
	public function validateLinkOrder($data) {
		$this->set($data);
		$this->validates();
		if ($this->validationErrors) {
			return false;
		}
		return true;
	}

/**
 * getMaxWeight
 *
 * @param string $blockKey blocks.key
 * @param string $categoryKey categories.key
 * @return int $weight link_orders.weight
 */
	public function getMaxWeight($blockKey, $categoryKey) {
		$order = $this->find('first', array(
				'recursive' => -1,
				'fields' => array('weight'),
				'conditions' => array('block_key' => $blockKey, 'category_key' => $categoryKey),
				'order' => array('weight' => 'DESC')
			));

		if (isset($order[$this->alias]['weight'])) {
			$weight = (int)$order[$this->alias]['weight'];
		} else {
			$weight = 0;
		}
		return $weight;
	}

/**
 * Save LinkOrder
 *
 * @param array $data received post data
 * @return bool True on success, false on validation errors
 * @throws InternalErrorException
 */
	public function saveLinkOrders($data) {
		$this->loadModels([
			'LinkOrder' => 'Links.LinkOrder',
		]);

		//トランザクションBegin
		$this->setDataSource('master');
		$dataSource = $this->getDataSource();
		$dataSource->begin();

		try {
			//バリデーション
			$indexes = array_keys($data['LinkOrders']);
			foreach ($indexes as $i) {
				if (! $this->validateLinkOrder($data['LinkOrders'][$i])) {
					return false;
				}
			}

			//登録処理
			foreach ($indexes as $i) {
				if (! $this->save($data['LinkOrders'][$i], false, false)) {
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

}
