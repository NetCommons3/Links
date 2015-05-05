<?php
/**
 * LinkFrameSetting Model
 *
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
				'notEmpty' => array(
					'rule' => array('notEmpty'),
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
 * Get link setting data
 *
 * @param string $frameKey frames.key
 * @return array
 */
	public function getLinkFrameSetting($frameKey) {
		$conditions = array(
			'frame_key' => $frameKey
		);

		$linkFrameSetting = $this->find('first', array(
				'recursive' => -1,
				'conditions' => $conditions,
			)
		);

		return $linkFrameSetting;
	}

/**
 * Get category_separator_line data
 *
 * @param string $categorySeparator category_separator_line data
 * @return array
 */
	public function getCategorySeparatorLineCss($categorySeparator) {
		//カテゴリ間の区切り線
		$categorySeparators = Hash::combine(self::$categorySeparators, '{n}.key', '{n}');
		if (isset($categorySeparators[$categorySeparator])) {
			$result = $categorySeparators[$categorySeparator]['style'];
		} else {
			$result = null;
		}

		return $result;
	}

/**
 * Get line_style data
 *
 * @param string $lineStyle line_style data
 * @return array
 */
	public function getLineStyleCss($lineStyle) {
		//カテゴリ間の区切り線
		$listStyles = Hash::combine(self::$listStyles, '{n}.key', '{n}');
		if (isset($listStyles[$lineStyle])) {
			$result = $listStyles[$lineStyle]['style'];
		} else {
			$result = null;
		}

		return $result;
	}

/**
 * Save link settings
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
		$this->setDataSource('master');
		$dataSource = $this->getDataSource();
		$dataSource->begin();

		try {
			if (! $this->validateLinkFrameSetting($data)) {
				return false;
			}

			if (! $this->save(null, false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
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

/**
 * Validate linkFrameSettings
 *
 * @param array $data received post data
 * @return bool True on success, false on validation errors
 */
	public function validateLinkFrameSetting($data) {
		$this->set($data);
		$this->validates();
		if ($this->validationErrors) {
			return false;
		}
		return true;
	}
}
