<?php

class Site_Api_Controller extends Site_Controller
{

	public function init()
	{
		parent::init();
        $this->getHelper('layout')->disableLayout();
	}

}