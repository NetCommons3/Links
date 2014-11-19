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
 *
 * @property LinkCategory $LinkCategory
 */
class LinkCategoryTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.links.link_category',
		'plugin.links.link_category_order',
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


	public function testAssociationLinkCategoryOrder() {
		$linkCategory = $this->LinkCategory->findById(1);
		$this->assertEqual($linkCategory['LinkCategoryOrder']['id'], 1);

		$linkCategory = $this->LinkCategory->findById(2);
		$this->assertEqual($linkCategory['LinkCategoryOrder']['id'], 2);

		$linkCategory = $this->LinkCategory->findById(3);
		$this->assertEqual($linkCategory['LinkCategoryOrder']['id'], 1);
	}

	public function testAssociationLink() {
		$linkCategory = $this->LinkCategory->findById(1);
		$this->assertEqual(count($linkCategory['Link']), 2);

		$linkCategory = $this->LinkCategory->findById(2);
		$this->assertEqual(count($linkCategory['Link']), 1);
	}

	public function testGetCategories() {
		$blockId = 1;
		$categories = $this->LinkCategory->getCategories($blockId);
		$this->assertEqual($categories[0]['LinkCategory']['id'], 2);
		$this->assertEqual($categories[1]['LinkCategory']['id'], 1);
	}

	public function testUpdateCategories() {
		$data = array(
			array(
				'LinkCategory' => array(

					'id' => 1,
					'name' => 'ID1DATA'
				),
				'LinkCategoryOrder' => array(
					'id' => 1,
					'weight' => 1
				)
			),
			array(
				'LinkCategory' => array(

					'id' => 2,
					'name' => 'ID2DATA'
				),
				'LinkCategoryOrder' => array(
					'id' => 2,
					'weight' => 2
				)
			),
		);
		$resultTrue = $this->LinkCategory->updateCategories($data);
		$this->assertTrue($resultTrue);
		$linkCategory1 = $this->LinkCategory->findById(1);
		$this->assertEqual($linkCategory1['LinkCategory']['name'], 'ID1DATA');

	}
}