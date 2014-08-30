<?php
/**
 * LinklistPartSettingFixture
 *
* @author   Jun Nishikawa <topaz2@m0n0m0n0.com>
* @link     http://www.netcommons.org NetCommons Project
* @license  http://www.netcommons.org/license.txt NetCommons License
 */

/**
 * Summary for LinklistPartSettingFixture
 */
class LinklistPartSettingFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'linklist_block_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'part_id' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'readable_content' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'editable_content' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'creatable_content' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'publishable_content' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
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
			'linklist_block_id' => 1,
			'part_id' => 1,
			'readable_content' => 1,
			'editable_content' => 1,
			'creatable_content' => 1,
			'publishable_content' => 1,
			'created_user' => 1,
			'created' => '2014-08-30 00:55:01',
			'modified_user' => 1,
			'modified' => '2014-08-30 00:55:01'
		),
	);

}
