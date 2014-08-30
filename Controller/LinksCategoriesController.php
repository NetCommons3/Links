<?php
App::uses('LinksAppController', 'Links.Controller');
/**
 * LinksCategories Controller
 *
 * @property LinksCategory $LinksCategory
 * @property PaginatorComponent $Paginator
 *
 * @author   Ryuji AMANO <ryuji@ryus.co.jp>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */
class LinksCategoriesController extends LinksAppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->LinksCategory->recursive = 0;
		$this->set('linkListsCategories', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @param string $id 仮
 * @throws NotFoundException
 * @return void
 */
	public function view($id = null) {
		if (!$this->LinksCategory->exists($id)) {
			throw new NotFoundException(__('Invalid link lists category'));
		}
		$options = array('conditions' => array('LinksCategory.' . $this->LinksCategory->primaryKey => $id));
		$this->set('linkListsCategory', $this->LinksCategory->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->LinksCategory->create();
			if ($this->LinksCategory->save($this->request->data)) {
				$this->Session->setFlash(__('The link lists category has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The link lists category could not be saved. Please, try again.'));
			}
		}
		$linksBlocks = $this->LinksCategory->LinksBlock->find('list');
		$languages = $this->LinksCategory->Language->find('list');
		$this->set(compact('linksBlocks', 'languages'));
	}

/**
 * edit method
 *
 * @param string $id 仮
 * @throws NotFoundException
 * @return void
 */
	public function edit($id = null) {
		if (!$this->LinksCategory->exists($id)) {
			throw new NotFoundException(__('Invalid link lists category'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->LinksCategory->save($this->request->data)) {
				$this->Session->setFlash(__('The link lists category has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The link lists category could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('LinksCategory.' . $this->LinksCategory->primaryKey => $id));
			$this->request->data = $this->LinksCategory->find('first', $options);
		}
		$linksBlocks = $this->LinksCategory->LinksBlock->find('list');
		$languages = $this->LinksCategory->Language->find('list');
		$this->set(compact('linksBlocks', 'languages'));
	}

/**
 * delete method
 *
 * @param string $id 仮
 * @throws NotFoundException
 * @return void
 */
	public function delete($id = null) {
		$this->LinksCategory->id = $id;
		if (!$this->LinksCategory->exists()) {
			throw new NotFoundException(__('Invalid link lists category'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->LinksCategory->delete()) {
			$this->Session->setFlash(__('The link lists category has been deleted.'));
		} else {
			$this->Session->setFlash(__('The link lists category could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}}
