<?php
/**
 * メール設定データのMigration
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('MailsMigration', 'Mails.Config/Migration');

/**
 * メール設定データのMigration
 *
 * @package NetCommons\Mails\Config\Migration
 */
class LinkMailSettingRecords extends MailsMigration {

/**
 * プラグインキー
 *
 * @var string
 */
	const PLUGIN_KEY = 'links';

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
			//コンテンツ通知 - 設定
			array(
				'plugin_key' => self::PLUGIN_KEY,
				'block_key' => null,
				'is_mail_send' => false,
				'is_mail_send_approval' => true,
			),
		),
		'MailSettingFixedPhrase' => array(
			//コンテンツ通知 - 定型文
			// * 英語
			array(
				'language_id' => '1',
				'plugin_key' => self::PLUGIN_KEY,
				'block_key' => null,
				'type_key' => 'contents',
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
				'plugin_key' => self::PLUGIN_KEY,
				'block_key' => null,
				'type_key' => 'contents',
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
		return parent::updateAndDelete($direction, self::PLUGIN_KEY);
	}
}
