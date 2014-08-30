<?php
/**
 * LinklistsCategoryFixture
 *
* @author   Jun Nishikawa <topaz2@m0n0m0n0.com>
* @link     http://www.netcommons.org NetCommons Project
* @license  http://www.netcommons.org/license.txt NetCommons License
 */

/**
 * Summary for LinklistsCategoryFixture
 */
class LinklistsCategoryFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'linklists_block_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'status' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 3),
		'language_id' => array('type' => 'integer', 'null' => false, 'default' => '2'),
		'is_auto_translated' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'translation_engine' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'title' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created_user' => array('type' => 'integer', 'null' => true, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified_user' => array('type' => 'integer', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
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
			'linklists_block_id' => 1,
			'status' => 1,
			'language_id' => 1,
			'is_auto_translated' => 1,
			'translation_engine' => 'Lorem ipsum dolor sit amet',
			'title' => 'Lorem ipsum dolor sit amet',
			'created_user' => 1,
			'created' => '2014-08-30 00:53:41',
			'modified_user' => 1,
			'modified' => '2014-08-30 00:53:41'
		),
	);

}
