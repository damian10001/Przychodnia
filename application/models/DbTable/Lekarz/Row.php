<?php

class Application_Model_DbTable_Lekarz_Row extends Zend_Db_Table_Row {

    public function __toString() {
	return (string) $this->nazwisko . ' ' . $this->imie;
    }

    protected function _insert() {
	if ($this->slug === null) {
	    $this->setSlug(My_Slugs::string2slug($this->__toString()));
	}
    }

    protected function _update() {
	if ($this->slug === null) {
	    $this->setSlug(My_Slugs::string2slug($this->__toString()));
	}
    }

    function getSpecjalizacje() {
	return $this->findManyToManyRowset('Application_Model_DbTable_Specjalizacja', 'Application_Model_DbTable_LekarzHasSpecjalizacja');
    }

    function getGodzinyPrzyjec() {
	return $this->findDependentRowset('Application_Model_DbTable_GodzinyPrzyjec');
    }

    function getWizyty() {
	return $this->findDependentRowset('Application_Model_DbTable_Wizyta');
    }

    public function setSlug($slug) {
	if (trim($slug) == '') {
	    $slug = 'nieznany';
	}

	$next_slug = $slug;

	$q = 'select count(lekarz_id) from lekarz where slug = ?';
	$db = $this->_getTable()->getAdapter();
	$ile = $db->fetchOne($q, $next_slug);

	$unikatowy = ($ile == 0);

	$min = 2;
	$max = 100;

	while (!$unikatowy) {

	    $next_slug = $slug . $min;
	    $min++;

	    if ($min > $max + 1) {
		throw new Exception("setSlug({$next_slug})");
	    };

	    $q = 'select count(lekarz_id) from lekarz where slug = ?';
	    $db = $this->_getTable()->getAdapter();
	    $ile = $db->fetchOne($q, $next_slug);

	    $unikatowy = ($ile == 0);
	}

	$this->slug = $next_slug;
    }

}