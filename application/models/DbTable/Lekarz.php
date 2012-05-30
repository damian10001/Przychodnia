<?php

class Application_Model_DbTable_Lekarz extends Zend_Db_Table_Abstract {

    protected $_name = 'lekarz';
    protected $_rowClass = 'Application_Model_DbTable_Lekarz_Row';
    //relacja n:m z tabelą 'specjalizacja', relacje 1:n z tabelą 'wizyta' i 'godziny przyjec' (tabele docelowe)
    protected $_dependentTables = array(
	'Application_Model_DbTable_LekarzHasSpecjalizacja',
	'Application_Model_DbTable_Wizyta',
	'Application_Model_DbTable_GodzinyPrzyjec'
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

	$select->order(array('nazwisko', 'imie'));

	return parent::fetchAll($select, $order, $count, $offset);
    }

    public function findOneBySlug($slug) {
	$select = $this->select()->where('slug = ?', $slug);
	return $this->fetchRow($select);
    }

    public function insertIfNotExists($data) {
	$select = $this->select()
		->from('lekarz', array('lekarz_id'))
		->where('nazwisko = ?', $data['nazwisko'])
		->where('imie = ?', $data['imie'])
		->where('pesel = ?', $data['pesel'])
		->where('email = ?', $data['email']);
	if ($lekarz = $this->fetchRow($select)) {
	    return $lekarz->lekarz_id;
	}

	return $this->createRow($data)->save();
    }

}

