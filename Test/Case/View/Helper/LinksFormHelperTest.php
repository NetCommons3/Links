<?php
/**
 * LinksFormHelper Test Case
 *
 * @author   Jun Nishikawa <topaz2@m0n0m0n0.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('View', 'View');
App::uses('Helper', 'View');
App::uses('LinksFormHelper', 'Links.View/Helper');

/**
 * Summary for LinksFormHelper Test Case
 */
class LinksFormHelperTest extends CakeTestCase {

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$View = new View();
		$this->LinksForm = new LinksFormHelper($View);
	}

/**
 * Fake
 *
 * @return void
 */
	public function testFake() {
		//fake
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->LinksForm);

		parent::tearDown();
	}

}
