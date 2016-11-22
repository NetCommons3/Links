<?php
/**
 * Migration file
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Mitsuru Mutaguchi <mutaguchi@opensource-workshop.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

/**
 * Migration file
 *
 * @author Mitsuru Mutaguchi <mutaguchi@opensource-workshop.jp>
 * @package NetCommons\Links\Config\Migration
 */
class AddIndex extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'add_index';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
			'alter_field' => array(
				'link_frame_settings' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary', 'comment' => 'ID'),
					'frame_key' => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'index', 'collate' => 'utf8_general_ci', 'comment' => 'フレームKey', 'charset' => 'utf8'),
					'display_type' => array('type' => 'integer', 'null' => false, 'default' => '1', 'length' => 4, 'unsigned' => false, 'comment' => '表示方法種別  1: ドロップダウン型、2:リスト型（説明なし）、3:リスト型（説明あり）'),
					'created_user' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false, 'comment' => '作成者'),
					'modified_user' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false, 'comment' => '更新者'),
				),
				'link_orders' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary', 'comment' => 'ID'),
					'link_key' => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'index', 'collate' => 'utf8_general_ci', 'comment' => 'リンクKey', 'charset' => 'utf8'),
					'weight' => array('type' => 'integer', 'null' => false, 'default' => '0', 'unsigned' => false, 'comment' => '表示の重み(表示順序)'),
					'created_user' => array('type' => 'integer', 'null' => true, 'default' => '0', 'unsigned' => false, 'comment' => '作成者'),
					'modified_user' => array('type' => 'integer', 'null' => true, 'default' => '0', 'unsigned' => false, 'comment' => '更新者'),
				),
				'links' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary', 'comment' => 'ID'),
					'block_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'index', 'comment' => 'ブロックID'),
					'category_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false, 'comment' => 'カテゴリーID'),
					'language_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 6, 'unsigned' => false, 'comment' => '言語ID'),
					'status' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 4, 'unsigned' => false, 'comment' => '公開状況  1:公開中、2:公開申請中、3:下書き中、4:差し戻し'),
					'click_count' => array('type' => 'integer', 'null' => false, 'default' => '0', 'unsigned' => false, 'comment' => 'クリック数'),
					'created_user' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false, 'comment' => '作成者'),
					'modified_user' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false, 'comment' => '更新者'),
				),
			),
			'create_field' => array(
				'link_frame_settings' => array(
					'indexes' => array(
						'frame_key' => array('column' => 'frame_key', 'unique' => 0),
					),
				),
				'link_orders' => array(
					'indexes' => array(
						'link_key' => array('column' => 'link_key', 'unique' => 0),
					),
				),
				'links' => array(
					'indexes' => array(
						'block_id' => array('column' => array('block_id', 'language_id'), 'unique' => 0),
					),
				),
			),
		),
		'down' => array(
			'alter_field' => array(
				'link_frame_settings' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary', 'comment' => 'ID'),
					'frame_key' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'フレームKey', 'charset' => 'utf8'),
					'display_type' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 4, 'comment' => '表示方法種別  1: ドロップダウン型、2:リスト型（説明なし）、3:リスト型（説明あり）'),
					'created_user' => array('type' => 'integer', 'null' => true, 'default' => null, 'comment' => '作成者'),
					'modified_user' => array('type' => 'integer', 'null' => true, 'default' => null, 'comment' => '更新者'),
				),
				'link_orders' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary', 'comment' => 'ID'),
					'link_key' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'リンクKey', 'charset' => 'utf8'),
					'weight' => array('type' => 'integer', 'null' => false, 'default' => '0', 'comment' => '表示の重み(表示順序)'),
					'created_user' => array('type' => 'integer', 'null' => true, 'default' => '0', 'comment' => '作成者'),
					'modified_user' => array('type' => 'integer', 'null' => true, 'default' => '0', 'comment' => '更新者'),
				),
				'links' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary', 'comment' => 'ID'),
					'block_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'comment' => 'ブロックID'),
					'category_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'comment' => 'カテゴリーID'),
					'language_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 6, 'comment' => '言語ID'),
					'status' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 4, 'comment' => '公開状況  1:公開中、2:公開申請中、3:下書き中、4:差し戻し'),
					'click_count' => array('type' => 'integer', 'null' => false, 'default' => '0', 'comment' => 'クリック数'),
					'created_user' => array('type' => 'integer', 'null' => true, 'default' => null, 'comment' => '作成者'),
					'modified_user' => array('type' => 'integer', 'null' => true, 'default' => null, 'comment' => '更新者'),
				),
			),
			'drop_field' => array(
				'link_frame_settings' => array('indexes' => array('frame_key')),
				'link_orders' => array('indexes' => array('link_key')),
				'links' => array('indexes' => array('block_id')),
			),
		),
	);

/**
 * Before migration callback
 *
 * @param string $direction Direction of migration process (up or down)
 * @return bool Should process continue
 */
	public function before($direction) {
		return true;
	}

/**
 * After migration callback
 *
 * @param string $direction Direction of migration process (up or down)
 * @return bool Should process continue
 */
	public function after($direction) {
		return true;
	}
}
