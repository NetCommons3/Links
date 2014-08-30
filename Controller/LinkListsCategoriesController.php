<?php
App::uses('LinkListsAppController', 'LinkLists.Controller');
/**
 * LinkListsCategories Controller
 *
 * @property LinkListsCategory $LinkListsCategory
 * @property PaginatorComponent $Paginator
 *
* @author   Jun Nishikawa <topaz2@m0n0m0n0.com>
* @link     http://www.netcommons.org NetCommons Project
* @license  http://www.netcommons.org/license.txt NetCommons License
 */
class LinkListsCategoriesController extends LinkListsAppController {

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
		$this->LinkListsCategory->recursive = 0;
		$this->set('linkListsCategories', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->LinkListsCategory->exists($id)) {
			throw new NotFoundException(__('Invalid link lists category'));
		}
		$options = array('conditions' => array('LinkListsCategory.' . $this->LinkListsCategory->primaryKey => $id));
		$this->set('linkListsCategory', $this->LinkListsCategory->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->LinkListsCategory->create();
			if ($this->LinkListsCategory->save($this->request->data)) {
				$this->Session->setFlash(__('The link lists category has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The link lists category could not be saved. Please, try again.'));
			}
		}
		$linklistsBlocks = $this->LinkListsCategory->LinklistsBlock->find('list');
		$languages = $this->LinkListsCategory->Language->find('list');
		$this->set(compact('linklistsBlocks', 'languages'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->LinkListsCategory->exists($id)) {
			throw new NotFoundException(__('Invalid link lists category'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->LinkListsCategory->save($this->request->data)) {
				$this->Session->setFlash(__('The link lists category has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The link lists category could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('LinkListsCategory.' . $this->LinkListsCategory->primaryKey => $id));
			$this->request->data = $this->LinkListsCategory->find('first', $options);
		}
		$linklistsBlocks = $this->LinkListsCategory->LinklistsBlock->find('list');
		$languages = $this->LinkListsCategory->Language->find('list');
		$this->set(compact('linklistsBlocks', 'languages'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->LinkListsCategory->id = $id;
		if (!$this->LinkListsCategory->exists()) {
			throw new NotFoundException(__('Invalid link lists category'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->LinkListsCategory->delete()) {
			$this->Session->setFlash(__('The link lists category has been deleted.'));
		} else {
			$this->Session->setFlash(__('The link lists category could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}}
