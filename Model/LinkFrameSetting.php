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
	public $categorySeparators = array();

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
	public $listStyles = array();

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

		$this->categorySeparators = array(
			null => array(
				'key' => null,
				'name' => __d('links', '(no line)'),
				'style' => null
			),
			self::CATEGORY_SEPARATOR_DEFAULT => array(
				'key' => self::CATEGORY_SEPARATOR_DEFAULT,
				'name' => '',
				'style' => ''
			)
		);
		foreach ($files as $file) {
			$info = getimagesize($dir->pwd() . DS . $file);
			$img = Router::url('/') . Inflector::underscore($this->plugin) . '/img/line/' . $file;
			$this->categorySeparators[$file] = array(
				'key' => $file,
				'name' => '',
				'style' => 'background-image: url(' . $img . '); ' .
							'border-image: url(' . $img . '); ' . 'height: ' . $info[1] . 'px;',
			);
		}
		unset($dir);

		//線スタイル
		$dir = new Folder($pluginDir . 'mark');
		$files = $dir->find('.*\..*');
		$files = Hash::sort($files, '{n}', 'asc');
		$this->listStyles = array(
			null => array(
				'key' => null,
				'name' => '',
				'style' => 'list-style-type: ' . self::LINE_STYLE_NONE . ';'
			),
			self::LINE_STYLE_DISC => array(
				'key' => self::LINE_STYLE_DISC,
				'name' => '',
				'style' => 'list-style-type: ' . self::LINE_STYLE_DISC . ';'
			),
			self::LINE_STYLE_CIRCLE => array(
				'key' => self::LINE_STYLE_CIRCLE,
				'name' => '',
				'style' => 'list-style-type: ' . self::LINE_STYLE_CIRCLE . ';'
			),
			self::LINE_STYLE_LOWER_ALPHA => array(
				'key' => self::LINE_STYLE_LOWER_ALPHA,
				'name' => '',
				'style' => 'list-style-type: ' . self::LINE_STYLE_LOWER_ALPHA . ';'
			),
			self::LINE_STYLE_UPPER_ALPHA => array(
				'key' => self::LINE_STYLE_UPPER_ALPHA,
				'name' => '',
				'style' => 'list-style-type: ' . self::LINE_STYLE_UPPER_ALPHA . ';'
			),
		);

		foreach ($files as $file) {
			$info = getimagesize($dir->pwd() . DS . $file);
			$img = Router::url('/') . Inflector::underscore($this->plugin) . '/img/mark/' . $file;
			$this->listStyles[$file] = array(
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
						array_keys($this->categorySeparators)
					),
					'message' => __d('net_commons', 'Invalid request.'),
					'allowEmpty' => true,
				)
			),
			'list_style' => array(
				'inList' => array(
					'rule' => array('inList',
						array_keys($this->listStyles)
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

		if (! $linkFrameSetting) {
			if ($created) {
				$linkFrameSetting = $this->create(array(
					'category_separator_line' => self::CATEGORY_SEPARATOR_DEFAULT
				));
			} else {
				return $linkFrameSetting;
			}
		}

		//カテゴリ間の区切り線
		$separatorLine = $linkFrameSetting['LinkFrameSetting']['category_separator_line'];
		if (isset($this->categorySeparators[$separatorLine])) {
			$style = $this->categorySeparators[$separatorLine]['style'];
		} else {
			$style = null;
		}
		$linkFrameSetting['LinkFrameSetting']['category_separator_line_css'] = $style;

		//リストマーク
		$listStyle = $linkFrameSetting['LinkFrameSetting']['list_style'];
		if (isset($this->listStyles[$listStyle])) {
			$style = $this->listStyles[$listStyle]['style'];
		} else {
			$style = null;
		}
		$linkFrameSetting['LinkFrameSetting']['list_style_css'] = $style;

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
