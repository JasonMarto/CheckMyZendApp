<?php

class Application_Form_Album extends Zend_Form {

    public function init() {
	$view = new Zend_View();
	$view->addScriptPath(APPLICATION_PATH.'/forms/views/script/album/');
	$this->setView($view);

	$this->setMethod('POST');
	$this->setAction('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
    }

    public function add() {
	/* Form Elements & Other Definitions Here ... */
	
	$this->addElements(array($this->addId(), $this->addTitle(), $this->addArtist(), $this->addSubmitButton(), $this->addBackButton()));
	$this->setDecorators(array(array('ViewScript', array('viewScript' => 'albumForm.phtml'))));
	
	
	return $this;
    }

    protected function addId() {
	//id element caché
	$id = new Zend_Form_Element_Hidden('id');
	$id->addFilter('Int');

	return $id;
    }

    protected function addTitle() {
	//Title
	$title = new Zend_Form_Element_Text('title');
	$title->setLabel('Title')
		->setRequired(true)
		->addFilter('StripTags')
		->addFilter('StringTrim')
		->addValidator('NotEmpty');

	return $title;
    }

    protected function addArtist() {
	//Artist
	$artist = new Zend_Form_Element_Text('artist');
	$artist->setLabel('Artist')
		->setRequired(true)
		->addFilter('StripTags')
		->addFilter('StringTrim')
		->addValidator('NotEmpty');

	return $artist;
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

