<?php
App::uses('LinkListsAppController', 'LinkLists.Controller');
/**
 * LinkLists Controller
 *
 * @property LinkList $LinkList
 * @property PaginatorComponent $Paginator
 *
* @author   Jun Nishikawa <topaz2@m0n0m0n0.com>
* @link     http://www.netcommons.org NetCommons Project
* @license  http://www.netcommons.org/license.txt NetCommons License
 */
class LinkListsController extends LinkListsAppController {

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
		$this->LinkList->recursive = 0;
		$this->set('linkLists', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->LinkList->exists($id)) {
			throw new NotFoundException(__('Invalid link list'));
		}
		$options = array('conditions' => array('LinkList.' . $this->LinkList->primaryKey => $id));
		$this->set('linkList', $this->LinkList->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->LinkList->create();
			if ($this->LinkList->save($this->request->data)) {
				$this->Session->setFlash(__('The link list has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The link list could not be saved. Please, try again.'));
			}
		}
		$linklistsBlocks = $this->LinkList->LinklistsBlock->find('list');
		$languages = $this->LinkList->Language->find('list');
		$linklistsCategories = $this->LinkList->LinklistsCategory->find('list');
		$blocks = $this->LinkList->Block->find('list');
		$this->set(compact('linklistsBlocks', 'languages', 'linklistsCategories', 'blocks'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->LinkList->exists($id)) {
			throw new NotFoundException(__('Invalid link list'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->LinkList->save($this->request->data)) {
				$this->Session->setFlash(__('The link list has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The link list could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('LinkList.' . $this->LinkList->primaryKey => $id));
			$this->request->data = $this->LinkList->find('first', $options);
		}
		$linklistsBlocks = $this->LinkList->LinklistsBlock->find('list');
		$languages = $this->LinkList->Language->find('list');
		$linklistsCategories = $this->LinkList->LinklistsCategory->find('list');
		$blocks = $this->LinkList->Block->find('list');
		$this->set(compact('linklistsBlocks', 'languages', 'linklistsCategories', 'blocks'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->LinkList->id = $id;
		if (!$this->LinkList->exists()) {
			throw new NotFoundException(__('Invalid link list'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->LinkList->delete()) {
			$this->Session->setFlash(__('The link list has been deleted.'));
		} else {
			$this->Session->setFlash(__('The link list could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}}
