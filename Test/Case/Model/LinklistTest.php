<?php
/**
 * Linklist Test Case
 *
* @author   Jun Nishikawa <topaz2@m0n0m0n0.com>
* @link     http://www.netcommons.org NetCommons Project
* @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('Linklist', 'LinkLists.Model');

/**
 * Summary for Linklist Test Case
 */
class LinklistTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.link_lists.linklist',
		'plugin.link_lists.linklists_block',
		'plugin.link_lists.language',
		'plugin.link_lists.linklists_category',
		'plugin.link_lists.block',
		'plugin.link_lists.blocks_language'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Linklist = ClassRegistry::init('LinkLists.Linklist');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Linklist);

		parent::tearDown();
	}

}
