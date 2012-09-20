<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // query defaults and get parameters
        $defaults = array(
            'p' => 1,
            'pp' => 10,
            'q' => null,
        );
        $Request = $this->getRequest();
        $query = $this->getRequest()->getQuery();
        $config = array_merge($defaults, $query);
        // pagination
        $page = $config['p'];
        $perPage = $config['pp'];
        $searchQuery = $config['q'];
        // get the tweets
        $Table = new Application_Model_DbTable_Tweet(array(
            'rowClass' => 'Application_Model_Tweet'
        ));
        $tweets = $Table->search($searchQuery, ($page - 1) * $perPage, $perPage);

        // send json bodies or render HTML?
        $isXmlHttpRequest = $Request->isXmlHttpRequest();
        $isJSONContentType = $Request->getHeader('Content-Type') == 'application/json';
        $isGetAjax = isset($query['ajax']);
        if ($isGetAjax || $isJSONContentType || $isXmlHttpRequest) {
            $data = array();
            foreach($tweets as $Tweet) {
                $date = new DateTime($Tweet->getCreatedAt());
                $tweetData = array(
                    'id' => $Tweet->getIdStr(),
                    'user' => array(
                        'name' => $Tweet->getFromUser(),
                        'id' => $Tweet->getFromUserIdStr(),
                        'username' => $Tweet->getFromUserName(),
                    ),
                    'source' => $Tweet->getSource(),
                    'text' => $Tweet->getText(),
                    'created' => $date->format('c'),
                );
                $data[] = $tweetData;
            }
            $this->getHelper('json')->sendJson($data);
            exit;
        }

        // assign for the view
        $this->view->assign('tweets', $tweets);
        $this->view->assign('q', $searchQuery);
    }
}