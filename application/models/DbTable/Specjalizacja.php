<?php

class Application_Model_DbTable_Specjalizacja extends Zend_Db_Table_Abstract {

    protected $_name = 'specjalizacja';
    protected $_rowClass = 'Application_Model_DbTable_Specjalizacja_Row';
    //relacja n:m z tabelą 'lekarz'
    protected $_dependentTables = array(
	'Application_Model_DbTable_LekarzHasSpecjalizacja'
    );

    public function fetchAll($where = null, $order = null, $count = null, $offset = null) {
	if ($where === null) {
	    $select = $this->select();
	} else if (!($where instanceof Zend_Db_Table_Select)) {
	    $select = $this->select();

	    if ($where !== null) {
		$this->_where($select, $where);
	    }

	    if ($order !== null) {
		$this->_order($select, $order);
	    }

	    if ($count !== null || $offset !== null) {
		$select->limit($count, $offset);
	    }
	} else {
	    $select = $where;
	}

	$select->order('nazwa');

	return parent::fetchAll($select, $order, $count, $offset);
    }

    public function findOneBySlug($slug) {
	$select = $this->select()->where('slug = ?', $slug);
	return $this->fetchRow($select);
    }

    public function insertIfNotExists($data) {
	$select = $this->select()
		->from('specjalizacja', array('specjalizacja_id'))
		->where('nazwa = ?', $data['nazwa']);

	if ($specjalizacja = $this->fetchRow($select)) {
	    return $specjalizacja->specjalizacja_id;
	}

	return $this->createRow($data)->save();
    }

}

