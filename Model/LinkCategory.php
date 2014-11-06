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

	public function saveLinkCategory($postData){
		$models = array(
			'Frame' => 'Frames.Frame',
			'Block' => 'Blocks.Block',
		);
		foreach ($models as $model => $class) {
			$this->$model = ClassRegistry::init($class);
			$this->$model->setDataSource('master');
		}

		//frame関連のセット
		$frame = $this->Frame->findById($postData['Frame']['frame_id']);
		if (! $frame) {
			return false;
		}
		if (! isset($frame['Frame']['block_id']) ||
			$frame['Frame']['block_id'] === '0') {
			//generate link_categories.key
		}

		//DBへの登録
		$dataSource = $this->getDataSource();
		$dataSource->begin();
		try {
			$blockId = $this->__saveBlock($frame);

			// MyTodo block_id取得, key生成、 created_userセットは別途ビヘイビアつくってBeforeSaveあたりで処理すりゃええんちゃうか
			//link_categoriesへ 登録
			$linkCategory['LinkCategory'] = $postData['LinkCategory'];
			$linkCategory['LinkCategory']['key'] = hash('sha256', 'link_category_' . microtime()); //新規時はkeyを新規に発行
			$linkCategory['LinkCategory']['block_id'] = $blockId;
			$linkCategory['LinkCategory']['created_user'] = CakeSession::read('Auth.User.id');



			if (! $this->save($linkCategory)) {
				throw new ForbiddenException(serialize($this->validationErrors));
			}
			$this->LinkCategoryOrder->addLinkCategoryOrder($linkCategory);
			$dataSource->commit();
			return true;

		} catch (Exception $ex) {
			CakeLog::error($ex->getTraceAsString());
			$dataSource->rollback();
			return false;
		}

	}

	public function updateCategories($postData) {
		return $this->saveMany($postData['LinkCategories'], array('deep' => true));
	}

	/**
	 * save block
	 * ブロックモデルが担当した方がいいんじゃね？ By Ryuji
	 * @param array $frame frame data
	 * @return int blocks.id
	 * @throws ForbiddenException
	 *
	 */
	private function __saveBlock($frame) {
		if (! isset($frame['Frame']['block_id']) ||
			$frame['Frame']['block_id'] === '0') {
			//blocksテーブル登録
			$block = array();
			$block['Block']['room_id'] = $frame['Frame']['room_id'];
			$block['Block']['language_id'] = $frame['Frame']['language_id'];
			$block = $this->Block->save($block);
			if (! $block) {
				throw new ForbiddenException(serialize($this->Block->validationErrors));
			}
			$blockId = (int)$block['Block']['id'];

			//framesテーブル更新
			$frame['Frame']['block_id'] = $blockId;
			if (! $this->Frame->save($frame)) {
				throw new ForbiddenException(serialize($this->Frame->validationErrors));
			}
		}

		return (int)$frame['Frame']['block_id'];
	}

}
