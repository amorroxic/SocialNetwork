<?php

class Site_Controller extends Zend_Controller_Action
{

	protected $accountsManager;
	protected $citiesManager;

	public function init()
	{
		$this->accountsManager = new Accounts_Manager();
		$this->citiesManager = new Cities_Manager();
		$this->view->addHelperPath(ROOTDIR.'/application/library/Helpers/','Zend_View_Helper');
	}

	protected function sanitizeInput($field, $performEscape = false) {

		$request = $this->getRequest();
		$parameterValue = $request->getParam($field);

		if (!isset($parameterValue)) {
			throw new SocialException(SocialException::USER_NOT_SPECIFIED);
			return false;
		}

		$parameterValue = $this->view->slug($parameterValue);

		if ($parameterValue == '') {
			throw new SocialException(SocialException::USER_NOT_SPECIFIED);
			return false;
		}

		return $parameterValue;

	}

	protected function processInput($parameterKey) {

    	try {
    		$user = $this->sanitizeInput($parameterKey);
    		$userID = $this->accountsManager->getIdForSlug($user);
    	} catch (SocialException $e) {
    		throw $e;
    	}

    	return $userID;

	}

}