<?php
/**
 * Link Fixture
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

/**
 * Link Fixture
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Links\Test\Fixture
 */
class LinkFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary', 'comment' => 'ID |  |  | '),
		'block_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'comment' => 'block id | ブロックID | blocks.id | '),
		'category_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'comment' => 'category id | カテゴリーID | link_categories.id | '),
		'language_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 6, 'comment' => 'language id | 言語ID | languages.id | '),
		'key' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'link key | リンクキー | Hash値 | ', 'charset' => 'utf8'),
		'status' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 4, 'comment' => 'public status, 1: public, 2: public pending, 3: draft during 4: remand | 公開状況  1:公開中、2:公開申請中、3:下書き中、4:差し戻し |  | '),
		'is_active' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'comment' => 'Is active, 0:deactive 1:acive | アクティブなコンテンツかどうか 0:アクティブでない 1:アクティブ | | '),
		'is_latest' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'comment' => 'Is latest, 0:not latest 1:latest | 最新コンテンツかどうか 0:最新でない 1:最新 | | '),
		'url' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'link url | リンク先URL |  | ', 'charset' => 'utf8'),
		'title' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'title | タイトル |  | ', 'charset' => 'utf8'),
		'description' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'description | 説明 |  | ', 'charset' => 'utf8'),
		'click_count' => array('type' => 'integer', 'null' => false, 'default' => '0', 'comment' => 'link click count | クリック数 |  | '),
		'created_user' => array('type' => 'integer', 'null' => true, 'default' => null, 'comment' => 'created user | 作成者 | users.id | '),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => 'created datetime | 作成日時 |  | '),
		'modified_user' => array('type' => 'integer', 'null' => true, 'default' => null, 'comment' => 'modified user | 更新者 | users.id | '),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => 'modified datetime | 更新日時 |  | '),
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
		// * ルーム管理者が書いたコンテンツ＆一度公開して、下書き中
		array(
			'id' => '1',
			'block_id' => '2',
			'key' => 'content_key_1',
			'language_id' => '2',
			'category_id' => '1',
			'status' => '1',
			'is_active' => true,
			'is_latest' => false,
			'url' => 'http://www.netcommons.org',
			'title' => 'Title 1',
			'description' => 'Description 1',
			'click_count' => '1',
			'created_user' => '1'
		),
		array(
			'id' => '2',
			'block_id' => '2',
			'key' => 'content_key_1',
			'language_id' => '2',
			'category_id' => '1',
			'status' => '3',
			'is_active' => false,
			'is_latest' => true,
			'url' => 'http://www.netcommons.org',
			'title' => 'Title 2',
			'description' => 'Description 2',
			'click_count' => '1',
			'created_user' => '1'
		),
		// * 一般が書いたコンテンツ＆一度も公開していない（承認待ち）
		array(
			'id' => '3',
			'block_id' => '2',
			'key' => 'content_key_2',
			'language_id' => '2',
			'category_id' => '1',
			'status' => '2',
			'is_active' => false,
			'is_latest' => true,
			'url' => 'http://www.netcommons.org',
			'title' => 'Title 3',
			'description' => 'Description 3',
			'click_count' => '1',
			'created_user' => '4'
		),
		// * 一般が書いたコンテンツ＆公開して、一時保存
		array(
			'id' => '4',
			'block_id' => '2',
			'key' => 'content_key_3',
			'language_id' => '2',
			'category_id' => null,
			'status' => '1',
			'is_active' => true,
			'is_latest' => false,
			'url' => 'http://www.netcommons.org',
			'title' => 'Title 4',
			'description' => 'Description 4',
			'click_count' => '1',
			'created_user' => '4'
		),
		array(
			'id' => '5',
			'block_id' => '2',
			'key' => 'content_key_3',
			'language_id' => '2',
			'category_id' => null,
			'status' => '3',
			'is_active' => false,
			'is_latest' => true,
			'url' => 'http://www.netcommons.org',
			'title' => 'Title 5',
			'description' => 'Description 5',
			'click_count' => '1',
			'created_user' => '4'
		),
		// * 編集者が書いたコンテンツ＆一度公開して、差し戻し
		array(
			'id' => '6',
			'block_id' => '2',
			'key' => 'content_key_4',
			'language_id' => '2',
			'category_id' => '1',
			'status' => '1',
			'is_active' => true,
			'is_latest' => false,
			'url' => 'http://www.netcommons.org',
			'title' => 'Title 6',
			'description' => 'Description 6',
			'click_count' => '1',
			'created_user' => '3'
		),
		array(
			'id' => '7',
			'block_id' => '2',
			'key' => 'content_key_4',
			'language_id' => '2',
			'category_id' => '1',
			'status' => '4',
			'is_active' => false,
			'is_latest' => true,
			'url' => 'http://www.netcommons.org',
			'title' => 'Title 7',
			'description' => 'Description 7',
			'click_count' => '1',
			'created_user' => '3'
		),
		// * 編集長が書いたコンテンツ＆一度も公開していない（下書き中）
		array(
			'id' => '8',
			'block_id' => '2',
			'key' => 'content_key_5',
			'language_id' => '2',
			'category_id' => '1',
			'status' => '3',
			'is_active' => false,
			'is_latest' => true,
			'url' => 'http://www.netcommons.org',
			'title' => 'Title 8',
			'description' => 'Description 8',
			'click_count' => '1',
			'created_user' => '2'
		),
	);

}
