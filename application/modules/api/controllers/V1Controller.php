<?php

class Api_V1Controller extends Site_Api_Controller
{
    public function init()
    {
        parent::init();

        // determine the requested output format
        // if we don't support it, switch to xml
        $request = $this->getRequest();
        $format = $request->getParam('format','xml');
        $format = strtolower($format);
        if (!in_array($format, array('xml','json'))) $format = 'xml';
        $request->setParam('format',$format);

        try {
          $this->_helper->contextSwitch()
                        ->addActionContext('friends', array('xml', 'json'))
                        ->addActionContext('friends-of-friends', array('xml', 'json'))
                        ->addActionContext('suggested-friends', array('xml', 'json'))
                        ->addActionContext('recommended-cities', array('xml', 'json'))
                        ->setAutoJsonSerialization(true)
                        ->initContext($format);
        } catch (Exception $e) {
          throw new SocialException(SocialException::API_FORMAT_NOT_SUPPORTED);
        }
    }

    public function friendsAction() {
      // never trust input. trust Mogwai instead.
      try {
        $userID = $this->processInput('of');
        $this->view->friends = $this->accountsManager->getFriendsOf($userID);
      } catch (SocialException $e) {
        $this->view->error_code = $e->getCode();
        $this->view->error_message = $e->getMessage();
      }

    }

    public function friendsOfFriendsAction() {
      // never trust input. trust Mogwai instead.
      try{
        $userID = $this->processInput('of');
        $this->view->friends_of_friends = $this->accountsManager->getFriendsOfFriendsOf($userID);
      } catch (SocialException $e) {
        $this->view->error_code = $e->getCode();
        $this->view->error_message = $e->getMessage();
      }
    }

    public function suggestedFriendsAction() {
      // never trust input. trust Mogwai instead.
      try{
        $userID = $this->processInput('for');
        $this->view->suggested_friends = $this->accountsManager->getSuggestedFriendsFor($userID);
      } catch (SocialException $e) {
        $this->view->error_code = $e->getCode();
        $this->view->error_message = $e->getMessage();
      }
    }

    public function recommendedCitiesAction() {
      // never trust input. trust Mogwai instead.
      try{
        $userID = $this->processInput('for');
        $this->view->cities = $this->citiesManager->getRecommendedCitiesFor($userID);
      } catch (SocialException $e) {
        $this->view->error_code = $e->getCode();
        $this->view->error_message = $e->getMessage();
      }
    }

}