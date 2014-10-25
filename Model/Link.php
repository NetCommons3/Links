<?php
/**
 * Link Model
 *
 * @property LinksBlock $LinksBlock
 * @property Language $Language
 * @property LinksCategory $LinksCategory
 * @property Block $Block
 *
 * @author   Jun Nishikawa <topaz2@m0n0m0n0.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('LinksAppModel', 'Links.Model');

/**
 * Summary for Link Model
 */
class Link extends LinksAppModel {

/**
 * Link status publish
 *
 * @var int
 */
	const STATUS_PUBLISHED = '1';

/**
 * Link status approval
 *
 * @var int
 */
	const STATUS_APPROVED = '2';

/**
 * Link status draft
 *
 * @var int
 */
	const STATUS_DRAFTED = '3';

/**
 * Link status disapproval
 *
 * @var int
 */
	const STATUS_DISAPPROVED = '4';

/**
 * Use database config
 *
 * @var string
 */
	public $useDbConfig = 'master';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'links_block_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'status' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'language_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
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
		'url' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
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
//		'LinksBlock' => array(
//			'className' => 'LinksBlock',
//			'foreignKey' => 'links_block_id',
//			'conditions' => '',
//			'fields' => '',
//			'order' => ''
//		),
//		'Language' => array(
//			'className' => 'Language',
//			'foreignKey' => 'language_id',
//			'conditions' => '',
//			'fields' => '',
//			'order' => ''
//		),
//		'LinksCategory' => array(
//			'className' => 'LinksCategory',
//			'foreignKey' => 'links_category_id',
//			'conditions' => '',
//			'fields' => '',
//			'order' => ''
//		)
	);

/**
 * hasAndBelongsToMany associations
 *
 * @var array
 */
	public $hasAndBelongsToMany = array(
//		'Block' => array(
//			'className' => 'Block',
//			'joinTable' => 'links_blocks',
//			'foreignKey' => 'link_id',
//			'associationForeignKey' => 'block_id',
//			'unique' => 'keepExisting',
//			'conditions' => '',
//			'fields' => '',
//			'order' => '',
//			'limit' => '',
//			'offset' => '',
//			'finderQuery' => '',
//		)
	);


	public function getLinks($blockId, $contentEditable){
		$conditions = array(
//			'block_id' => $blockId,
		);
		if (! $contentEditable) {
			$conditions['status'] = NetCommonsBlockComponent::STATUS_PUBLISHED;
		}

		$links = $this->find('all', array(
				'conditions' => $conditions,
				'order' => 'Link' . '.id DESC',
			)
		);

//		if (! $links) {
//			$links = $this->create();
//			$links['Link']['content'] = '';
//			$links['Link']['status'] = '0';
//			$links['Link']['block_id'] = '0';
//			$links['Link']['key'] = '';
//			$links['Link']['id'] = '0';
//		}

		return $links;
	}

}
