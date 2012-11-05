<?php

class StatusController extends Zend_Controller_Action
{

	public function init() 
	{ 
	}

    public function indexAction()
    {
		die(phpinfo());
    }

	public function zendAction() {
		die(Zend_Version::VERSION);
	}
	
	public function includeAction() {
		die(get_include_path());
	}
    
}