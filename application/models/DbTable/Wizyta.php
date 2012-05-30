<?php

class Application_Model_DbTable_Wizyta extends Zend_Db_Table_Abstract {

    protected $_name = 'wizyta';
    protected $_rowClass = 'Application_Model_DbTable_Wizyta_Row';
    
//relacje 1:n z tablicami 'pacjent' i 'lekarz' (tabele źródłowe)
    protected $_referenceMap = array(
	'Pacjent' => array(
	    'columns'		=> array('pacjent_id'),
	    'refTableClass'	=> 'Application_Model_DbTable_Pacjent',
	    'refTableColumns'	=> array('pacjent_id')
	),
	'Lekarz' => array(
	    'columns'		=> array('lekarz_id'),
	    'refTableClass'	=> 'Application_Model_DbTable_Lekarz',
	    'refTableColumns'	=> array('lekarz_id')
	)
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

	$select->order('data');

	return parent::fetchAll($select, $order, $count, $offset);
    }

    public function findOneBySlug($slug) {
	$select = $this->select()->where('slug = ?', $slug);
	return $this->fetchRow($select);
    }

    public function insertIfNotExists($data) {
	$select = $this->select()
		->from('wizyta', array('wizyta_id'))
		->where('data = ?', $data['data'])
		->where('lekarz_id = ?', $data['lekarz_id'])
		->where('pacjent_id = ?', $data['pacjent_id'])
		->where('czas = ?', $data['czas'])
		->where('czy_odbyta = ?', $data['czy_odbyta'])
		->where('recepta = ?', $data['recepta']);

	if ($wizyta = $this->fetchRow($select)) {
	    return $wizyta->wizyta_id;
	}

	return $this->createRow($data)->save();
    }

}

