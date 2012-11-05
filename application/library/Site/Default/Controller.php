<?php

class Site_Default_Controller extends Site_Controller
{

	public function init()
	{
		parent::init();
		$this->_helper->layout->setLayout('layout');
	}

}