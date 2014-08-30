<?php
/**
 * LinkPartSetting Test Case
 *
 * @author   Jun Nishikawa <topaz2@m0n0m0n0.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('LinkPartSetting', 'Links.Model');

/**
 * Summary for LinkPartSetting Test Case
 */
class LinkPartSettingTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.link_lists.link_part_setting',
		'plugin.link_lists.link_block',
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
		$this->LinkPartSetting = ClassRegistry::init('Links.LinkPartSetting');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->LinkPartSetting);

		parent::tearDown();
	}

}
