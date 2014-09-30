Links
==============

Links for NetComomns3


【プラグイン追加方法】

1. /var/www/app/app/Plugin/にダウンロードしてください。

2. 以下、SQLを実行して、「Add plugin」からプラグインを追加してください。

プラグインを追加したのち、ログイン⇒セッティングモードONにして下さい。


    INSERT INTO plugins(id, folder, type, version) VALUES (11, 'links', 1, 'dev-master');

    INSERT INTO plugins_roles(role_id, plugin_id) VALUES (1, 11);

    INSERT INTO plugins_rooms(room_id, plugin_id) VALUES (1, 11);

    INSERT INTO languages_plugins(plugin_id, language_id, name) VALUES (11, 2, 'リンクリスト');

尚、最新のソースでないとエラーが起こることがあります。
