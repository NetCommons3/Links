<?php
/**
 * LinkCategoryFixture
 *
* @author   Jun Nishikawa <topaz2@m0n0m0n0.com>
* @link     http://www.netcommons.org NetCommons Project
* @license  http://www.netcommons.org/license.txt NetCommons License
 */

/**
 * Summary for LinkCategoryFixture
 */
class LinkCategoryFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary', 'comment' => 'ID |  |  | '),
		'block_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'comment' => 'block id |  ブロックID | blocks.id | '),
		'key' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'category key | カテゴリーKey |  | ', 'charset' => 'utf8'),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'category name | カテゴリー名 |  | ', 'charset' => 'utf8'),
		'is_auto_translated' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'comment' => 'translation type. 0:original , 1:auto translation | 翻訳タイプ  0:オリジナル、1:自動翻訳 |  | '),
		'translation_engine' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'translation engine | 翻訳エンジン |  | ', 'charset' => 'utf8'),
		'created_user' => array('type' => 'integer', 'null' => true, 'default' => '0', 'comment' => 'created user | 作成者 | users.id | '),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => 'created datetime | 作成日時 |  | '),
		'modified_user' => array('type' => 'integer', 'null' => true, 'default' => '0', 'comment' => 'modified user | 更新者 | users.id | '),
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
			'block_id' => 1,
			'key' => 'key1',
			'name' => '株式会社RYUS',
			'is_auto_translated' => 1,
			'translation_engine' => 'Lorem ipsum dolor sit amet',
			'created_user' => 1,
			'created' => '2014-10-25 04:56:24',
			'modified_user' => 1,
			'modified' => '2014-10-25 04:56:24'
		),
		array(
			'id' => 2,
			'block_id' => 1,
			'key' => 'key2',
			'name' => 'Lorem ipsum dolor sit amet',
			'is_auto_translated' => 1,
			'translation_engine' => 'Lorem ipsum dolor sit amet',
			'created_user' => 1,
			'created' => '2014-10-25 04:56:24',
			'modified_user' => 1,
			'modified' => '2014-10-25 04:56:24'
		),
		array(
			'id' => 3,
			'block_id' => 2,
			'key' => 'key1',
			'name' => 'RYUS INC',
			'is_auto_translated' => 1,
			'translation_engine' => 'Lorem ipsum dolor sit amet',
			'created_user' => 1,
			'created' => '2014-10-25 04:56:24',
			'modified_user' => 1,
			'modified' => '2014-10-25 04:56:24'
		),
	);

}
