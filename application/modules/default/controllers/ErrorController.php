<?php

class ErrorController extends Site_Default_Controller
{

    public function errorAction()
    {
		// Clear the response body
		$this->getResponse()->clearBody();

		// Get the error message
    	$errors = $this->_getParam('error_handler');
    	$exception = $errors->exception;
		$this->view->zend_error_message = $exception;
		die($exception->getMessage());
		// Log the error
		try {
			if (!$exception instanceof Zend_Controller_Dispatcher_Exception) {
				Logger::get()->err($exception);
			} else {
		    	Logger::get()->warn($exception);
			}
		} catch (Exception $ex) {
			// don't do anything yet
		}
	}
}