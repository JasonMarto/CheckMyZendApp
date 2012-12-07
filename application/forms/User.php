<?php

class Application_Form_User extends Zend_Form {

    public function init() {
	/* Form Elements & Other Definitions Here ... */
	$view = new Zend_View();
	$view->addScriptPath(APPLICATION_PATH . '/forms/views/script/user/');
	$this->setView($view);

	$this->setMethod('POST');
	$this->setAction('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
    }

    public function add() {

	$this->addElement($this->addUserName());
	$this->addElement($this->addPassword());
	$this->addElement($this->addSubmitButton());
	$this->addElement($this->addBackButton());
	
	$this->setDecorators(array(array('viewScript', array('viewScript' => 'add.phtml'))));

	return $this;
    }
        public function login() {

	$this->addElement($this->addUserName());
	$this->addElement($this->addPassword());
	$this->addElement($this->addSubmitButton());
	$this->addElement($this->addBackButton());


	$this->setDecorators(array(array('viewScript', array('viewScript' => 'login.phtml'))));

	return $this;
    }

    protected function addUserName() {
	//Title
	$username = new Zend_Form_Element_Text('username');
	$username->setLabel('Enter a Login')
		->addValidator('alnum')
		->addValidator('regex', false, array('/^[a-z]+/'))
		->addValidator('stringLength', false, array(6, 20))
		->setRequired(true)
		->addFilter('StringToLower');

	return $username;
    }

    protected function addPassword() {
	//Title
	$password = new Zend_Form_Element_Text('password');
	$password->setLabel('Enter a password')
		->addValidator('StringLength', false, array(6))
		->setRequired(true);

	return $password;
    }

    protected function addSubmitButton() {

	$submit = new Zend_Form_Element_Submit('submit');
	$submit->setAttrib('id', 'submitbutton');

	return $submit;
    }

    protected function addBackButton() {

	$submit = new Zend_Form_Element_Submit('back');
	$submit->setAttrib('id', 'backbutton');

	return $submit;
    }

}

