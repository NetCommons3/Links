<?php
/**
 * LinksController::get()のテスト用Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

/**
 * LinksController::get()のテスト用ダミーResponse
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Links\Test\test_app\Plugin\Links\Controller
 */
class TestResponse {

/**
 * URL
 *
 * @var string
 */
	public $url = '';

/**
 * レスポンスボディ
 *
 * @var string
 */
	public $body = '';

/**
 * Constructor.
 *
 * @param string $url URL
 * @return void
 */
	public function __construct($url) {
		$this->url = $url;
		$this->body = '<head>
			<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
			<meta http-equiv="content-language" content="ja" />
			<meta name="robots" content="index,follow" />
			<meta name="description" content="LinksController::get() test description" />
			<title>LinksController::get() test title</title>
			</head>';
	}

/**
 * OKかどうか
 *
 * @return bool
 */
	public function isOk() {
		return ($this->url === 'success');
	}

}

/**
 * LinksController::get()のテスト用ダミーHttpSocket
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Links\Test\test_app\Plugin\Links\Controller
 */
class HttpSocket {

/**
 * Constructor.
 *
 * @param array $options オプション
 * @return void
 */
	public function __construct($options = array()) {
	}

/**
 * getメソッド
 *
 * @param string $url URL
 * @return void
 */
	public function get($url) {
		return new TestResponse($url);
	}

}
