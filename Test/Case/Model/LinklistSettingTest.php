<?php
/**
 * LinklistSetting Test Case
 *
* @author   Jun Nishikawa <topaz2@m0n0m0n0.com>
* @link     http://www.netcommons.org NetCommons Project
* @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('LinklistSetting', 'LinkLists.Model');

/**
 * Summary for LinklistSetting Test Case
 */
class LinklistSettingTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.link_lists.linklist_setting',
		'plugin.link_lists.linklist_block'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->LinklistSetting = ClassRegistry::init('LinkLists.LinklistSetting');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->LinklistSetting);

		parent::tearDown();
	}

}
