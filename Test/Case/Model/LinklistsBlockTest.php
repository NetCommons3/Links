<?php
/**
 * LinklistsBlock Test Case
 *
* @author   Jun Nishikawa <topaz2@m0n0m0n0.com>
* @link     http://www.netcommons.org NetCommons Project
* @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('LinklistsBlock', 'LinkLists.Model');

/**
 * Summary for LinklistsBlock Test Case
 */
class LinklistsBlockTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.link_lists.linklists_block',
		'plugin.link_lists.block',
		'plugin.link_lists.language',
		'plugin.link_lists.blocks_language',
		'plugin.link_lists.linklist',
		'plugin.link_lists.linklists_category'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->LinklistsBlock = ClassRegistry::init('LinkLists.LinklistsBlock');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->LinklistsBlock);

		parent::tearDown();
	}

}
