<?php
/**
 * View/Elements/Links/index_dropdownテスト用Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('LinksController', 'Links.Controller');

/**
 * View/Elements/Links/index_dropdownテスト用Controller
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Links\Test\test_app\Plugin\TestLinks\Controller
 */
class TestViewElementsLinksIndexDropdownController extends LinksController {

/**
 * index_dropdown
 *
 * @return void
 */
	public function index_dropdown() {
		$this->autoRender = true;
		parent::index();
	}

}
