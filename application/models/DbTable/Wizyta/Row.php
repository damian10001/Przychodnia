<?php

class Application_Model_DbTable_Wizyta_Row extends Zend_Db_Table_Row {

    public function __toString() {
	return (string) $this->data . ' ' . $this->getPacjent();
    }
    
    public function czasBezSekund(){
	$czas_bez_sekund = $this->czas;
	$czas_bez_sekund = substr($czas_bez_sekund, 0, strlen($czas_bez_sekund)-3);
	
	return $czas_bez_sekund;
    }

    function getLekarz() {
	return $this->findParentRow('Application_Model_DbTable_Lekarz');
    }

    function getPacjent() {
	return $this->findParentRow('Application_Model_DbTable_Pacjent');
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

    public function setSlug($slug) {
	if (trim($slug) == '') {
	    $slug = 'nieznany';
	}

	$next_slug = $slug;

	$q = 'select count(wizyta_id) from wizyta where slug = ?';
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

	    $q = 'select count(wizyta_id) from wizyta where slug = ?';
	    $db = $this->_getTable()->getAdapter();
	    $ile = $db->fetchOne($q, $next_slug);

	    $unikatowy = ($ile == 0);
	}

	$this->slug = $next_slug;
    }

}