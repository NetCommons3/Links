<?php
/**
 * LinkFrameSetting Fixture
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

/**
 * LinkFrameSetting Fixture
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Links\Test\Fixture
 */
class LinkFrameSettingFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary', 'comment' => 'ID |  |  | '),
		'frame_key' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'frame key | フレームKey | frames.key | ', 'charset' => 'utf8'),
		'display_type' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 4, 'comment' => 'display type, 1: dropdown type, 2: list type (no explanation), 3: list type (with explanation) | 表示方法種別  1: ドロップダウン型、2:リスト型（説明なし）、3:リスト型（説明あり） |  | '),
		'open_new_tab' => array('type' => 'boolean', 'null' => false, 'default' => '1', 'comment' => 'open new tab, 1: new tab or 0: same window | リンクの開き方  0:同じウィンドウ内、1:新しいタブ |  | '),
		'display_click_count' => array('type' => 'boolean', 'null' => false, 'default' => '1', 'comment' => 'display of click count, 1: display or 0: no display | リンクのクリック数の表示  0:表示しない、1:表示する |  | '),
		'category_separator_line' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'separator line between the categories | カテゴリ間の区切り線 |  | ', 'charset' => 'utf8'),
		'list_style' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'list mark | リストマーク |  | ', 'charset' => 'utf8'),
		'created_user' => array('type' => 'integer', 'null' => true, 'default' => null, 'comment' => 'created user | 作成者 | users.id | '),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => 'created datetime | 作成日時 |  | '),
		'modified_user' => array('type' => 'integer', 'null' => true, 'default' => null, 'comment' => 'modified user | 更新者 | users.id | '),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => 'modified datetime | 更新日時 |  | '),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'frame_key' => 'Lorem ipsum dolor sit amet',
			'display_type' => 1,
			'open_new_tab' => 1,
			'display_click_count' => 1,
			'category_separator_line' => 'Lorem ipsum dolor sit amet',
			'list_style' => 'Lorem ipsum dolor sit amet',
			'created_user' => 1,
			'created' => '2015-05-01 07:17:43',
			'modified_user' => 1,
			'modified' => '2015-05-01 07:17:43'
		),
	);

}
