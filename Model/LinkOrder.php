<?php
/**
 * LinkOrder Model
 *
 *
* @author   Ryuji AMANO <ryuji@ryus.co.jp>
* @link     http://www.netcommons.org NetCommons Project
* @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('LinksAppModel', 'Links.Model');

/**
 * Summary for LinkOrder Model
 */
class LinkOrder extends LinksAppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'link_key' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
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

	public function addLinkOrder($link) {
		$LinkCategory = ClassRegistry::init('Links.LinkCategory');
		$linkCategoryId = $link['Link']['link_category_id'];
		$linkCategory = $LinkCategory->findById($linkCategoryId);
		$linkCategoryKey = $linkCategory['LinkCategory']['key'];


		$linkOrder['LinkOrder']['link_key'] = $link['Link']['key'];
		$linkOrder['LinkOrder']['link_category_key'] = $linkCategoryKey;

		$linkOrder['LinkOrder']['weight'] = $this->_getMaxWeightByLinkCategoryKey($linkCategoryKey) + 1;
		$linkOrder['LinkOrder']['created_user'] = CakeSession::read('Auth.User.id');;

		if (! $this->save($linkOrder)) {
			throw new ForbiddenException(serialize($this->validationErrors));
		}

	}
	protected function _getMaxWeightByLinkCategoryKey($linkCategoryKey) {
		$options = array(
			'conditions' => array(
				'link_category_key' => $linkCategoryKey,
			),
			'order' => 'weight DESC'
		);
		$linkOrder = $this->find('first', $options);
		if(empty($linkOrder)){
			return 0; // まだ登録がない
		}else{
			return $linkOrder['LinkOrder']['weight'] ;
		}
	}

}
