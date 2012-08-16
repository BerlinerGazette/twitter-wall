<?php

class Application_Model_DbTable_Tweet extends Zend_Db_Table_Abstract
{
	protected $_name = 'tweet';

	/**
	 * @TODO documentation
	 *
	 * @param string $query
	 * @return Zend_Db_Table_Row_Abstract
	 */
	public function findMaxIdByQuery($query)
	{
		$select = $this->select()
			->from(
				array($this->_name),
				array('maxId' => 'MAX(idStr)')
			)
			->where('query = :query')
			->bind(array(':query' => $query));

		return $this->fetchRow($select);
	}
}
