<?php
/**
 * View/Elements/Links/edit_formテスト用Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AppController', 'Controller');
App::uses('LinkFixture', 'Links.Test/Fixture');
App::uses('LinkOrderFixture', 'Links.Test/Fixture');
App::uses('CategoryFixture', 'Categories.Test/Fixture');
App::uses('CategoryOrderFixture', 'Categories.Test/Fixture');

/**
 * View/Elements/Links/edit_formテスト用Controller
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Links\Test\test_app\Plugin\TestLinks\Controller
 */
class TestViewElementsLinksEditFormController extends AppController {

/**
 * use component
 *
 * @var array
 */
	public $components = array(
		'Categories.Categories',
	);

/**
 * edit_form
 *
 * @return void
 */
	public function edit_form() {
		$this->autoRender = true;

		$this->request->data['Link'] = (new LinkFixture())->records[1];
		$this->request->data['LinkOrder'] = (new LinkOrderFixture())->records[0];
		$this->request->data['Category'] = (new CategoryFixture())->records[0];
		$this->request->data['CategoryOrder'] = (new CategoryOrderFixture())->records[0];
		$this->request->data['Block'] = array(
			'id' => '2',
			'language_id' => '2',
			'room_id' => '2',
			'plugin_key' => 'links',
			'key' => 'block_1',
			'name' => 'Block name 1',
			'public_type' => '1',
			'publish_start' => null,
			'publish_end' => null,
		);
		$this->request->data['Frame'] = array(
			'id' => '6',
			'language_id' => '2',
			'room_id' => '2',
			'box_id' => '3',
			'plugin_key' => 'links',
			'block_id' => '2',
			'key' => 'frame_3',
			'name' => 'Test frame main',
			'weight' => '1',
			'is_deleted' => '0',
		);
	}

}
