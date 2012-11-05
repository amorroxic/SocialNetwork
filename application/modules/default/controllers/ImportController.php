<?php

class ImportController extends Zend_Controller_Action
{

    public function indexAction()
    {
		// Set the site title, description, keywords
		$this->view->headTitle("Import");
		$this->view->headMeta()->appendName('description', 'This is a demo for Web Reservations Intl. Oh hai.');
		$this->view->headMeta()->appendName('keywords', 'keywords, are, evil');
        $this->view->addHelperPath(ROOTDIR.'/application/library/Helpers/','Zend_View_Helper');

        try {
            $importManager = new Import_Manager($this->view);
            $importManager->sanitizeInputData();
            $importManager->insertDataIntoDatabase();
        } catch (SocialException $e) {
            die($e->getMessage().' ['.$e->getCode().']');
        }

        die("Import succeeded.");

    }

}