<?php
/**
 * LinkFrameSetting Model
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('LinksAppModel', 'Links.Model');
App::uses('Folder', 'Utility');

/**
 * LinkFrameSetting Model
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Links\Model
 */
class LinkFrameSetting extends LinksAppModel {

/**
 * Type
 *
 * @var string
 */
	const
		TYPE_DROPDOWN = '1',
		TYPE_LIST_ONLY_TITLE = '2',
		TYPE_LIST_WITH_DESCRIPTION = '3';

/**
 * categorySeparatorLine
 *
 * @var array
 */
	static public $categorySeparators = array();

/**
 * categorySeparatorLine default
 *
 * @var string
 */
	const CATEGORY_SEPARATOR_DEFAULT = 'default';

/**
 * categorySeparatorLine default
 *
 * @var string
 */
	const LINE_STYLE_NONE = 'none',
			LINE_STYLE_DISC = 'disc',
			LINE_STYLE_CIRCLE = 'circle',
			LINE_STYLE_LOWER_ALPHA = 'lower-alpha',
			LINE_STYLE_UPPER_ALPHA = 'upper-alpha';

/**
 * listStyle
 *
 * @var array
 */
	static public $listStyles = array();

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array();

/**
 * Constructor. Binds the model's database table to the object.
 *
 * @param bool|int|string|array $id Set this ID for this model on startup,
 * can also be an array of options, see above.
 * @param string $table Name of database table to use.
 * @param string $ds DataSource connection name.
 * @see Model::__construct()
 * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
 */
	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);
		$pluginDir = APP . 'Plugin' . DS . $this->plugin . DS . WEBROOT_DIR . DS . 'img' . DS;

		//カテゴリ間の区切り線
		$dir = new Folder($pluginDir . 'line');
		$files = $dir->find('.*\..*');
		$files = Hash::sort($files, '{n}', 'asc');

		self::$categorySeparators = array(
			array(
				'key' => null,
				'name' => __d('links', '(no line)'),
				'style' => null
			),
			array(
				'key' => self::CATEGORY_SEPARATOR_DEFAULT,
				'name' => '',
				'style' => ''
			)
		);
		foreach ($files as $file) {
			$info = getimagesize($dir->pwd() . DS . $file);
			$img = '/' . Inflector::underscore($this->plugin) . DS . 'img' . DS . 'line' . DS . $file;
			self::$categorySeparators[] = array(
				'key' => $file,
				'name' => '',
				'style' => 'background-image: url(' . $img . '); ' . 'border-image: url(' . $img . '); ' . 'height: ' . $info[1] . 'px;',
			);
		}
		unset($dir);

		//線スタイル
		$dir = new Folder($pluginDir . 'mark');
		$files = $dir->find('.*\..*');
		$files = Hash::sort($files, '{n}', 'asc');
		self::$listStyles = array(
			array(
				'key' => null,
				'name' => '',
				'style' => 'list-style-type: ' . self::LINE_STYLE_NONE . ';'
			),
			array(
				'key' => self::LINE_STYLE_DISC,
				'name' => '',
				'style' => 'list-style-type: ' . self::LINE_STYLE_DISC . ';'
			),
			array(
				'key' => self::LINE_STYLE_CIRCLE,
				'name' => '',
				'style' => 'list-style-type: ' . self::LINE_STYLE_CIRCLE . ';'
			),
			array(
				'key' => self::LINE_STYLE_LOWER_ALPHA,
				'name' => '',
				'style' => 'list-style-type: ' . self::LINE_STYLE_LOWER_ALPHA . ';'
			),
			array(
				'key' => self::LINE_STYLE_UPPER_ALPHA,
				'name' => '',
				'style' => 'list-style-type: ' . self::LINE_STYLE_UPPER_ALPHA . ';'
			),
		);

		foreach ($files as $file) {
			$info = getimagesize($dir->pwd() . DS . $file);
			$img = '/' . Inflector::underscore($this->plugin) . DS . 'img' . DS . 'mark' . DS . $file;
			self::$listStyles[] = array(
				'key' => $file,
				'name' => '',
				'style' => 'list-style-type: none; ' . 'list-style-image: url(' . $img . '); '
			);
		}
		unset($dir);
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
			'frame_key' => array(
				'notBlank' => array(
					'rule' => array('notBlank'),
					'message' => __d('net_commons', 'Invalid request.'),
					'allowEmpty' => false,
					'required' => true,
					'on' => 'update', // Limit validation to 'create' or 'update' operations
				),
			),
			'display_type' => array(
				'numeric' => array(
					'rule' => array('numeric'),
					'message' => __d('net_commons', 'Invalid request.'),
					'allowEmpty' => false,
					'required' => true,
				),
				'inList' => array(
					'rule' => array('inList', array(
						self::TYPE_DROPDOWN,
						self::TYPE_LIST_ONLY_TITLE,
						self::TYPE_LIST_WITH_DESCRIPTION
					)),
					'message' => __d('net_commons', 'Invalid request.'),
				)
			),
			'open_new_tab' => array(
				'boolean' => array(
					'rule' => array('boolean'),
					'message' => __d('net_commons', 'Invalid request.'),
				),
			),
			'display_click_count' => array(
				'boolean' => array(
					'rule' => array('boolean'),
					'message' => __d('net_commons', 'Invalid request.'),
				),
			),
			'category_separator_line' => array(
				'inList' => array(
					'rule' => array('inList',
						array_keys(Hash::combine(self::$categorySeparators, '{n}.key', '{n}.key'))
					),
					'message' => __d('net_commons', 'Invalid request.'),
					'allowEmpty' => true,
				)
			),
			'list_style' => array(
				'inList' => array(
					'rule' => array('inList',
						array_keys(Hash::combine(self::$listStyles, '{n}.key', '{n}.key'))
					),
					'message' => __d('net_commons', 'Invalid request.'),
					'allowEmpty' => true,
				)
			),
		));

		return parent::beforeValidate($options);
	}

