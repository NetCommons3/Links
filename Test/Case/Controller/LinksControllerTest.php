<?php
/**
 * LinksController Test Case
 *
 * @author Ryuji AMANO <ryuji@ryus.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('LinksController', 'Links.Controller');
App::uses('NetCommonsFrameComponent', 'NetCommons.Controller/Component');
App::uses('NetCommonsBlockComponent', 'NetCommons.Controller/Component');
App::uses('NetCommonsRoomRoleComponent', 'NetCommons.Controller/Component');

/**
 * LinksController Test Case
 */
class LinksControllerTest extends ControllerTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
//		'plugin.links.link',
//		'plugin.links.site_setting',
//		'plugin.links.site_setting_value'
		'site_setting',
//		'plugin.frames.box',
//		'plugin.frames.language',
		'plugin.rooms.room',
		'plugin.rooms.roles_rooms_user',
		'plugin.roles.default_role_permission',
		'plugin.rooms.roles_room',
		'plugin.rooms.room_role_permission',
		'plugin.rooms.user',
	);

	/**
	 * setUp
	 *
	 * @return void
	 */
	public function setUp() {
		parent::setUp();
		Configure::write('Config.language', 'ja');
	}

	/**
	 * tearDown method
	 *
	 * @return void
	 */
	public function tearDown() {
		Configure::write('Config.language', null);
		parent::tearDown();
	}

//	/**
//	 * testBeforeFilterByNoSetFrameId method
//	 *
//	 * @return void
//	 */
//	public function testBeforeFilterByNoSetFrameId() {
//		$this->setExpectedException('ForbiddenException');
//		$this->testAction('/announcements/announcements/index', array('method' => 'get'));
//	}

	/**
	 * testIndex method
	 *
	 * @return void
	 */
	public function testIndex() {
		$result = $this->testAction('/links/links/index/1', array('method' => 'get'));
		debug($result);

		$expected = 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.';
		$this->assertTextContains($expected, $this->view);
	}

}
