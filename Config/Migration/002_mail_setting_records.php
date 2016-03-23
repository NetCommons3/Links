<?php
/**
 * メール設定データのMigration
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsMigration', 'NetCommons.Config/Migration');

/**
 * メール設定データのMigration
 *
 * @package NetCommons\Mails\Config\Migration
 */
class LinkMailSettingRecords extends NetCommonsMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'mail_setting_records';

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
		'MailSetting' => array(
			//コンテンツ通知
			// * 英語
			array(
				'language_id' => '1',
				'plugin_key' => 'links',
				'block_key' => null,
				'type_key' => 'contents',
				'is_mail_send' => false,
				'mail_fixed_phrase_subject' => '', //デフォルト(__d('mails', 'MailSetting.mail_fixed_phrase_subject'))
				'mail_fixed_phrase_body' => '{X-PLUGIN_NAME}にリンクが追加されたのでお知らせします。
ルーム名: {X-ROOM}
リンクリスト名: {X-BLOCK_NAME}
リンク先: {X-LINK_URL}
タイトル: {X-TITLE}
カテゴリ: {X-CATEGORY_NAME}
登録者: {X-USER}
登録日時: {X-TO_DATE}
説明:
{X-DESCRIPTION}

このリンクを確認するには、下記アドレスへ
{X-URL}',
			),
			// * 日本語
			array(
				'language_id' => '2',
				'plugin_key' => 'links',
				'block_key' => null,
				'type_key' => 'contents',
				'is_mail_send' => false,
				'mail_fixed_phrase_subject' => '',
				'mail_fixed_phrase_body' => '{X-PLUGIN_NAME}にリンクが追加されたのでお知らせします。
ルーム名: {X-ROOM}
リンクリスト名: {X-BLOCK_NAME}
リンク先: {X-LINK_URL}
タイトル: {X-TITLE}
カテゴリ: {X-CATEGORY_NAME}
登録者: {X-USER}
登録日時: {X-TO_DATE}
説明:
{X-DESCRIPTION}

このリンクについて確認するには、下記アドレスへ
{X-URL}',
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
		foreach ($this->records as $model => $records) {
			if (!$this->updateRecords($model, $records)) {
				return false;
			}
		}
		return true;
	}
}
