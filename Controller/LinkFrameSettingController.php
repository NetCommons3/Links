<?php
/**
 * Links Controller
 *
 * @author Ryuji AMANO <ryuji@ryus.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('LinksAppController', 'Links.Controller');

/**
 * Links Controller
 *
 * @author Ryuji AMANO <ryuji@ryus.co.jp>
 * @package NetCommons\Links\Controller
 *
 * @property LinkFrameSetting $LinkFrameSetting
 */
class LinkFrameSettingController extends LinksAppController {

public $helpers = array('Links.LinksStatus');
/**
 * use model
 *
 * @var array
 */
	public $uses = array(
		'Links.LinkFrameSetting',
	);

/**
 * use component
 *
 * @var array
 */

	public $components = array(
		'NetCommons.NetCommonsBlock', //use Announcement model
		'NetCommons.NetCommonsFrame',
		'NetCommons.NetCommonsRoomRole',
	);

/**
 * beforeFilter
 *
 * @return void
 */
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow();

		$frameId = (isset($this->params['pass'][0]) ? (int)$this->params['pass'][0] : 0);
		//Frameのデータをviewにセット
		if (! $this->NetCommonsFrame->setView($this, $frameId)) {
			$this->response->statusCode(400);
			return;
		}
		//Roleのデータをviewにセット
		if (! $this->NetCommonsRoomRole->setView($this)) {
			$this->response->statusCode(400);
			return;
		}
	}

	public function get($frameId = 0) {
		$linkFrameSetting = $this->LinkFrameSetting->getByFrameId($frameId);
		$this->set('linkFrameSetting', $linkFrameSetting['LinkFrameSetting']);
		$this->set('_serialize', 'linkFrameSetting');
		return $this->render(false);

	}


	public function form($frameId = 0) {
		$this->set(compact('frameId'));
		$linkFrameSetting = $this->LinkFrameSetting->getByFrameId($frameId);
		$this->set(compact('linkFrameSetting'));
	}

	public function edit($frameId) {
		if (! $this->request->isPost()) {
			throw new MethodNotAllowedException();
		}
		//保存
		if ($this->LinkFrameSetting->save($this->data)) {

			$result = array(
				'name' => __d('net_commons', 'Successfully finished.'),
				'link' => $this->data,
			);

			$this->set(compact('result'));
			$this->set('_serialize', 'result');
			return $this->render(false);
		} else {

			$error = __d('net_commons', 'Failed to register data.');
			$error .= $this->formatValidationErrors($this->LinkFrameSetting->validationErrors);
			throw new ForbiddenException($error);
		}

	}

	// MyTodo モデルに移動するか、ヘルパかコンポーネントかビヘイビアにする… ->beforeValidate
	protected function formatValidationErrors($validationErrors) {
		$errors = array();
		foreach($validationErrors as $field => $fieldErrors){
			foreach($fieldErrors as $errorMessage){
				$errors[] = __d('links', $field) . ':' . __d('links', $errorMessage);
			}
		}
		$returnMessage = implode("\n", $errors);
		return $returnMessage;
	}
}
