<?php
/**
 * LinklistsCategory Test Case
 *
* @author   Jun Nishikawa <topaz2@m0n0m0n0.com>
* @link     http://www.netcommons.org NetCommons Project
* @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('LinklistsCategory', 'LinkLists.Model');

/**
 * Summary for LinklistsCategory Test Case
 */
class LinklistsCategoryTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.link_lists.linklists_category',
		'plugin.link_lists.linklists_block',
		'plugin.link_lists.language',
		'plugin.link_lists.linklist'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->LinklistsCategory = ClassRegistry::init('LinkLists.LinklistsCategory');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->LinklistsCategory);

		parent::tearDown();
	}

}
