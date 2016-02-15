<?php
/**
 * View/Elements/LinkBlocks/delete_formテスト用Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AppController', 'Controller');

/**
 * View/Elements/LinkBlocks/delete_formテスト用Controller
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Links\Test\test_app\Plugin\Links\Controller
 */
class TestViewElementsLinkBlocksDeleteFormController extends AppController {

/**
 * delete_form
 *
 * @return void
 */
	public function delete_form() {
		$this->autoRender = true;

		$this->request->data = array(
			'Block' => array(
				'id' => '1',
				'key' => 'block_key_1',
			),
			'LinkBlock' => array(
				'key' => 'block_key_1',
			),
		);
	}

}