/**
 * LinkFrameSettingデータ取得
 *
 * @param bool $created 作成フラグ
 * @return array LinkFrameSettingデータ配列
 */
	public function getLinkFrameSetting($created) {
		$conditions = array(
			'frame_key' => Current::read('Frame.key')
		);

		$linkFrameSetting = $this->find('first', array(
			'recursive' => -1,
			'conditions' => $conditions,
		));

		if ($created && ! $linkFrameSetting) {
			$linkFrameSetting = $this->create();
		}

		//カテゴリ間の区切り線
		$separatorLine = $linkFrameSetting['LinkFrameSetting']['category_separator_line'];
		$linkFrameSetting['LinkFrameSetting']['category_separator_line_css'] =
				Hash::get(Hash::extract(self::$categorySeparators, '{n}[key=' . $separatorLine . ']'), '0.style');

		//リストマーク
		$listStyle = $linkFrameSetting['LinkFrameSetting']['list_style'];
		$linkFrameSetting['LinkFrameSetting']['list_style_css'] =
				Hash::get(Hash::extract(self::$listStyles, '{n}[key=' . $listStyle . ']'), '0.style');

		return $linkFrameSetting;
	}

/**
 * LinkFrameSettingデータ登録処理
 *
 * @param array $data received post data
 * @return bool True on success, false on failure
 * @throws InternalErrorException
 */
	public function saveLinkFrameSetting($data) {
		$this->loadModels([
			'LinkFrameSetting' => 'Links.LinkFrameSetting',
		]);

		//トランザクションBegin
		$this->begin();

		//バリデーション
		$this->set($data);
		if (! $this->validates()) {
			return false;
		}

		try {
			if (! $this->save(null, false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			//トランザクションCommit
			$this->commit();

		} catch (Exception $ex) {
			//トランザクションRollback
			$this->rollback($ex);
		}

		return true;
	}
}
