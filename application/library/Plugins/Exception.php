<?php
class Plugins_Exception extends Zend_Controller_Plugin_Abstract {

	public function preDispatch(Zend_Controller_Request_Abstract $request) {
	
		$front = Zend_Controller_Front::getInstance();
		$dispatcher = $front->getDispatcher();
		if (!$dispatcher->isDispatchable($request)) {
			console.log("redirected");
		} else {
			console.log("not redirected");
		}
	}
}

?>