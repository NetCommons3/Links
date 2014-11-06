<?php
/**
 * LinkOrder Test Case
 *
* @author   Jun Nishikawa <topaz2@m0n0m0n0.com>
* @link     http://www.netcommons.org NetCommons Project
* @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('LinkOrder', 'Links.Model');


class LinkOrderTesting extends LinkOrder{
	public $useTable = 'link_orders';
	public $alias = 'LinkOrder';
	public function _getMaxWeightByLinkCategoryKey($linkCategoryKey) {
		return parent::_getMaxWeightByLinkCategoryKey($linkCategoryKey);
	}
}
/**
 * Summary for LinkOrder Test Case
 */
class LinkOrderTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.links.link_order',
		'plugin.links.link_category',
		'plugin.links.link_category_order',
		'plugin.links.link',
		'plugin.links.block',
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->LinkOrder = ClassRegistry::init('Links.LinkOrder');
		$this->LinkOrderTesting = ClassRegistry::init('Links.LinkOrderTesting');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->LinkOrder);

		parent::tearDown();
	}

	public function testGetMaxWeight() {
		$key = 'ckey1';
		$max = $this->LinkOrderTesting->_getMaxWeightByLinkCategoryKey($key);
		$this->assertEqual($max, 10);

		$max = $this->LinkOrderTesting->_getMaxWeightByLinkCategoryKey('noDataKey');
		$this->assertEqual($max, 0);
	}

	public function testAddLinkOrder() {
//		$link = array(
//			'Link' => array(
//				'description' => "desc",
//				'link_category_id' => 2,
//				'status' => 1,
//				'title'  => 'title',
//				'url' => 'url'
//			)
//		);
		$link = array(
			'Link' => array('key' => 'key01', 'link_category_id' => 1)
		);
		$this->LinkOrder->addLinkOrder($link);


	}

}
