<?php

class Application_Model_DbTable_Users extends Zend_Db_Table_Abstract {

    protected $_name = 'users';
    protected $_primary = 'id';

    public function auth() {

	$dbAdapter = Zend_Db_Table::getDefaultAdapter();
	$authAdapter = new Zend_Auth_Adapter_DbTable($dbAdapter);

	$authAdapter->setTableName($this->_name)
		->setIdentityColumn('username')
		->setCredentialColumn('password');


	// Set the input credential values to authenticate against
	$authAdapter->setIdentity($this->loginName);
	$authAdapter->setCredential($this->loginPassword);

	$auth = Zend_Auth::getInstance();
	$authResult = $auth->authenticate($authAdapter);
	
	
	if ($authResult->isValid()) {

	    $user = $authAdapter->getResultRowObject();
	    
	    $auth->getStorage()->write($user);
	    
	    
	    return true;
	}

	return false;
    }

}

