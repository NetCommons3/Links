<?php
/**
 * LinkFrameSetting Test Case
 *
* @author   Jun Nishikawa <topaz2@m0n0m0n0.com>
* @link     http://www.netcommons.org NetCommons Project
* @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('LinkFrameSetting', 'Links.Model');

/**
 * Summary for LinkFrameSetting Test Case
 */
class LinkFrameSettingTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.links.link_frame_setting'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->LinkFrameSetting = ClassRegistry::init('Links.LinkFrameSetting');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->LinkFrameSetting);

		parent::tearDown();
	}

}
