<?php

class Application_Model_DbTable_Pacjent extends Zend_Db_Table_Abstract {

    protected $_name = 'pacjent';
    protected $_rowClass = 'Application_Model_DbTable_Pacjent_Row';
    //relacje 1:n z tabelami 'wizyta' i 'historia_choroby' (tabele docelowe)
    protected $_dependentTables = array(
	'Application_Model_DbTable_Wizyta',
	'Application_Model_DbTable_HistoriaChoroby'
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
		->from('pacjent', array('pacjent_id'))
		->where('nazwisko = ?', $data['nazwisko'])
		->where('imie = ?', $data['imie'])
		->where('email = ?', $data['email'])
		->where('pesel = ?', $data['pesel']);

	if ($pacjent = $this->fetchRow($select)) {
	    return $pacjent->pacjent_id;
	}

	return $this->createRow($data)->save();
    }

}

