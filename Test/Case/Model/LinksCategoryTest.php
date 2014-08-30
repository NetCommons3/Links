<?php
/**
 * LinksCategory Test Case
 *
 * @author   Jun Nishikawa <topaz2@m0n0m0n0.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('LinksCategory', 'Links.Model');

/**
 * Summary for LinksCategory Test Case
 */
class LinksCategoryTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.link_lists.links_category',
		'plugin.link_lists.links_block',
		'plugin.link_lists.language',
		'plugin.link_lists.link'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->LinksCategory = ClassRegistry::init('Links.LinksCategory');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->LinksCategory);

		parent::tearDown();
	}

}
