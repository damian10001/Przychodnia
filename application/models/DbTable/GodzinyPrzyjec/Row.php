<?php

class Application_Model_DbTable_GodzinyPrzyjec_Row extends Zend_Db_Table_Row {

    //nadpisana metoda magiczna, która po wywołaniu obiektu zwraca to, co poniżej
    public function __toString() {
	return (string) $this->getLekarz() . ' ' . $this->dzien_tygodnia . ' ' .
		$this->godzina_od . ' ' . $this->godzina_do;
    }
    
    public function czasBezSekund($godzina){
	$czas_bez_sekund = $godzina;
	$czas_bez_sekund = substr($czas_bez_sekund, 0, strlen($czas_bez_sekund)-3);
	
	return $czas_bez_sekund;
    }

    //metoda do ustawiania wartości slug (przyjazne linki)
    public function setSlug($slug) {
	if (trim($slug) == '') {
	    $slug = 'nieznany';
	}

	$next_slug = $slug;

	$q = 'select count(godziny_przyjec_id) from godziny_przyjec where slug = ?';
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

	    $q = 'select count(godziny_przyjec_id) from godziny_przyjec where slug = ?';
	    $db = $this->_getTable()->getAdapter();
	    $ile = $db->fetchOne($q, $next_slug);

	    $unikatowy = ($ile == 0);
	}

	$this->slug = $next_slug;
    }

    //metoda pobierająca zależnego lekarza z tabeli 'lekarz'
    function getLekarz() {
	return $this->findParentRow('Application_Model_DbTable_Lekarz');
    }

    //nadpisana metoda insert
    protected function _insert() {
	if ($this->slug === null) {
	    $this->setSlug(My_Slugs::string2slug($this->__toString()));
	}
    }

    //nadpisana metoda update
    protected function _update() {
	if ($this->slug === null) {
	    $this->setSlug(My_Slugs::string2slug($this->__toString()));
	}
    }

}