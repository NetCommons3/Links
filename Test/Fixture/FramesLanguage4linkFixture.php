<?php
/**
 * Linksプラグイン用FrameFixture
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('FramesLanguageFixture', 'Frames.Test/Fixture');

/**
 * Linksプラグイン用FrameFixture
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Links\Test\Fixture
 */
class FramesLanguage4linkFixture extends FramesLanguageFixture {

/**
 * Model name
 *
 * @var string
 */
	public $name = 'FramesLanguage';

/**
 * Full Table Name
 *
 * @var string
 */
	public $table = 'frames_languages';

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
			'frame_id' => '6',
			'name' => 'Test frame main',
		),
		array(
			'id' => '7',
			'language_id' => '2',
			'frame_id' => '7',
			'name' => 'Test frame main',
		),
		array(
			'id' => '8',
			'language_id' => '2',
			'frame_id' => '8',
			'name' => 'Test frame main',
		),
	);
}
