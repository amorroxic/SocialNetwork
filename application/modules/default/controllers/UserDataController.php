<?php

class UserDataController extends Site_Default_Controller
{

    function preDispatch()
    {
        $request = $this->getRequest();
        $isAjax = $request->isXmlHttpRequest();
        if (!$isAjax) {
            $this->_redirect('/');
        }

    }

    public function indexAction()
    {
        // we already know it's an XMLHTTP request. Checking to see what's the story with the protocol.
        $request = $this->getRequest();
        $isPost = $request->isPost();

        // is there somebody trying uri ?
        if (!$isPost) {
            $jsonData = array();
            $jsonData['content'] = "Please send data via POST.";
            $this->_helper->json->sendJson($jsonData);
            return;
        }

        // we're good to go.
        $jsonData = array();

        try {

            $userID = $this->processInput('slug');

            $friends = $this->accountsManager->getFriendsOf($userID);
            $friendsOfFriends = $this->accountsManager->getFriendsOfFriendsOf($userID);
            $suggestedFriends = $this->accountsManager->getSuggestedFriendsFor($userID);
            $recommendedCities = $this->citiesManager->getRecommendedCitiesFor($userID);

            $this->view->people = $friends;
            $this->view->title = "Friends";
            $this->view->apiLink = "/api/v1/friends/of";
            $jsonData['content'] = $this->view->render('user-data/list.phtml');

            $this->view->people = $friendsOfFriends;
            $this->view->title = "Friends of friends";
            $this->view->apiLink = "/api/v1/friends-of-friends/of";
            $jsonData['content'] .= $this->view->render('user-data/list.phtml');

            $this->view->people = $suggestedFriends;
            $this->view->title = "Suggested friends";
            $this->view->apiLink = "/api/v1/suggested-friends/for";
            $jsonData['content'] .= $this->view->render('user-data/list.phtml');

            $slug = $this->sanitizeInput('slug');
            $this->view->cities = $recommendedCities;
            $this->view->title = "Recommended cities";
            $this->view->apiLink = "/api/v1/recommended-cities/for/".$slug;
            $jsonData['content'] .= $this->view->render('user-data/cities.phtml');

        } catch (Exception $e) {
            $jsonData['content'] = "<h2>".$e->getMessage()."</h2>";
        }

        $this->_helper->json->sendJson($jsonData);
        return;

    }

}