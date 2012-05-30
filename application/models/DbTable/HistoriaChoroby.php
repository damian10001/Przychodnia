<?php

class Application_Model_DbTable_HistoriaChoroby extends Zend_Db_Table_Abstract {

    protected $_name = 'historia_choroby';
    protected $_rowClass = 'Application_Model_DbTable_HistoriaChoroby_Row';
    //relacja 1:n z tabelą 'pacjent' (tabela źródłowa)
    protected $_referenceMap = array(
	'Pacjent' => array(
	    'columns' => array('pacjent_id'),
	    'refTableClass' => 'Application_Model_DbTable_Pacjent',
	    'refTableColumns' => array('pacjent_id')
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

	$select->order('pacjent_id');

	return parent::fetchAll($select, $order, $count, $offset);
    }

    public function findOneBySlug($slug) {
	$select = $this->select()->where('slug = ?', $slug);
	return $this->fetchRow($select);
    }

    public function insertIfNotExists($data) {
	$select = $this->select()
		->from('historia_choroby', array('historia_choroby'))
		->where('nazwa = ?', $data['nazwa'])
		->where('opis_choroby = ?', $data['opis_choroby'])
		->where('data = ?', $data['data'])
		->where('pacjent_id = ?', $data['pacjent_id']);

	if ($historia_choroby = $this->fetchRow($select)) {
	    return $historia_choroby->historia_choroby_id;
	}

	return $this->createRow($data)->save();
    }

}

