<?php
/**
 * Linksプラグイン用FrameFixture
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('FrameFixture', 'Frames.Test/Fixture');

/**
 * Linksプラグイン用FrameFixture
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Links\Test\Fixture
 */
class Frame4linkFixture extends FrameFixture {

/**
 * Model name
 *
 * @var string
 */
	public $name = 'Frame';

/**
 * Full Table Name
 *
 * @var string
 */
	public $table = 'frames';

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		//メイン
		array(
			'id' => '6',
			'language_id' => '2',
			'room_id' => '1',
			'box_id' => '3',
			'plugin_key' => 'test_plugin',
			'block_id' => '2',
			'key' => 'frame_3',
			'name' => 'Test frame main',
			'weight' => '1',
			'is_deleted' => '0',
		),
		array(
			'id' => '7',
			'language_id' => '2',
			'room_id' => '1',
			'box_id' => '3',
			'plugin_key' => 'test_plugin',
			'block_id' => '2',
			'key' => 'frame_4',
			'name' => 'Test frame main',
			'weight' => '1',
			'is_deleted' => '0',
		),
		array(
			'id' => '8',
			'language_id' => '2',
			'room_id' => '1',
			'box_id' => '3',
			'plugin_key' => 'test_plugin',
			'block_id' => '2',
			'key' => 'frame_5',
			'name' => 'Test frame main',
			'weight' => '1',
			'is_deleted' => '0',
		),
	);

}
