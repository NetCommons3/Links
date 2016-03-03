<?php
/**
 * View/Elements/Links/edit_linkテスト用Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AppController', 'Controller');
App::uses('LinkFixture', 'Links.Test/Fixture');

/**
 * View/Elements/Links/edit_linkテスト用Controller
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Links\Test\test_app\Plugin\TestLinks\Controller
 */
class TestViewElementsLinksEditLinkController extends AppController {

/**
 * use helpers
 *
 * @var array
 */
	public $helpers = array(
		'Workflow.Workflow',
	);

/**
 * edit_link
 *
 * @return void
 */
	public function edit_link() {
		$this->autoRender = true;
		$link['Link'] = (new LinkFixture())->records[1];
		$this->set('link', $link);
	}

}
