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

App::uses('LinksController', 'Links.Controller');

/**
 * LinksController::get()のテスト用Controller
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Links\Test\test_app\Plugin\Links\Controller
 */
class TestControllerLinksControllerGetController extends LinksController {

/**
 * delete_form
 *
 * @return void
 */
	public function get() {
		$this->autoRender = true;
		App::uses('HttpSocket', 'TestLinks.Network');
		parent::get();
	}

}
