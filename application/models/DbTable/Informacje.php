<?php

class Application_Model_DbTable_Informacje extends Zend_Db_Table_Abstract {

    protected $_name = 'informacje';

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

	$select->order('data');

	return parent::fetchAll($select, $order, $count, $offset);
    }

    public function findOneBySlug($slug) {
	$select = $this->select()->where('slug = ?', $slug);
	return $this->fetchRow($select);
    }

    public function insertIfNotExists($data) {
	$select = $this->select()
		->from('informacje', array('informacje_id'))
		->where('autor = ?', $data['autor'])
		->where('data = ?', $data['data'])
		->where('tytul = ?', $data['tytul'])
		->where('czas = ?', $data['czas']);

	if ($informacje = $this->fetchRow($select)) {
	    return $informacje->informacje_id;
	}

	return $this->createRow($data)->save();
    }

}

