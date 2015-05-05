<?php
/**
 * Common code of LinkBlock model test
 *
 * @property LinkBlock $LinkBlock
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('LinksBaseModel', 'Links.Test/Case/Model');

/**
 * Common code of LinkBlock model test
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Links\Test\Case\Model
 */
class LinkBlockTest extends LinksBaseModel {

/**
 * setUp
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Block = ClassRegistry::init('Blocks.Block');
		$this->Category = ClassRegistry::init('Categories.Category');
		$this->CategoryOrder = ClassRegistry::init('Categories.CategoryOrder');
		$this->Link = ClassRegistry::init('Links.Link');
		$this->LinkBlock = ClassRegistry::init('Links.LinkBlock');
		$this->LinkOrder = ClassRegistry::init('Links.LinkOrder');
		$this->LinkSetting = ClassRegistry::init('Links.LinkSetting');
	}

/**
 * tearDown
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Block);
		unset($this->Category);
		unset($this->CategoryOrder);
		unset($this->Link);
		unset($this->LinkBlock);
		unset($this->LinkOrder);
		unset($this->LinkSetting);
		parent::tearDown();
	}
}
