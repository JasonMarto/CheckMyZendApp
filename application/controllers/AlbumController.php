<?php

class AlbumController extends Zend_Controller_Action {

    public function init() {
	/* Initialize action controller here */
    }

    public function indexAction() {
	// action body
	$albums = new Application_Model_DbTable_Albums();
	$this->view->albums = $albums->fetchAll();
    }

    public function addAction() {
	// action body
	// 
	//Envoi du form à la vue
	$formAlbum = new Application_Form_Album();
	$formAlbum->add();
	//$form->submit->setLabel('Add');
	//$form->add;

	//Récupération du formulaire
	if ($this->getRequest()->isPost()) {
	    $formData = $this->getRequest()->getPost();
	    if(isset($formData['back'])){
		$this->_helper->redirector('index');
	    }
	    else{
	    
	    if ($formAlbum->isValid($formData)) {	

		$artist = $formAlbum->getValue('artist');
		$title = $formAlbum->getValue('title');
		$albums = new Application_Model_DbTable_Albums();
		$albums->addAlbum($artist, $title);
		
	    	$this->_helper->FlashMessenger('Successfull Save !');

	    } else {
		$formAlbum->populate($formData);
	    }
	}
	}
	$this->view->form = $formAlbum;
    }

    public function editAction() {
	// action body
	$formAlbum = new Application_Form_Album();
	
	$formAlbum->add();

	if ($this->getRequest()->isPost()) {
	    $formData = $this->getRequest()->getPost();

	    if ($formAlbum->isValid($formData)) {
		$id = (int) $this->getRequest()->getParam('id');
		$artist = $formAlbum->getValue('artist');
		$title = $formAlbum->getValue('title');

		$albums = new Application_Model_DbTable_Albums();
		$albums->updateAlbum($id, $artist, $title);
		$this->_helper->redirector('index');
	    } else {
		$formAlbum->populate($formData);
	    }
	} else {
	    $id = $this->_getParam('id', 0);

	    if ($id > 0) {
		$albums = new Application_Model_DbTable_Albums();
		$formAlbum->populate($albums->getAlbum($id));
	    }
	}
	$this->view->form = $formAlbum;
    }

    public function deleteAction() {
	// action body
	if ($this->getRequest()->isPost()) {
	    $del = $this->getRequest()->getPost('del');
	    if ($del == 'Yes') {
		$id = (int) $this->getRequest()->getPost('id');
		$albums = new Application_Model_DbTable_Albums();
		$albums->deleteAlbum($id);
	    }
	    $this->_helper->redirector('index');
	    $this->_helper->FlashMessenger('Deleted !');
	} else {
	    $id = $this->_getParam('id', 0);
	    $albums = new Application_Model_DbTable_Albums();
	    $this->view->album = $albums->getAlbum($id);
	}
    }

}

