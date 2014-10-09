Links
==============

Links for NetComomns3


【プラグイン追加方法】

1. /var/www/app/app/Plugin/にダウンロードしてください。

2. 以下、SQLを実行して、「Add plugin」からプラグインを追加してください。

プラグインを追加したのち、ログイン⇒セッティングモードONにして下さい。


    INSERT INTO plugins (id, language_id, `key`, `name`, namespace, weight, `type`, created_user, created, modified_user, modified)
     VALUES (11, 2, 'links', 'リンクリスト', 'netcommons/links', NULL, 1, 1, NULL, 1, NULL);

    INSERT INTO plugins_roles (role_key, plugin_key, created_user, created, modified_user, modified)
     VALUES ('room_administrator', 'links', NULL, NULL, NULL, NULL);

    INSERT INTO plugins_rooms (room_id, plugin_key, created_user, created, modified_user, modified)
     VALUES (1, 'links', NULL, NULL, NULL, NULL);


尚、最新のソースでないとエラーが起こることがあります。
