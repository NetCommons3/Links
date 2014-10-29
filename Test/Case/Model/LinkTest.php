<?php
/**
 * Link Test Case
 *
* @author   Jun Nishikawa <topaz2@m0n0m0n0.com>
* @link     http://www.netcommons.org NetCommons Project
* @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('Link', 'Links.Model');

/**
 * Summary for Link Test Case
 *
 * @property Link $Link
 */
class LinkTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.links.link',
		'plugin.links.link_order',
		'plugin.links.link_category',
		'plugin.links.link_category_order',
		'plugin.links.block',
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Link = ClassRegistry::init('Links.Link');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Link);

		parent::tearDown();
	}

	public function testAssociationLinkOrder() {
		$link = $this->Link->findById(1);
		$this->assertEqual($link['LinkOrder']['id'], 1);

		$link = $this->Link->findById(2);
		$this->assertEqual($link['LinkOrder']['id'], 2);
	}

	public function testAssociationLinkCategory() {
		$link = $this->Link->findById(1);
		$this->assertEqual($link['LinkCategory']['id'], 1);
	}


	public function testGetLinksByCategoryId() {
		$categoryId = 1;
		$blockId = 1;
		$contentEditable = true;

		//
		$links = $this->Link->getLinksByCategoryId($categoryId, $blockId, $contentEditable);

		$this->assertEqual(count($links), 2);
	}
	public function testGetLinksByCategoryId4NotEditable() {
		$categoryId = 1;
		$blockId = 1;
		$contentEditable = false;
		$links = $this->Link->getLinksByCategoryId($categoryId, $blockId, $contentEditable);
		$this->assertEqual(count($links), 1);
	}
	// リンクがオーダー順にとれてるか
	public function testGetLinksByCategoryIdOrderWight() {
		$categoryId = 1;
		$blockId = 1;
		$contentEditable = true;
		$links = $this->Link->getLinksByCategoryId($categoryId, $blockId, $contentEditable);

		$this->assertEqual($links[0]['Link']['id'] , 2);
		$this->assertEqual($links[1]['Link']['id'] , 1);
	}

}
