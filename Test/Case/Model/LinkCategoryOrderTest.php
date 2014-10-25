<?php
/**
 * LinkCategoryOrder Test Case
 *
* @author   Jun Nishikawa <topaz2@m0n0m0n0.com>
* @link     http://www.netcommons.org NetCommons Project
* @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('LinkCategoryOrder', 'Links.Model');

/**
 * Summary for LinkCategoryOrder Test Case
 */
class LinkCategoryOrderTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.links.link_category_order'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->LinkCategoryOrder = ClassRegistry::init('Links.LinkCategoryOrder');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->LinkCategoryOrder);

		parent::tearDown();
	}

}
