<?php
/**
 * View/Elements/Links/delete_formテスト用Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AppController', 'Controller');

/**
 * View/Elements/Links/delete_formテスト用Controller
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Links\Test\test_app\Plugin\TestLinks\Controller
 */
class TestViewElementsLinksDeleteFormController extends AppController {

/**
 * delete_form
 *
 * @return void
 */
	public function delete_form() {
		$this->autoRender = true;
		$this->request->data['Link'] = array('id' => '2', 'key' => 'content_key_1');
		$this->request->data['LinkOrder'] = array('id' => '1');
		$this->request->data['Block'] = array('id' => '2', 'key' => 'block_1');
		$this->request->data['Frame'] = array('id' => '6');

		$this->request->params['plugin'] = 'links';
		$this->request->params['controller'] = 'links';
	}

}
