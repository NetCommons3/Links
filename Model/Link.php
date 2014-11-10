<?php
/**
 * Link Model
 *
 * @property LinkCategory $LinkCategory
 *
* @author   Ryuji AMANO <ryuji@ryus.co.jp>
* @link     http://www.netcommons.org NetCommons Project
* @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('LinksAppModel', 'Links.Model');

/**
 * Summary for Link Model
 */
class Link extends LinksAppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'url' => array(
			'url' => [
				'rule' => array('url'),
//				'message' => 'Your custom message here',
				'message' => 'required url', // ここでは__d()を使えないので多言語化のキーを記述しておいて、後プロセスで__dをかます。
				//'allowEmpty' => false,
				'required' => true,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			],
		),

		'link_category_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Your custom message here',
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
		'click_number' => array(
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
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'LinkCategory' => array(
			'className' => 'Links.LinkCategory',
			'foreignKey' => 'link_category_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'LinkOrder' => array(
			'className' => 'Links.LinkOrder',
			'foreignKey' => false,
			'conditions' => array('Link.key = LinkOrder.link_key'),
		)


	);

	public function getLinksByCategoryId($categoryId, $blockId, $contentEditable){
		$conditions = array(
			'link_category_id' => $categoryId,
			'LinkCategory.block_id' => $blockId,
		);
		if (! $contentEditable) {
			$conditions['status'] = NetCommonsBlockComponent::STATUS_PUBLISHED;
		}

		$links = $this->find('all', array(
				'conditions' => $conditions,
				'order' => 'LinkOrder.weight ASC',
			)
		);

		return $links;
	}

	public function add($postData) {
		//DBへの登録
		$dataSource = $this->getDataSource();
		$dataSource->begin();
		try {

			// MyTodo block_id取得, key生成、 created_userセットは別途ビヘイビアつくってBeforeSaveあたりで処理すりゃええんちゃうか
			//linksへ 登録
			$link['Link'] = $postData['Link'];
			$link['Link']['key'] = $this->_makeKey(); //新規時はkeyを新規に発行
			$link['Link']['created_user'] = CakeSession::read('Auth.User.id');



			if (! $this->save($link)) {
				throw new ForbiddenException(serialize($this->validationErrors));
			}
			$this->LinkOrder->addLinkOrder($link);
			$dataSource->commit();
			return true;

		} catch (Exception $ex) {
			CakeLog::error($ex->getTraceAsString());
			$dataSource->rollback();
			return false;
		}
	}

	// Todo ビヘイビアにしたらええと思う
	protected function _makeKey() {
		$className = get_class($this);
		return hash('sha256', $className . microtime());
	}
}
