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
			'room_id' => '2',
			'box_id' => '27',
			'plugin_key' => 'test_plugin',
			'block_id' => '2',
			'key' => 'frame_3',
			'weight' => '1',
			'is_deleted' => '0',
		),
		array(
			'id' => '7',
			'room_id' => '2',
			'box_id' => '27',
			'plugin_key' => 'test_plugin',
			'block_id' => '2',
			'key' => 'frame_4',
			'weight' => '1',
			'is_deleted' => '0',
		),
		array(
			'id' => '8',
			'room_id' => '2',
			'box_id' => '27',
			'plugin_key' => 'test_plugin',
			'block_id' => '2',
			'key' => 'frame_5',
			'weight' => '1',
			'is_deleted' => '0',
		),
	);
}
