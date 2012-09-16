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

	public function search($q = null, $offset = 0, $limit = null)
	{
		$select = $this->select()
			->from(array($this->_name))
			->order(array('id DESC'))
		;
		// add search term if needed
		if ($q !== null) {
			$select->where('text LIKE :q');
			$select->bind(array(
				'q' => '%'.$q.'%'
			));
		}
		// add limit query
		if ($limit !== null) {
			$select->limit($limit, $offset);
		}
		return $this->fetchAll($select);
	}
}
