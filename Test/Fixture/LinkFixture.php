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

/**
 * Initialize the fixture.
 *
 * @return void
 */
	public function init() {
		require_once App::pluginPath('Links') . 'Config' . DS . 'Schema' . DS . 'schema.php';
		$this->fields = (new LinksSchema())->tables[Inflector::tableize($this->name)];
		parent::init();
	}

}
