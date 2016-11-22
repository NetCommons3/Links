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
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary', 'comment' => 'ID'),
		'frame_key' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'フレームKey', 'charset' => 'utf8'),
		'display_type' => array('type' => 'integer', 'null' => false, 'default' => '1', 'length' => 4, 'comment' => '表示方法種別  1: ドロップダウン型、2:リスト型（説明なし）、3:リスト型（説明あり）'),
		'open_new_tab' => array('type' => 'boolean', 'null' => false, 'default' => '1', 'comment' => 'リンクの開き方  0:同じウィンドウ内、1:新しいタブ'),
		'display_click_count' => array('type' => 'boolean', 'null' => false, 'default' => '1', 'comment' => 'リンクのクリック数の表示  0:表示しない、1:表示する'),
		'category_separator_line' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'カテゴリ間の区切り線', 'charset' => 'utf8'),
		'list_style' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'リストマーク', 'charset' => 'utf8'),
		'created_user' => array('type' => 'integer', 'null' => true, 'default' => null, 'comment' => '作成者'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => '作成日時'),
		'modified_user' => array('type' => 'integer', 'null' => true, 'default' => null, 'comment' => '更新者'),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => '更新日時'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => '6',
			'frame_key' => 'frame_3',
			'display_type' => '3',
			'open_new_tab' => true,
			'display_click_count' => true,
			'category_separator_line' => 'line_a2.gif',
			'list_style' => 'mark_a1.gif',
		),
		array(
			'id' => '8',
			'frame_key' => 'frame_4',
			'display_type' => '2',
			'open_new_tab' => true,
			'display_click_count' => true,
			'category_separator_line' => 'line_a2.gif',
			'list_style' => 'mark_a1.gif',
		),
		array(
			'id' => '9',
			'frame_key' => 'frame_5',
			'display_type' => '1',
			'open_new_tab' => true,
			'display_click_count' => true,
			'category_separator_line' => 'line_a2.gif',
			'list_style' => 'mark_a1.gif',
		),
	);

}
