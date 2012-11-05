<?php

class IndexController extends Site_Default_Controller
{

    public function indexAction()
    {
		// Set the site title, description, keywords
		$this->view->headTitle("Informations");
		$this->view->headMeta()->appendName('description', 'This is a demo for Web Reservations Intl. Oh hai.');
		$this->view->headMeta()->appendName('keywords', 'keywords, are, evil');

		$accounts = $this->accountsManager->getAccounts();
		$this->view->accounts = $accounts;

    }

}