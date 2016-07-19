<?php
/**
 * View/Elements/Links/linkテスト用Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AppController', 'Controller');
App::uses('LinkFixture', 'Links.Test/Fixture');
App::uses('LinkFrameSettingFixture', 'Links.Test/Fixture');

/**
 * View/Elements/Links/linkテスト用Controller
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Links\Test\test_app\Plugin\TestLinks\Controller
 */
class TestViewElementsLinksLinkController extends AppController {

/**
 * use helpers
 *
 * @var array
 */
	public $helpers = array(
		'Workflow.Workflow',
	);

/**
 * link
 *
 * @return void
 */
	public function link() {
		$this->autoRender = true;
		$this->view = 'link';
		if ($this->params['key'] === 'content_key_2') {
			$link['Link'] = (new LinkFixture())->records[2];
		} else {
			$link['Link'] = (new LinkFixture())->records[0];
		}
		$this->set('link', $link);
		$this->set('linkFrameSetting', (new LinkFrameSettingFixture())->records[0]);
	}

/**
 * link_without_new_tab
 *
 * @return void
 */
	public function link_without_new_tab() {
		$this->link();
		$this->viewVars['linkFrameSetting']['open_new_tab'] = false;
	}

/**
 * link_without_click_count
 *
 * @return void
 */
	public function link_without_click_count() {
		$this->link();
		$this->viewVars['linkFrameSetting']['display_click_count'] = false;
	}

}
