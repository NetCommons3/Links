<?php
/**
 * LinkCategoryOrder Model
 *
 *
* @author   Ryuji AMANO <ryuji@ryus.co.jp>
* @link     http://www.netcommons.org NetCommons Project
* @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('LinksAppModel', 'Links.Model');

/**
 * Summary for LinkCategoryOrder Model
 */
class LinkCategoryOrder extends LinksAppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'link_category_key' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'block_key' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'weight' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	public function addLinkCategoryOrder($linkCategory){
		$Block = ClassRegistry::init('Block');
		$block = $Block->findById($linkCategory['LinkCategory']['block_id']);

		$linkCategoryOrder['LinkCategoryOrder']['link_category_key'] = $linkCategory['LinkCategory']['key'];
		$linkCategoryOrder['LinkCategoryOrder']['block_key'] = $block['Block']['key'];

		$linkCategoryOrder['LinkCategoryOrder']['weight'] = $this->_getMaxWightByBlockKey($block['Block']['key']) + 1;
		$linkCategoryOrder['LinkCategoryOrder']['created_user'] = CakeSession::read('Auth.User.id');;

		if (! $this->save($linkCategoryOrder)) {
			throw new ForbiddenException(serialize($this->validationErrors));
		}

	}

	protected function _getMaxWightByBlockKey($blockKey) {
		$options = array(
			'conditions' => array(
				'block_key' => $blockKey,
			),
			'order' => 'weight DESC'
		);
		$linkCategoryOrder = $this->find('first', $options);
		return $linkCategoryOrder['LinkCategoryOrder']['weight'] ;
	}
}
