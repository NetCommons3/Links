<?php
App::uses('LinksAppController', 'Links.Controller');
/**
 * Links Controller
 *
 * @property Link $Link
 * @property PaginatorComponent $Paginator
 *
 * @author   Jun Nishikawa <topaz2@m0n0m0n0.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */
class LinksController extends LinksAppController {

	public $uses = array(
		'Links.Link',
	);

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

/**
 * index
 *
 * @param int $frameId frame.id
 * @param string $lang languge_id
 * @return void
 */
	public function index($frameId = 0, $lang = '') {
		$this->_init($frameId, $lang);

		$this->Link->recursive = 0;
		$this->set('links', $this->Paginator->paginate());

		if (Configure::read('Pages.isSetting')) {
			$this->render('Links/setting_mode/index');
			//		編集権限があり、セッティングモードON⇒index/edit.ctpでrenderする
		} else {
			//		編集権限があり、セッティングモードOFF⇒index/latest.ctpでrenderする
			$this->render('Links/view/index');
		}
	}

/**
 * view method
 *
 * @param string $id 仮
 * @throws NotFoundException
 * @return void
 */
	public function view($id = null) {
		if (!$this->Link->exists($id)) {
			throw new NotFoundException(__('Invalid link list'));
		}
		$options = array('conditions' => array('Link.' . $this->Link->primaryKey => $id));
		$this->set('linkList', $this->Link->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Link->create();
			if ($this->Link->save($this->request->data)) {
				$this->Session->setFlash(__('The link list has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The link list could not be saved. Please, try again.'));
			}
		}
		$linksBlocks = $this->Link->LinksBlock->find('list');
		$languages = $this->Link->Language->find('list');
		$linksCategories = $this->Link->LinksCategory->find('list');
		$blocks = $this->Link->Block->find('list');
		$this->set(compact('linksBlocks', 'languages', 'linksCategories', 'blocks'));
	}

/**
 * edit method
 *
 * @param string $id 仮
 * @throws NotFoundException
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Link->exists($id)) {
			throw new NotFoundException(__('Invalid link list'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Link->save($this->request->data)) {
				$this->Session->setFlash(__('The link list has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The link list could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Link.' . $this->Link->primaryKey => $id));
			$this->request->data = $this->Link->find('first', $options);
		}
		$linksBlocks = $this->Link->LinksBlock->find('list');
		$languages = $this->Link->Language->find('list');
		$linksCategories = $this->Link->LinksCategory->find('list');
		$blocks = $this->Link->Block->find('list');
		$this->set(compact('linksBlocks', 'languages', 'linksCategories', 'blocks'));
	}

/**
 * delete method
 *
 * @param string $id kari
 * @throws NotFoundException
 * @return void
 */
	public function delete($id = null) {
		$this->Link->id = $id;
		if (!$this->Link->exists()) {
			throw new NotFoundException(__('Invalid link list'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Link->delete()) {
			$this->Session->setFlash(__('The link list has been deleted.'));
		} else {
			$this->Session->setFlash(__('The link list could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
