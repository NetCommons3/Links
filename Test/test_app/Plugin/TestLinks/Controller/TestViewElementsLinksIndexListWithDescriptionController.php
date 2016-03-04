<?php
/**
 * View/Elements/Links/index_list_with_descriptionテスト用Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('LinksController', 'Links.Controller');

/**
 * View/Elements/Links/index_list_with_descriptionテスト用Controller
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Links\Test\test_app\Plugin\TestLinks\Controller
 */
class TestViewElementsLinksIndexListWithDescriptionController extends LinksController {

/**
 * index_list_with_description
 *
 * @return void
 */
	public function index_list_with_description() {
		$this->autoRender = true;
		parent::index();
	}

}
