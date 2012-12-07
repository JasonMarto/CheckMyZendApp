<?php

class UserController extends Zend_Controller_Action {

    public function init() {
	/* Initialize action controller here */
    }

    public function indexAction() {
	// action body
    }

    public function addAction() {
	// action body
	$formUser = new Application_Form_User();
	$formUser->add();

	if ($this->getRequest()->isPost()) {
	    $request = $this->getRequest()->getPost();
	    $valid = $formUser->isValid($request);

	    if (isset($request['back'])) {
		$this->_helper->redirector('index');
	    }
	    if ($valid) {
		$insertUser = new Application_Model_DbTable_Users();
		$values = $formUser->getValues();

		//$allUsers = $insertUser->fetchAll()->toArray();

		$insertUser->insert($values);

		//var_dump($values);
	    }
	}
	$this->view->formUser = $formUser;
    }

    public function loginAction() {
	// action body
	$formUser = new Application_Form_User();
	$formUser->login();
	if ($this->getRequest()->isPost()) {
	    $request = $this->getRequest()->getPost();
	    $valid = $formUser->isValid($request);

	    if (isset($request['back'])) {
		$this->_helper->redirector('index');
	    }
	    
	    if ($valid) {
		$loginUser = new Application_Model_DbTable_Users();
		$loginUser->loginName = $formUser->getValue("username");
		$loginUser->loginPassword = $formUser->getValue("password");
		$loginAuth = $loginUser->auth();

		if ($loginAuth) {
		    $auth = Zend_Auth::getInstance();
		    $userAuth = $auth->getIdentity();
		    $this->view->user = $userAuth;
		  //  $this->_helper->FlashMessenger('Welcome '.$auth->getIdentity()->username);
		    // Et pour envoyer les messages à la vue :
		}
	    } else {
		$formUser->populate($request);
	    }
	}
	//$this->view->messages = $this->_helper->FlashMessenger->getMessages();
	$this->view->formUser = $formUser;
    }

}

