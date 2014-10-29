<?php
/**
 * LinkCategory Model
 *
 *  前提条件　ユニーク制約 (key and block_id)
 *
 * @property Block $Block
 * @property Link $Link
 *
* @author   Ryuji AMANO <ryuji@ryus.co.jp>
* @link     http://www.netcommons.org NetCommons Project
* @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('LinksAppModel', 'Links.Model');

/**
 * Summary for LinkCategory Model
 */
class LinkCategory extends LinksAppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'block_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'key' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'is_auto_translated' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Block' => array(
			'className' => 'Block',
			'foreignKey' => 'block_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'LinkCategoryOrder' => array(
			'className' => 'Links.LinkCategoryOrder',
			'foreignKey' => false,
			'conditions' => array('LinkCategory.key = LinkCategoryOrder.link_category_key'),
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Link' => array(
			'className' => 'Links.Link',
			'foreignKey' => 'link_category_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);


	public $actsAs = array('Containable');

	public function getCategories($blockId){
		$conditions = array(
			'block_id' => $blockId,
		);

		$this->unbindModel(array(
				'belongsTo' => array('Block'),
				'hasMany' => array('Link'),
			));

		// ソート順はlink_category_ordersテーブル参照
		$categories = $this->find('all', array(
				'conditions' => $conditions,
				'order' => 'LinkCategoryOrder.weight ASC',
			)
		);

		return $categories;
	}

}
