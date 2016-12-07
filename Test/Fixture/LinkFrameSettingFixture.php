<?php
/**
 * LinkFrameSetting Fixture
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

/**
 * LinkFrameSetting Fixture
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Links\Test\Fixture
 */
class LinkFrameSettingFixture extends CakeTestFixture {

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => '6',
			'frame_key' => 'frame_3',
			'display_type' => '3',
			'open_new_tab' => true,
			'display_click_count' => true,
			'category_separator_line' => 'line_a2.gif',
			'list_style' => 'mark_a1.gif',
		),
		array(
			'id' => '8',
			'frame_key' => 'frame_4',
			'display_type' => '2',
			'open_new_tab' => true,
			'display_click_count' => true,
			'category_separator_line' => 'line_a2.gif',
			'list_style' => 'mark_a1.gif',
		),
		array(
			'id' => '9',
			'frame_key' => 'frame_5',
			'display_type' => '1',
			'open_new_tab' => true,
			'display_click_count' => true,
			'category_separator_line' => 'line_a2.gif',
			'list_style' => 'mark_a1.gif',
		),
	);

/**
 * Initialize the fixture.
 *
 * @return void
 */
	public function init() {
		require_once App::pluginPath('Links') . 'Config' . DS . 'Schema' . DS . 'schema.php';
		$this->fields = (new LinksSchema())->tables[Inflector::tableize($this->name)];
		parent::init();
	}

}
