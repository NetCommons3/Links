<?php
/**
 * Add plugin migration
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsMigration', 'NetCommons.Config/Migration');
App::uses('Space', 'Rooms.Model');

/**
 * Add plugin migration
 *
 * @package NetCommons\PluginManager\Config\Migration
 */
class PluginRecords extends NetCommonsMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'plugin_records';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(),
		'down' => array(),
	);

/**
 * plugin data
 *
 * @var array $migration
 */
	public $records = array(
		'Plugin' => array(
			//日本語
			array(
				'language_id' => '2',
				'key' => 'links',
				'namespace' => 'netcommons/links',
				'name' => 'リンクリスト',
				'type' => 1,
				'default_action' => 'links/index',
				'default_setting_action' => 'link_blocks/index',
				'display_topics' => 1,
				'display_search' => 1,
			),
			//英語
			array(
				'language_id' => '1',
				'key' => 'links',
				'namespace' => 'netcommons/links',
				'name' => 'Bookmark List',
				'type' => 1,
				'default_action' => 'links/index',
				'default_setting_action' => 'link_blocks/index',
				'display_topics' => 1,
				'display_search' => 1,
			),
		),
		'PluginsRole' => array(
			array(
				'role_key' => 'room_administrator',
				'plugin_key' => 'links'
			),
		),
		//PluginsRoomは、beforeでセットする
	);

/**
 * Before migration callback
 *
 * @param string $direction Direction of migration process (up or down)
 * @return bool Should process continue
 */
	public function before($direction) {
		$pluginName = $this->records['Plugin'][0]['key'];
		$this->records['PluginsRoom'] = array(
			//サイト全体
			array(
				'room_id' => Space::getRoomIdRoot(Space::WHOLE_SITE_ID, 'Room'),
				'plugin_key' => $pluginName
			),
			//パブリックスペース
			array(
				'room_id' => Space::getRoomIdRoot(Space::PUBLIC_SPACE_ID, 'Room'),
				'plugin_key' => $pluginName
			),
			//プライベートスペース
			array(
				'room_id' => Space::getRoomIdRoot(Space::PRIVATE_SPACE_ID, 'Room'),
				'plugin_key' => $pluginName
			),
			//グループスペース
			array(
				'room_id' => Space::getRoomIdRoot(Space::COMMUNITY_SPACE_ID, 'Room'),
				'plugin_key' => $pluginName
			),
		);
		return true;
	}

/**
 * After migration callback
 *
 * @param string $direction Direction of migration process (up or down)
 * @return bool Should process continue
 */
	public function after($direction) {
		$this->loadModels([
			'Plugin' => 'PluginManager.Plugin',
		]);

		if ($direction === 'down') {
			$this->Plugin->uninstallPlugin($this->records['Plugin'][0]['key']);
			return true;
		}

		foreach ($this->records as $model => $records) {
			if (!$this->updateRecords($model, $records)) {
				return false;
			}
		}
		return true;
	}
}
