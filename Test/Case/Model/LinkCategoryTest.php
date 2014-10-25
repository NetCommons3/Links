<?php
/**
 * LinkCategory Test Case
 *
* @author   Jun Nishikawa <topaz2@m0n0m0n0.com>
* @link     http://www.netcommons.org NetCommons Project
* @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('LinkCategory', 'Links.Model');

/**
 * Summary for LinkCategory Test Case
 */
class LinkCategoryTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.links.link_category',
		'plugin.links.block',
		'plugin.links.link'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->LinkCategory = ClassRegistry::init('Links.LinkCategory');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->LinkCategory);

		parent::tearDown();
	}

}
