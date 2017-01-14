<?php
/**
 * Linksプラグイン用FrameFixture
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('FramePublicLanguageFixture', 'Frames.Test/Fixture');

/**
 * Linksプラグイン用FrameFixture
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Links\Test\Fixture
 */
class FramePublicLanguage4linkFixture extends FramePublicLanguageFixture {

/**
 * Model name
 *
 * @var string
 */
	public $name = 'FramePublicLanguage';

/**
 * Full Table Name
 *
 * @var string
 */
	public $table = 'frame_public_languages';

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		//メイン
		array(
			'frame_id' => '6',
			'language_id' => '0',
			'is_public' => '1',
		),
		array(
			'frame_id' => '7',
			'language_id' => '0',
			'is_public' => '1',
		),
		array(
			'frame_id' => '8',
			'language_id' => '0',
			'is_public' => '1',
		),
	);
}
