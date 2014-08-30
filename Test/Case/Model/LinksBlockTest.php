<?php
/**
 * LinksBlock Test Case
 *
 * @author   Jun Nishikawa <topaz2@m0n0m0n0.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('LinksBlock', 'Links.Model');

/**
 * Summary for LinksBlock Test Case
 */
class LinksBlockTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.link_lists.links_block',
		'plugin.link_lists.block',
		'plugin.link_lists.language',
		'plugin.link_lists.blocks_language',
		'plugin.link_lists.link',
		'plugin.link_lists.links_category'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->LinksBlock = ClassRegistry::init('Links.LinksBlock');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->LinksBlock);

		parent::tearDown();
	}

}
