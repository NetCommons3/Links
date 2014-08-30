<?php
/**
 * LinkSetting Test Case
 *
 * @author   Jun Nishikawa <topaz2@m0n0m0n0.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('LinkSetting', 'Links.Model');

/**
 * Summary for LinkSetting Test Case
 */
class LinkSettingTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.link_lists.link_setting',
		'plugin.link_lists.link_block'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->LinkSetting = ClassRegistry::init('Links.LinkSetting');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->LinkSetting);

		parent::tearDown();
	}

}
