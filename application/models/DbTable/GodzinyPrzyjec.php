<?php

class Application_Model_DbTable_GodzinyPrzyjec extends Zend_Db_Table_Abstract {

    protected $_name = 'godziny_przyjec';
    protected $_rowClass = 'Application_Model_DbTable_GodzinyPrzyjec_Row';
    //relacja 1:n z tabelą 'lekarz' (tabela źródłowa)
    protected $_referenceMap = array(
	'Lekarz' => array(
	    'columns' => array('lekarz_id'),
	    'refTableClass' => 'Application_Model_DbTable_Lekarz',
	    'refTableColumns' => array('lekarz_id')
	)
    );

    //metoda do wyszukania jednego rekordu po wartości slug
    public function findOneBySlug($slug) {
	$select = $this->select()->where('slug = ?', $slug);
	return $this->fetchRow($select);
    }

    //nadpisana metoda zwracająca wszystkie rekordy
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

	$select->order('lekarz_id');

	return parent::fetchAll($select, $order, $count, $offset);
    }

    //metoda wstawiająca rekord do tabeli jeśli taki nie istnieje (a jeśli istnieje to go zwraca
    public function insertIfNotExists($data) {
	$slect = $this->select()->from('godziny_przyjec', array('godziny_przyjec_id'))
		->where('dzien_tygodnia = ?', $data['dzien_tygodnia'])
		->where('godzina_od = ?', $data['godzina_od'])
		->where('godzina_do = ?', $data['godzina_do'])
		->where('lekarz_id = ?', $data['lekarz_id']);

	if ($godziny_przyjec = $this->fetchRow($select)) {
	    return $godziny_przyjec->godziny_przyjec_id;
	}

	return $this->createRow($data)->save();
    }

}

