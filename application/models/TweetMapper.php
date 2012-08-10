<?php

class Application_Model_TweetMapper
{
	/**
	 * @var Zend_Db_Table_Abstract
	 */
	protected $dbTable = null;

    /**
     * @TODO documentation
     */
    public function __constructor() {
    } 

 	/**
 	 * @TODO documentation
 	 *
 	 * @param Zend_Db_Table_Abstract $dbTable
 	 * @return Application_Model_TweetMapper
 	 */
    public function setDbTable(Zend_Db_Table_Abstract $dbTable)
    {
        $this->dbTable = $dbTable;
        return $this;
    }
 
 	/**
 	 * @TODO documentation
 	 *
 	 * @return Application_Model_DbTable_Tweet
 	 */
    public function getDbTable()
    {
        if (null === $this->dbTable) {
            $this->setDbTable(new Application_Model_DbTable_Tweet());
        }

        return $this->dbTable;
    }
 
 	/**
 	 * @TODO documentation
 	 *
 	 * @param Application_Model_Tweet $tweetModel
 	 * @return Application_Model_DbTable_Tweet
 	 */
    public function save(Application_Model_Tweet $tweetModel)
    {
        $data = array(
            'id' => $tweetModel->getId(),
            'createdAt' => $tweetModel->getCreatedAt(),
        );
 
        $this->getDbTable()->insert($data);

        return $this;
    }
 
 	/**
 	 * @TODO documentation
 	 *
 	 * @param integer $id
 	 * @param Application_Model_Tweet $tweetModel
 	 * @return Application_Model_DbTable_Tweet
 	 */
    public function find($id, Application_Model_Tweet $tweetModel)
    {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $tweetModel
        	->setId($row->id)
        	->setCreatedAt($row->createdAt);

        return $this;
    }
 
 	/**
 	 * @TODO documentation
 	 *
 	 * @return array
 	 */
    public function fetchAll()
    {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_Tweet();
            $entry
            	->setId($row->id)
            	->setCreatedAt($row->createdAt);
            $entries[] = $entry;
        }
        return $entries;
    }

}

