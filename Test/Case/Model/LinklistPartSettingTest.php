<?php
/**
 * LinklistPartSetting Test Case
 *
* @author   Jun Nishikawa <topaz2@m0n0m0n0.com>
* @link     http://www.netcommons.org NetCommons Project
* @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('LinklistPartSetting', 'LinkLists.Model');

/**
 * Summary for LinklistPartSetting Test Case
 */
class LinklistPartSettingTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.link_lists.linklist_part_setting',
		'plugin.link_lists.linklist_block',
		'plugin.link_lists.part',
		'plugin.link_lists.language',
		'plugin.link_lists.languages_part'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->LinklistPartSetting = ClassRegistry::init('LinkLists.LinklistPartSetting');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->LinklistPartSetting);

		parent::tearDown();
	}

}
