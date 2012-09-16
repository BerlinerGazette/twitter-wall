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
        $query = $this->getRequest()->getQuery();
        $config = array_merge($defaults, $query);
        // pagination
        $page = $config['p'];
        $perPage = $config['pp'];
        $query = $config['q'];
        // get the tweets
        $Table = new Application_Model_DbTable_Tweet(array(
            'rowClass' => 'Application_Model_Tweet'
        ));
        $tweets = $Table->search($query, ($page - 1) * $perPage, $perPage);
        // assign for the view
        $this->view->assign('tweets', $tweets);
        $this->view->assign('q', $query);
    }
}