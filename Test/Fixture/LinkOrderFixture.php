<?php
/**
 * LinkOrder Fixture
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

/**
 * LinkOrder Fixture
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Links\Test\Fixture
 */
class LinkOrderFixture extends CakeTestFixture {

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => '1',
			'block_key' => 'block_1',
			'category_key' => 'category_1',
			'link_key' => 'content_key_1',
			'weight' => '1',
		),
		array(
			'id' => '2',
			'block_key' => 'block_1',
			'category_key' => 'category_1',
			'link_key' => 'content_key_2',
			'weight' => '2',
		),
		array(
			'id' => '3',
			'block_key' => 'block_1',
			'category_key' => null,
			'link_key' => 'content_key_3',
			'weight' => '1',
		),
		array(
			'id' => '4',
			'block_key' => 'block_1',
			'category_key' => 'category_1',
			'link_key' => 'content_key_4',
			'weight' => '3',
		),
		array(
			'id' => '5',
			'block_key' => 'block_1',
			'category_key' => 'category_1',
			'link_key' => 'content_key_5',
			'weight' => '4',
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
